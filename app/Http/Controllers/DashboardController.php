<?php

namespace App\Http\Controllers;

use App\Models\Sale;
use App\Models\SaleDetail;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        // Get filter type (default: month)
        $filter = $request->input('filter', 'month');
        
        // Calculate date range based on filter
        switch ($filter) {
            case 'today':
                $start = Carbon::today()->startOfDay();
                $end = Carbon::today()->endOfDay();
                break;
            case 'yesterday':
                $start = Carbon::yesterday()->startOfDay();
                $end = Carbon::yesterday()->endOfDay();
                break;
            case 'week':
                $start = Carbon::now()->startOfWeek();
                $end = Carbon::now()->endOfWeek();
                break;
            case 'month':
                $start = Carbon::now()->startOfMonth();
                $end = Carbon::now()->endOfMonth();
                break;
            case 'custom':
                $startDate = $request->input('start_date', Carbon::now()->startOfMonth()->toDateString());
                $endDate = $request->input('end_date', Carbon::now()->endOfMonth()->toDateString());
                $start = Carbon::parse($startDate)->startOfDay();
                $end = Carbon::parse($endDate)->endOfDay();
                break;
            default:
                $start = Carbon::now()->startOfMonth();
                $end = Carbon::now()->endOfMonth();
                break;
        }
        
        // Store dates as strings for view
        $startDate = $start->toDateString();
        $endDate = $end->toDateString();

        // Daily Sales (Today)
        $dailySales = Sale::whereDate('created_at', Carbon::today())
            ->sum('subtotal');

        // Monthly Sales (Current Month)
        $monthlySales = Sale::whereYear('created_at', Carbon::now()->year)
            ->whereMonth('created_at', Carbon::now()->month)
            ->sum('subtotal');

        // Filtered Sales (based on date range)
        $filteredSales = Sale::whereBetween('created_at', [$start, $end])
            ->sum('subtotal');

        // Daily Orders Count
        $dailyOrders = Sale::whereDate('created_at', Carbon::today())
            ->count();

        // Monthly Orders Count
        $monthlyOrders = Sale::whereYear('created_at', Carbon::now()->year)
            ->whereMonth('created_at', Carbon::now()->month)
            ->count();

        // Filtered Orders Count
        $filteredOrders = Sale::whereBetween('created_at', [$start, $end])
            ->count();

        // Average Order Value (Filtered)
        $averageOrderValue = $filteredOrders > 0 ? $filteredSales / $filteredOrders : 0;

        // Top Selling Products (based on filtered date range)
        $topProducts = SaleDetail::select(
                'products.id',
                'products.p_name',
                'products.p_image',
                'categories.c_name',
                DB::raw('SUM(sales_details.quantity) as total_quantity'),
                DB::raw('SUM(sales_details.subtotal) as total_revenue'),
                DB::raw('COUNT(DISTINCT sales_details.sale_id) as order_count')
            )
            ->join('products', 'sales_details.product_id', '=', 'products.id')
            ->join('categories', 'sales_details.category_id', '=', 'categories.id')
            ->join('sales', 'sales_details.sale_id', '=', 'sales.id')
            ->whereBetween('sales.created_at', [$start, $end])
            ->groupBy('sales_details.product_id', 'products.id', 'products.p_name', 'products.p_image', 'categories.c_name')
            ->orderByDesc('total_quantity')
            ->limit(10)
            ->get();

        // Sales Chart Data - Dynamic based on date range
        $totalDays = $start->diffInDays($end) + 1;
        
        // Determine grouping strategy based on days range
        if ($totalDays <= 31) {
            // Show daily data for ranges up to 31 days
            $salesChartData = Sale::select(
                    DB::raw('DATE(created_at) as date'),
                    DB::raw('SUM(subtotal) as total'),
                    DB::raw('COUNT(*) as orders')
                )
                ->whereBetween('created_at', [$start, $end])
                ->groupBy(DB::raw('DATE(created_at)'))
                ->orderBy('date')
                ->get();

            // Fill missing dates with zero values
            $chartData = [];
            $currentDate = $start->copy();
            while ($currentDate <= $end) {
                $dateStr = $currentDate->toDateString();
                $existingData = $salesChartData->firstWhere('date', $dateStr);
                
                $chartData[] = [
                    'date' => $currentDate->format('M d'),
                    'total' => $existingData ? (float) $existingData->total : 0,
                    'orders' => $existingData ? $existingData->orders : 0,
                ];
                
                $currentDate->addDay();
            }
        } else {
            // For ranges > 31 days, group by week
            $salesChartData = Sale::select(
                    DB::raw('YEARWEEK(created_at) as week'),
                    DB::raw('MIN(DATE(created_at)) as date'),
                    DB::raw('SUM(subtotal) as total'),
                    DB::raw('COUNT(*) as orders')
                )
                ->whereBetween('created_at', [$start, $end])
                ->groupBy(DB::raw('YEARWEEK(created_at)'))
                ->orderBy('date')
                ->get();

            $chartData = $salesChartData->map(function($item) {
                return [
                    'date' => Carbon::parse($item->date)->format('M d'),
                    'total' => (float) $item->total,
                    'orders' => $item->orders,
                ];
            })->toArray();
        }

        // Recent Sales
        $recentSales = Sale::with(['order', 'user'])
            ->whereBetween('created_at', [$start, $end])
            ->orderByDesc('created_at')
            ->limit(5)
            ->get();

        return view('dashboard', compact(
            'dailySales',
            'monthlySales',
            'filteredSales',
            'dailyOrders',
            'monthlyOrders',
            'filteredOrders',
            'averageOrderValue',
            'topProducts',
            'chartData',
            'recentSales',
            'startDate',
            'endDate',
            'filter'
        ));
    }
}
