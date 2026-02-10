<!-- Top Bar -->
<div class="topbar">
    <div class="topbar-left">
        @if(isset($showBackButton) && $showBackButton)
            <button class="back-btn" onclick="window.history.back()">
                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24" width="24" height="24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                </svg>
            </button>
        @endif
        <h1>{{ $pageTitle ?? 'Dashboard' }}</h1>
    </div>
    
    <div class="topbar-right">
        @if(config('navigation.topbar.show_notifications', true))
            <button class="notification-btn" title="Notifications">
                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24" width="24" height="24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9" />
                </svg>
                @if(isset($notificationCount) && $notificationCount > 0)
                    <span class="notification-badge"></span>
                @endif
            </button>
        @endif
        
        @if(config('navigation.topbar.show_user_avatar', true))
            <div class="user-avatar" title="{{ Auth::user()->u_name }}">
                {{ strtoupper(substr(Auth::user()->u_name, 0, 1)) }}
            </div>
        @endif
    </div>
</div>
