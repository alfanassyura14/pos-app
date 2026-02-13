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
            @include('partials.notification-panel')
        @endif
        
        @if(config('navigation.topbar.show_user_avatar', true))
            <div class="user-profile-container">
                <div class="user-avatar" id="userProfileBtn" title="{{ Auth::user()->u_name }}" style="cursor: pointer;">
                    {{ strtoupper(substr(Auth::user()->u_name, 0, 1)) }}
                </div>
                
                <!-- Profile Dropdown -->
                <div class="profile-dropdown" id="profileDropdown" style="display: none;">
                    <div class="profile-dropdown-header">
                        <div class="profile-avatar-large">
                            {{ strtoupper(substr(Auth::user()->u_name, 0, 1)) }}
                        </div>
                        <div class="profile-info">
                            <div class="profile-name">{{ Auth::user()->u_name }}</div>
                            <div class="profile-email">{{ Auth::user()->u_email }}</div>
                        </div>
                    </div>
                    
                    <div class="profile-info-section">
                        <div class="profile-info-item">
                            <div class="profile-info-label">
                                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24" width="16" height="16">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                </svg>
                                Name
                            </div>
                            <div class="profile-info-value">{{ Auth::user()->u_name }}</div>
                        </div>
                        <div class="profile-info-item">
                            <div class="profile-info-label">
                                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24" width="16" height="16">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                                </svg>
                                Email
                            </div>
                            <div class="profile-info-value">{{ Auth::user()->u_email }}</div>
                        </div>
                        <div class="profile-info-item">
                            <div class="profile-info-label">
                                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24" width="16" height="16">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                                </svg>
                                Password
                            </div>
                            <div class="profile-info-value">••••••••</div>
                        </div>
                    </div>
                    
                    <div class="profile-dropdown-divider"></div>
                    <div class="profile-dropdown-menu">
                        <button class="profile-menu-item" id="editProfileBtn">
                            <svg fill="none" stroke="currentColor" viewBox="0 0 24 24" width="20" height="20">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                            </svg>
                            Edit Profile
                        </button>
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit" class="profile-menu-item profile-menu-item-danger">
                                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24" width="20" height="20">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                                </svg>
                                Logout
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        @endif
    </div>
</div>

<style>
    .user-profile-container {
        position: relative;
        z-index: 9997;
    }

    .profile-dropdown {
        position: absolute;
        top: calc(100% + 10px);
        right: 0;
        width: 340px;
        background: rgba(26, 26, 26, 0.98);
        backdrop-filter: blur(10px);
        border: 1px solid rgba(168, 85, 247, 0.3);
        border-radius: 12px;
        box-shadow: 0 10px 40px rgba(0, 0, 0, 0.5);
        z-index: 9996;
        overflow: hidden;
    }

    .profile-dropdown-header {
        padding: 1.5rem;
        display: flex;
        gap: 1rem;
        align-items: center;
        background: linear-gradient(135deg, rgba(168, 85, 247, 0.1) 0%, rgba(192, 132, 252, 0.1) 100%);
    }

    .profile-avatar-large {
        width: 60px;
        height: 60px;
        border-radius: 50%;
        background: linear-gradient(135deg, #a855f7 0%, #c084fc 100%);
        display: flex;
        align-items: center;
        justify-content: center;
        font-weight: bold;
        font-size: 1.5rem;
        box-shadow: 0 4px 15px rgba(168, 85, 247, 0.5);
        flex-shrink: 0;
    }

    .profile-info {
        flex: 1;
        min-width: 0;
    }

    .profile-name {
        font-weight: 600;
        font-size: 1.1rem;
        color: white;
        margin-bottom: 0.25rem;
        word-break: break-word;
    }

    .profile-email {
        font-size: 0.875rem;
        color: #9ca3af;
        word-break: break-all;
    }

    .profile-dropdown-divider {
        height: 1px;
        background: rgba(168, 85, 247, 0.2);
    }

    .profile-info-section {
        padding: 1rem 1.5rem;
        background: rgba(0, 0, 0, 0.2);
    }

    .profile-info-item {
        margin-bottom: 0.875rem;
    }

    .profile-info-item:last-child {
        margin-bottom: 0;
    }

    .profile-info-label {
        display: flex;
        align-items: center;
        gap: 0.5rem;
        font-size: 0.75rem;
        color: #9ca3af;
        text-transform: uppercase;
        letter-spacing: 0.05em;
        margin-bottom: 0.25rem;
    }

    .profile-info-value {
        font-size: 0.95rem;
        color: #e5e7eb;
        padding-left: 1.5rem;
        word-break: break-all;
    }

    .profile-dropdown-divider {
        height: 1px;
        background: rgba(168, 85, 247, 0.2);
    }

    .profile-dropdown-menu {
        padding: 0.5rem;
    }

    .profile-menu-item {
        width: 100%;
        display: flex;
        align-items: center;
        gap: 0.75rem;
        padding: 0.75rem 1rem;
        background: none;
        border: none;
        color: #e5e7eb;
        font-size: 0.95rem;
        border-radius: 8px;
        cursor: pointer;
        transition: all 0.2s;
        text-align: left;
    }

    .profile-menu-item:hover {
        background: rgba(168, 85, 247, 0.2);
        color: white;
    }

    .profile-menu-item-danger:hover {
        background: rgba(220, 38, 38, 0.2);
        color: #fca5a5;
    }

    .profile-menu-item svg {
        flex-shrink: 0;
    }
</style>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const userProfileBtn = document.getElementById('userProfileBtn');
        const profileDropdown = document.getElementById('profileDropdown');

        // Toggle profile dropdown
        userProfileBtn?.addEventListener('click', function(e) {
            e.stopPropagation();
            const isVisible = profileDropdown.style.display === 'block';
            profileDropdown.style.display = isVisible ? 'none' : 'block';
        });

        // Close dropdown when clicking outside
        document.addEventListener('click', function(e) {
            if (!e.target.closest('.user-profile-container')) {
                profileDropdown.style.display = 'none';
            }
        });

        // Open edit profile modal
        document.getElementById('editProfileBtn')?.addEventListener('click', function() {
            profileDropdown.style.display = 'none';
            document.getElementById('editProfileModal').style.display = 'flex';
        });
    });
</script>