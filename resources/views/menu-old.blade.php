<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Menu - PINGU</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', sans-serif;
            background: linear-gradient(135deg, #1a202c 0%, #2d3748 100%);
            color: white;
        }

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
            text-decoration: none;
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
            background: #1a1d2e;
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

        .topbar-left {
            display: flex;
            align-items: center;
            gap: 1rem;
        }

        .back-btn {
            background: rgba(107, 114, 128, 0.3);
            border: none;
            color: white;
            width: 40px;
            height: 40px;
            border-radius: 10px;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: all 0.3s;
        }

        .back-btn:hover {
            background: rgba(107, 114, 128, 0.5);
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

        /* Menu Content */
        .menu-content {
            flex: 1;
            padding: 2rem;
            overflow-y: auto;
        }

        /* Categories Section */
        .section-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 1.5rem;
        }

        .section-header h2 {
            font-size: 1.25rem;
            font-weight: bold;
        }

        .add-btn {
            background: linear-gradient(135deg, #ec4899 0%, #db2777 100%);
            color: white;
            border: none;
            padding: 0.75rem 1.5rem;
            border-radius: 12px;
            cursor: pointer;
            font-weight: 500;
            transition: all 0.3s;
            box-shadow: 0 4px 15px rgba(236, 72, 153, 0.4);
        }

        .add-btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(236, 72, 153, 0.5);
        }

        .categories-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(140px, 1fr));
            gap: 1rem;
            margin-bottom: 3rem;
        }

        .category-card {
            background: rgba(45, 55, 72, 0.5);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(107, 114, 128, 0.3);
            border-radius: 16px;
            padding: 1.5rem;
            text-align: center;
            cursor: pointer;
            transition: all 0.3s;
            position: relative;
        }

        .category-card:hover {
            background: rgba(55, 65, 81, 0.6);
            transform: translateY(-4px);
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.3);
        }

        .category-card.active {
            background: linear-gradient(135deg, #ec4899 0%, #8b5cf6 100%);
            border-color: transparent;
        }

        .category-icon {
            font-size: 3rem;
            margin-bottom: 0.5rem;
            filter: drop-shadow(0 4px 10px rgba(0, 0, 0, 0.3));
        }

        .category-name {
            font-weight: 600;
            font-size: 0.9rem;
            margin-bottom: 0.25rem;
        }

        .category-count {
            font-size: 0.75rem;
            color: #9ca3af;
        }

        .category-card.active .category-count {
            color: rgba(255, 255, 255, 0.8);
        }

        /* Menu Tabs */
        .menu-tabs {
            display: flex;
            gap: 1rem;
            margin-bottom: 2rem;
            flex-wrap: wrap;
        }

        .menu-tab {
            background: rgba(45, 55, 72, 0.5);
            border: 1px solid rgba(107, 114, 128, 0.3);
            color: #9ca3af;
            padding: 0.75rem 1.5rem;
            border-radius: 12px;
            cursor: pointer;
            font-weight: 500;
            transition: all 0.3s;
        }

        .menu-tab.active {
            background: linear-gradient(135deg, #ec4899 0%, #8b5cf6 100%);
            color: white;
            border-color: transparent;
        }

        .menu-tab:hover:not(.active) {
            background: rgba(55, 65, 81, 0.6);
            color: white;
        }

        /* Products Table */
        .table-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 1rem;
        }

        .table-container {
            background: rgba(45, 55, 72, 0.3);
            border-radius: 16px;
            overflow: hidden;
        }

        .products-table {
            width: 100%;
            border-collapse: collapse;
        }

        .products-table thead {
            background: rgba(55, 65, 81, 0.5);
        }

        .products-table th {
            padding: 1rem;
            text-align: left;
            font-weight: 600;
            color: #9ca3af;
            font-size: 0.875rem;
        }

        .products-table td {
            padding: 1rem;
            border-top: 1px solid rgba(107, 114, 128, 0.2);
        }

        .products-table tbody tr {
            transition: background 0.3s;
        }

        .products-table tbody tr:hover {
            background: rgba(55, 65, 81, 0.3);
        }

        .product-info {
            display: flex;
            align-items: center;
            gap: 1rem;
        }

        .product-image {
            width: 60px;
            height: 60px;
            border-radius: 12px;
            object-fit: cover;
            background: rgba(107, 114, 128, 0.3);
        }

        .product-details h3 {
            font-weight: 600;
            margin-bottom: 0.25rem;
        }

        .product-details p {
            font-size: 0.75rem;
            color: #9ca3af;
        }

        .status-badge {
            padding: 0.375rem 0.75rem;
            border-radius: 8px;
            font-size: 0.75rem;
            font-weight: 500;
        }

        .status-badge.in-stock {
            background: rgba(16, 185, 129, 0.2);
            color: #10b981;
        }

        .status-badge.out-stock {
            background: rgba(239, 68, 68, 0.2);
            color: #ef4444;
        }

        .status-badge.low-stock {
            background: rgba(251, 191, 36, 0.2);
            color: #fbbf24;
        }

        .action-buttons {
            display: flex;
            gap: 0.5rem;
        }

        .icon-btn {
            background: rgba(107, 114, 128, 0.3);
            border: none;
            color: white;
            width: 36px;
            height: 36px;
            border-radius: 8px;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: all 0.3s;
        }

        .icon-btn:hover {
            background: rgba(107, 114, 128, 0.5);
        }

        .icon-btn.edit:hover {
            background: #3b82f6;
        }

        .icon-btn.delete:hover {
            background: #ef4444;
        }

        /* Modal Styles */
        .modal {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: rgba(0, 0, 0, 0.75);
            backdrop-filter: blur(4px);
            z-index: 1000;
            align-items: center;
            justify-content: center;
        }

        .modal.active {
            display: flex;
        }

        .modal-content {
            background: linear-gradient(135deg, #2d3748 0%, #1a202c 100%);
            border-radius: 20px;
            padding: 2rem;
            max-width: 500px;
            width: 90%;
            max-height: 90vh;
            overflow-y: auto;
            border: 1px solid rgba(107, 114, 128, 0.3);
            box-shadow: 0 20px 60px rgba(0, 0, 0, 0.5);
        }

        .modal-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 2rem;
        }

        .modal-header h2 {
            font-size: 1.5rem;
            font-weight: bold;
        }

        .close-btn {
            background: rgba(107, 114, 128, 0.3);
            border: none;
            color: white;
            width: 36px;
            height: 36px;
            border-radius: 50%;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: all 0.3s;
        }

        .close-btn:hover {
            background: #ef4444;
        }

        .form-group {
            margin-bottom: 1.5rem;
        }

        .form-group label {
            display: block;
            margin-bottom: 0.5rem;
            font-weight: 500;
            color: #e5e7eb;
        }

        .form-group input,
        .form-group select,
        .form-group textarea {
            width: 100%;
            padding: 0.75rem;
            background: rgba(55, 65, 81, 0.5);
            border: 1px solid rgba(107, 114, 128, 0.3);
            border-radius: 12px;
            color: white;
            font-size: 0.875rem;
            transition: all 0.3s;
        }

        .form-group input:focus,
        .form-group select:focus,
        .form-group textarea:focus {
            outline: none;
            border-color: #ec4899;
            background: rgba(55, 65, 81, 0.7);
        }

        .form-group textarea {
            resize: vertical;
            min-height: 100px;
        }

        .icon-selector {
            display: grid;
            grid-template-columns: repeat(6, 1fr);
            gap: 0.5rem;
            margin-top: 0.5rem;
        }

        .icon-option {
            aspect-ratio: 1;
            background: rgba(55, 65, 81, 0.5);
            border: 2px solid transparent;
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 2rem;
            cursor: pointer;
            transition: all 0.3s;
        }

        .icon-option:hover {
            background: rgba(75, 85, 99, 0.7);
        }

        .icon-option.selected {
            border-color: #ec4899;
            background: rgba(236, 72, 153, 0.2);
        }

        .image-upload {
            border: 2px dashed rgba(107, 114, 128, 0.5);
            border-radius: 12px;
            padding: 2rem;
            text-align: center;
            cursor: pointer;
            transition: all 0.3s;
        }

        .image-upload:hover {
            border-color: #ec4899;
            background: rgba(236, 72, 153, 0.05);
        }

        .image-upload input[type="file"] {
            display: none;
        }

        .image-preview {
            max-width: 200px;
            max-height: 200px;
            border-radius: 12px;
            margin-top: 1rem;
        }

        .modal-actions {
            display: flex;
            gap: 1rem;
            justify-content: flex-end;
            margin-top: 2rem;
        }

        .btn {
            padding: 0.75rem 1.5rem;
            border-radius: 12px;
            border: none;
            font-weight: 500;
            cursor: pointer;
            transition: all 0.3s;
        }

        .btn-cancel {
            background: rgba(107, 114, 128, 0.3);
            color: white;
        }

        .btn-cancel:hover {
            background: rgba(107, 114, 128, 0.5);
        }

        .btn-save {
            background: linear-gradient(135deg, #ec4899 0%, #db2777 100%);
            color: white;
            box-shadow: 0 4px 15px rgba(236, 72, 153, 0.4);
        }

        .btn-save:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(236, 72, 153, 0.5);
        }

        /* Success Message */
        .success-message {
            background: linear-gradient(135deg, #10b981 0%, #059669 100%);
            color: white;
            padding: 1rem 1.5rem;
            border-radius: 12px;
            margin-bottom: 1.5rem;
            display: flex;
            align-items: center;
            gap: 0.75rem;
            box-shadow: 0 4px 15px rgba(16, 185, 129, 0.4);
        }
    </style>
</head>
<body>
    <div class="dashboard-container">
        <!-- Sidebar -->
        <aside class="sidebar">
            <div class="logo">COSYPOS</div>
            
            <nav class="nav-items">
                <a href="{{ route('dashboard') }}" class="nav-item">
                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path>
                    </svg>
                    <span>Dashboard</span>
                </a>
                
                <a href="{{ route('menu') }}" class="nav-item active">
                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
                    </svg>
                    <span>Menu</span>
                </a>
                
                <button class="nav-item">
                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                    </svg>
                    <span>Staff</span>
                </button>
                
                <button class="nav-item">
                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path>
                    </svg>
                    <span>Inventory</span>
                </button>
                
                <button class="nav-item">
                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                    </svg>
                    <span>Reports</span>
                </button>
                
                <button class="nav-item">
                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"></path>
                    </svg>
                    <span>Order/Table</span>
                </button>
                
                <button class="nav-item">
                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                    </svg>
                    <span>Reservation</span>
                </button>
            </nav>
            
            <form action="{{ route('logout') }}" method="POST">
                @csrf
                <button type="submit" class="logout-btn">
                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24" width="20" height="20">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path>
                    </svg>
                </button>
            </form>
        </aside>

        <!-- Main Content -->
        <main class="main-content">
            <!-- Top Bar -->
            <div class="topbar">
                <div class="topbar-left">
                    <button class="back-btn" onclick="window.history.back()">
                        <svg fill="none" stroke="currentColor" viewBox="0 0 24 24" width="20" height="20">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
                        </svg>
                    </button>
                    <h1>Menu</h1>
                </div>
                <div class="topbar-right">
                    <button class="notification-btn">
                        <svg fill="none" stroke="currentColor" viewBox="0 0 24 24" width="24" height="24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"></path>
                        </svg>
                    </button>
                    <div class="user-avatar">{{ substr(auth()->user()->u_name ?? 'A', 0, 1) }}</div>
                </div>
            </div>

            <!-- Menu Content -->
            <div class="menu-content">
                @if(session('success'))
                    <div class="success-message">
                        <svg fill="none" stroke="currentColor" viewBox="0 0 24 24" width="24" height="24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        {{ session('success') }}
                    </div>
                @endif

                <!-- Categories Section -->
                <div class="section-header">
                    <h2>Categories</h2>
                    <button class="add-btn" id="addCategoryBtn">Add New Category</button>
                </div>

                <div class="categories-grid">
                    <div class="category-card active" data-category="all">
                        <div class="category-icon">
                            <svg fill="none" stroke="currentColor" viewBox="0 0 24 24" width="48" height="48">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z"></path>
                            </svg>
                        </div>
                        <div class="category-name">All</div>
                        <div class="category-count">{{ $products->count() }} items</div>
                    </div>

                    @foreach($categories as $category)
                    <div class="category-card" data-category="{{ $category->id }}">
                        <div class="category-icon">
                            {!! $category->icon ?? '📦' !!}
                        </div>
                        <div class="category-name">{{ $category->name }}</div>
                        <div class="category-count">{{ $category->products_count }} items</div>
                        <div class="action-buttons" style="position: absolute; top: 0.5rem; right: 0.5rem; display: none;">
                            <button class="icon-btn edit" data-id="{{ $category->id }}" data-name="{{ $category->name }}" data-description="{{ $category->description }}" data-icon="{{ $category->icon }}" data-menu-type="{{ $category->menu_type }}">
                                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24" width="16" height="16">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                </svg>
                            </button>
                            <button class="icon-btn delete" data-id="{{ $category->id }}" data-name="{{ $category->name }}">
                                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24" width="16" height="16">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                </svg>
                            </button>
                        </div>
                    </div>
                    @endforeach
                </div>

                <!-- Special Menu Section -->
                <div class="section-header">
                    <h2>Special menu all items</h2>
                    <button class="add-btn" id="addProductBtn">Add Menu Item</button>
                </div>

                <div class="menu-tabs">
                    <button class="menu-tab active" data-menu-type="all">Normal Menu</button>
                    @foreach($menuTypes as $menuType)
                    <button class="menu-tab" data-menu-type="{{ $menuType }}">{{ $menuType }}</button>
                    @endforeach
                </div>

                <!-- Products Table -->
                <div class="table-container">
                    <table class="products-table">
                        <thead>
                            <tr>
                                <th style="width: 40px;">
                                    <input type="checkbox" id="select-all">
                                </th>
                                <th>Product</th>
                                <th>Product Name</th>
                                <th>Item ID</th>
                                <th>Stock</th>
                                <th>Category</th>
                                <th>Price</th>
                                <th>Availability</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody id="products-tbody">
                            @foreach($products as $product)
                            <tr class="product-row" data-category="{{ $product->category_id }}" data-menu-type="{{ $product->category->menu_type ?? 'Normal Menu' }}">
                                <td>
                                    <input type="checkbox" class="product-checkbox">
                                </td>
                                <td>
                                    <div class="product-info">
                                        <img src="{{ $product->image ? asset('storage/' . $product->image) : 'https://via.placeholder.com/60' }}" alt="{{ $product->name }}" class="product-image">
                                    </div>
                                </td>
                                <td>
                                    <div class="product-details">
                                        <h3>{{ $product->name }}</h3>
                                        <p>{{ Str::limit($product->description, 50) }}</p>
                                    </div>
                                </td>
                                <td>#{{ str_pad($product->id, 7, '0', STR_PAD_LEFT) }}</td>
                                <td>{{ $product->stock }} items</td>
                                <td>{{ $product->category->name ?? 'N/A' }}</td>
                                <td>Rp. {{ number_format($product->price, 0, ',', '.') }}</td>
                                <td>
                                    <span class="status-badge {{ $product->status == 'In Stock' ? 'in-stock' : ($product->status == 'Out of Stock' ? 'out-stock' : 'low-stock') }}">
                                        {{ $product->status }}
                                    </span>
                                </td>
                                <td>
                                    <div class="action-buttons">
                                        <button class="icon-btn edit product-edit" data-id="{{ $product->id }}" data-name="{{ $product->name }}" data-description="{{ $product->description }}" data-price="{{ $product->price }}" data-stock="{{ $product->stock }}" data-category="{{ $product->category_id }}" data-image="{{ $product->image }}" data-serving="{{ $product->serving }}">
                                            <svg fill="none" stroke="currentColor" viewBox="0 0 24 24" width="16" height="16">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                            </svg>
                                        </button>
                                        <button class="icon-btn delete product-delete" data-id="{{ $product->id }}" data-name="{{ $product->name }}">
                                            <svg fill="none" stroke="currentColor" viewBox="0 0 24 24" width="16" height="16">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                            </svg>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </main>
    </div>

    <!-- Category Modal -->
    <div class="modal" id="categoryModal">
        <div class="modal-content">
            <div class="modal-header">
                <h2 id="categoryModalTitle">Add New Category</h2>
                <button class="close-btn" id="closeCategoryModal">
                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24" width="20" height="20">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                </button>
            </div>

            <form id="categoryForm" method="POST" action="{{ route('categories.store') }}">
                @csrf
                <input type="hidden" name="_method" id="categoryMethod" value="POST">
                <input type="hidden" name="category_id" id="categoryId">

                <div class="form-group">
                    <label>Select Icon here</label>
                    <div class="image-upload" style="padding: 1rem; text-align: left;">
                        <div style="color: #9ca3af; font-size: 0.875rem; margin-bottom: 0.5rem;">Select icon</div>
                        <button type="button" class="btn" id="toggleIconSelector" style="background: rgba(107, 114, 128, 0.3); padding: 0.5rem 1rem;">Change Icon</button>
                    </div>
                    <input type="hidden" name="icon" id="categoryIcon" value="📦">
                    <div class="icon-selector" id="iconSelector" style="display: none;">
                        <div class="icon-option" data-icon="🍕">🍕</div>
                        <div class="icon-option" data-icon="🍔">🍔</div>
                        <div class="icon-option" data-icon="🍗">🍗</div>
                        <div class="icon-option" data-icon="🎂">🎂</div>
                        <div class="icon-option" data-icon="🥤">🥤</div>
                        <div class="icon-option" data-icon="🍤">🍤</div>
                        <div class="icon-option" data-icon="🍜">🍜</div>
                        <div class="icon-option" data-icon="🍝">🍝</div>
                        <div class="icon-option" data-icon="🍛">🍛</div>
                        <div class="icon-option" data-icon="🍱">🍱</div>
                        <div class="icon-option" data-icon="🍣">🍣</div>
                        <div class="icon-option" data-icon="🥗">🥗</div>
                    </div>
                </div>

                <div class="form-group">
                    <label for="categoryName">Category Name</label>
                    <input type="text" id="categoryName" name="name" placeholder="Enter Category Name" required>
                </div>

                <div class="form-group">
                    <label for="categoryMenuType">Select Menu</label>
                    <select id="categoryMenuType" name="menu_type" required>
                        @foreach($menuTypes as $menuType)
                        <option value="{{ $menuType }}">{{ $menuType }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="form-group">
                    <label for="categoryDescription">Description</label>
                    <textarea id="categoryDescription" name="description" placeholder="write your category description here"></textarea>
                </div>

                <div class="modal-actions">
                    <button type="button" class="btn btn-cancel" id="cancelCategoryBtn">Cancel</button>
                    <button type="submit" class="btn btn-save">Save</button>
                </div>
            </form>
        </div>
    </div>

    <!-- Product Modal -->
    <div class="modal" id="productModal">
        <div class="modal-content">
            <div class="modal-header">
                <h2 id="productModalTitle">Add Menu Item</h2>
                <button class="close-btn" id="closeProductModal">
                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24" width="20" height="20">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                </button>
            </div>

            <form id="productForm" method="POST" action="{{ route('products.store') }}" enctype="multipart/form-data">
                @csrf
                <input type="hidden" name="_method" id="productMethod" value="POST">
                <input type="hidden" name="product_id" id="productId">

                <div class="form-group">
                    <label>Product Image</label>
                    <div class="image-upload" id="imageUploadArea">
                        <svg fill="none" stroke="currentColor" viewBox="0 0 24 24" width="48" height="48" style="margin: 0 auto; color: #9ca3af;">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                        </svg>
                        <p style="color: #9ca3af; margin-top: 0.5rem;">Click to upload product image</p>
                        <input type="file" id="productImage" name="image" accept="image/*" style="display: none;">
                    </div>
                    <img id="imagePreview" class="image-preview" style="display: none; margin: 0 auto;">
                </div>

                <div class="form-group">
                    <label for="productName">Product Name</label>
                    <input type="text" id="productName" name="name" placeholder="Enter Product Name" required>
                </div>

                <div class="form-group">
                    <label for="productCategory">Category</label>
                    <select id="productCategory" name="category_id" required>
                        @foreach($categories as $category)
                        <option value="{{ $category->id }}">{{ $category->name }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="form-group">
                    <label for="productDescription">Description</label>
                    <textarea id="productDescription" name="description" placeholder="Enter product description"></textarea>
                </div>

                <div class="form-group">
                    <label for="productPrice">Price (Rp.)</label>
                    <input type="number" id="productPrice" name="price" placeholder="0" step="1" min="0" required>
                </div>

                <div class="form-group">
                    <label for="productStock">Stock Quantity</label>
                    <input type="number" id="productStock" name="stock" placeholder="0" min="0" required>
                </div>

                <div class="form-group">
                    <label for="productServing">Serving (Optional)</label>
                    <input type="text" id="productServing" name="serving" placeholder="e.g., 1-2 persons">
                </div>

                <div class="modal-actions">
                    <button type="button" class="btn btn-cancel" id="cancelProductBtn">Cancel</button>
                    <button type="submit" class="btn btn-save">Save</button>
                </div>
            </form>
        </div>
    </div>

    <script>
        // DOM Elements
        const categoryModal = document.getElementById('categoryModal');
        const productModal = document.getElementById('productModal');
        const categoryForm = document.getElementById('categoryForm');
        const productForm = document.getElementById('productForm');

        // Category Modal Functions
        function openCategoryModal() {
            categoryModal.classList.add('active');
            document.getElementById('categoryModalTitle').textContent = 'Add New Category';
            categoryForm.action = "{{ route('categories.store') }}";
            document.getElementById('categoryMethod').value = 'POST';
            categoryForm.reset();
            document.getElementById('categoryIcon').value = '📦';
        }

        function closeCategoryModal() {
            categoryModal.classList.remove('active');
        }

        // Product Modal Functions  
        function openProductModal() {
            productModal.classList.add('active');
            document.getElementById('productModalTitle').textContent = 'Add Menu Item';
            productForm.action = "{{ route('products.store') }}";
            document.getElementById('productMethod').value = 'POST';
            productForm.reset();
            document.getElementById('imagePreview').style.display = 'none';
        }

        function closeProductModal() {
            productModal.classList.remove('active');
        }

        // Event Listeners
        document.getElementById('addCategoryBtn').addEventListener('click', openCategoryModal);
        document.getElementById('closeCategoryModal').addEventListener('click', closeCategoryModal);
        document.getElementById('cancelCategoryBtn').addEventListener('click', closeCategoryModal);

        document.getElementById('addProductBtn').addEventListener('click', openProductModal);
        document.getElementById('closeProductModal').addEventListener('click', closeProductModal);
        document.getElementById('cancelProductBtn').addEventListener('click', closeProductModal);

        // Icon selector toggle
        document.getElementById('toggleIconSelector').addEventListener('click', function() {
            const selector = document.getElementById('iconSelector');
            selector.style.display = selector.style.display === 'none' ? 'grid' : 'none';
        });

        // Icon selection
        document.querySelectorAll('.icon-option').forEach(option => {
            option.addEventListener('click', function() {
                const icon = this.getAttribute('data-icon');
                document.getElementById('categoryIcon').value = icon;
                document.querySelectorAll('.icon-option').forEach(opt => opt.classList.remove('selected'));
                this.classList.add('selected');
            });
        });

        // Image upload area click
        document.getElementById('imageUploadArea').addEventListener('click', function() {
            document.getElementById('productImage').click();
        });

        // Image preview
        document.getElementById('productImage').addEventListener('change', function() {
            if (this.files && this.files[0]) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    document.getElementById('imagePreview').src = e.target.result;
                    document.getElementById('imagePreview').style.display = 'block';
                };
                reader.readAsDataURL(this.files[0]);
            }
        });

        // Category filtering
        document.querySelectorAll('.category-card').forEach(card => {
            card.addEventListener('click', function(e) {
                // Don't filter if clicking action buttons
                if (e.target.closest('.action-buttons')) return;
                
                const categoryId = this.getAttribute('data-category');
                document.querySelectorAll('.category-card').forEach(c => c.classList.remove('active'));
                this.classList.add('active');

                const rows = document.querySelectorAll('.product-row');
                rows.forEach(row => {
                    if (categoryId === 'all' || row.dataset.category == categoryId) {
                        row.style.display = '';
                    } else {
                        row.style.display = 'none';
                    }
                });
            });
        });

        // Menu type filtering
        document.querySelectorAll('.menu-tab').forEach(tab => {
            tab.addEventListener('click', function() {
                const menuType = this.getAttribute('data-menu-type');
                document.querySelectorAll('.menu-tab').forEach(t => t.classList.remove('active'));
                this.classList.add('active');

                const rows = document.querySelectorAll('.product-row');
                rows.forEach(row => {
                    if (menuType === 'all' || row.dataset.menuType === menuType) {
                        row.style.display = '';
                    } else {
                        row.style.display = 'none';
                    }
                });
            });
        });

        // Category Edit
        document.querySelectorAll('.category-card .edit').forEach(btn => {
            btn.addEventListener('click', function(e) {
                e.stopPropagation();
                const id = this.getAttribute('data-id');
                const name = this.getAttribute('data-name');
                const description = this.getAttribute('data-description');
                const icon = this.getAttribute('data-icon');
                const menuType = this.getAttribute('data-menu-type');

                categoryModal.classList.add('active');
                document.getElementById('categoryModalTitle').textContent = 'Edit Category';
                categoryForm.action = `/categories/${id}`;
                document.getElementById('categoryMethod').value = 'PUT';
                document.getElementById('categoryId').value = id;
                document.getElementById('categoryName').value = name;
                document.getElementById('categoryDescription').value = description;
                document.getElementById('categoryIcon').value = icon;
                document.getElementById('categoryMenuType').value = menuType;
            });
        });

        // Category Delete
        document.querySelectorAll('.category-card .delete').forEach(btn => {
            btn.addEventListener('click', function(e) {
                e.stopPropagation();
                const id = this.getAttribute('data-id');
                const name = this.getAttribute('data-name');

                if (confirm(`Are you sure you want to delete "${name}" category?`)) {
                    const form = document.createElement('form');
                    form.method = 'POST';
                    form.action = `/categories/${id}`;
                    form.innerHTML = `
                        @csrf
                        <input type="hidden" name="_method" value="DELETE">
                    `;
                    document.body.appendChild(form);
                    form.submit();
                }
            });
        });

        // Product Edit
        document.querySelectorAll('.product-edit').forEach(btn => {
            btn.addEventListener('click', function() {
                const id = this.getAttribute('data-id');
                const name = this.getAttribute('data-name');
                const description = this.getAttribute('data-description');
                const price = this.getAttribute('data-price');
                const stock = this.getAttribute('data-stock');
                const categoryId = this.getAttribute('data-category');
                const image = this.getAttribute('data-image');
                const serving = this.getAttribute('data-serving');

                productModal.classList.add('active');
                document.getElementById('productModalTitle').textContent = 'Edit Menu Item';
                productForm.action = `/products/${id}`;
                document.getElementById('productMethod').value = 'PUT';
                document.getElementById('productId').value = id;
                document.getElementById('productName').value = name;
                document.getElementById('productDescription').value = description;
                document.getElementById('productPrice').value = price;
                document.getElementById('productStock').value = stock;
                document.getElementById('productCategory').value = categoryId;
                document.getElementById('productServing').value = serving;
                
                if (image && image !== 'null') {
                    document.getElementById('imagePreview').src = `/storage/${image}`;
                    document.getElementById('imagePreview').style.display = 'block';
                } else {
                    document.getElementById('imagePreview').style.display = 'none';
                }
            });
        });

        // Product Delete
        document.querySelectorAll('.product-delete').forEach(btn => {
            btn.addEventListener('click', function() {
                const id = this.getAttribute('data-id');
                const name = this.getAttribute('data-name');

                if (confirm(`Are you sure you want to delete "${name}"?`)) {
                    const form = document.createElement('form');
                    form.method = 'POST';
                    form.action = `/products/${id}`;
                    form.innerHTML = `
                        @csrf
                        <input type="hidden" name="_method" value="DELETE">
                    `;
                    document.body.appendChild(form);
                    form.submit();
                }
            });
        });

        // Close modals when clicking outside
        window.onclick = function(event) {
            if (event.target.classList.contains('modal')) {
                event.target.classList.remove('active');
            }
        };

        // Show edit/delete buttons on hover for categories
        document.querySelectorAll('.category-card').forEach(card => {
            card.addEventListener('mouseenter', function() {
                const actions = this.querySelector('.action-buttons');
                if (actions) actions.style.display = 'flex';
            });
            card.addEventListener('mouseleave', function() {
                const actions = this.querySelector('.action-buttons');
                if (actions) actions.style.display = 'none';
            });
        });
    </script>
</body>
</html>
