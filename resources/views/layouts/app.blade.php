<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $pageTitle ?? 'Dashboard' }} - PINGU</title>
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
            min-height: 100vh;
        }

        .dashboard-container {
            display: flex;
            min-height: 100vh;
        }

        /* Sidebar Styles */
        .sidebar {
            position: fixed;
            left: 0;
            top: 0;
            width: 80px;
            height: 100vh;
            background: linear-gradient(180deg, rgba(45, 55, 72, 0.9) 0%, rgba(26, 32, 44, 0.9) 100%);
            backdrop-filter: blur(10px);
            display: flex;
            flex-direction: column;
            align-items: center;
            padding: 1.5rem 0;
            gap: 2rem;
            z-index: 100;
            overflow-y: auto;
            scrollbar-width: none; /* Firefox */
            -ms-overflow-style: none; /* IE and Edge */
        }

        .sidebar::-webkit-scrollbar {
            display: none; /* Chrome, Safari, Opera */
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

        .nav-item:hover:not(.active):not([disabled]) {
            background: rgba(107, 114, 128, 0.5);
            color: white;
        }

        .nav-item[disabled] {
            opacity: 0.5;
            cursor: not-allowed;
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
            margin-left: 80px;
            display: flex;
            flex-direction: column;
            background: #1a1d2e;
            min-height: 100vh;
        }

        /* Top Bar */
        .topbar {
            background: rgba(45, 55, 72, 0.5);
            backdrop-filter: blur(10px);
            padding: 1rem 2rem;
            display: flex;
            justify-content: space-between;
            align-items: center;
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

        /* Page Content */
        .page-content {
            flex: 1;
            padding: 2rem;
            overflow-y: auto;
        }

        /* Custom Styles dapat ditambahkan di sini atau di @stack('styles') */
        @stack('styles')
    </style>
</head>
<body>
    <div class="dashboard-container">
        {{-- Include Sidebar --}}
        @include('partials.sidebar')

        {{-- Main Content --}}
        <div class="main-content">
            {{-- Include Topbar --}}
            @include('partials.topbar')

            {{-- Page Content --}}
            <div class="page-content">
                @yield('content')
            </div>
        </div>
    </div>

    {{-- Custom Scripts --}}
    @stack('scripts')
</body>
</html>
