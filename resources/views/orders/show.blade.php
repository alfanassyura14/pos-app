@extends('layouts.app')

@php
    $pageTitle = 'Order #' . $order->order_number;
    $showBackButton = true;
@endphp

@push('styles')
    .order-detail-container {
        max-width: 1000px;
        margin: 0 auto;
    }

    .order-card {
        background: rgba(45, 55, 72, 0.5);
        backdrop-filter: blur(10px);
        border: 1px solid rgba(107, 114, 128, 0.3);
        border-radius: 12px;
        padding: 2rem;
        margin-bottom: 1.5rem;
    }

    .order-header {
        display: flex;
        justify-content: space-between;
        align-items: flex-start;
        margin-bottom: 2rem;
        padding-bottom: 1.5rem;
        border-bottom: 2px solid rgba(107, 114, 128, 0.3);
    }

    .order-info h1 {
        font-size: 1.5rem;
        font-weight: bold;
        margin-bottom: 0.5rem;
    }

    .order-meta {
        font-size: 0.875rem;
        color: #9ca3af;
    }

    .status-badge {
        padding: 0.5rem 1rem;
        border-radius: 20px;
        font-size: 0.875rem;
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

    .items-section h3 {
        font-size: 1.125rem;
        font-weight: bold;
        margin-bottom: 1rem;
    }

    .items-table {
        width: 100%;
        border-collapse: collapse;
    }

    .items-table th {
        text-align: left;
        padding: 0.75rem;
        background: rgba(55, 65, 81, 0.3);
        color: #9ca3af;
        font-size: 0.875rem;
        font-weight: 600;
    }

    .items-table td {
        padding: 1rem 0.75rem;
        border-bottom: 1px solid rgba(107, 114, 128, 0.3);
    }

    .summary-section {
        background: rgba(55, 65, 81, 0.3);
        padding: 1.5rem;
        border-radius: 8px;
        margin-top: 1.5rem;
    }

    .summary-row {
        display: flex;
        justify-content: space-between;
        padding: 0.5rem 0;
        font-size: 0.875rem;
    }

    .summary-row.total {
        font-size: 1.25rem;
        font-weight: bold;
        color: #ec4899;
        padding-top: 1rem;
        margin-top: 0.5rem;
        border-top: 1px solid rgba(107, 114, 128, 0.3);
    }

    .actions-section {
        display: flex;
        gap: 1rem;
        margin-top: 1.5rem;
    }

    .action-btn {
        flex: 1;
        padding: 1rem;
        border: none;
        border-radius: 10px;
        font-size: 0.875rem;
        font-weight: 600;
        cursor: pointer;
        transition: all 0.3s;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 0.5rem;
        text-decoration: none;
    }

    .primary-btn {
        background: linear-gradient(135deg, #ec4899 0%, #8b5cf6 100%);
        color: white;
    }

    .primary-btn:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 15px rgba(236, 72, 153, 0.5);
    }

    .secondary-btn {
        background: rgba(107, 114, 128, 0.3);
        color: white;
        border: 1px solid rgba(107, 114, 128, 0.5);
    }

    .secondary-btn:hover {
        background: rgba(107, 114, 128, 0.5);
    }
@endpush

@section('content')
<div class="order-detail-container">
    <div class="order-card">
        <div class="order-header">
            <div class="order-info">
                <h1>Order #{{ $order->order_number }}</h1>
                <div class="order-meta">
                    <p>Created: {{ $order->created_at->format('F d, Y - h:i A') }}</p>
                    <p>Served by: {{ $order->user->u_name }}</p>
                    @if($order->table_number)
                    <p>Table: {{ $order->table_number }}</p>
                    @endif
                </div>
            </div>
            <div class="status-badge status-{{ $order->status }}">
                {{ ucfirst(str_replace('_', ' ', $order->status)) }}
            </div>
        </div>

        <div class="items-section">
            <h3>Order Items</h3>
            <table class="items-table">
                <thead>
                    <tr>
                        <th>Item</th>
                        <th style="text-align: center;">Quantity</th>
                        <th style="text-align: right;">Price</th>
                        <th style="text-align: right;">Subtotal</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($order->orderItems as $item)
                    <tr>
                        <td>{{ $item->product->name }}</td>
                        <td style="text-align: center;">{{ $item->quantity }}</td>
                        <td style="text-align: right;">Rp {{ number_format($item->price, 0, ',', '.') }}</td>
                        <td style="text-align: right;">Rp {{ number_format($item->subtotal, 0, ',', '.') }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>

            <div class="summary-section">
                <div class="summary-row">
                    <span>Subtotal</span>
                    <span>Rp {{ number_format($order->orderItems->sum('subtotal'), 0, ',', '.') }}</span>
                </div>
                <div class="summary-row">
                    <span>Tax (11%)</span>
                    <span>Rp {{ number_format($order->tax, 0, ',', '.') }}</span>
                </div>
                @if($order->discount > 0)
                <div class="summary-row">
                    <span>Discount</span>
                    <span>-Rp {{ number_format($order->discount, 0, ',', '.') }}</span>
                </div>
                @endif
                <div class="summary-row total">
                    <span>Total Amount</span>
                    <span>Rp {{ number_format($order->total_amount, 0, ',', '.') }}</span>
                </div>
            </div>
        </div>

        <div class="actions-section">
            <a href="{{ route('orders.invoice', $order->id) }}" target="_blank" class="action-btn primary-btn">
                <svg width="20" height="20" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                </svg>
                View Invoice
            </a>
            <a href="{{ route('orders.index') }}" class="action-btn secondary-btn">
                <svg width="20" height="20" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                </svg>
                Back to Orders
            </a>
        </div>
    </div>
</div>
@endsection
