@extends('layouts.app')

@php
    $pageTitle = 'Sales Report';
@endphp

@push('styles')
<style>
    .page-content {
        padding: 1.5rem !important;
    }

    .reports-header {
        display: flex;
        align-items: center;
        gap: 1rem;
        margin-bottom: 2rem;
    }

    .reports-header h1 {
        font-size: 1.5rem;
        font-weight: bold;
    }

    /* Date Range Filter - Same style as Dashboard */
    .date-range-filter {
        background: rgba(45, 55, 72, 0.5);
        backdrop-filter: blur(10px);
        border-radius: 1rem;
        padding: 1.5rem;
        margin-bottom: 2rem;
        border: 1px solid rgba(107, 114, 128, 0.3);
    }

    .filter-select {
        width: 100%;
        max-width: 300px;
        padding: 0.75rem 1rem;
        background: rgba(30, 41, 59, 0.5);
        border: 1px solid rgba(107, 114, 128, 0.3);
        border-radius: 8px;
        color: white;
        font-size: 0.875rem;
        font-weight: 500;
        cursor: pointer;
        transition: all 0.3s;
        margin-bottom: 1rem;
    }

    .filter-select:focus {
        outline: none;
        border-color: #ec4899;
        background: rgba(30, 41, 59, 0.7);
    }

    .filter-select option {
        background: #1e293b;
        color: white;
    }

    .custom-range {
        padding-top: 1rem;
        border-top: 1px solid rgba(107, 114, 128, 0.3);
        margin-top: 1rem;
    }

    .custom-range.hidden {
        display: none;
    }

    .filter-form {
        display: flex;
        gap: 1rem;
        align-items: flex-end;
        flex-wrap: wrap;
    }

    .filter-group {
        flex: 1;
        min-width: 200px;
    }

    .filter-label {
        display: block;
        font-size: 0.875rem;
        color: #9ca3af;
        margin-bottom: 0.5rem;
    }

    .filter-input {
        width: 100%;
        padding: 0.75rem 1rem;
        background: rgba(30, 41, 59, 0.5);
        border: 1px solid rgba(107, 114, 128, 0.3);
        border-radius: 8px;
        color: white;
        font-size: 0.875rem;
        transition: all 0.3s;
    }

    .filter-input:focus {
        outline: none;
        border-color: #ec4899;
        background: rgba(30, 41, 59, 0.7);
    }

    .filter-input::placeholder {
        color: rgba(255, 255, 255, 0.4);
    }

    .filter-btn {
        padding: 0.75rem 1.5rem;
        background: linear-gradient(135deg, #ec4899 0%, #8b5cf6 100%);
        border: none;
        border-radius: 8px;
        color: white;
        font-weight: 500;
        cursor: pointer;
        transition: all 0.3s;
        box-shadow: 0 4px 15px rgba(236, 72, 153, 0.4);
    }

    .filter-btn:hover {
        transform: translateY(-2px);
        box-shadow: 0 6px 20px rgba(236, 72, 153, 0.5);
    }

    /* Search Filters Section - Always visible */
    .search-filters {
        background: rgba(45, 55, 72, 0.5);
        backdrop-filter: blur(10px);
        border-radius: 1rem;
        padding: 1.5rem;
        margin-bottom: 2rem;
        border: 1px solid rgba(107, 114, 128, 0.3);
    }

    .search-grid {
        display: grid;
        grid-template-columns: 1fr 1fr auto;
        gap: 1rem;
        align-items: end;
    }

    .table-section {
        background: rgba(45, 55, 72, 0.5);
        backdrop-filter: blur(10px);
        border: 1px solid rgba(107, 114, 128, 0.3);
        border-radius: 12px;
        padding: 1.5rem;
        overflow: hidden;
    }

    .table-header {
        font-size: 1.125rem;
        font-weight: bold;
        margin-bottom: 1.5rem;
    }

    .sales-table {
        width: 100%;
        border-collapse: separate;
        border-spacing: 0;
    }

    .sales-table thead {
        background: rgba(30, 41, 59, 0.5);
    }

    .sales-table th {
        padding: 1rem;
        text-align: left;
        font-size: 0.875rem;
        font-weight: 600;
        color: rgba(255, 255, 255, 0.9);
        border-bottom: 1px solid rgba(107, 114, 128, 0.3);
    }

    .sales-table th:first-child {
        border-top-left-radius: 8px;
    }

    .sales-table th:last-child {
        border-top-right-radius: 8px;
    }

    .sales-table td {
        padding: 1rem;
        font-size: 0.875rem;
        color: rgba(255, 255, 255, 0.9);
        border-bottom: 1px solid rgba(107, 114, 128, 0.2);
    }

    .sales-table tbody tr {
        transition: all 0.2s;
    }

    .sales-table tbody tr:hover {
        background: rgba(55, 65, 81, 0.3);
    }

    .sales-table tbody tr:last-child td {
        border-bottom: none;
    }

    .status-badge {
        display: inline-block;
        padding: 0.25rem 0.75rem;
        border-radius: 999px;
        font-size: 0.75rem;
        font-weight: 500;
    }

    .status-cash {
        background: rgba(34, 197, 94, 0.2);
        color: #22c55e;
        border: 1px solid rgba(34, 197, 94, 0.3);
    }

    .status-card {
        background: rgba(59, 130, 246, 0.2);
        color: #3b82f6;
        border: 1px solid rgba(59, 130, 246, 0.3);
    }

    .status-qr {
        background: rgba(168, 85, 247, 0.2);
        color: #a855f7;
        border: 1px solid rgba(168, 85, 247, 0.3);
    }

    .invoice-link {
        color: #ec4899;
        text-decoration: none;
        font-weight: 500;
        transition: all 0.2s;
    }

    .invoice-link:hover {
        color: #8b5cf6;
        text-decoration: underline;
    }

    .empty-state {
        text-align: center;
        padding: 3rem;
        color: rgba(255, 255, 255, 0.5);
    }

    .empty-state svg {
        width: 64px;
        height: 64px;
        margin: 0 auto 1rem;
        opacity: 0.5;
    }

    .pagination {
        display: flex;
        justify-content: center;
        gap: 0.5rem;
        margin-top: 1.5rem;
    }

    .pagination a,
    .pagination span {
        padding: 0.5rem 1rem;
        background: rgba(55, 65, 81, 0.3);
        border: 1px solid rgba(107, 114, 128, 0.3);
        border-radius: 6px;
        color: rgba(255, 255, 255, 0.7);
        font-size: 0.875rem;
        text-decoration: none;
        transition: all 0.3s;
    }

    .pagination a:hover {
        background: rgba(55, 65, 81, 0.5);
        border-color: #ec4899;
        color: white;
    }

    .pagination .active {
        background: rgba(236, 72, 153, 0.2);
        border-color: #ec4899;
        color: #ec4899;
    }

    @media (max-width: 1024px) {
        .filter-form {
            flex-direction: column;
            align-items: stretch;
        }

        .filter-group {
            min-width: 100%;
        }

        .filter-select {
            max-width: 100%;
        }

        .search-grid {
            grid-template-columns: 1fr;
        }
    }
</style>
@endpush

@section('content')

<!-- Date Range Filter - Same style as Dashboard -->
<div class="date-range-filter">
    <!-- Filter Dropdown -->
    <div>
        <label class="filter-label">Filter Period</label>
        <select class="filter-select" id="filterSelect" onchange="handleFilterChange(this.value)">
            <option value="today" {{ request('filter') == 'today' ? 'selected' : '' }}>Today</option>
            <option value="yesterday" {{ request('filter') == 'yesterday' ? 'selected' : '' }}>Yesterday</option>
            <option value="week" {{ request('filter') == 'week' ? 'selected' : '' }}>This Week</option>
            <option value="month" {{ request('filter') == 'month' ? 'selected' : '' }}>This Month</option>
            <option value="custom" {{ request('filter') == 'custom' || request('start_date') ? 'selected' : '' }}>Custom Range</option>
        </select>
    </div>

    <!-- Custom Range Form -->
    <div class="custom-range {{ request('filter') != 'custom' && !request('start_date') ? 'hidden' : '' }}" id="customRange">
        <form action="{{ route('reports.sales') }}" method="GET" class="filter-form">
            <input type="hidden" name="filter" value="custom">
            <div class="filter-group">
                <label class="filter-label">Start Date</label>
                <input type="date" name="start_date" value="{{ request('start_date', now()->subDays(30)->format('Y-m-d')) }}" class="filter-input" required>
            </div>
            <div class="filter-group">
                <label class="filter-label">End Date</label>
                <input type="date" name="end_date" value="{{ request('end_date', now()->format('Y-m-d')) }}" class="filter-input" required>
            </div>
            <input type="hidden" name="invoice" value="{{ request('invoice') }}">
            <input type="hidden" name="customer" value="{{ request('customer') }}">
            <div>
                <button type="submit" class="filter-btn">Apply Filter</button>
            </div>
        </form>
    </div>
</div>

<!-- Search Filters - Always visible -->
<div class="search-filters">
    <form action="{{ route('reports.sales') }}" method="GET" class="search-grid">
        <input type="hidden" name="filter" value="{{ request('filter', 'custom') }}">
        <input type="hidden" name="start_date" value="{{ request('start_date') }}">
        <input type="hidden" name="end_date" value="{{ request('end_date') }}">
        
        <div class="filter-group">
            <label class="filter-label">Search Invoice</label>
            <input type="text" name="invoice" value="{{ request('invoice') }}" class="filter-input" placeholder="Sale number...">
        </div>
        
        <div class="filter-group">
            <label class="filter-label">Search Customer</label>
            <input type="text" name="customer" value="{{ request('customer') }}" class="filter-input" placeholder="Customer name...">
        </div>
        
        <div>
            <button type="submit" class="filter-btn">Search</button>
        </div>
    </form>
</div>

<div class="table-section">
    <div class="table-header">Sales Transactions</div>
    
    @if($sales->count() > 0)
    <div style="overflow-x: auto;">
        <table class="sales-table">
            <thead>
                <tr>
                    <th>Invoice Number</th>
                    <th>Customer Name</th>
                    <th>Date</th>
                    <th>Time</th>
                    <th>Table</th>
                    <th>Payment Method</th>
                    <th>Total</th>
                </tr>
            </thead>
            <tbody>
                @foreach($sales as $sale)
                <tr>
                    <td>
                        <a href="{{ route('sales.invoice', $sale->id) }}" target="_blank" class="invoice-link">
                            {{ $sale->sale_number }}
                        </a>
                    </td>
                    <td>{{ $sale->customer_name }}</td>
                    <td>{{ $sale->created_at->format('d M Y') }}</td>
                    <td>{{ $sale->created_at->format('H:i') }}</td>
                    <td>{{ $sale->table_number ?? '-' }}</td>
                    <td>
                        <span class="status-badge status-{{ $sale->payment_method }}">
                            {{ ucfirst($sale->payment_method) }}
                        </span>
                    </td>
                    <td>Rp {{ number_format($sale->subtotal_amount, 0, ',', '.') }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    
    @if($sales->hasPages())
    <div class="pagination">
        @if(!$sales->onFirstPage())
            <a href="{{ $sales->previousPageUrl() }}">Previous</a>
        @endif
        
        @foreach($sales->getUrlRange(1, $sales->lastPage()) as $page => $url)
            @if($page == $sales->currentPage())
                <span class="active">{{ $page }}</span>
            @else
                <a href="{{ $url }}">{{ $page }}</a>
            @endif
        @endforeach
        
        @if($sales->hasMorePages())
            <a href="{{ $sales->nextPageUrl() }}">Next</a>
        @endif
    </div>
    @endif
    @else
    <div class="empty-state">
        <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
        </svg>
        <p>No sales data found for the selected filters</p>
    </div>
    @endif
</div>

<script>
    // Filter dropdown handler - Same as Dashboard
    function handleFilterChange(value) {
        const customRange = document.getElementById('customRange');
        
        if (value === 'custom') {
            customRange.classList.remove('hidden');
        } else {
            customRange.classList.add('hidden');
            // Redirect with selected filter
            window.location.href = '{{ route("reports.sales") }}?filter=' + value;
        }
    }
</script>
@endsection
