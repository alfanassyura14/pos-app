<!-- Edit Profile Modal -->
<div id="editProfileModal" class="modal-overlay" style="display: none;">
    <div class="modal-container" style="max-width: 500px;">
        <div class="modal-header">
            <h2 class="modal-title">Edit Profile</h2>
            <button type="button" class="modal-close" onclick="closeProfileModal()">
                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24" width="24" height="24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                </svg>
            </button>
        </div>

        @if(session('profile_success'))
            <div class="alert alert-success" style="margin: 1rem; padding: 1rem; background: rgba(34, 197, 94, 0.2); border: 1px solid rgba(34, 197, 94, 0.3); border-radius: 8px; color: #86efac;">
                {{ session('profile_success') }}
            </div>
        @endif

        @if($errors->any())
            <div class="alert alert-danger" style="margin: 1rem; padding: 1rem; background: rgba(220, 38, 38, 0.2); border: 1px solid rgba(220, 38, 38, 0.3); border-radius: 8px; color: #fca5a5;">
                <ul style="margin: 0; padding-left: 1.25rem;">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('profile.update') }}" method="POST" class="modal-body">
            @csrf
            @method('PUT')

            <div class="form-group">
                <label class="form-label">Name</label>
                <input 
                    type="text" 
                    name="u_name" 
                    class="form-input" 
                    value="{{ old('u_name', Auth::user()->u_name) }}" 
                    required
                    style="width: 100%; padding: 0.75rem; background: rgba(60, 60, 60, 0.5); border: 1px solid rgba(168, 85, 247, 0.3); border-radius: 8px; color: white; font-size: 0.95rem;"
                >
            </div>

            <div class="form-group" style="margin-top: 1rem;">
                <label class="form-label">Email</label>
                <input 
                    type="email" 
                    name="u_email" 
                    class="form-input" 
                    value="{{ old('u_email', Auth::user()->u_email) }}" 
                    required
                    style="width: 100%; padding: 0.75rem; background: rgba(60, 60, 60, 0.5); border: 1px solid rgba(168, 85, 247, 0.3); border-radius: 8px; color: white; font-size: 0.95rem;"
                >
            </div>

            <div class="form-group" style="margin-top: 1rem;">
                <label class="form-label">Current Password</label>
                <div style="position: relative;">
                    <input 
                        type="password" 
                        name="current_password" 
                        id="currentPassword"
                        class="form-input" 
                        placeholder="••••••••"
                        style="width: 100%; padding: 0.75rem; padding-right: 3rem; background: rgba(60, 60, 60, 0.5); border: 1px solid rgba(168, 85, 247, 0.3); border-radius: 8px; color: white; font-size: 0.95rem;"
                    >
                    <button 
                        type="button" 
                        onclick="togglePassword('currentPassword', 'toggleCurrentIcon')" 
                        style="position: absolute; right: 0.75rem; top: 50%; transform: translateY(-50%); background: none; border: none; color: #9ca3af; cursor: pointer; padding: 0.25rem;"
                    >
                        <svg id="toggleCurrentIcon" fill="none" stroke="currentColor" viewBox="0 0 24 24" width="20" height="20">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                        </svg>
                    </button>
                </div>
                <small style="color: #9ca3af; font-size: 0.8rem; display: block; margin-top: 0.25rem;">
                    Leave blank to keep current password
                </small>
            </div>

            <div class="form-group" style="margin-top: 1rem;">
                <label class="form-label">New Password</label>
                <div style="position: relative;">
                    <input 
                        type="password" 
                        name="new_password" 
                        id="newPassword"
                        class="form-input" 
                        placeholder="••••••••"
                        style="width: 100%; padding: 0.75rem; padding-right: 3rem; background: rgba(60, 60, 60, 0.5); border: 1px solid rgba(168, 85, 247, 0.3); border-radius: 8px; color: white; font-size: 0.95rem;"
                    >
                    <button 
                        type="button" 
                        onclick="togglePassword('newPassword', 'toggleNewIcon')" 
                        style="position: absolute; right: 0.75rem; top: 50%; transform: translateY(-50%); background: none; border: none; color: #9ca3af; cursor: pointer; padding: 0.25rem;"
                    >
                        <svg id="toggleNewIcon" fill="none" stroke="currentColor" viewBox="0 0 24 24" width="20" height="20">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                        </svg>
                    </button>
                </div>
            </div>

            <div class="form-group" style="margin-top: 1rem;">
                <label class="form-label">Confirm New Password</label>
                <div style="position: relative;">
                    <input 
                        type="password" 
                        name="new_password_confirmation" 
                        id="confirmPassword"
                        class="form-input" 
                        placeholder="••••••••"
                        style="width: 100%; padding: 0.75rem; padding-right: 3rem; background: rgba(60, 60, 60, 0.5); border: 1px solid rgba(168, 85, 247, 0.3); border-radius: 8px; color: white; font-size: 0.95rem;"
                    >
                    <button 
                        type="button" 
                        onclick="togglePassword('confirmPassword', 'toggleConfirmIcon')" 
                        style="position: absolute; right: 0.75rem; top: 50%; transform: translateY(-50%); background: none; border: none; color: #9ca3af; cursor: pointer; padding: 0.25rem;"
                    >
                        <svg id="toggleConfirmIcon" fill="none" stroke="currentColor" viewBox="0 0 24 24" width="20" height="20">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                        </svg>
                    </button>
                </div>
            </div>

            <div class="modal-footer" style="margin-top: 1.5rem; display: flex; gap: 0.75rem; justify-content: flex-end;">
                <button 
                    type="button" 
                    onclick="closeProfileModal()" 
                    class="btn-secondary"
                    style="padding: 0.75rem 1.5rem; background: rgba(60, 60, 60, 0.5); border: none; border-radius: 8px; color: #e5e7eb; cursor: pointer; font-size: 0.95rem; transition: all 0.2s;"
                >
                    Cancel
                </button>
                <button 
                    type="submit" 
                    class="btn-primary"
                    style="padding: 0.75rem 1.5rem; background: linear-gradient(135deg, #a855f7 0%, #c084fc 100%); border: none; border-radius: 8px; color: white; cursor: pointer; font-size: 0.95rem; font-weight: 600; transition: all 0.2s;"
                >
                    Save Changes
                </button>
            </div>
        </form>
    </div>
</div>

<style>
    .modal-overlay {
        position: fixed;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: rgba(0, 0, 0, 0.8);
        backdrop-filter: blur(4px);
        display: flex;
        align-items: center;
        justify-content: center;
        z-index: 9999;
        padding: 1rem;
    }

    .modal-container {
        background: rgba(26, 26, 26, 0.98);
        border: 1px solid rgba(168, 85, 247, 0.3);
        border-radius: 16px;
        box-shadow: 0 20px 60px rgba(0, 0, 0, 0.5);
        width: 100%;
        max-height: 90vh;
        overflow-y: auto;
    }

    .modal-header {
        padding: 1.5rem;
        border-bottom: 1px solid rgba(168, 85, 247, 0.2);
        display: flex;
        justify-content: space-between;
        align-items: center;
    }

    .modal-title {
        font-size: 1.5rem;
        font-weight: 600;
        color: white;
        margin: 0;
    }

    .modal-close {
        background: none;
        border: none;
        color: #9ca3af;
        cursor: pointer;
        padding: 0.25rem;
        transition: color 0.2s;
    }

    .modal-close:hover {
        color: white;
    }

    .modal-body {
        padding: 1.5rem;
    }

    .form-label {
        display: block;
        color: #e5e7eb;
        font-size: 0.9rem;
        font-weight: 500;
        margin-bottom: 0.5rem;
    }

    .form-input:focus {
        outline: none;
        border-color: #a855f7;
        box-shadow: 0 0 0 3px rgba(168, 85, 247, 0.1);
    }

    .btn-secondary:hover {
        background: rgba(80, 80, 80, 0.5);
    }

    .btn-primary:hover {
        transform: translateY(-1px);
        box-shadow: 0 4px 15px rgba(168, 85, 247, 0.5);
    }
</style>

<script>
    function closeProfileModal() {
        document.getElementById('editProfileModal').style.display = 'none';
    }

    function togglePassword(inputId, iconId) {
        const input = document.getElementById(inputId);
        const icon = document.getElementById(iconId);
        
        if (input.type === 'password') {
            input.type = 'text';
            icon.innerHTML = `
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21" />
            `;
        } else {
            input.type = 'password';
            icon.innerHTML = `
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
            `;
        }
    }

    // Show modal if there are validation errors or profile update success
    @if($errors->any() || session('profile_success'))
        document.addEventListener('DOMContentLoaded', function() {
            document.getElementById('editProfileModal').style.display = 'flex';
        });
    @endif

    // Close modal with Escape key
    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape') {
            closeProfileModal();
        }
    });
</script>
