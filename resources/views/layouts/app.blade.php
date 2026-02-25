<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ $pageTitle ?? 'Dashboard' }} - PINGU</title>
    
    <!-- Theme Initialization Script (Prevent FOUC) -->
    <script>
        (function() {
            const theme = localStorage.getItem('theme') || 'dark';
            document.documentElement.setAttribute('data-theme', theme);
        })();
    </script>
    
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    
    <style>
        :root {
            /* Light Mode Colors */
            --bg-primary: #ffffff;
            --bg-secondary: #f3f4f6;
            --bg-gradient-start: #f9fafb;
            --bg-gradient-end: #e5e7eb;
            --text-primary: #111827;
            --text-secondary: #6b7280;
            --text-tertiary: #9ca3af;
            --border-color: #e5e7eb;
            --card-bg: #ffffff;
            --card-bg-secondary: #f9fafb;
            --card-hover: #f3f4f6;
            --card-border: #e5e7eb;
            --sidebar-bg: rgba(255, 255, 255, 0.95);
            --sidebar-gradient-start: rgba(255, 255, 255, 0.95);
            --sidebar-gradient-end: rgba(249, 250, 251, 0.95);
            --nav-item-bg: rgba(243, 244, 246, 0.8);
            --nav-item-hover: rgba(229, 231, 235, 0.9);
            --nav-item-text: #6b7280;
            --topbar-bg: #ffffff;
            --input-bg: #ffffff;
            --input-border: #d1d5db;
            --shadow-color: rgba(0, 0, 0, 0.1);
            --shadow-hover: rgba(0, 0, 0, 0.15);
        }

        [data-theme="dark"] {
            /* Dark Mode Colors */
            --bg-primary: #0a0a0a;
            --bg-secondary: #1a1a1a;
            --bg-gradient-start: #000000;
            --bg-gradient-end: #1a1a1a;
            --text-primary: #ffffff;
            --text-secondary: #9ca3af;
            --text-tertiary: #6b7280;
            --border-color: #374151;
            --card-bg: rgba(26, 26, 26, 0.8);
            --card-bg-secondary: rgba(20, 20, 20, 0.7);
            --card-hover: rgba(30, 30, 30, 0.9);
            --card-border: rgba(60, 60, 60, 0.5);
            --sidebar-bg: rgba(0, 0, 0, 0.95);
            --sidebar-gradient-start: rgba(26, 26, 26, 0.95);
            --sidebar-gradient-end: rgba(0, 0, 0, 0.95);
            --nav-item-bg: rgba(60, 60, 60, 0.4);
            --nav-item-hover: rgba(80, 80, 80, 0.5);
            --nav-item-text: #9ca3af;
            --topbar-bg: transparent;
            --input-bg: rgba(30, 30, 30, 0.8);
            --input-border: #374151;
            --shadow-color: rgba(0, 0, 0, 0.5);
            --shadow-hover: rgba(0, 0, 0, 0.7);
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', sans-serif;
            background: linear-gradient(135deg, var(--bg-gradient-start) 0%, var(--bg-gradient-end) 100%);
            color: var(--text-primary);
            min-height: 100vh;
            transition: background 0.3s ease, color 0.3s ease;
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
            background: linear-gradient(180deg, var(--sidebar-gradient-start) 0%, var(--sidebar-gradient-end) 100%);
            backdrop-filter: blur(10px);
            border-right: 1px solid var(--border-color);
            display: flex;
            flex-direction: column;
            align-items: center;
            padding: 1.5rem 0;
            gap: 2rem;
            z-index: 100;
            overflow-y: auto;
            scrollbar-width: none; /* Firefox */
            -ms-overflow-style: none; /* IE and Edge */
            transition: background 0.3s ease;
        }

        .sidebar::-webkit-scrollbar {
            display: none; /* Chrome, Safari, Opera */
        }

        .logo {
            font-size: 0.875rem;
            font-weight: bold;
            background: linear-gradient(135deg, #a855f7 0%, #c084fc 100%);
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
            background: var(--nav-item-bg);
            color: var(--nav-item-text);
            text-decoration: none;
        }

        .nav-item.active {
            background: linear-gradient(135deg, #a855f7 0%, #c084fc 100%);
            color: white;
            box-shadow: 0 4px 15px rgba(168, 85, 247, 0.6);
        }

        .nav-item:hover:not(.active):not([disabled]) {
            background: var(--nav-item-hover);
            color: var(--text-primary);
        }

        .nav-item[disabled] {
            opacity: 0.5;
            cursor: not-allowed;
        }

        /* Locked Menu Item */
        .nav-item-locked {
            position: relative;
            opacity: 0.6;
        }

        .nav-item-locked:hover {
            background: rgba(239, 68, 68, 0.2) !important;
            color: #ef4444;
            opacity: 0.8;
        }

        .nav-item-locked .lock-icon {
            position: absolute;
            bottom: 2px;
            right: 2px;
            width: 12px;
            height: 12px;
            color: #ef4444;
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
            background: var(--nav-item-bg);
            color: var(--nav-item-text);
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
            background: var(--bg-primary);
            min-height: 100vh;
            transition: background 0.3s ease;
        }

        /* Top Bar */
        .topbar {
            background: var(--topbar-bg);
            padding: 1rem 2rem;
            display: flex;
            justify-content: space-between;
            align-items: center;
            position: relative;
            z-index: 1000;
            border-bottom: 1px solid var(--border-color);
            transition: all 0.3s ease;
        }

        .topbar-left {
            display: flex;
            align-items: center;
            gap: 1rem;
        }

        .back-btn {
            background: var(--nav-item-bg);
            border: 1px solid var(--border-color);
            color: var(--text-primary);
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
            background: var(--nav-item-hover);
        }

        .topbar h1 {
            font-size: 1.5rem;
            font-weight: bold;
        }

        .topbar-right {
            display: flex;
            align-items: center;
            gap: 1rem;
            position: relative;
            z-index: 99999;
        }

        /* Notification button styles moved to notification-panel.blade.php */

        .user-avatar {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            background: linear-gradient(135deg, #a855f7 0%, #c084fc 100%);
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: bold;
            box-shadow: 0 4px 10px rgba(168, 85, 247, 0.5);
        }

        /* Theme Toggle Button */
        .theme-toggle {
            width: 40px;
            height: 40px;
            border-radius: 10px;
            background: var(--nav-item-bg);
            border: 1px solid var(--border-color);
            color: var(--text-primary);
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: all 0.3s;
        }

        .theme-toggle:hover {
            background: var(--nav-item-hover);
            transform: rotate(15deg);
        }

        .theme-toggle svg {
            width: 20px;
            height: 20px;
        }

        .theme-icon {
            display: none;
        }

        [data-theme="light"] .theme-icon-light {
            display: block;
        }

        [data-theme="dark"] .theme-icon-dark {
            display: block;
        }

        /* Page Content */
        .page-content {
            flex: 1;
            padding: 2rem;
            overflow-y: auto;
        }

        /* Access Denied Modal */
        .access-denied-overlay {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.7);
            backdrop-filter: blur(4px);
            z-index: 100000;
            align-items: center;
            justify-content: center;
            animation: fadeIn 0.2s ease-out;
        }

        .access-denied-overlay.active {
            display: flex;
        }

        .access-denied-modal {
            background: var(--sidebar-bg);
            border: 1px solid rgba(239, 68, 68, 0.4);
            border-radius: 16px;
            padding: 2rem;
            max-width: 400px;
            width: 90%;
            box-shadow: 0 20px 60px var(--shadow-color);
            animation: slideUp 0.3s ease-out;
            text-align: center;
        }

        .access-denied-icon {
            width: 80px;
            height: 80px;
            margin: 0 auto 1.5rem;
            border-radius: 50%;
            background: linear-gradient(135deg, rgba(239, 68, 68, 0.2) 0%, rgba(220, 38, 38, 0.2) 100%);
            display: flex;
            align-items: center;
            justify-content: center;
            color: #ef4444;
        }

        .access-denied-title {
            font-size: 1.5rem;
            font-weight: bold;
            color: var(--text-primary);
            margin-bottom: 0.75rem;
        }

        .access-denied-message {
            font-size: 0.875rem;
            color: var(--text-secondary);
            margin-bottom: 0.5rem;
            line-height: 1.5;
        }

        .access-denied-submessage {
            font-size: 1rem;
            color: #fca5a5;
            font-weight: 600;
            margin-bottom: 2rem;
            padding: 0.75rem;
            background: rgba(239, 68, 68, 0.1);
            border-radius: 8px;
            border: 1px solid rgba(239, 68, 68, 0.2);
        }

        .access-denied-button {
            width: 100%;
            padding: 0.875rem 1.5rem;
            background: linear-gradient(135deg, #ef4444 0%, #dc2626 100%);
            border: none;
            border-radius: 10px;
            color: white;
            font-size: 0.875rem;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s;
        }

        .access-denied-button:hover {
            box-shadow: 0 4px 15px rgba(239, 68, 68, 0.4);
            transform: translateY(-1px);
        }

        @keyframes fadeIn {
            from { opacity: 0; }
            to { opacity: 1; }
        }

        @keyframes slideUp {
            from {
                transform: translateY(20px);
                opacity: 0;
            }
            to {
                transform: translateY(0);
                opacity: 1;
            }
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

    {{-- Profile Edit Modal --}}
    @include('partials.profile-modal')

    {{-- Access Denied Modal --}}
    <div id="accessDeniedModal" class="access-denied-overlay">
        <div class="access-denied-modal">
            <div class="access-denied-icon">
                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24" width="48" height="48">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                </svg>
            </div>
            <h3 class="access-denied-title">Akses Ditolak</h3>
            <p class="access-denied-message">Anda tidak memiliki akses ke menu <strong id="deniedMenuName"></strong>.</p>
            <div class="access-denied-submessage">Hubungi Admin Untuk Akses Menu</div>
            <button class="access-denied-button" onclick="closeAccessDeniedModal()">Mengerti</button>
        </div>
    </div>

    <script>
        // Show access denied modal
        function showAccessDeniedModal(menuName) {
            document.getElementById('deniedMenuName').textContent = menuName;
            document.getElementById('accessDeniedModal').classList.add('active');
        }

        // Close access denied modal
        function closeAccessDeniedModal() {
            document.getElementById('accessDeniedModal').classList.remove('active');
        }

        // Close modal on outside click
        document.getElementById('accessDeniedModal').addEventListener('click', function(e) {
            if (e.target === this) {
                closeAccessDeniedModal();
            }
        });

        // Close modal on ESC key
        document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape') {
                closeAccessDeniedModal();
            }
        });
    </script>

    {{-- Custom Scripts --}}
    @stack('scripts')
</body>
</html>
