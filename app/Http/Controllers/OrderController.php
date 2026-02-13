<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use App\Models\Category;
use App\Models\Sale;
use App\Models\SaleDetail;
use App\Models\Notification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class OrderController extends Controller
{
    public function index()
    {
        $orders = Order::with(['orderItems.product', 'user'])
            ->orderBy('created_at', 'desc')
            ->get();
        
        return view('orders.index', compact('orders'));
    }

    public function create()
    {
        $categories = Category::with(['products' => function($query) {
            $query->where('p_stock', '>', 0);
        }])->get();
        
        $products = Product::where('p_stock', '>', 0)->get();
        
        return view('orders.create', compact('categories', 'products'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'customer_name' => 'nullable|string|max:255',
            'table_number' => 'nullable|string',
            'items' => 'required|array|min:1',
            'items.*.product_id' => 'required|exists:products,id',
            'items.*.quantity' => 'required|integer|min:1',
            'discount' => 'nullable|numeric|min:0',
            'discount_type' => 'nullable|in:amount,percent',
            'voucher_code' => 'nullable|string',
        ]);

        DB::beginTransaction();
        try {
            // Calculate totals
            $subtotal = 0;
            $items = [];

            foreach ($request->items as $item) {
                $product = Product::findOrFail($item['product_id']);
                
                if ($product->p_stock < $item['quantity']) {
                    return response()->json([
                        'error' => "Insufficient stock for {$product->p_name}"
                    ], 422);
                }

                $itemSubtotal = $product->p_price * $item['quantity'];
                $subtotal += $itemSubtotal;

                $items[] = [
                    'product' => $product,
                    'quantity' => $item['quantity'],
                    'price' => $product->p_price,
                    'subtotal' => $itemSubtotal,
                ];
            }

            // Calculate tax (11%)
            $tax = $subtotal * 0.11;
            
            // Calculate discount
            $discount = $request->discount ?? 0;
            
            // Calculate total
            $total = $subtotal + $tax - $discount;

            // Generate sale number
            $saleNumber = 'SALE-' . date('Ymd') . '-' . str_pad(Sale::whereDate('created_at', today())->count() + 1, 4, '0', STR_PAD_LEFT);

            // Create sale record directly (no order needed)
            $sale = Sale::create([
                'user_id' => Auth::id(),
                'sale_number' => $saleNumber,
                'order_id' => null,
                'customer_name' => $request->customer_name ?? $request->table_number ?? 'Walk-in Customer',
                'table_number' => $request->table_number,
                'amount' => $total,
                'subtotal' => $subtotal,
                'subtotal_amount' => $request->subtotal_amount ?? ($subtotal + $tax - $discount),
                'tax' => $tax,
                'discount' => $discount,
                'discount_type' => $request->discount_type ?? 'amount',
                'payment_method' => $request->payment_method ?? 'cash',
            ]);

            // Create sale details and update stock
            foreach ($items as $item) {
                SaleDetail::create([
                    'sale_id' => $sale->id,
                    'product_id' => $item['product']->id,
                    'category_id' => $item['product']->category_id,
                    'quantity' => $item['quantity'],
                    'price' => $item['price'],
                    'discount' => 0,
                    'subtotal' => $item['subtotal'],
                ]);

                // Update product stock
                $item['product']->decrement('p_stock', $item['quantity']);
                
                // Check if product is now low stock after purchase
                $updatedProduct = Product::find($item['product']->id);
                if ($updatedProduct->p_stock <= 5 && $updatedProduct->p_stock > 0) {
                    Notification::create([
                        'type' => 'low_stock',
                        'title' => 'Low Stock Alert',
                        'message' => "Product '{$updatedProduct->p_name}' is running low on stock ({$updatedProduct->p_stock} left) after recent purchase.",
                        'data' => ['product_id' => $updatedProduct->id, 'stock' => $updatedProduct->p_stock],
                    ]);
                }
            }

            // Create notification for successful checkout
            $totalItems = array_sum(array_column($request->items, 'quantity'));
            Notification::create([
                'type' => 'checkout_success',
                'title' => 'Checkout Successful',
                'message' => "Order {$saleNumber} completed successfully. Total: Rp " . number_format($total, 0, ',', '.') . " ({$totalItems} items).",
                'data' => ['sale_id' => $sale->id, 'sale_number' => $saleNumber, 'total' => $total],
            ]);

            DB::commit();

            return response()->json([
                'success' => true,
                'sale_id' => $sale->id,
                'sale_number' => $saleNumber,
                'message' => 'Sale created successfully'
            ]);

        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'error' => 'Failed to create order: ' . $e->getMessage()
            ], 500);
        }
    }

    public function show($id)
    {
        $order = Order::with(['orderItems.product', 'user'])->findOrFail($id);
        return view('orders.show', compact('order'));
    }

    public function invoice($id)
    {
        $order = Order::with(['orderItems.product', 'user'])->findOrFail($id);
        return view('orders.invoice', compact('order'));
    }

    public function saleInvoice($id)
    {
        $sale = Sale::with(['saleDetails.product', 'saleDetails.category', 'user'])->findOrFail($id);
        return view('orders.sale-invoice', compact('sale'));
    }

    public function updateStatus(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|in:open,in_process,completed,cancelled',
        ]);

        $order = Order::findOrFail($id);
        $order->update(['status' => $request->status]);

        return response()->json([
            'success' => true,
            'message' => 'Order status updated successfully'
        ]);
    }

    public function payBill(Request $request, $id)
    {
        $request->validate([
            'payment_method' => 'required|in:cash,card,qr',
        ]);

        $order = Order::findOrFail($id);
        $order->update([
            'payment_status' => 'paid',
            'payment_method' => $request->payment_method,
            'status' => 'completed',
        ]);

        // Update sale record if exists
        if ($order->sale) {
            $order->sale->update([
                'payment_method' => $request->payment_method,
            ]);
        }

        return response()->json([
            'success' => true,
            'message' => 'Payment processed successfully',
            'redirect_url' => route('orders.invoice', $order->id)
        ]);
    }

    public function destroy($id)
    {
        $order = Order::findOrFail($id);
        
        // Restore stock for each item
        foreach ($order->orderItems as $item) {
            $item->product->increment('p_stock', $item->quantity);
        }
        
        // Delete order items
        $order->orderItems()->delete();
        
        // Delete order
        $order->delete();

        return response()->json([
            'success' => true,
            'message' => 'Order deleted successfully'
        ]);
    }
}
