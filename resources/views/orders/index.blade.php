@extends('layouts.app')

@php
    $pageTitle = 'Orders';
@endphp

@push('styles')
    .orders-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 1.5rem;
    }

    .orders-header h2 {
        font-size: 1.5rem;
        font-weight: bold;
    }

    .header-actions {
        display: flex;
        gap: 1rem;
        align-items: center;
    }

    .search-input {
        padding: 0.75rem 1rem 0.75rem 3rem;
        background: var(--input-bg);
        border: 1px solid var(--input-border);
        border-radius: 10px;
        color: var(--text-primary);
        font-size: 0.875rem;
        width: 300px;
        position: relative;
    }

    .search-input:focus {
        outline: none;
        border-color: #a855f7;
    }

    .add-order-btn {
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
        text-decoration: none;
    }

    .add-order-btn:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 15px rgba(168, 85, 247, 0.6);
    }

    /* Tabs */
    .tabs {
        display: flex;
        gap: 0.5rem;
        margin-bottom: 1.5rem;
        border-bottom: 2px solid var(--card-border);
        padding-bottom: 0.5rem;
    }

    .tab {
        padding: 0.75rem 1.5rem;
        background: transparent;
        border: none;
        color: var(--text-secondary);
        font-size: 0.875rem;
        font-weight: 500;
        cursor: pointer;
        transition: all 0.3s;
        border-radius: 8px 8px 0 0;
    }

    .tab.active {
        background: rgba(168, 85, 247, 0.15);
        color: #a855f7;
        border: 1px solid rgba(168, 85, 247, 0.3);
    }

    .tab:hover:not(.active) {
        color: var(--text-primary);
        background: var(--card-hover);
    }

    /* Orders Grid */
    .orders-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(350px, 1fr));
        gap: 1.5rem;
    }

    /* Confirmation Modal */
    .confirm-modal-overlay {
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: rgba(0, 0, 0, 0.75);
        backdrop-filter: blur(8px);
        display: flex;
        align-items: center;
        justify-content: center;
        z-index: 10000;
        animation: fadeIn 0.2s ease-out;
    }

    .confirm-modal {
        background: var(--card-bg);
        border: 1px solid var(--card-border);
        border-radius: 16px;
        padding: 2rem;
        max-width: 400px;
        width: 90%;
        box-shadow: 0 20px 60px var(--shadow-color);
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
        color: var(--text-primary);
        text-align: center;
        margin-bottom: 0.75rem;
    }

    .confirm-modal-message {
        font-size: 0.875rem;
        color: var(--text-secondary);
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
        background: var(--nav-item-bg);
        color: var(--text-primary);
        border: 1px solid var(--card-border);
    }

    .cancel-btn:hover {
        background: var(--nav-item-hover);
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

    @keyframes fadeIn {
        from {
            opacity: 0;
        }
        to {
            opacity: 1;
        }
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

    .order-card {
        background: var(--card-bg);
        backdrop-filter: blur(10px);
        border: 1px solid var(--card-border);
        border-radius: 12px;
        padding: 1.5rem;
        transition: all 0.3s;
    }

    .order-card:hover {
        border-color: #a855f7;
        transform: translateY(-2px);
        box-shadow: 0 4px 15px var(--shadow-hover);
    }

    .order-header {
        display: flex;
        justify-content: space-between;
        align-items: flex-start;
        margin-bottom: 1rem;
        padding-bottom: 1rem;
        border-bottom: 1px solid var(--card-border);
    }

    .order-number {
        font-size: 1rem;
        font-weight: bold;
        color: #a855f7;
        margin-bottom: 0.25rem;
    }

    .order-customer {
        font-size: 0.875rem;
        color: var(--text-secondary);
    }

    .order-status {
        padding: 0.375rem 0.75rem;
        border-radius: 20px;
        font-size: 0.75rem;
        font-weight: 600;
    }

    .status-open {
        background: rgba(59, 130, 246, 0.15);
        color: #3b82f6;
        border: 1px solid rgba(59, 130, 246, 0.3);
    }

    .status-in_process {
        background: rgba(245, 158, 11, 0.15);
        color: #f59e0b;
        border: 1px solid rgba(245, 158, 11, 0.3);
    }

    .status-completed {
        background: rgba(16, 185, 129, 0.15);
        color: #10b981;
        border: 1px solid rgba(16, 185, 129, 0.3);
    }

    .status-cancelled {
        background: rgba(239, 68, 68, 0.15);
        color: #ef4444;
        border: 1px solid rgba(239, 68, 68, 0.3);
    }

    .order-meta {
        display: flex;
        justify-content: space-between;
        font-size: 0.75rem;
        color: var(--text-secondary);
        margin-bottom: 1rem;
    }

    .order-items {
        display: flex;
        flex-direction: column;
        gap: 0.5rem;
        margin-bottom: 1rem;
        max-height: 150px;
        overflow-y: auto;
    }

    .order-item {
        display: flex;
        justify-content: space-between;
        font-size: 0.875rem;
    }

    .item-qty {
        color: var(--text-secondary);
        margin-right: 0.5rem;
    }

    .item-name {
        flex: 1;
    }

    .item-price {
        color: #a855f7;
        font-weight: 500;
    }

    .order-summary {
        padding-top: 1rem;
        border-top: 1px solid var(--card-border);
        margin-bottom: 1rem;
    }

    .summary-row {
        display: flex;
        justify-content: space-between;
        font-size: 0.875rem;
        margin-bottom: 0.5rem;
    }

    .summary-row.total {
        font-size: 1.125rem;
        font-weight: bold;
        color: #a855f7;
        margin-top: 0.5rem;
        padding-top: 0.5rem;
        border-top: 1px solid var(--card-border);
    }

    .order-actions {
        display: flex;
        gap: 0.5rem;
    }

    .action-btn {
        flex: 1;
        padding: 0.75rem;
        border: none;
        border-radius: 8px;
        font-size: 0.875rem;
        font-weight: 500;
        cursor: pointer;
        transition: all 0.3s;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 0.5rem;
    }

    .edit-btn {
        background: rgba(59, 130, 246, 0.15);
        color: #3b82f6;
        border: 1px solid rgba(59, 130, 246, 0.3);
    }

    .edit-btn:hover {
        background: rgba(59, 130, 246, 0.25);
    }

    .delete-btn {
        background: rgba(239, 68, 68, 0.15);
        color: #ef4444;
        border: 1px solid rgba(239, 68, 68, 0.3);
    }

    .delete-btn:hover {
        background: rgba(239, 68, 68, 0.25);
    }

    .pay-btn {
        background: linear-gradient(135deg, #a855f7 0%, #c084fc 100%);
        color: white;
    }

    .pay-btn:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 15px rgba(168, 85, 247, 0.6);
    }

    .empty-state {
        text-align: center;
        padding: 4rem 2rem;
        color: var(--text-secondary);
    }

    .empty-state svg {
        margin: 0 auto 1rem;
    }
@endpush

@section('content')
<div class="orders-header">
    <h2>Orders Management</h2>
    <div class="header-actions">
        <input type="text" class="search-input" placeholder="Search by order number or customer...">
        <a href="{{ route('orders.create') }}" class="add-order-btn">
            <svg width="20" height="20" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
            </svg>
            Add New Order
        </a>
    </div>
</div>

<!-- Tabs -->
<div class="tabs">
    <button class="tab active" data-status="all">All</button>
    <button class="tab" data-status="open">Open</button>
    <button class="tab" data-status="in_process">In Process</button>
    <button class="tab" data-status="completed">Completed</button>
    <button class="tab" data-status="cancelled">Cancelled</button>
</div>

<!-- Orders Grid -->
<div class="orders-grid" id="ordersGrid">
    @forelse($orders as $order)
    <div class="order-card" data-status="{{ $order->status }}">
        <div class="order-header">
            <div>
                <div class="order-number">{{ $order->order_number }}</div>
                <div class="order-customer">{{ $order->user->u_name }}</div>
            </div>
            <div class="order-status status-{{ $order->status }}">
                {{ ucfirst(str_replace('_', ' ', $order->status)) }}
            </div>
        </div>

        <div class="order-meta">
            <span>{{ $order->created_at->format('l, d M Y') }}</span>
            <span>{{ $order->created_at->format('h:i A') }}</span>
        </div>

        <div class="order-items">
            @foreach($order->orderItems as $item)
            <div class="order-item">
                <span class="item-qty">{{ str_pad($item->quantity, 2, '0', STR_PAD_LEFT) }}</span>
                <span class="item-name">{{ $item->product->name }}</span>
                <span class="item-price">Rp {{ number_format($item->subtotal, 0, ',', '.') }}</span>
            </div>
            @endforeach
        </div>

        <div class="order-summary">
            <div class="summary-row">
                <span>City</span>
                <span>Items</span>
                <span>Price</span>
            </div>
            <div class="summary-row">
                <span>-</span>
                <span>{{ $order->orderItems->count() }}</span>
                <span>Rp {{ number_format($order->orderItems->sum('subtotal'), 0, ',', '.') }}</span>
            </div>
            @if($order->discount > 0)
            <div class="summary-row">
                <span>Discount</span>
                <span></span>
                <span>-Rp {{ number_format($order->discount, 0, ',', '.') }}</span>
            </div>
            @endif
            <div class="summary-row total">
                <span>SubTotal</span>
                <span></span>
                <span>Rp {{ number_format($order->total_amount, 0, ',', '.') }}</span>
            </div>
        </div>

        <div class="order-actions">
            <button class="action-btn edit-btn" data-action="view" data-order-id="{{ $order->id }}">
                <svg width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                </svg>
                Edit
            </button>
            <button class="action-btn delete-btn" data-action="delete" data-order-id="{{ $order->id }}">
                <svg width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                </svg>
                Delete
            </button>
            @if($order->payment_status === 'pending')
            <button class="action-btn pay-btn" data-action="pay" data-order-id="{{ $order->id }}">
                Pay Bill
            </button>
            @else
            <button class="action-btn pay-btn" data-action="invoice" data-order-id="{{ $order->id }}">
                View Invoice
            </button>
            @endif
        </div>
    </div>
    @empty
    <div class="empty-state" style="grid-column: 1 / -1;">
        <svg width="64" height="64" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
        </svg>
        <p>No orders found</p>
        <p style="font-size: 0.875rem; margin-top: 0.5rem;">Create your first order to get started</p>
    </div>
    @endforelse
</div>

<!-- Confirmation Modal -->
<div id="confirmModalOverlay" class="confirm-modal-overlay" style="display: none;">
    <div class="confirm-modal">
        <div class="confirm-modal-icon">
            <svg fill="none" stroke="currentColor" viewBox="0 0 24 24" width="48" height="48">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
            </svg>
        </div>
        <h3 class="confirm-modal-title" id="confirmModalTitle">Confirm Action</h3>
        <p class="confirm-modal-message" id="confirmModalMessage">Are you sure you want to proceed?</p>
        <div class="confirm-modal-actions">
            <button class="confirm-modal-btn cancel-btn" id="confirmModalCancel">Cancel</button>
            <button class="confirm-modal-btn confirm-btn" id="confirmModalConfirm">Confirm</button>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    // Tab filtering
    document.querySelectorAll('.tab').forEach(tab => {
        tab.addEventListener('click', function() {
            // Update active tab
            document.querySelectorAll('.tab').forEach(t => t.classList.remove('active'));
            this.classList.add('active');

            const status = this.dataset.status;
            
            // Filter orders
            document.querySelectorAll('.order-card').forEach(card => {
                if (status === 'all' || card.dataset.status === status) {
                    card.style.display = 'block';
                } else {
                    card.style.display = 'none';
                }
            });
        });
    });

    // Action button event delegation
    document.addEventListener('click', function(e) {
        const btn = e.target.closest('[data-action]');
        if (!btn) return;

        const action = btn.dataset.action;
        const orderId = btn.dataset.orderId;

        if (action === 'view') {
            viewOrder(orderId);
        } else if (action === 'delete') {
            deleteOrder(orderId);
        } else if (action === 'pay') {
            payBill(orderId);
        } else if (action === 'invoice') {
            viewInvoice(orderId);
        }
    });

    function viewOrder(orderId) {
        window.location.href = `/orders/${orderId}`;
    }

    function showConfirmModal(title, message, onConfirm) {
        const overlay = document.getElementById('confirmModalOverlay');
        const titleEl = document.getElementById('confirmModalTitle');
        const messageEl = document.getElementById('confirmModalMessage');
        const confirmBtn = document.getElementById('confirmModalConfirm');
        const cancelBtn = document.getElementById('confirmModalCancel');
        
        titleEl.textContent = title;
        messageEl.textContent = message;
        overlay.style.display = 'flex';
        
        // Remove old listeners
        const newConfirmBtn = confirmBtn.cloneNode(true);
        const newCancelBtn = cancelBtn.cloneNode(true);
        confirmBtn.parentNode.replaceChild(newConfirmBtn, confirmBtn);
        cancelBtn.parentNode.replaceChild(newCancelBtn, cancelBtn);
        
        // Add new listeners
        newConfirmBtn.addEventListener('click', () => {
            overlay.style.display = 'none';
            onConfirm();
        });
        
        newCancelBtn.addEventListener('click', () => {
            overlay.style.display = 'none';
        });
        
        // Close on overlay click
        overlay.addEventListener('click', (e) => {
            if (e.target === overlay) {
                overlay.style.display = 'none';
            }
        });
    }

    async function deleteOrder(orderId) {
        showConfirmModal(
            'Delete Order',
            'Are you sure you want to delete this order? This action cannot be undone.',
            async () => {
                try {
                    const response = await fetch(`/orders/${orderId}`, {
                        method: 'DELETE',
                        headers: {
                            'X-CSRF-TOKEN': '{{ csrf_token() }}'
                        }
                    });

                    if (response.ok) {
                        alert('Order deleted successfully');
                        location.reload();
                    } else {
                        alert('Failed to delete order');
                    }
                } catch (error) {
                    console.error('Error:', error);
                    alert('Failed to delete order');
                }
            }
        );
    }

    async function payBill(orderId) {
        const paymentMethod = prompt('Enter payment method (cash/card/qr):', 'cash');
        
        if (!paymentMethod) return;

        try {
            const response = await fetch(`/orders/${orderId}/pay`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: JSON.stringify({ payment_method: paymentMethod })
            });

            const result = await response.json();

            if (result.success) {
                window.open(result.redirect_url, '_blank');
                location.reload();
            } else {
                alert('Failed to process payment');
            }
        } catch (error) {
            console.error('Error:', error);
            alert('Failed to process payment');
        }
    }

    function viewInvoice(orderId) {
        window.open(`/orders/${orderId}/invoice`, '_blank');
    }
</script>
@endpush
