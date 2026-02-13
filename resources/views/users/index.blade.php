@extends('layouts.app')

@php
    $pageTitle = 'User Management';
@endphp

@push('styles')
<style>
    .users-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        gap: 1rem;
        margin-bottom: 2rem;
    }

    .users-header h2 {
        font-size: 1.5rem;
        font-weight: bold;
        color: white;
    }

    .add-user-btn {
        padding: 0.75rem 1.5rem;
        background: linear-gradient(135deg, #a855f7 0%, #c084fc 100%);
        border: none;
        border-radius: 10px;
        color: white;
        font-size: 0.875rem;
        font-weight: 600;
        cursor: pointer;
        transition: all 0.3s;
        display: flex;
        align-items: center;
        gap: 0.5rem;
        flex-shrink: 0;
        white-space: nowrap;
    }

    .add-user-btn:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 15px rgba(168, 85, 247, 0.6);
    }

    /* Users Cards */
    .users-container {
        display: flex;
        flex-direction: column;
        gap: 1rem;
    }

    .user-card {
        background: rgba(26, 26, 26, 0.8);
        border: 1px solid rgba(60, 60, 60, 0.5);
        border-radius: 12px;
        padding: 1.5rem;
        transition: all 0.3s;
    }

    .user-card:hover {
        border-color: rgba(168, 85, 247, 0.5);
        box-shadow: 0 4px 20px rgba(168, 85, 247, 0.2);
    }

    .user-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 1rem;
        padding-bottom: 1rem;
        border-bottom: 1px solid rgba(60, 60, 60, 0.5);
    }

    .user-info {
        display: flex;
        flex-direction: column;
        gap: 0.25rem;
    }

    .user-name {
        font-size: 1.125rem;
        font-weight: 600;
        color: white;
    }

    .user-email {
        font-size: 0.875rem;
        color: #9ca3af;
    }

    .user-role {
        display: inline-block;
        padding: 0.25rem 0.75rem;
        border-radius: 6px;
        font-size: 0.75rem;
        font-weight: 600;
        text-transform: capitalize;
    }

    .role-admin {
        background: linear-gradient(135deg, rgba(168, 85, 247, 0.2), rgba(192, 132, 252, 0.2));
        color: #a855f7;
        border: 1px solid rgba(168, 85, 247, 0.3);
    }

    .role-sub_admin {
        background: linear-gradient(135deg, rgba(236, 72, 153, 0.2), rgba(244, 114, 182, 0.2));
        color: #ec4899;
        border: 1px solid rgba(236, 72, 153, 0.3);
    }

    .role-user {
        background: linear-gradient(135deg, rgba(107, 114, 128, 0.2), rgba(156, 163, 175, 0.2));
        color: #9ca3af;
        border: 1px solid rgba(107, 114, 128, 0.3);
    }

    .user-actions {
        display: flex;
        gap: 0.5rem;
    }

    .action-btn {
        padding: 0.5rem;
        border: none;
        border-radius: 8px;
        cursor: pointer;
        transition: all 0.3s;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .edit-btn {
        background: rgba(168, 85, 247, 0.2);
        color: #a855f7;
    }

    .edit-btn:hover {
        background: rgba(168, 85, 247, 0.3);
        transform: scale(1.1);
    }

    .delete-btn {
        background: rgba(239, 68, 68, 0.2);
        color: #ef4444;
    }

    .delete-btn:hover {
        background: rgba(239, 68, 68, 0.3);
        transform: scale(1.1);
    }

    /* Menu Access Grid */
    .menu-access-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(150px, 1fr));
        gap: 1rem;
    }

    .menu-item {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 0.75rem;
        background: rgba(20, 20, 20, 0.6);
        border: 1px solid rgba(60, 60, 60, 0.5);
        border-radius: 8px;
    }

    .menu-label {
        font-size: 0.875rem;
        color: #e5e7eb;
        font-weight: 500;
    }

    /* Toggle Switch */
    .toggle-switch {
        position: relative;
        width: 44px;
        height: 24px;
    }

    .toggle-switch input {
        opacity: 0;
        width: 0;
        height: 0;
    }

    .toggle-slider {
        position: absolute;
        cursor: pointer;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: rgba(60, 60, 60, 0.6);
        transition: 0.3s;
        border-radius: 24px;
        border: 1px solid rgba(60, 60, 60, 0.8);
    }

    .toggle-slider:before {
        position: absolute;
        content: "";
        height: 16px;
        width: 16px;
        left: 3px;
        bottom: 3px;
        background: white;
        transition: 0.3s;
        border-radius: 50%;
    }

    .toggle-switch input:checked + .toggle-slider {
        background: linear-gradient(135deg, #a855f7 0%, #c084fc 100%);
        border-color: #a855f7;
    }

    .toggle-switch input:checked + .toggle-slider:before {
        transform: translateX(20px);
    }

    /* Modal Styles */
    .modal-overlay {
        display: none;
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: rgba(0, 0, 0, 0.7);
        backdrop-filter: blur(4px);
        z-index: 10000;
        align-items: center;
        justify-content: center;
        animation: fadeIn 0.2s ease-out;
    }

    .modal-overlay.active {
        display: flex;
    }

    .modal-box {
        background: rgba(26, 26, 26, 0.95);
        border: 1px solid rgba(168, 85, 247, 0.3);
        border-radius: 16px;
        padding: 2rem;
        max-width: 500px;
        width: 90%;
        max-height: 90vh;
        overflow-y: auto;
        box-shadow: 0 20px 60px rgba(0, 0, 0, 0.5);
        animation: slideUp 0.3s ease-out;
    }

    .modal-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 1.5rem;
    }

    .modal-title {
        font-size: 1.25rem;
        font-weight: bold;
        color: white;
    }

    .modal-close {
        background: none;
        border: none;
        color: #9ca3af;
        font-size: 1.5rem;
        cursor: pointer;
        padding: 0;
        width: 32px;
        height: 32px;
        display: flex;
        align-items: center;
        justify-content: center;
        border-radius: 8px;
        transition: all 0.3s;
    }

    .modal-close:hover {
        background: rgba(239, 68, 68, 0.2);
        color: #ef4444;
    }

    .form-group {
        margin-bottom: 1.5rem;
    }

    .form-label {
        display: block;
        font-size: 0.875rem;
        font-weight: 600;
        color: #e5e7eb;
        margin-bottom: 0.5rem;
    }

    .form-input,
    .form-select {
        width: 100%;
        padding: 0.75rem 1rem;
        background: rgba(20, 20, 20, 0.8);
        border: 1px solid rgba(60, 60, 60, 0.5);
        border-radius: 10px;
        color: white;
        font-size: 0.875rem;
        transition: all 0.3s;
    }

    .form-input:focus,
    .form-select:focus {
        outline: none;
        border-color: #a855f7;
        box-shadow: 0 0 0 3px rgba(168, 85, 247, 0.1);
    }

    .form-hint {
        font-size: 0.75rem;
        color: #6b7280;
        margin-top: 0.25rem;
    }

    .form-actions {
        display: flex;
        gap: 0.75rem;
        margin-top: 2rem;
    }

    .btn {
        flex: 1;
        padding: 0.75rem 1.5rem;
        border: none;
        border-radius: 10px;
        font-size: 0.875rem;
        font-weight: 600;
        cursor: pointer;
        transition: all 0.3s;
    }

    .btn-cancel {
        background: rgba(60, 60, 60, 0.5);
        color: white;
        border: 1px solid rgba(60, 60, 60, 0.5);
    }

    .btn-cancel:hover {
        background: rgba(80, 80, 80, 0.6);
        transform: translateY(-1px);
    }

    .btn-submit {
        background: linear-gradient(135deg, #a855f7 0%, #c084fc 100%);
        color: white;
    }

    .btn-submit:hover {
        box-shadow: 0 4px 15px rgba(168, 85, 247, 0.4);
        transform: translateY(-1px);
    }

    /* Toast */
    .toast {
        position: fixed;
        top: 20px;
        right: 20px;
        background: rgba(26, 26, 26, 0.95);
        border: 1px solid rgba(168, 85, 247, 0.3);
        border-radius: 10px;
        padding: 1rem 1.5rem;
        display: flex;
        align-items: center;
        gap: 0.75rem;
        z-index: 11000;
        box-shadow: 0 10px 40px rgba(0, 0, 0, 0.5);
        animation: slideInRight 0.3s ease-out;
    }

    .toast.success {
        border-color: rgba(16, 185, 129, 0.5);
    }

    .toast.error {
        border-color: rgba(239, 68, 68, 0.5);
    }

    .toast-icon {
        width: 24px;
        height: 24px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .toast.success .toast-icon {
        background: rgba(16, 185, 129, 0.2);
        color: #10b981;
    }

    .toast.error .toast-icon {
        background: rgba(239, 68, 68, 0.2);
        color: #ef4444;
    }

    .toast-message {
        color: white;
        font-size: 0.875rem;
        font-weight: 500;
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

    @keyframes slideInRight {
        from {
            transform: translateX(100px);
            opacity: 0;
        }
        to {
            transform: translateX(0);
            opacity: 1;
        }
    }

    /* Confirm Modal */
    .confirm-modal-overlay {
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: rgba(0, 0, 0, 0.7);
        backdrop-filter: blur(4px);
        display: flex;
        align-items: center;
        justify-content: center;
        z-index: 10000;
        animation: fadeIn 0.2s ease-out;
    }

    .confirm-modal {
        background: rgba(26, 26, 26, 0.95);
        border: 1px solid rgba(168, 85, 247, 0.3);
        border-radius: 16px;
        padding: 2rem;
        max-width: 400px;
        width: 90%;
        box-shadow: 0 20px 60px rgba(0, 0, 0, 0.5);
        animation: slideUp 0.3s ease-out;
    }

    .confirm-modal-icon {
        width: 64px;
        height: 64px;
        margin: 0 auto 1.5rem;
        border-radius: 50%;
        background: linear-gradient(135deg, rgba(239, 68, 68, 0.2) 0%, rgba(220, 38, 38, 0.2) 100%);
        display: flex;
        align-items: center;
        justify-content: center;
        color: #ef4444;
    }

    .confirm-modal-title {
        font-size: 1.25rem;
        font-weight: bold;
        color: white;
        text-align: center;
        margin-bottom: 0.75rem;
    }

    .confirm-modal-message {
        font-size: 0.875rem;
        color: #9ca3af;
        text-align: center;
        margin-bottom: 2rem;
        line-height: 1.5;
    }

    .confirm-modal-actions {
        display: flex;
        gap: 0.75rem;
    }

    .confirm-modal-btn {
        flex: 1;
        padding: 0.75rem 1.5rem;
        border: none;
        border-radius: 10px;
        font-size: 0.875rem;
        font-weight: 600;
        cursor: pointer;
        transition: all 0.3s;
    }

    .cancel-btn {
        background: rgba(60, 60, 60, 0.5);
        color: white;
        border: 1px solid rgba(60, 60, 60, 0.5);
    }

    .cancel-btn:hover {
        background: rgba(80, 80, 80, 0.6);
        transform: translateY(-1px);
    }

    .confirm-btn {
        background: linear-gradient(135deg, #ef4444 0%, #dc2626 100%);
        color: white;
    }

    .confirm-btn:hover {
        box-shadow: 0 4px 15px rgba(239, 68, 68, 0.4);
        transform: translateY(-1px);
    }

    /* Search Bar */
    .search-container {
        flex: 1;
        max-width: 500px;
    }

    .search-bar {
        position: relative;
        width: 100%;
    }

    .search-input {
        width: 100%;
        padding: 0.875rem 1rem 0.875rem 3rem;
        background: rgba(20, 20, 20, 0.8);
        border: 1px solid rgba(60, 60, 60, 0.5);
        border-radius: 12px;
        color: white;
        font-size: 0.875rem;
        transition: all 0.3s;
    }

    .search-input:focus {
        outline: none;
        border-color: #a855f7;
        box-shadow: 0 0 0 3px rgba(168, 85, 247, 0.1);
    }

    .search-input::placeholder {
        color: #6b7280;
    }

    .search-icon {
        position: absolute;
        left: 1rem;
        top: 50%;
        transform: translateY(-50%);
        color: #6b7280;
        pointer-events: none;
    }

    /* No Menu Access Message */
    .no-menu-access {
        padding: 1rem;
        background: linear-gradient(135deg, rgba(239, 68, 68, 0.1) 0%, rgba(220, 38, 38, 0.1) 100%);
        border: 1px solid rgba(239, 68, 68, 0.3);
        border-radius: 10px;
        display: flex;
        align-items: center;
        gap: 0.75rem;
    }

    .no-menu-access-icon {
        width: 40px;
        height: 40px;
        border-radius: 50%;
        background: rgba(239, 68, 68, 0.2);
        display: flex;
        align-items: center;
        justify-content: center;
        color: #ef4444;
        flex-shrink: 0;
    }

    .no-menu-access-text {
        color: #fca5a5;
        font-size: 0.875rem;
        font-weight: 600;
    }
</style>
@endpush

@section('content')
<div class="users-header">
    <!-- Search Bar -->
    <div class="search-container">
        <div class="search-bar">
            <svg class="search-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24" width="20" height="20">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
            </svg>
            <input 
                type="text" 
                id="searchInput" 
                class="search-input" 
                placeholder="Cari user berdasarkan nama atau email..."
                oninput="searchUsers(this.value)"
            >
        </div>
    </div>
    
    <button class="add-user-btn" onclick="openUserModal()">
        <svg fill="none" stroke="currentColor" viewBox="0 0 24 24" width="20" height="20">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
        </svg>
        Add User
    </button>
</div>

<div class="users-container" id="usersContainer">
    <!-- Users will be loaded here via AJAX -->
</div>

<!-- User Modal -->
<div id="userModal" class="modal-overlay" style="display: none;">
    <div class="modal-box">
        <div class="modal-header">
            <h3 class="modal-title" id="modalTitle">Add New User</h3>
            <button class="modal-close" onclick="closeUserModal()">&times;</button>
        </div>
        
        <form id="userForm" method="POST">
            @csrf
            <input type="hidden" id="formMethod" name="_method" value="POST">
            
            <div class="form-group">
                <label class="form-label">Full Name</label>
                <input type="text" name="u_name" id="userName" class="form-input" required>
            </div>

            <div class="form-group">
                <label class="form-label">Email Address</label>
                <input type="email" name="u_email" id="userEmail" class="form-input" required>
            </div>

            <div class="form-group">
                <label class="form-label">Password</label>
                <input type="password" name="u_password" id="userPassword" class="form-input">
                <span class="form-hint" id="passwordHint">Enter password for the user</span>
            </div>

            <div class="form-group">
                <label class="form-label">Role</label>
                <select name="role" id="userRole" class="form-select" required>
                    <option value="user">User</option>
                    <option value="sub_admin">Sub Admin</option>
                    <option value="admin">Admin</option>
                </select>
            </div>

            <div class="form-actions">
                <button type="button" class="btn btn-cancel" onclick="closeUserModal()">Cancel</button>
                <button type="submit" class="btn btn-submit">Save User</button>
            </div>
        </form>
    </div>
</div>

<!-- Confirm Delete Modal -->
<div id="confirmModal" class="confirm-modal-overlay" style="display: none;">
    <div class="confirm-modal">
        <div class="confirm-modal-icon">
            <svg fill="none" stroke="currentColor" viewBox="0 0 24 24" width="48" height="48">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
            </svg>
        </div>
        <h3 class="confirm-modal-title" id="confirmTitle">Delete User</h3>
        <p class="confirm-modal-message" id="confirmMessage">Are you sure you want to delete this user?</p>
        <div class="confirm-modal-actions">
            <button class="confirm-modal-btn cancel-btn" onclick="closeConfirmModal()">Cancel</button>
            <button class="confirm-modal-btn confirm-btn" id="confirmButton">Delete</button>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
let editingUserId = null;

// Show toast notification
function showToast(message, type = 'success') {
    const existingToast = document.querySelector('.toast');
    if (existingToast) existingToast.remove();

    const toast = document.createElement('div');
    toast.className = `toast ${type}`;
    
    const icon = type === 'success' 
        ? '<svg fill="none" stroke="currentColor" viewBox="0 0 24 24" width="20" height="20"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7" /></svg>'
        : '<svg fill="none" stroke="currentColor" viewBox="0 0 24 24" width="20" height="20"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" /></svg>';
    
    toast.innerHTML = `
        <div class="toast-icon">${icon}</div>
        <div class="toast-message">${message}</div>
    `;
    
    document.body.appendChild(toast);
    setTimeout(() => toast.remove(), 3000);
}

// Open user modal
function openUserModal() {
    editingUserId = null;
    document.getElementById('modalTitle').textContent = 'Add New User';
    document.getElementById('userForm').action = '{{ route("users.store") }}';
    document.getElementById('formMethod').value = 'POST';
    document.getElementById('userForm').reset();
    document.getElementById('passwordHint').textContent = 'Enter password for the user';
    document.getElementById('userPassword').required = true;
    document.getElementById('userModal').style.display = 'flex';
}

// Edit user
function editUser(user) {
    editingUserId = user.id;
    document.getElementById('modalTitle').textContent = 'Edit User';
    document.getElementById('userForm').action = `/users/${user.id}`;
    document.getElementById('formMethod').value = 'PUT';
    document.getElementById('userName').value = user.u_name;
    document.getElementById('userEmail').value = user.u_email;
    document.getElementById('userPassword').value = '';
    document.getElementById('userPassword').required = false;
    document.getElementById('passwordHint').textContent = 'Leave blank to keep current password';
    document.getElementById('userRole').value = user.role;
    document.getElementById('userModal').style.display = 'flex';
}

// Close user modal
function closeUserModal() {
    document.getElementById('userModal').style.display = 'none';
}

// Update menu access
async function updateMenuAccess(userId, menu, checked) {
    try {
        // Get all checkboxes for this user
        const checkboxes = document.querySelectorAll(`input[data-user-id="${userId}"]`);
        const menuAccess = Array.from(checkboxes)
            .filter(cb => cb.checked)
            .map(cb => cb.dataset.menu);

        const response = await fetch(`/users/${userId}/menu-access`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            body: JSON.stringify({ menu_access: menuAccess })
        });

        const result = await response.json();
        
        if (result.success) {
            showToast('Menu access updated successfully', 'success');
        } else {
            showToast('Failed to update menu access', 'error');
        }
    } catch (error) {
        console.error('Error:', error);
        showToast('Failed to update menu access', 'error');
    }
}

// Delete user
function deleteUser(userId, userName) {
    document.getElementById('confirmTitle').textContent = 'Delete User';
    document.getElementById('confirmMessage').textContent = `Are you sure you want to delete "${userName}"? This action cannot be undone.`;
    document.getElementById('confirmModal').style.display = 'flex';
    
    document.getElementById('confirmButton').onclick = async () => {
        const form = document.createElement('form');
        form.method = 'POST';
        form.action = `/users/${userId}`;
        
        const csrfToken = document.createElement('input');
        csrfToken.type = 'hidden';
        csrfToken.name = '_token';
        csrfToken.value = '{{ csrf_token() }}';
        
        const method = document.createElement('input');
        method.type = 'hidden';
        method.name = '_method';
        method.value = 'DELETE';
        
        form.appendChild(csrfToken);
        form.appendChild(method);
        document.body.appendChild(form);
        form.submit();
    };
}

// Close confirm modal
function closeConfirmModal() {
    document.getElementById('confirmModal').style.display = 'none';
}

// Close modals on outside click
document.getElementById('userModal').addEventListener('click', (e) => {
    if (e.target === document.getElementById('userModal')) {
        closeUserModal();
    }
});

document.getElementById('confirmModal').addEventListener('click', (e) => {
    if (e.target === document.getElementById('confirmModal')) {
        closeConfirmModal();
    }
});

// Show Laravel session messages
@if(session('success'))
    showToast('{{ session('success') }}', 'success');
@endif

@if(session('error'))
    showToast('{{ session('error') }}', 'error');
@endif

// Search users with AJAX
let searchTimeout;
function searchUsers(query) {
    clearTimeout(searchTimeout);
    
    searchTimeout = setTimeout(async () => {
        try {
            const response = await fetch(`{{ route('users.search') }}?search=${encodeURIComponent(query)}`, {
                method: 'GET',
                headers: {
                    'X-Requested-With': 'XMLHttpRequest',
                    'Accept': 'application/json'
                }
            });
            
            const data = await response.json();
            
            if (data.success) {
                renderUsers(data.users);
            }
        } catch (error) {
            console.error('Search error:', error);
        }
    }, 300);
}

// Render users to DOM
function renderUsers(users) {
    const container = document.getElementById('usersContainer');
    
    if (users.length === 0) {
        container.innerHTML = `
            <div style="text-align: center; padding: 3rem; color: #6b7280;">
                <svg width="64" height="64" fill="none" stroke="currentColor" viewBox="0 0 24 24" style="margin: 0 auto 1rem;">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                </svg>
                <p>Tidak ada user ditemukan</p>
            </div>
        `;
        return;
    }
    
    // Menu list sesuai dengan sidebar navigation
    const menuConfig = {
        'dashboard': 'Dashboard',
        'inventory': 'Menu',
        'reports': 'Reports',
        'orders': 'Orders',
        'settings': 'Users'
    };
    
    container.innerHTML = users.map(user => {
        const userAccess = user.menu_access || [];
        const hasMenuAccess = userAccess.length > 0;
        
        const menuAccessHtml = Object.entries(menuConfig).map(([key, label]) => `
            <div class="menu-item">
                <span class="menu-label">${label}</span>
                <label class="toggle-switch">
                    <input type="checkbox" 
                           data-user-id="${user.id}" 
                           data-menu="${key}"
                           ${userAccess.includes(key) ? 'checked' : ''}
                           onchange="updateMenuAccess(${user.id}, '${key}', this.checked)">
                    <span class="toggle-slider"></span>
                </label>
            </div>
        `).join('');
        
        const noAccessHtml = !hasMenuAccess ? `
            <div class="no-menu-access">
                <div class="no-menu-access-icon">
                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24" width="24" height="24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                    </svg>
                </div>
                <div class="no-menu-access-text">Hubungi Admin Untuk Akses Menu</div>
            </div>
        ` : '';
        
        const roleText = user.role.charAt(0).toUpperCase() + user.role.slice(1).replace('_', ' ');
        
        return `
            <div class="user-card">
                <div class="user-header">
                    <div class="user-info">
                        <div class="user-name">${user.u_name}</div>
                        <div class="user-email">${user.u_email}</div>
                    </div>
                    <div style="display: flex; align-items: center; gap: 0.75rem;">
                        <span class="user-role role-${user.role}">${roleText}</span>
                        <div class="user-actions">
                            <button class="action-btn edit-btn" onclick='editUser(${JSON.stringify(user)})'>
                                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24" width="20" height="20">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                </svg>
                            </button>
                            <button class="action-btn delete-btn" onclick="deleteUser(${user.id}, '${user.u_name.replace(/'/g, "\\'")}')">
                                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24" width="20" height="20">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                </svg>
                            </button>
                        </div>
                    </div>
                </div>
                ${noAccessHtml}
                <div class="menu-access-grid">
                    ${menuAccessHtml}
                </div>
            </div>
        `;
    }).join('');
}

// Initial load on page ready
document.addEventListener('DOMContentLoaded', function() {
    searchUsers('');
});
</script>
@endpush
