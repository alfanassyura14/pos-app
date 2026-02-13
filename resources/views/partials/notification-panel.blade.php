<!-- Simple Notification Panel - Clean Version -->
<div class="notif-wrapper">
    <button id="notifBtn" class="notif-btn">
        <svg fill="none" stroke="currentColor" viewBox="0 0 24 24" width="24" height="24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                  d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9" />
        </svg>
        <span id="notifBadge" class="notif-badge" style="display: none;"></span>
    </button>

    <div id="notifDropdown" class="notif-dropdown" style="display: none;">
        <div class="notif-header">
            <h3>Notifications</h3>
            <span id="notifCount">0 unread</span>
        </div>
        
        <div class="notif-actions">
            <button id="markAllBtn">Mark all read</button>
            <button id="clearReadBtn">Clear read</button>
        </div>

        <div id="notifList" class="notif-list">
            <p>Loading...</p>
        </div>
    </div>
</div>

<!-- Confirm Modal -->
<div id="confirmModal" class="confirm-modal-overlay" style="display: none;">
    <div class="confirm-modal-box">
        <div class="confirm-modal-icon">
            <svg fill="none" stroke="currentColor" viewBox="0 0 24 24" width="48" height="48">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
            </svg>
        </div>
        <h3 id="confirmTitle" class="confirm-modal-title">Confirm</h3>
        <p id="confirmMsg" class="confirm-modal-message">Are you sure?</p>
        <div class="confirm-modal-actions">
            <button id="confirmNo" class="confirm-modal-btn cancel-btn">Cancel</button>
            <button id="confirmYes" class="confirm-modal-btn confirm-btn">Confirm</button>
        </div>
    </div>
</div>

<style>
.notif-wrapper { position: relative; z-index: 10000; }
.notif-btn {
    background: none; border: none; color: #9ca3af; padding: 0.5rem;
    cursor: pointer; display: flex; align-items: center; position: relative;
}
.notif-btn:hover { color: white; }
.notif-badge {
    position: absolute; top: 4px; right: 4px; width: 8px; height: 8px;
    background: #a855f7; border-radius: 50%;
}

.notif-dropdown {
    position: absolute; top: calc(100% + 10px); right: 0; width: 400px;
    background: rgba(26, 26, 26, 0.98); border: 1px solid rgba(168, 85, 247, 0.3);
    border-radius: 12px; box-shadow: 0 10px 40px rgba(0, 0, 0, 0.5);
}

.notif-header {
    padding: 1rem 1.5rem; border-bottom: 1px solid rgba(168, 85, 247, 0.2);
    display: flex; justify-content: space-between; align-items: center;
    background: linear-gradient(135deg, rgba(168, 85, 247, 0.1), rgba(192, 132, 252, 0.1));
}
.notif-header h3 { margin: 0; color: white; font-size: 1.125rem; }
.notif-header span { font-size: 0.875rem; color: #9ca3af; }

.notif-actions {
    display: flex; gap: 0.5rem; padding: 0.75rem 1rem;
    border-bottom: 1px solid rgba(60, 60, 60, 0.3);
}
.notif-actions button {
    flex: 1; padding: 0.5rem; background: rgba(60, 60, 60, 0.4);
    border: 1px solid rgba(60, 60, 60, 0.5); border-radius: 6px;
    color: #e5e7eb; font-size: 0.8rem; cursor: pointer;
}
.notif-actions button:hover { background: rgba(168, 85, 247, 0.2); color: white; }

.notif-list { max-height: 450px; overflow-y: auto; }
.notif-item {
    display: flex; gap: 1rem; padding: 1rem 1.5rem;
    border-bottom: 1px solid rgba(60, 60, 60, 0.3); cursor: pointer;
}
.notif-item:hover { background: rgba(168, 85, 247, 0.05); }
.notif-item.unread { background: rgba(168, 85, 247, 0.08); }
.notif-icon {
    width: 40px; height: 40px; border-radius: 50%;
    display: flex; align-items: center; justify-content: center;
}
.notif-icon svg { width: 20px; height: 20px; stroke: white; }
.notif-body { flex: 1; }
.notif-title { font-size: 0.95rem; font-weight: 600; color: white; margin-bottom: 0.25rem; }
.notif-msg { font-size: 0.875rem; color: #9ca3af; margin-bottom: 0.25rem; }
.notif-time { font-size: 0.75rem; color: #6b7280; }
.notif-del {
    background: rgba(20, 20, 20, 0.8); border: none; color: #ef4444;
    width: 28px; height: 28px; border-radius: 50%; cursor: pointer;
    display: none;
}
.notif-item:hover .notif-del { display: flex; align-items: center; justify-content: center; }

.confirm-modal-overlay {
    position: fixed; top: 0; left: 0; width: 100%; height: 100%;
    background: rgba(0, 0, 0, 0.7); backdrop-filter: blur(4px);
    display: flex; align-items: center; justify-content: center;
    z-index: 20000; animation: fadeIn 0.2s ease-out;
}
.confirm-modal-box {
    background: rgba(26, 26, 26, 0.95);
    border: 1px solid rgba(168, 85, 247, 0.3);
    border-radius: 16px; padding: 2rem;
    max-width: 400px; width: 90%;
    box-shadow: 0 20px 60px rgba(0, 0, 0, 0.5);
    animation: slideUp 0.3s ease-out;
}
.confirm-modal-icon {
    width: 64px; height: 64px; margin: 0 auto 1.5rem;
    border-radius: 50%;
    background: linear-gradient(135deg, rgba(239, 68, 68, 0.2) 0%, rgba(220, 38, 38, 0.2) 100%);
    display: flex; align-items: center; justify-content: center;
    color: #ef4444;
}
.confirm-modal-title {
    font-size: 1.25rem; font-weight: bold; color: white;
    text-align: center; margin-bottom: 0.75rem;
}
.confirm-modal-message {
    font-size: 0.875rem; color: #9ca3af;
    text-align: center; margin-bottom: 2rem; line-height: 1.5;
}
.confirm-modal-actions { display: flex; gap: 0.75rem; }
.confirm-modal-btn {
    flex: 1; padding: 0.75rem 1.5rem; border: none;
    border-radius: 10px; font-size: 0.875rem;
    font-weight: 600; cursor: pointer; transition: all 0.3s;
}
.cancel-btn {
    background: rgba(60, 60, 60, 0.5); color: white;
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
@keyframes fadeIn { from { opacity: 0; } to { opacity: 1; } }
@keyframes slideUp { from { transform: translateY(20px); opacity: 0; } to { transform: translateY(0); opacity: 1; } }
</style>

<script>

const $ = (id) => document.getElementById(id);
const notifBtn = $('notifBtn');
const notifDropdown = $('notifDropdown');
const notifList = $('notifList');
const notifBadge = $('notifBadge');
const notifCount = $('notifCount');

// Toggle dropdown
notifBtn.addEventListener('click', (e) => {
    e.stopPropagation();
    const visible = notifDropdown.style.display === 'block';
    notifDropdown.style.display = visible ? 'none' : 'block';
    if (!visible) loadNotifs();
});

// Close when click outside
document.addEventListener('click', (e) => {
    if (!notifBtn.contains(e.target) && !notifDropdown.contains(e.target)) {
        notifDropdown.style.display = 'none';
    }
});

// Load notifications
function loadNotifs() {
    notifList.innerHTML = '<p style="padding: 2rem; text-align: center; color: #9ca3af;">Loading...</p>';
    
    fetch('/notifications')
        .then(r => {
            if (!r.ok) throw new Error(`HTTP ${r.status}`);
            return r.json();
        })
        .then(data => {
            renderNotifs(data.notifications || []);
            updateBadge(data.unread_count || 0);
        })
        .catch(err => {
            notifList.innerHTML = `<p style="padding: 2rem; text-align: center; color: #ef4444;">Error: ${err.message}</p>`;
        });
}

// Render notifications
function renderNotifs(items) {
    
    if (items.length === 0) {
        notifList.innerHTML = `<p style="padding: 3rem; text-align: center; color: #6b7280;">No notifications</p>`;
        notifCount.textContent = '0 unread';
        return;
    }

    const unread = items.filter(n => !n.is_read).length;
    notifCount.textContent = `${unread} unread`;

    notifList.innerHTML = items.map(n => `
        <div class="notif-item ${!n.is_read ? 'unread' : ''}" onclick="markRead(${n.id})">
            <div class="notif-icon" style="background: ${getColor(n.type)};">
                <svg fill="none" stroke="white" viewBox="0 0 24 24">${getIcon(n.type)}</svg>
            </div>
            <div class="notif-body">
                <div class="notif-title">${n.title}</div>
                <div class="notif-msg">${n.message}</div>
                <div class="notif-time">${timeAgo(n.created_at)}</div>
            </div>
            <button class="notif-del" onclick="event.stopPropagation(); delNotif(${n.id})">×</button>
        </div>
    `).join('');
}

// Update badge
function updateBadge(count) {
    notifBadge.style.display = count > 0 ? 'block' : 'none';
}

// Mark as read
function markRead(id) {
    fetch(`/notifications/${id}/read`, {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]')?.getAttribute('content') || ''
        }
    })
    .then(r => r.json())
    .then(() => loadNotifs())
    .catch(err => console.error(err));
}

// Mark all read
$('markAllBtn').addEventListener('click', () => {
    fetch('/notifications/read-all', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.content || ''
        }
    })
    .then(r => r.json())
    .then(() => loadNotifs())
    .catch(err => console.error(err));
});

// Delete notification
function delNotif(id) {
    showConfirm('Delete?', 'Delete this notification?', () => {
        fetch(`/notifications/${id}`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.content || ''
            },
            body: JSON.stringify({ _method: 'DELETE' })
        })
        .then(r => r.json())
        .then(() => loadNotifs())
        .catch(err => console.error(err));
    });
}

// Clear read
$('clearReadBtn').addEventListener('click', () => {
    showConfirm('Clear Read?', 'Delete all read notifications?', () => {
        fetch('/notifications/delete-read', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.content || ''
            },
            body: JSON.stringify({ _method: 'DELETE' })
        })
        .then(r => r.json())
        .then(() => loadNotifs())
        .catch(err => console.error(err));
    });
});

// Show confirm
function showConfirm(title, msg, onYes) {
    const modal = $('confirmModal');
    $('confirmTitle').textContent = title;
    $('confirmMsg').textContent = msg;
    modal.style.display = 'flex';

    const yes = $('confirmYes');
    const no = $('confirmNo');
    
    const handleYes = () => {
        modal.style.display = 'none';
        yes.removeEventListener('click', handleYes);
        no.removeEventListener('click', handleNo);
        onYes();
    };
    
    const handleNo = () => {
        modal.style.display = 'none';
        yes.removeEventListener('click', handleYes);
        no.removeEventListener('click', handleNo);
    };

    yes.addEventListener('click', handleYes);
    no.addEventListener('click', handleNo);
}

// Helpers
function getColor(type) {
    const colors = {
        new_menu: '#10b981', low_stock: '#f59e0b', stock_update: '#3b82f6',
        menu_update: '#8b5cf6', checkout_success: '#a855f7'
    };
    return colors[type] || '#6b7280';
}

function getIcon(type) {
    const icons = {
        new_menu: '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>',
        low_stock: '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>',
        stock_update: '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/>',
        menu_update: '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>',
        checkout_success: '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>'
    };
    return icons[type] || '<path d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"/>';
}

function timeAgo(date) {
    const sec = Math.floor((new Date() - new Date(date)) / 1000);
    if (sec < 60) return 'Just now';
    if (sec < 3600) return `${Math.floor(sec / 60)}m ago`;
    if (sec < 86400) return `${Math.floor(sec / 3600)}h ago`;
    return `${Math.floor(sec / 86400)}d ago`;
}

// Initial load
loadNotifs();

// Auto refresh every 30s
setInterval(() => {
    fetch('/notifications')
        .then(r => r.json())
        .then(data => updateBadge(data.unread_count || 0))
        .catch(err => console.error(err));
}, 30000);

</script>
