<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - AZURRPOS</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        .dashboard-container {
            display: flex;
            min-height: 100vh;
        }

        /* Sidebar */
        .sidebar {
            width: 80px;
            background: linear-gradient(180deg, rgba(45, 55, 72, 0.9) 0%, rgba(26, 32, 44, 0.9) 100%);
            backdrop-filter: blur(10px);
            display: flex;
            flex-direction: column;
            align-items: center;
            padding: 1.5rem 0;
            gap: 2rem;
        }

        .logo {
            font-size: 0.875rem;
            font-weight: bold;
            background: linear-gradient(135deg, #ec4899 0%, #8b5cf6 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
            padding: 0.5rem 0.75rem;
            border-radius: 0.5rem;
        }

        .nav-items {
            flex: 1;
            display: flex;
            flex-direction: column;
            gap: 1.5rem;
            margin-top: 2rem;
        }

        .nav-item {
            width: 48px;
            height: 48px;
            border-radius: 12px;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            transition: all 0.3s;
            border: none;
            background: rgba(107, 114, 128, 0.3);
            color: #9ca3af;
        }

        .nav-item.active {
            background: linear-gradient(135deg, #ec4899 0%, #8b5cf6 100%);
            color: white;
            box-shadow: 0 4px 15px rgba(236, 72, 153, 0.4);
        }

        .nav-item:hover:not(.active) {
            background: rgba(107, 114, 128, 0.5);
            color: white;
        }

        .nav-item svg {
            width: 20px;
            height: 20px;
        }

        .nav-item span {
            font-size: 8px;
            margin-top: 2px;
        }

        .logout-btn {
            width: 48px;
            height: 48px;
            border-radius: 12px;
            background: rgba(107, 114, 128, 0.3);
            color: #9ca3af;
            border: none;
            cursor: pointer;
            transition: all 0.3s;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .logout-btn:hover {
            background: #dc2626;
            color: white;
        }

        /* Main Content */
        .main-content {
            flex: 1;
            display: flex;
            flex-direction: column;
        }

        /* Top Bar */
        .topbar {
            background: rgba(45, 55, 72, 0.5);
            backdrop-filter: blur(10px);
            padding: 1rem 2rem;
            display: flex;
            justify-content: space-between;
            align-items: center;
            border-bottom: 1px solid rgba(107, 114, 128, 0.3);
        }

        .topbar h1 {
            font-size: 1.5rem;
            font-weight: bold;
        }

        .topbar-right {
            display: flex;
            align-items: center;
            gap: 1rem;
        }

        .notification-btn {
            position: relative;
            padding: 0.5rem;
            background: none;
            border: none;
            color: #9ca3af;
            cursor: pointer;
            transition: color 0.3s;
        }

        .notification-btn:hover {
            color: white;
        }

        .notification-badge {
            position: absolute;
            top: 4px;
            right: 4px;
            width: 8px;
            height: 8px;
            background: #ec4899;
            border-radius: 50%;
        }

        .user-avatar {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            background: linear-gradient(135deg, #ec4899 0%, #8b5cf6 100%);
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: bold;
            box-shadow: 0 4px 10px rgba(236, 72, 153, 0.3);
        }

        /* Dashboard Content */
        .dashboard-content {
            flex: 1;
            padding: 2rem;
            overflow-y: auto;
        }

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
            color: #9ca3af;
            font-size: 0.875rem;
            margin-bottom: 0.5rem;
        }

        .metric-value {
            font-size: 2rem;
            font-weight: bold;
        }

        .metric-date {
            font-size: 0.75rem;
            color: #6b7280;
            margin-top: 0.25rem;
        }

        .metric-icon {
            width: 48px;
            height: 48px;
            border-radius: 50%;
            background: linear-gradient(135deg, #ec4899 0%, #8b5cf6 100%);
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .metric-icon svg {
            width: 24px;
            height: 24px;
        }

        .mini-chart {
            height: 64px;
            display: flex;
            align-items: flex-end;
            gap: 2px;
        }

        .mini-bar {
            flex: 1;
            background: linear-gradient(to top, #ec4899, #8b5cf6);
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

        .overview-tabs {
            display: flex;
            gap: 0.5rem;
        }

        .tab-btn {
            padding: 0.5rem 1rem;
            border-radius: 8px;
            border: none;
            font-size: 0.875rem;
            font-weight: 500;
            cursor: pointer;
            transition: all 0.3s;
            background: rgba(107, 114, 128, 0.3);
            color: #9ca3af;
        }

        .tab-btn.active {
            background: linear-gradient(135deg, #ec4899 0%, #8b5cf6 100%);
            color: white;
        }

        .tab-btn:hover:not(.active) {
            color: white;
        }

        .export-btn {
            padding: 0.5rem 1rem;
            border-radius: 8px;
            border: none;
            font-size: 0.875rem;
            font-weight: 500;
            cursor: pointer;
            background: rgba(107, 114, 128, 0.3);
            color: #9ca3af;
            display: flex;
            align-items: center;
            gap: 0.5rem;
            transition: all 0.3s;
        }

        .export-btn:hover {
            color: white;
        }

        .chart-container {
            height: 320px;
            position: relative;
        }
    </style>
</head>
<body>
    <div class="dashboard-container">
        <!-- Sidebar -->
        <div class="sidebar">
            <div class="logo">AZURRPOS</div>
            
            <div class="nav-items">
                <button class="nav-item active">
                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                    </svg>
                    <span>Dashboard</span>
                </button>
                <button class="nav-item">
                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                    </svg>
                    <span>Menu</span>
                </button>
                <button class="nav-item">
                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
                    </svg>
                    <span>Staff</span>
                </button>
                <button class="nav-item">
                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4" />
                    </svg>
                    <span>Inventory</span>
                </button>
                <button class="nav-item">
                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                    </svg>
                    <span>Reports</span>
                </button>
                <button class="nav-item">
                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M3 14h18m-9-4v8m-7 0h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z" />
                    </svg>
                    <span>Order/Table</span>
                </button>
                <button class="nav-item">
                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                    </svg>
                    <span>Reservation</span>
                </button>
            </div>

            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="logout-btn">
                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24" width="20" height="20">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                    </svg>
                </button>
            </form>
        </div>

        <!-- Main Content -->
        <div class="main-content">
            <!-- Top Bar -->
            <div class="topbar">
                <h1>Dashboard</h1>
                <div class="topbar-right">
                    <button class="notification-btn">
                        <svg fill="none" stroke="currentColor" viewBox="0 0 24 24" width="24" height="24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9" />
                        </svg>
                        <span class="notification-badge"></span>
                    </button>
                    <div class="user-avatar">{{ strtoupper(substr(Auth::user()->u_name, 0, 1)) }}</div>
                </div>
            </div>

            <!-- Dashboard Content -->
            <div class="dashboard-content">
                <!-- Metrics Cards -->
                <div class="metrics-grid">
                    <div class="metric-card">
                        <div class="metric-header">
                            <div class="metric-info">
                                <h3>Daily Sales</h3>
                                <div class="metric-value">$2k</div>
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
                                <div class="metric-value">$55k</div>
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
                                    <div class="dish-price">$55.00</div>
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
                                    <div class="dish-price">$55.00</div>
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
                                    <div class="dish-price">$55.00</div>
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
                                    <div class="dish-price">$55.00</div>
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
                                    <div class="dish-price">$110.00</div>
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
                                    <div class="dish-price">$55.00</div>
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
                                    <div class="dish-price">$55.00</div>
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
                                    <div class="dish-price">$55.00</div>
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
            </div>
        </div>
    </div>
</body>
</html>
