@extends('layouts.app')

@php
$pageTitle = 'Dashboard';
@endphp

@push('styles')
/* Date Range Filter */
.date-range-filter {
background: rgba(26, 26, 26, 0.7);
backdrop-filter: blur(10px);
border-radius: 1rem;
padding: 1.5rem;
margin-bottom: 2rem;
border: 1px solid rgba(60, 60, 60, 0.5);
}

.filter-select {
width: 100%;
max-width: 300px;
padding: 0.75rem 1rem;
background: rgba(20, 20, 20, 0.7);
border: 1px solid rgba(60, 60, 60, 0.5);
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
border-color: #a855f7;
background: rgba(20, 20, 20, 0.9);
}

.filter-select option {
background: #1a1a1a;
color: white;
}

.custom-range {
padding-top: 1rem;
border-top: 1px solid rgba(60, 60, 60, 0.5);
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
background: rgba(20, 20, 20, 0.7);
border: 1px solid rgba(60, 60, 60, 0.5);
border-radius: 8px;
color: white;
font-size: 0.875rem;
transition: all 0.3s;
}

.filter-input:focus {
outline: none;
border-color: #a855f7;
background: rgba(20, 20, 20, 0.9);
}

.filter-btn {
padding: 0.75rem 1.5rem;
background: linear-gradient(135deg, #a855f7 0%, #c084fc 100%);
border: none;
border-radius: 8px;
color: white;
font-weight: 500;
cursor: pointer;
transition: all 0.3s;
box-shadow: 0 4px 15px rgba(168, 85, 247, 0.5);
}

.filter-btn:hover {
transform: translateY(-2px);
box-shadow: 0 6px 20px rgba(168, 85, 247, 0.6);
}

.filter-btn-reset {
padding: 0.75rem 1.5rem;
background: rgba(60, 60, 60, 0.5);
border: none;
border-radius: 8px;
color: white;
font-weight: 500;
cursor: pointer;
transition: all 0.3s;
text-decoration: none;
display: inline-block;
}

.filter-btn-reset:hover {
background: rgba(80, 80, 80, 0.6);
}

/* Metrics Cards */
.metrics-grid {
display: grid;
grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
gap: 1.5rem;
margin-bottom: 2rem;
}

.metric-card {
background: rgba(26, 26, 26, 0.7);
backdrop-filter: blur(10px);
border-radius: 1rem;
padding: 1.5rem;
border: 1px solid rgba(60, 60, 60, 0.5);
transition: all 0.3s;
}

.metric-card:hover {
transform: translateY(-4px);
box-shadow: 0 8px 25px rgba(0, 0, 0, 0.3);
}

.metric-header {
display: flex;
justify-content: space-between;
align-items: flex-start;
margin-bottom: 1rem;
}

.metric-info h3 {
font-size: 0.875rem;
color: #9ca3af;
margin-bottom: 0.5rem;
}

.metric-value {
font-size: 2rem;
font-weight: bold;
margin-bottom: 0.25rem;
background: linear-gradient(135deg, #a855f7 0%, #c084fc 100%);
-webkit-background-clip: text;
-webkit-text-fill-color: transparent;
background-clip: text;
}

.metric-date {
font-size: 0.75rem;
color: #6b7280;
}

.metric-icon {
width: 48px;
height: 48px;
border-radius: 12px;
background: rgba(168, 85, 247, 0.15);
display: flex;
align-items: center;
justify-content: center;
color: #a855f7;
}

.metric-icon svg {
width: 28px;
height: 28px;
}

/* Top Products */
.top-products-card {
background: rgba(26, 26, 26, 0.7);
backdrop-filter: blur(10px);
border-radius: 1rem;
padding: 1.5rem;
border: 1px solid rgba(60, 60, 60, 0.5);
margin-bottom: 2rem;
}

.card-header {
display: flex;
justify-content: space-between;
align-items: center;
margin-bottom: 1.5rem;
padding-bottom: 1rem;
border-bottom: 1px solid rgba(60, 60, 60, 0.5);
}

.card-header h2 {
font-size: 1.25rem;
font-weight: bold;
}

.product-list {
display: flex;
flex-direction: column;
gap: 1rem;
}

.product-item {
display: flex;
align-items: center;
gap: 1rem;
padding: 1rem;
background: rgba(20, 20, 20, 0.7);
border-radius: 12px;
transition: all 0.3s;
text-decoration: none;
color: inherit;
}

.product-item:hover {
background: rgba(30, 30, 30, 0.8);
transform: translateX(4px);
cursor: pointer;
}

.product-rank {
width: 32px;
height: 32px;
border-radius: 8px;
background: linear-gradient(135deg, #a855f7 0%, #c084fc 100%);
display: flex;
align-items: center;
justify-content: center;
font-weight: bold;
font-size: 0.875rem;
}

.product-image {
width: 64px;
height: 64px;
border-radius: 12px;
object-fit: cover;
}

.product-info {
flex: 1;
}

.product-name {
font-weight: 600;
font-size: 1rem;
margin-bottom: 0.25rem;
}

.product-category {
font-size: 0.875rem;
color: #9ca3af;
}

.product-stats {
text-align: right;
}

.product-quantity {
font-weight: 600;
font-size: 1.125rem;
color: #a855f7;
margin-bottom: 0.25rem;
}

.product-revenue {
font-size: 0.875rem;
color: #9ca3af;
}

.product-orders {
font-size: 0.75rem;
color: #6b7280;
margin-top: 0.25rem;
}

/* Chart */
.chart-card {
background: rgba(26, 26, 26, 0.7);
backdrop-filter: blur(10px);
border-radius: 1rem;
padding: 1.5rem;
border: 1px solid rgba(60, 60, 60, 0.5);
margin-bottom: 2rem;
}

.chart-container {
height: 300px;
margin-top: 1rem;
}

.no-data {
text-align: center;
padding: 3rem 1rem;
color: #9ca3af;
}

.no-data-icon {
font-size: 3rem;
line-height: 1;
margin-bottom: 1rem;
color: #a855f7;
display: block;
}
@endpush

@section('content')
<!-- Date Range Filter -->
<div class="date-range-filter">
    <!-- Filter Dropdown -->
    <div>
        <label class="filter-label">Filter Period</label>
        <select class="filter-select" onchange="handleFilterChange(this.value)">
            <option value="today" {{ $filter == 'today' ? 'selected' : '' }}>Today</option>
            <option value="yesterday" {{ $filter == 'yesterday' ? 'selected' : '' }}>Yesterday</option>
            <option value="week" {{ $filter == 'week' ? 'selected' : '' }}>This Week</option>
            <option value="month" {{ $filter == 'month' ? 'selected' : '' }}>This Month</option>
            <option value="custom" {{ $filter == 'custom' ? 'selected' : '' }}>Custom Range</option>
        </select>
    </div>

    <!-- Custom Range Form -->
    <div class="custom-range {{ $filter != 'custom' ? 'hidden' : '' }}" id="customRange">
        <form action="{{ route('dashboard') }}" method="GET" class="filter-form">
            <input type="hidden" name="filter" value="custom">
            <div class="filter-group">
                <label class="filter-label">Start Date</label>
                <input type="date" name="start_date" value="{{ $startDate }}" class="filter-input" required>
            </div>
            <div class="filter-group">
                <label class="filter-label">End Date</label>
                <input type="date" name="end_date" value="{{ $endDate }}" class="filter-input" required>
            </div>
            <div>
                <button type="submit" class="filter-btn">Apply Filter</button>
            </div>
        </form>
    </div>
</div>

<!-- Metrics Grid -->
<div class="metrics-grid">
    <!-- Daily Sales -->
    <div class="metric-card">
        <div class="metric-header">
            <div class="metric-info">
                <h3>Daily Sales</h3>
                <div class="metric-value" data-value="{{ $dailySales }}" data-type="currency">Rp 0</div>
                <div class="metric-date">{{ \Carbon\Carbon::today()->format('d M Y') }}</div>
            </div>
            <div class="metric-icon">
                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
            </div>
        </div>
    </div>

    <!-- Monthly Sales -->
    <div class="metric-card">
        <div class="metric-header">
            <div class="metric-info">
                <h3>Monthly Sales</h3>
                <div class="metric-value" data-value="{{ $monthlySales }}" data-type="currency">Rp 0</div>
                <div class="metric-date">{{ \Carbon\Carbon::now()->format('F Y') }}</div>
            </div>
            <div class="metric-icon">
                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" />
                </svg>
            </div>
        </div>
    </div>

    <!-- Total Orders (Filtered) -->
    <div class="metric-card">
        <div class="metric-header">
            <div class="metric-info">
                <h3>Total Orders</h3>
                <div class="metric-value" data-value="{{ $filteredOrders }}" data-type="number">0</div>
                <div class="metric-date">{{ \Carbon\Carbon::parse($startDate)->format('d M') }} - {{ \Carbon\Carbon::parse($endDate)->format('d M Y') }}</div>
            </div>
            <div class="metric-icon">
                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z" />
                </svg>
            </div>
        </div>
    </div>

    <!-- Average Order Value -->
    <div class="metric-card">
        <div class="metric-header">
            <div class="metric-info">
                <h3>Average Order Value</h3>
                <div class="metric-value" data-value="{{ $averageOrderValue }}" data-type="currency">Rp 0</div>
                <div class="metric-date">{{ \Carbon\Carbon::parse($startDate)->format('d M') }} - {{ \Carbon\Carbon::parse($endDate)->format('d M Y') }}</div>
            </div>
            <div class="metric-icon">
                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 12l3-3 3 3 4-4M8 21l4-4 4 4M3 4h18M4 4h16v12a1 1 0 01-1 1H5a1 1 0 01-1-1V4z" />
                </svg>
            </div>
        </div>
    </div>
</div>

<!-- Top Selling Products -->
<div class="top-products-card">
    <div class="card-header">
        <h2>Top Selling Products</h2>
        <span style="color: #9ca3af; font-size: 0.875rem;">{{ \Carbon\Carbon::parse($startDate)->format('d M') }} - {{ \Carbon\Carbon::parse($endDate)->format('d M Y') }}</span>
    </div>

    @if($topProducts->count() > 0)
    <div class="product-list">
        @foreach($topProducts as $index => $product)
        <a href="{{ route('menu') }}" class="product-item">
            <div class="product-rank">#{{ $index + 1 }}</div>
            @if($product->p_image)
            <img src="{{ asset('storage/' . $product->p_image) }}" alt="{{ $product->p_name }}" class="product-image">
            @else
            <div class="product-image" style="background: rgba(107, 114, 128, 0.3); display: flex; align-items: center; justify-content: center;">
                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24" width="32" height="32" style="color: #9ca3af;">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                </svg>
            </div>
            @endif
            <div class="product-info">
                <div class="product-name">{{ $product->p_name }}</div>
                <div class="product-category">{{ $product->c_name }}</div>
            </div>
            <div class="product-stats">
                <div class="product-quantity">{{ number_format($product->total_quantity) }} sold</div>
                <div class="product-revenue">Rp {{ number_format($product->total_revenue, 0, ',', '.') }}</div>
                <div class="product-orders">{{ $product->order_count }} orders</div>
            </div>
        </a>
        @endforeach
    </div>
    @else
    <div class="no-data">
        <div class="no-data-icon"><svg xmlns="http://www.w3.org/2000/svg" width="64" height="64" fill="currentColor" class="bi bi-bar-chart" viewBox="0 0 16 16">
                <path d="M4 11H2v3h2zm5-4H7v7h2zm5-5v12h-2V2zm-2-1a1 1 0 0 0-1 1v12a1 1 0 0 0 1 1h2a1 1 0 0 0 1-1V2a1 1 0 0 0-1-1zM6 7a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1v7a1 1 0 0 1-1 1H7a1 1 0 0 1-1-1zm-5 4a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1v3a1 1 0 0 1-1 1H2a1 1 0 0 1-1-1z" />
            </svg></div>
        <p>No sales data available for the selected period</p>
    </div>
    @endif
</div>

<!-- Sales Chart -->
<div class="chart-card">
    <div class="card-header">
        <h2>Sales Overview</h2>
    </div>
    <div class="chart-container">
        <canvas id="salesChart"></canvas>
    </div>
</div>
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    // Sales Chart
    const ctx = document.getElementById('salesChart');
    const chartData = @json($chartData);

    new Chart(ctx, {
        type: 'line',
        data: {
            labels: chartData.map(item => item.date),
            datasets: [{
                label: 'Sales (Rp)',
                data: chartData.map(item => item.total),
                borderColor: '#a855f7',
                backgroundColor: 'rgba(168, 85, 247, 0.15)',
                tension: 0.4,
                fill: true,
                pointBackgroundColor: '#a855f7',
                pointBorderColor: '#fff',
                pointBorderWidth: 2,
                pointRadius: 5,
                pointHoverRadius: 7
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    display: false
                },
                tooltip: {
                    backgroundColor: 'rgba(20, 20, 20, 0.95)',
                    titleColor: '#fff',
                    bodyColor: '#fff',
                    borderColor: '#a855f7',
                    borderWidth: 1,
                    padding: 12,
                    displayColors: false,
                    callbacks: {
                        label: function(context) {
                            return 'Sales: Rp ' + context.parsed.y.toLocaleString('id-ID');
                        },
                        afterLabel: function(context) {
                            const orders = chartData[context.dataIndex].orders;
                            return 'Orders: ' + orders;
                        }
                    }
                }
            },
            scales: {
                y: {
                    beginAtZero: true,
                    grid: {
                        color: 'rgba(60, 60, 60, 0.3)'
                    },
                    ticks: {
                        color: '#9ca3af',
                        callback: function(value) {
                            if (value >= 1000000) {
                                return 'Rp ' + (value / 1000000).toFixed(1) + 'M';
                            } else if (value >= 1000) {
                                return 'Rp ' + (value / 1000).toFixed(0) + 'K';
                            }
                            return 'Rp ' + value;
                        }
                    },
                    grace: '10%'
                },
                x: {
                    grid: {
                        color: 'rgba(60, 60, 60, 0.3)'
                    },
                    ticks: {
                        color: '#9ca3af'
                    }
                }
            }
        }
    });

    // Handle Filter Change
    function handleFilterChange(value) {
        const customRange = document.getElementById('customRange');
        
        if (value === 'custom') {
            customRange.classList.remove('hidden');
        } else {
            window.location.href = '{{ route("dashboard") }}?filter=' + value;
        }
    }

    // Animated Counter Function
    function animateCounter(element, target, duration = 1500) {
        const start = 0;
        const increment = target / (duration / 16); // 60 FPS
        const type = element.getAttribute('data-type');
        let current = 0;
        
        const timer = setInterval(() => {
            current += increment;
            
            if (current >= target) {
                current = target;
                clearInterval(timer);
            }
            
            // Format based on type
            if (type === 'currency') {
                element.textContent = 'Rp ' + Math.round(current).toLocaleString('id-ID');
            } else {
                element.textContent = Math.round(current).toLocaleString('id-ID');
            }
        }, 16);
    }

    // Initialize counters on page load
    document.addEventListener('DOMContentLoaded', function() {
        const metricValues = document.querySelectorAll('.metric-value[data-value]');
        
        metricValues.forEach(element => {
            const targetValue = parseFloat(element.getAttribute('data-value'));
            if (!isNaN(targetValue)) {
                animateCounter(element, targetValue, 1500);
            }
        });
    });
</script>
@endpush