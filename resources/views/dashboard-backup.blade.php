@extends('layouts.app')

@php
    $pageTitle = 'Dashboard';
@endphp

@push('styles')
    /* Metrics Cards */
    .metrics-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
        gap: 1.5rem;
        margin-bottom: 2rem;
    }

    .metric-card {
        background: rgba(45, 55, 72, 0.5);
        backdrop-filter: blur(10px);
        border-radius: 1rem;
        padding: 1.5rem;
        border: 1px solid rgba(107, 114, 128, 0.3);
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
    }

    .metric-date {
        font-size: 0.75rem;
        color: #6b7280;
    }

    .metric-icon {
        width: 48px;
        height: 48px;
        border-radius: 12px;
        background: rgba(236, 72, 153, 0.1);
        display: flex;
        align-items: center;
        justify-content: center;
        color: #ec4899;
    }

    .metric-icon svg {
        width: 24px;
        height: 24px;
    }

    .mini-chart {
        display: flex;
        align-items: flex-end;
        gap: 4px;
        height: 40px;
    }

    .mini-bar {
        flex: 1;
        background: linear-gradient(180deg, #ec4899 0%, #8b5cf6 100%);
        border-radius: 2px 2px 0 0;
    }

    /* Popular Dishes */
    .popular-dishes-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(450px, 1fr));
        gap: 1.5rem;
        margin-bottom: 2rem;
    }

    .popular-dishes-card {
        background: rgba(45, 55, 72, 0.5);
        backdrop-filter: blur(10px);
        border-radius: 1rem;
        padding: 1.5rem;
        border: 1px solid rgba(107, 114, 128, 0.3);
    }

    .card-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 1.5rem;
    }

    .card-header h2 {
        font-size: 1.25rem;
        font-weight: bold;
    }

    .see-all-btn {
        color: #ec4899;
        font-size: 0.875rem;
        font-weight: 500;
        background: none;
        border: none;
        cursor: pointer;
        transition: color 0.3s;
    }

    .see-all-btn:hover {
        color: #db2777;
    }

    .dishes-list {
        display: flex;
        flex-direction: column;
        gap: 1rem;
    }

    .dish-item {
        display: flex;
        align-items: center;
        gap: 1rem;
        padding: 0.75rem;
        border-radius: 12px;
        background: rgba(55, 65, 81, 0.3);
        transition: background 0.3s;
    }

    .dish-item:hover {
        background: rgba(55, 65, 81, 0.5);
    }

    .dish-image {
        width: 64px;
        height: 64px;
        border-radius: 8px;
        object-fit: cover;
    }

    .dish-info {
        flex: 1;
    }

    .dish-name {
        font-weight: 500;
        font-size: 0.875rem;
        margin-bottom: 0.25rem;
    }

    .dish-details {
        font-size: 0.75rem;
        color: #9ca3af;
    }

    .dish-price-info {
        text-align: right;
    }

    .dish-status {
        font-size: 0.75rem;
        font-weight: 500;
        margin-bottom: 0.25rem;
    }

    .dish-status.in-stock {
        color: #10b981;
    }

    .dish-status.out-of-stock {
        color: #ef4444;
    }

    .dish-price {
        font-size: 0.875rem;
        font-weight: bold;
    }

    /* Overview Chart */
    .overview-card {
        background: rgba(45, 55, 72, 0.5);
        backdrop-filter: blur(10px);
        border-radius: 1rem;
        padding: 1.5rem;
        border: 1px solid rgba(107, 114, 128, 0.3);
    }

    .overview-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 1.5rem;
    }

    .overview-header h2 {
        font-size: 1.25rem;
        font-weight: bold;
    }

    .overview-tabs {
        display: flex;
        gap: 0.5rem;
        align-items: center;
    }

    .tab-btn {
        padding: 0.5rem 1rem;
        background: rgba(55, 65, 81, 0.3);
        border: 1px solid rgba(107, 114, 128, 0.3);
        border-radius: 8px;
        color: #9ca3af;
        font-size: 0.875rem;
        cursor: pointer;
        transition: all 0.3s;
    }

    .tab-btn.active {
        background: linear-gradient(135deg, #ec4899 0%, #8b5cf6 100%);
        color: white;
        border-color: transparent;
    }

    .tab-btn:hover:not(.active) {
        background: rgba(55, 65, 81, 0.5);
        color: white;
    }

    .export-btn {
        display: flex;
        align-items: center;
        gap: 0.5rem;
        padding: 0.5rem 1rem;
        background: rgba(236, 72, 153, 0.1);
        border: 1px solid rgba(236, 72, 153, 0.3);
        border-radius: 8px;
        color: #ec4899;
        font-size: 0.875rem;
        cursor: pointer;
        transition: all 0.3s;
    }

    .export-btn:hover {
        background: rgba(236, 72, 153, 0.2);
    }

    .chart-container {
        height: 300px;
        display: flex;
        align-items: center;
        justify-content: center;
        color: #9ca3af;
    }
@endpush

@section('content')
    <!-- Metrics Cards -->
    <div class="metrics-grid">
        <div class="metric-card">
            <div class="metric-header">
                <div class="metric-info">
                    <h3>Daily Sales</h3>
                    <div class="metric-value">Rp 2jt</div>
                    <div class="metric-date">9 February 2024</div>
                </div>
                <div class="metric-icon">
                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                </div>
            </div>
            <div class="mini-chart">
                <div class="mini-bar" style="height: 30%"></div>
                <div class="mini-bar" style="height: 45%"></div>
                <div class="mini-bar" style="height: 35%"></div>
                <div class="mini-bar" style="height: 50%"></div>
                <div class="mini-bar" style="height: 40%"></div>
                <div class="mini-bar" style="height: 60%"></div>
                <div class="mini-bar" style="height: 50%"></div>
                <div class="mini-bar" style="height: 55%"></div>
                <div class="mini-bar" style="height: 65%"></div>
                <div class="mini-bar" style="height: 70%"></div>
            </div>
        </div>

        <div class="metric-card">
            <div class="metric-header">
                <div class="metric-info">
                    <h3>Monthly Revenue</h3>
                    <div class="metric-value">Rp 55jt</div>
                    <div class="metric-date">1 Jan - 1 Feb</div>
                </div>
                <div class="metric-icon">
                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6" />
                    </svg>
                </div>
            </div>
            <div class="mini-chart">
                <div class="mini-bar" style="height: 40%"></div>
                <div class="mini-bar" style="height: 50%"></div>
                <div class="mini-bar" style="height: 45%"></div>
                <div class="mini-bar" style="height: 60%"></div>
                <div class="mini-bar" style="height: 55%"></div>
                <div class="mini-bar" style="height: 70%"></div>
                <div class="mini-bar" style="height: 65%"></div>
                <div class="mini-bar" style="height: 75%"></div>
                <div class="mini-bar" style="height: 80%"></div>
                <div class="mini-bar" style="height: 85%"></div>
            </div>
        </div>

        <div class="metric-card">
            <div class="metric-header">
                <div class="metric-info">
                    <h3>Table Occupancy</h3>
                    <div class="metric-value">25 Tables</div>
                    <div class="metric-date">Currently occupied</div>
                </div>
                <div class="metric-icon">
                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M3 14h18m-9-4v8m-7 0h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z" />
                    </svg>
                </div>
            </div>
            <div class="mini-chart">
                <div class="mini-bar" style="height: 50%"></div>
                <div class="mini-bar" style="height: 60%"></div>
                <div class="mini-bar" style="height: 55%"></div>
                <div class="mini-bar" style="height: 70%"></div>
                <div class="mini-bar" style="height: 65%"></div>
                <div class="mini-bar" style="height: 80%"></div>
                <div class="mini-bar" style="height: 75%"></div>
                <div class="mini-bar" style="height: 85%"></div>
                <div class="mini-bar" style="height: 90%"></div>
                <div class="mini-bar" style="height: 95%"></div>
            </div>
        </div>
    </div>

    <!-- Popular Dishes -->
    <div class="popular-dishes-grid">
        <div class="popular-dishes-card">
            <div class="card-header">
                <h2>Popular Dishes</h2>
                <button class="see-all-btn">See All</button>
            </div>
            <div class="dishes-list">
                <div class="dish-item">
                    <img src="{{ asset('img/mie ayam.jfif') }}" alt="Mie Ayam Jumbo" class="dish-image">
                    <div class="dish-info">
                        <div class="dish-name">Mie Ayam Jumbo</div>
                        <div class="dish-details">Serving: 01 person</div>
                        <div class="dish-details">Order 7</div>
                    </div>
                    <div class="dish-price-info">
                        <div class="dish-status in-stock">In Stock</div>
                        <div class="dish-price">Rp 55.000</div>
                    </div>
                </div>
                <div class="dish-item">
                    <img src="{{ asset('img/mie ayam.jfif') }}" alt="Mie Ayam Jumbo" class="dish-image">
                    <div class="dish-info">
                        <div class="dish-name">Mie Ayam Jumbo</div>
                        <div class="dish-details">Serving: 01 person</div>
                        <div class="dish-details">Order 7</div>
                    </div>
                    <div class="dish-price-info">
                        <div class="dish-status in-stock">In Stock</div>
                        <div class="dish-price">Rp 55.000</div>
                    </div>
                </div>
                <div class="dish-item">
                    <img src="{{ asset('img/mie ayam.jfif') }}" alt="Mie Ayam Jumbo" class="dish-image">
                    <div class="dish-info">
                        <div class="dish-name">Mie Ayam Jumbo</div>
                        <div class="dish-details">Serving: 01 person</div>
                        <div class="dish-details">Order 7</div>
                    </div>
                    <div class="dish-price-info">
                        <div class="dish-status out-of-stock">Out of Stock</div>
                        <div class="dish-price">Rp 55.000</div>
                    </div>
                </div>
                <div class="dish-item">
                    <img src="{{ asset('img/mie ayam.jfif') }}" alt="Mie Ayam Jumbo" class="dish-image">
                    <div class="dish-info">
                        <div class="dish-name">Mie Ayam Jumbo</div>
                        <div class="dish-details">Serving: 01 person</div>
                        <div class="dish-details">Order 7</div>
                    </div>
                    <div class="dish-price-info">
                        <div class="dish-status in-stock">In Stock</div>
                        <div class="dish-price">Rp 55.000</div>
                    </div>
                </div>
            </div>
        </div>

        <div class="popular-dishes-card">
            <div class="card-header">
                <h2>Popular Dishes</h2>
                <button class="see-all-btn">See All</button>
            </div>
            <div class="dishes-list">
                <div class="dish-item">
                    <img src="{{ asset('img/mie ayam.jfif') }}" alt="Mie Ayam Jumbo" class="dish-image">
                    <div class="dish-info">
                        <div class="dish-name">Mie Ayam Jumbo</div>
                        <div class="dish-details">Serving: 01 person</div>
                        <div class="dish-details">Order 7</div>
                    </div>
                    <div class="dish-price-info">
                        <div class="dish-status in-stock">In Stock</div>
                        <div class="dish-price">Rp 110.000</div>
                    </div>
                </div>
                <div class="dish-item">
                    <img src="{{ asset('img/mie ayam.jfif') }}" alt="Mie Ayam Jumbo" class="dish-image">
                    <div class="dish-info">
                        <div class="dish-name">Mie Ayam Jumbo</div>
                        <div class="dish-details">Serving: 01 person</div>
                        <div class="dish-details">Order 7</div>
                    </div>
                    <div class="dish-price-info">
                        <div class="dish-status in-stock">In Stock</div>
                        <div class="dish-price">Rp 55.000</div>
                    </div>
                </div>
                <div class="dish-item">
                    <img src="{{ asset('img/mie ayam.jfif') }}" alt="Mie Ayam Jumbo" class="dish-image">
                    <div class="dish-info">
                        <div class="dish-name">Mie Ayam Jumbo</div>
                        <div class="dish-details">Serving: 01 person</div>
                        <div class="dish-details">Order 7</div>
                    </div>
                    <div class="dish-price-info">
                        <div class="dish-status out-of-stock">Out of Stock</div>
                        <div class="dish-price">Rp 55.000</div>
                    </div>
                </div>
                <div class="dish-item">
                    <img src="{{ asset('img/mie ayam.jfif') }}" alt="Mie Ayam Jumbo" class="dish-image">
                    <div class="dish-info">
                        <div class="dish-name">Mie Ayam Jumbo</div>
                        <div class="dish-details">Serving: 01 person</div>
                        <div class="dish-details">Order 7</div>
                    </div>
                    <div class="dish-price-info">
                        <div class="dish-status in-stock">In Stock</div>
                        <div class="dish-price">Rp 55.000</div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Overview Chart -->
    <div class="overview-card">
        <div class="overview-header">
            <h2>Overview</h2>
            <div class="overview-tabs">
                <button class="tab-btn active">Monthly</button>
                <button class="tab-btn">Daily</button>
                <button class="tab-btn">Weekly</button>
                <button class="export-btn">
                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24" width="16" height="16">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4" />
                    </svg>
                    <span>Export</span>
                </button>
            </div>
        </div>
        <div class="chart-container">
            <canvas id="overviewChart"></canvas>
        </div>
    </div>
@endsection
