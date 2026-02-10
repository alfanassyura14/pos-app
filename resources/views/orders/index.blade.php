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
        background: rgba(45, 55, 72, 0.5);
        border: 1px solid rgba(107, 114, 128, 0.3);
        border-radius: 10px;
        color: white;
        font-size: 0.875rem;
        width: 300px;
        position: relative;
    }

    .search-input:focus {
        outline: none;
        border-color: #ec4899;
    }

    .add-order-btn {
        padding: 0.75rem 1.5rem;
        background: linear-gradient(135deg, #ec4899 0%, #8b5cf6 100%);
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
        box-shadow: 0 4px 15px rgba(236, 72, 153, 0.5);
    }

    /* Tabs */
    .tabs {
        display: flex;
        gap: 0.5rem;
        margin-bottom: 1.5rem;
        border-bottom: 2px solid rgba(107, 114, 128, 0.3);
        padding-bottom: 0.5rem;
    }

    .tab {
        padding: 0.75rem 1.5rem;
        background: transparent;
        border: none;
        color: #9ca3af;
        font-size: 0.875rem;
        font-weight: 500;
        cursor: pointer;
        transition: all 0.3s;
        border-radius: 8px 8px 0 0;
    }

    .tab.active {
        background: rgba(236, 72, 153, 0.2);
        color: #ec4899;
    }

    .tab:hover:not(.active) {
        color: white;
        background: rgba(107, 114, 128, 0.3);
    }

    /* Orders Grid */
    .orders-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(350px, 1fr));
        gap: 1.5rem;
    }

    .order-card {
        background: rgba(45, 55, 72, 0.5);
        backdrop-filter: blur(10px);
        border: 1px solid rgba(107, 114, 128, 0.3);
        border-radius: 12px;
        padding: 1.5rem;
        transition: all 0.3s;
    }

    .order-card:hover {
        border-color: #ec4899;
        transform: translateY(-2px);
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.3);
    }

    .order-header {
        display: flex;
        justify-content: space-between;
        align-items: flex-start;
        margin-bottom: 1rem;
        padding-bottom: 1rem;
        border-bottom: 1px solid rgba(107, 114, 128, 0.3);
    }

    .order-number {
        font-size: 1rem;
        font-weight: bold;
        color: #ec4899;
        margin-bottom: 0.25rem;
    }

    .order-customer {
        font-size: 0.875rem;
        color: #9ca3af;
    }

    .order-status {
        padding: 0.375rem 0.75rem;
        border-radius: 20px;
        font-size: 0.75rem;
        font-weight: 600;
    }

    .status-open {
        background: rgba(59, 130, 246, 0.2);
        color: #3b82f6;
    }

    .status-in_process {
        background: rgba(245, 158, 11, 0.2);
        color: #f59e0b;
    }

    .status-completed {
        background: rgba(16, 185, 129, 0.2);
        color: #10b981;
    }

    .status-cancelled {
        background: rgba(239, 68, 68, 0.2);
        color: #ef4444;
    }

    .order-meta {
        display: flex;
        justify-content: space-between;
        font-size: 0.75rem;
        color: #9ca3af;
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
        color: #9ca3af;
        margin-right: 0.5rem;
    }

    .item-name {
        flex: 1;
    }

    .item-price {
        color: #ec4899;
        font-weight: 500;
    }

    .order-summary {
        padding-top: 1rem;
        border-top: 1px solid rgba(107, 114, 128, 0.3);
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
        color: #ec4899;
        margin-top: 0.5rem;
        padding-top: 0.5rem;
        border-top: 1px solid rgba(107, 114, 128, 0.3);
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
        background: rgba(59, 130, 246, 0.2);
        color: #3b82f6;
        border: 1px solid rgba(59, 130, 246, 0.3);
    }

    .edit-btn:hover {
        background: rgba(59, 130, 246, 0.3);
    }

    .delete-btn {
        background: rgba(239, 68, 68, 0.2);
        color: #ef4444;
        border: 1px solid rgba(239, 68, 68, 0.3);
    }

    .delete-btn:hover {
        background: rgba(239, 68, 68, 0.3);
    }

    .pay-btn {
        background: linear-gradient(135deg, #ec4899 0%, #8b5cf6 100%);
        color: white;
    }

    .pay-btn:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 15px rgba(236, 72, 153, 0.5);
    }

    .empty-state {
        text-align: center;
        padding: 4rem 2rem;
        color: #9ca3af;
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

    async function deleteOrder(orderId) {
        if (!confirm('Are you sure you want to delete this order?')) {
            return;
        }

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
