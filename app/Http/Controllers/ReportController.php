<?php

namespace App\Http\Controllers;

use App\Models\Sale;
use App\Models\SaleDetail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class ReportController extends Controller
{
    public function index()
    {
        return view('reports.index');
    }

    public function sales(Request $request)
    {
        // Handle quick filters (same as Dashboard)
        $filter = $request->input('filter', 'custom');
        $startDate = null;
        $endDate = null;

        switch ($filter) {
            case 'today':
                $startDate = Carbon::today();
                $endDate = Carbon::today();
                break;
            case 'yesterday':
                $startDate = Carbon::yesterday();
                $endDate = Carbon::yesterday();
                break;
            case 'week':
                $startDate = Carbon::now()->startOfWeek();
                $endDate = Carbon::now()->endOfWeek();
                break;
            case 'month':
                $startDate = Carbon::now()->startOfMonth();
                $endDate = Carbon::now()->endOfMonth();
                break;
            case 'custom':
                if ($request->filled('start_date') && $request->filled('end_date')) {
                    $startDate = Carbon::parse($request->start_date);
                    $endDate = Carbon::parse($request->end_date);
                } else {
                    // Default to last 30 days
                    $startDate = Carbon::now()->subDays(30);
                    $endDate = Carbon::now();
                }
                break;
        }

        $query = Sale::with(['user', 'saleDetails.product'])
            ->orderBy('created_at', 'desc');

        // Apply date filter
        if ($startDate && $endDate) {
            $query->whereBetween('created_at', [$startDate->startOfDay(), $endDate->endOfDay()]);
        }

        // Filter by invoice/sale number
        if ($request->filled('invoice')) {
            $query->where('sale_number', 'like', '%' . $request->invoice . '%');
        }

        // Filter by customer name
        if ($request->filled('customer')) {
            $query->where('customer_name', 'like', '%' . $request->customer . '%');
        }

        // Calculate summary statistics before pagination
        $totalSales = $query->count();
        $totalRevenue = $query->sum('subtotal_amount');
        $averageOrder = $totalSales > 0 ? $totalRevenue / $totalSales : 0;

        // Get paginated results
        $sales = $query->paginate(20)->appends($request->all());

        // Get chart data (daily sales for the period)
        $chartData = $this->getChartData($startDate, $endDate);

        if ($request->ajax()) {
            return response()->json([
                'success' => true,
                'sales' => $sales,
                'summary' => [
                    'total_sales' => $totalSales,
                    'total_revenue' => $totalRevenue,
                    'average_order' => $averageOrder
                ],
                'chart_data' => $chartData
            ]);
        }

        return view('reports.sales', compact('sales', 'totalSales', 'totalRevenue', 'averageOrder', 'chartData'));
    }

    private function getChartData($startDate = null, $endDate = null)
    {
        if (!$startDate) {
            $startDate = Carbon::now()->subDays(30);
        }
        
        if (!$endDate) {
            $endDate = Carbon::now();
        }

        // Clone to avoid modifying original
        $start = $startDate->copy()->startOfDay();
        $end = $endDate->copy()->endOfDay();

        $salesByDay = Sale::select(
                DB::raw('DATE(created_at) as date'),
                DB::raw('COUNT(*) as count'),
                DB::raw('SUM(subtotal_amount) as revenue')
            )
            ->whereBetween('created_at', [$start, $end])
            ->groupBy('date')
            ->orderBy('date')
            ->get();

        return [
            'labels' => $salesByDay->pluck('date')->map(function($date) {
                return Carbon::parse($date)->format('M d');
            }),
            'sales_count' => $salesByDay->pluck('count'),
            'revenue' => $salesByDay->pluck('revenue')
        ];
    }
}
