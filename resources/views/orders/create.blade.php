@extends('layouts.app')

@php
    $pageTitle = 'Orders';
@endphp

@push('styles')
<style>
    /* Override page-content padding for orders page */
    .page-content {
        padding: 1rem !important;
    }

    .orders-container {
        display: grid !important;
        grid-template-columns: 1fr 420px !important;
        gap: 1.5rem !important;
        height: calc(100vh - 120px) !important;
        width: 100% !important;
    }

    @media (max-width: 768px) {
        .orders-container {
            grid-template-columns: 1fr !important;
        }
        
        .checkout-panel {
            position: relative !important;
            height: auto !important;
        }
    }

    /* Left Panel - Menu */
    .menu-panel {
        display: flex;
        flex-direction: column;
        gap: 1.5rem;
        overflow-y: auto;
        padding-right: 0.5rem;
    }

    .menu-panel::-webkit-scrollbar {
        width: 6px;
    }

    .menu-panel::-webkit-scrollbar-track {
        background: rgba(45, 55, 72, 0.3);
        border-radius: 3px;
    }

    .menu-panel::-webkit-scrollbar-thumb {
        background: rgba(236, 72, 153, 0.5);
        border-radius: 3px;
    }

    .menu-panel::-webkit-scrollbar-thumb:hover {
        background: rgba(236, 72, 153, 0.7);
    }

    /* Search Bar */
    .search-bar {
        position: relative;
    }

    .search-input {
        width: 100%;
        padding: 0.875rem 1rem 0.875rem 3rem;
        background: rgba(45, 55, 72, 0.5);
        border: 1px solid rgba(107, 114, 128, 0.3);
        border-radius: 12px;
        color: white;
        font-size: 0.875rem;
        transition: all 0.3s;
    }

    .search-input:focus {
        outline: none;
        border-color: #ec4899;
        background: rgba(45, 55, 72, 0.7);
    }

    .search-input::placeholder {
        color: #9ca3af;
    }

    .search-icon {
        position: absolute;
        left: 1rem;
        top: 50%;
        transform: translateY(-50%);
        color: #9ca3af;
        width: 20px;
        height: 20px;
    }

    /* Categories Grid */
    .categories-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(120px, 1fr));
        gap: 1rem;
    }

    .category-card {
        background: rgba(45, 55, 72, 0.5);
        backdrop-filter: blur(10px);
        border: 2px solid rgba(107, 114, 128, 0.3);
        border-radius: 12px;
        padding: 1rem;
        cursor: pointer;
        transition: all 0.3s;
        display: flex;
        flex-direction: column;
        align-items: center;
        gap: 0.5rem;
        text-align: center;
    }

    .category-card:hover {
        border-color: #ec4899;
        background: rgba(45, 55, 72, 0.7);
        transform: translateY(-2px);
    }

    .category-card.active {
        border-color: #ec4899;
        background: linear-gradient(135deg, rgba(236, 72, 153, 0.2) 0%, rgba(139, 92, 246, 0.2) 100%);
        box-shadow: 0 4px 15px rgba(236, 72, 153, 0.4);
    }

    .category-icon {
        width: 48px;
        height: 48px;
        border-radius: 10px;
        background: rgba(236, 72, 153, 0.1);
        display: flex;
        align-items: center;
        justify-content: center;
        color: #ec4899;
        font-size: 1.5rem;
    }

    .category-name {
        font-size: 0.875rem;
        font-weight: 500;
    }

    .category-count {
        font-size: 0.75rem;
        color: #9ca3af;
    }

    /* Products Grid */
    .products-section h3 {
        font-size: 1.125rem;
        font-weight: bold;
        margin-bottom: 1rem;
    }

    .products-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(160px, 1fr));
        gap: 1rem;
    }

    .product-card {
        background: rgba(45, 55, 72, 0.5);
        backdrop-filter: blur(10px);
        border: 1px solid rgba(107, 114, 128, 0.3);
        border-radius: 12px;
        padding: 1rem;
        cursor: pointer;
        transition: all 0.3s;
        display: flex;
        flex-direction: column;
        gap: 0.75rem;
        position: relative;
    }

    .product-card:hover {
        border-color: #ec4899;
        transform: translateY(-2px);
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.3);
    }

    .product-image {
        width: 100%;
        height: 120px;
        border-radius: 8px;
        background: linear-gradient(135deg, rgba(236, 72, 153, 0.2) 0%, rgba(139, 92, 246, 0.2) 100%);
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 2rem;
        color: #ec4899;
        overflow: hidden;
        position: relative;
    }

    .product-info {
        flex: 1;
    }

    .product-name {
        font-size: 0.875rem;
        font-weight: 500;
        margin-bottom: 0.25rem;
    }

    .product-category {
        font-size: 0.75rem;
        color: #9ca3af;
        margin-bottom: 0.5rem;
    }

    .product-price {
        font-size: 1rem;
        font-weight: bold;
        color: #ec4899;
    }

    .product-stock {
        position: absolute;
        top: 0.75rem;
        right: 0.75rem;
        font-size: 0.75rem;
        padding: 0.25rem 0.5rem;
        border-radius: 6px;
        font-weight: 500;
        z-index: 10;
        backdrop-filter: blur(8px);
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.3);
    }

    .stock-available {
        background: rgba(16, 185, 129, 0.9);
        color: white;
    }

    .stock-low {
        background: rgba(245, 158, 11, 0.9);
        color: white;
    }

    /* Right Panel - Checkout */
    .checkout-panel {
        background: rgba(45, 55, 72, 0.5);
        backdrop-filter: blur(10px);
        border: 1px solid rgba(107, 114, 128, 0.3);
        border-radius: 12px;
        padding: 1.5rem;
        display: flex;
        flex-direction: column;
        gap: 1.5rem;
        height: calc(100vh - 140px);
        overflow-y: auto;
        overflow-x: hidden;
        position: sticky;
        top: 20px;
        align-self: start;
        box-sizing: border-box;
    }

    .checkout-panel::-webkit-scrollbar {
        width: 6px;
    }

    .checkout-panel::-webkit-scrollbar-track {
        background: rgba(45, 55, 72, 0.3);
        border-radius: 3px;
    }

    .checkout-panel::-webkit-scrollbar-thumb {
        background: rgba(236, 72, 153, 0.5);
        border-radius: 3px;
    }

    .checkout-panel::-webkit-scrollbar-thumb:hover {
        background: rgba(236, 72, 153, 0.7);
    }

    .checkout-header {
        display: flex;
        flex-direction: column;
        gap: 0.75rem;
    }

    .checkout-header h3 {
        font-size: 1.125rem;
        font-weight: bold;
    }

    .customer-info-group {
        display: flex;
        gap: 0.5rem;
        width: 100%;
    }

    .table-input {
        flex: 1;
        min-width: 0;
        padding: 0.5rem 0.75rem;
        background: rgba(55, 65, 81, 0.3);
        border: 1px solid rgba(107, 114, 128, 0.3);
        border-radius: 8px;
        color: white;
        font-size: 0.875rem;
        box-sizing: border-box;
    }

    .table-input:focus {
        outline: none;
        border-color: #ec4899;
    }

    /* Cart Items */
    .cart-items {
        flex: 1;
        display: flex;
        flex-direction: column;
        gap: 0.75rem;
        overflow-y: auto;
        overflow-x: hidden;
        min-height: 200px;
        max-height: 300px;
        width: 100%;
    }

    .cart-items::-webkit-scrollbar {
        width: 6px;
    }

    .cart-items::-webkit-scrollbar-track {
        background: rgba(45, 55, 72, 0.3);
        border-radius: 3px;
    }

    .cart-items::-webkit-scrollbar-thumb {
        background: rgba(236, 72, 153, 0.5);
        border-radius: 3px;
    }

    .cart-items::-webkit-scrollbar-thumb:hover {
        background: rgba(236, 72, 153, 0.7);
    }

    .cart-item {
        display: flex;
        gap: 0.75rem;
        padding: 0.75rem;
        background: rgba(55, 65, 81, 0.3);
        border-radius: 8px;
        width: 100%;
        box-sizing: border-box;
    }

    .cart-item-icon {
        width: 48px;
        height: 48px;
        flex-shrink: 0;
        border-radius: 6px;
        background: linear-gradient(135deg, rgba(236, 72, 153, 0.2) 0%, rgba(139, 92, 246, 0.2) 100%);
        display: flex;
        align-items: center;
        justify-content: center;
        color: #ec4899;
        font-size: 1.25rem;
    }

    .cart-item-info {
        flex: 1;
        min-width: 0;
        display: flex;
        flex-direction: column;
        gap: 0.25rem;
    }

    .cart-item-name {
        font-size: 0.875rem;
        font-weight: 500;
    }

    .cart-item-qty {
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }

    .qty-btn {
        width: 24px;
        height: 24px;
        border-radius: 4px;
        background: rgba(107, 114, 128, 0.3);
        border: none;
        color: white;
        cursor: pointer;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 0.875rem;
        transition: all 0.3s;
    }

    .qty-btn:hover {
        background: rgba(107, 114, 128, 0.5);
    }

    .qty-display {
        font-size: 0.875rem;
        min-width: 20px;
        text-align: center;
    }

    .cart-item-price {
        font-size: 0.875rem;
        font-weight: bold;
        color: #ec4899;
        text-align: right;
    }

    .remove-btn {
        background: none;
        border: none;
        color: #ef4444;
        cursor: pointer;
        padding: 0.25rem;
        transition: all 0.3s;
    }

    .remove-btn:hover {
        color: #dc2626;
    }

    .empty-cart {
        text-align: center;
        padding: 2rem;
        color: #9ca3af;
    }

    /* Discount Section */
    .discount-section {
        display: flex;
        flex-direction: column;
        gap: 0.75rem;
        width: 100%;
    }

    .discount-type-group {
        display: flex;
        gap: 1rem;
        align-items: center;
        padding: 0.5rem 0;
    }

    .discount-type-option {
        display: flex;
        align-items: center;
        gap: 0.4rem;
        cursor: pointer;
    }

    .discount-type-option input[type="radio"] {
        width: 18px;
        height: 18px;
        cursor: pointer;
        accent-color: #ec4899;
    }

    .discount-type-option label {
        color: rgba(255, 255, 255, 0.9);
        font-size: 0.875rem;
        cursor: pointer;
        user-select: none;
    }

    .discount-input-group {
        display: flex;
        gap: 0.5rem;
        width: 100%;
    }

    .discount-input {
        flex: 1;
        min-width: 0;
        padding: 0.75rem;
        background: rgba(55, 65, 81, 0.3);
        border: 1px solid rgba(107, 114, 128, 0.3);
        border-radius: 8px;
        color: white;
        font-size: 0.875rem;
        box-sizing: border-box;
    }

    .discount-input:focus {
        outline: none;
        border-color: #ec4899;
    }

    .apply-btn {
        padding: 0.75rem 1.25rem;
        background: rgba(236, 72, 153, 0.2);
        border: 1px solid #ec4899;
        border-radius: 8px;
        color: #ec4899;
        font-size: 0.875rem;
        font-weight: 500;
        cursor: pointer;
        transition: all 0.3s;
        box-sizing: border-box;
    }

    .apply-btn:hover {
        background: rgba(236, 72, 153, 0.3);
    }

    /* Summary */
    .summary {
        display: flex;
        flex-direction: column;
        gap: 0.75rem;
        padding-top: 1rem;
        border-top: 1px solid rgba(107, 114, 128, 0.3);
        width: 100%;
    }

    .summary-row {
        display: flex;
        justify-content: space-between;
        font-size: 0.875rem;
    }

    .summary-row.total {
        font-size: 1.125rem;
        font-weight: bold;
        color: #ec4899;
        padding-top: 0.75rem;
        border-top: 1px solid rgba(107, 114, 128, 0.3);
    }

    /* Payment Method */
    .payment-methods {
        display: flex;
        gap: 0.5rem;
        width: 100%;
    }

    .payment-method {
        flex: 1;
        min-width: 0;
        padding: 0.75rem;
        background: rgba(55, 65, 81, 0.3);
        border: 2px solid rgba(107, 114, 128, 0.3);
        border-radius: 8px;
        color: #9ca3af;
        font-size: 0.875rem;
        cursor: pointer;
        text-align: center;
        transition: all 0.3s;
        box-sizing: border-box;
    }

    .payment-method.active {
        border-color: #ec4899;
        color: white;
        background: rgba(236, 72, 153, 0.2);
    }

    /* Checkout Button */
    .checkout-btn {
        width: 100%;
        padding: 1rem;
        background: linear-gradient(135deg, #ec4899 0%, #8b5cf6 100%);
        border: none;
        border-radius: 12px;
        color: white;
        font-size: 1rem;
        font-weight: bold;
        cursor: pointer;
        transition: all 0.3s;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 0.5rem;
    }

    .checkout-btn:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 15px rgba(236, 72, 153, 0.5);
    }

    .checkout-btn:disabled {
        opacity: 0.5;
        cursor: not-allowed;
        transform: none;
    }

    /* QR Code Section */
    .qr-section {
        text-align: center;
        padding: 1rem;
        background: rgba(55, 65, 81, 0.3);
        border-radius: 8px;
    }

    .qr-label {
        font-size: 0.75rem;
        color: #9ca3af;
        margin-bottom: 0.5rem;
    }

    .qr-code {
        width: 120px;
        height: 120px;
        background: white;
        border-radius: 8px;
        margin: 0 auto;
    }

    /* Toast Notification */
    .toast {
        position: fixed;
        top: 2rem;
        right: 2rem;
        background: white;
        color: #1f2937;
        padding: 1.5rem;
        border-radius: 12px;
        box-shadow: 0 10px 40px rgba(0, 0, 0, 0.2);
        display: flex;
        align-items: center;
        gap: 1rem;
        min-width: 350px;
        z-index: 9999;
        animation: slideIn 0.4s ease-out;
    }

    .toast.show {
        opacity: 1;
    }

    .toast-icon {
        width: 48px;
        height: 48px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        flex-shrink: 0;
    }

    .toast-icon.success {
        background: linear-gradient(135deg, #10b981 0%, #059669 100%);
    }

    .toast-icon.error {
        background: linear-gradient(135deg, #ef4444 0%, #dc2626 100%);
    }

    .toast-content {
        flex: 1;
    }

    .toast-title {
        font-weight: 700;
        font-size: 1rem;
        margin-bottom: 0.25rem;
    }

    .toast-message {
        font-size: 0.875rem;
        color: #6b7280;
    }

    .toast-close {
        background: none;
        border: none;
        color: #9ca3af;
        cursor: pointer;
        padding: 0.25rem;
        display: flex;
        align-items: center;
        justify-content: center;
        transition: color 0.2s;
    }

    .toast-close:hover {
        color: #1f2937;
    }

    @keyframes slideIn {
        from {
            transform: translateX(100%);
            opacity: 0;
        }
        to {
            transform: translateX(0);
            opacity: 1;
        }
    }

    @keyframes slideOut {
        from {
            transform: translateX(0);
            opacity: 1;
        }
        to {
            transform: translateX(100%);
            opacity: 0;
        }
    }

    @keyframes spin {
        from {
            transform: rotate(0deg);
        }
        to {
            transform: rotate(360deg);
        }
    }
</style>
@endpush

@section('content')
<div class="orders-container">
    <!-- Left Panel - Menu -->
    <div class="menu-panel">
        <!-- Search Bar -->
        <div class="search-bar">
            <svg class="search-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
            </svg>
            <input type="text" class="search-input" id="searchInput" placeholder="Search menu or clear to see all...">
        </div>

        <!-- Categories -->
        <div>
            <div class="categories-grid">
                <div class="category-card active" data-category="all">
                    <div class="category-icon">🍽️</div>
                    <div class="category-name">All</div>
                    <div class="category-count">{{ $products->count() }} items</div>
                </div>
                @foreach($categories as $category)
                <div class="category-card" data-category="{{ $category->id }}">
                    <div class="category-icon">{{ $category->icon ?? '📦' }}</div>
                    <div class="category-name">{{ $category->c_name }}</div>
                    <div class="category-count">{{ $category->products->count() }} items</div>
                </div>
                @endforeach
            </div>
        </div>

        <!-- Products -->
        <div class="products-section">
            <h3 id="sectionTitle">All Products</h3>
            <div class="products-grid" id="productsGrid">
                @foreach($products as $product)
                <div class="product-card" 
                     data-id="{{ $product->id }}"
                     data-stock="{{ $product->p_stock }}"
                     data-name="{{ $product->p_name }}"
                     data-price="{{ $product->p_price }}"
                     data-category="{{ $product->category_id }}"
                     data-icon="{{ $product->p_image ? asset('storage/' . $product->p_image) : '🍽️' }}">
                    <span class="product-stock {{ $product->p_stock <= 5 ? 'stock-low' : 'stock-available' }}">
                        {{ $product->p_stock }} left
                    </span>
                    <div class="product-image">
                        @if($product->p_image)
                            <img src="{{ asset('storage/' . $product->p_image) }}" alt="{{ $product->p_name }}" style="width: 100%; height: 100%; object-fit: cover; border-radius: 8px;">
                        @else
                            <span style="font-size: 2rem;">🍽️</span>
                        @endif
                    </div>
                    <div class="product-info">
                        <div class="product-name">{{ $product->p_name }}</div>
                        <div class="product-category">{{ $product->category->c_name ?? 'Uncategorized' }}</div>
                        <div class="product-price">Rp {{ number_format($product->p_price, 0, ',', '.') }}</div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </div>

    <!-- Right Panel - Checkout -->
    <div class="checkout-panel">
        <div class="checkout-header">
            <h3 id="tableDisplay">New Order</h3>
            <div class="customer-info-group">
                <input type="text" class="table-input" id="customerName" placeholder="Customer Name">
                <input type="text" class="table-input" id="tableNumber" placeholder="Table No.">
            </div>
        </div>

        <!-- Cart Items -->
        <div class="cart-items" id="cartItems">
            <div class="empty-cart">
                <svg width="64" height="64" fill="none" stroke="currentColor" viewBox="0 0 24 24" style="margin: 0 auto 1rem;">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z" />
                </svg>
                <p>Cart is empty<br>Add items to continue</p>
            </div>
        </div>

        <!-- Discount Section -->
        <div class="discount-section">
            <div class="discount-input-group">
                <input type="text" class="discount-input" id="voucherCode" placeholder="Voucher code">
                <button class="apply-btn" onclick="applyVoucher()">Apply</button>
            </div>
            
            <div class="discount-type-group">
                <span style="color: rgba(255, 255, 255, 0.7); font-size: 0.875rem;">Discount Type:</span>
                <div class="discount-type-option">
                    <input type="radio" id="discountTypeAmount" name="discountType" value="amount" checked onchange="updateDiscountPlaceholder()">
                    <label for="discountTypeAmount">Amount (Rp)</label>
                </div>
                <div class="discount-type-option">
                    <input type="radio" id="discountTypePercent" name="discountType" value="percent" onchange="updateDiscountPlaceholder()">
                    <label for="discountTypePercent">Percent (%)</label>
                </div>
            </div>
            
            <div class="discount-input-group">
                <input type="number" class="discount-input" id="discountAmount" placeholder="Discount amount (Rp)" min="0" step="0.01">
                <button class="apply-btn" onclick="applyDiscount()">Apply</button>
            </div>
        </div>

        <!-- Summary -->
        <div class="summary">
            <div class="summary-row">
                <span>Subtotal</span>
                <span id="subtotalDisplay">Rp 0</span>
            </div>
            <div class="summary-row">
                <span>Tax (11%)</span>
                <span id="taxDisplay">Rp 0</span>
            </div>
            <div class="summary-row">
                <span>Discount</span>
                <span id="discountDisplay">Rp 0</span>
            </div>
            <div class="summary-row total">
                <span>Total</span>
                <span id="totalDisplay">Rp 0</span>
            </div>
        </div>

        <!-- Payment Method -->
        <div>
            <div style="font-size: 0.875rem; margin-bottom: 0.5rem; color: #9ca3af;">Payment Method</div>
            <div class="payment-methods">
                <div class="payment-method active" data-method="cash">Cash</div>
                <div class="payment-method" data-method="card">Card</div>
                <div class="payment-method" data-method="qr">QR Code</div>
            </div>
        </div>

        <!-- QR Code (shown when QR payment selected) -->
        <div class="qr-section" id="qrSection" style="display: none;">
            <div class="qr-label">Scan QR Code</div>
            <div class="qr-code">QR Code Here</div>
        </div>

        <!-- Checkout Button -->
        <button class="checkout-btn" id="checkoutBtn" onclick="checkout()" disabled>
            <svg width="24" height="24" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
            </svg>
            Checkout & Print Invoice
        </button>
    </div>
</div>
@endsection

@push('scripts')
<script>
    // Helper function to format Rupiah
    function formatRupiah(amount) {
        return 'Rp ' + Math.round(amount).toString().replace(/\B(?=(\d{3})+(?!\d))/g, '.');
    }

    // Toast notification function
    function showToast(title, message, type = 'success') {
        // Remove existing toast if any
        const existingToast = document.querySelector('.toast');
        if (existingToast) {
            existingToast.remove();
        }

        // Create toast element
        const toast = document.createElement('div');
        toast.className = 'toast show';
        
        const iconHtml = type === 'success' 
            ? '<svg width="24" height="24" fill="none" stroke="white" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7" /></svg>'
            : '<svg width="24" height="24" fill="none" stroke="white" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" /></svg>';
        
        toast.innerHTML = `
            <div class="toast-icon ${type}">
                ${iconHtml}
            </div>
            <div class="toast-content">
                <div class="toast-title">${title}</div>
                <div class="toast-message">${message}</div>
            </div>
            <button class="toast-close" onclick="this.parentElement.remove()">
                <svg width="20" height="20" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                </svg>
            </button>
        `;
        
        document.body.appendChild(toast);
        
        // Auto remove after 4 seconds
        setTimeout(() => {
            toast.style.animation = 'slideOut 0.4s ease-in';
            setTimeout(() => toast.remove(), 400);
        }, 4000);
    }

    // Cart state
    let cart = [];
    let discount = 0;
    let paymentMethod = 'cash';

    // Category filter
    document.querySelectorAll('.category-card').forEach(card => {
        card.addEventListener('click', function() {
            // Update active state
            document.querySelectorAll('.category-card').forEach(c => c.classList.remove('active'));
            this.classList.add('active');

            const categoryId = this.dataset.category;
            const categoryName = this.querySelector('.category-name').textContent;
            
            // Update section title
            document.getElementById('sectionTitle').textContent = categoryName + ' Products';
            
            // Filter products
            filterProducts(categoryId);
        });
    });

    // Search functionality
    document.getElementById('searchInput').addEventListener('input', function(e) {
        const searchTerm = e.target.value.toLowerCase();
        
        if (searchTerm === '') {
            // Show all products
            document.querySelectorAll('.product-card').forEach(card => {
                card.style.display = 'flex';
            });
            return;
        }

        document.querySelectorAll('.product-card').forEach(card => {
            const productName = card.dataset.name.toLowerCase();
            if (productName.includes(searchTerm)) {
                card.style.display = 'flex';
            } else {
                card.style.display = 'none';
            }
        });
    });

    function filterProducts(categoryId) {
        document.querySelectorAll('.product-card').forEach(card => {
            if (categoryId === 'all' || card.dataset.category === categoryId) {
                card.style.display = 'flex';
            } else {
                card.style.display = 'none';
            }
        });
    }

    // Add to cart
    document.querySelectorAll('.product-card').forEach(card => {
        card.addEventListener('click', function() {
            const product = {
                id: parseInt(this.dataset.id),
                name: this.dataset.name,
                price: parseFloat(this.dataset.price),
                icon: this.dataset.icon,
                stock: parseInt(this.dataset.stock)
            };

            addToCart(product);
        });
    });

    function addToCart(product) {
        const existingItem = cart.find(item => item.id === product.id);
        
        if (existingItem) {
            if (existingItem.quantity < product.stock) {
                existingItem.quantity++;
            } else {
                alert('Insufficient stock!');
                return;
            }
        } else {
            cart.push({
                ...product,
                quantity: 1
            });
        }

        updateCart();
    }

    function updateCart() {
        const cartItemsContainer = document.getElementById('cartItems');
        
        if (cart.length === 0) {
            cartItemsContainer.innerHTML = `
                <div class="empty-cart">
                    <svg width="64" height="64" fill="none" stroke="currentColor" viewBox="0 0 24 24" style="margin: 0 auto 1rem;">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z" />
                    </svg>
                    <p>Cart is empty<br>Add items to continue</p>
                </div>
            `;
            document.getElementById('checkoutBtn').disabled = true;
        } else {
            cartItemsContainer.innerHTML = cart.map(item => `
                <div class="cart-item">
                    <div class="cart-item-icon">
                        ${item.icon.startsWith('http') || item.icon.includes('storage/') 
                            ? `<img src="${item.icon}" alt="${item.name}" style="width: 100%; height: 100%; object-fit: cover; border-radius: 6px;">` 
                            : item.icon}
                    </div>
                    <div class="cart-item-info">
                        <div class="cart-item-name">${item.name}</div>
                        <div class="cart-item-qty">
                            <button class="qty-btn" onclick="decreaseQty(${item.id})">-</button>
                            <span class="qty-display">${item.quantity}</span>
                            <button class="qty-btn" onclick="increaseQty(${item.id})">+</button>
                        </div>
                    </div>
                    <div style="display: flex; flex-direction: column; align-items: flex-end; gap: 0.5rem;">
                        <div class="cart-item-price">${formatRupiah(item.price * item.quantity)}</div>
                        <button class="remove-btn" onclick="removeItem(${item.id})">
                            <svg width="20" height="20" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                            </svg>
                        </button>
                    </div>
                </div>
            `).join('');
            document.getElementById('checkoutBtn').disabled = false;
        }

        updateSummary();
    }

    function increaseQty(productId) {
        const item = cart.find(i => i.id === productId);
        if (item && item.quantity < item.stock) {
            item.quantity++;
            updateCart();
        } else {
            alert('Insufficient stock!');
        }
    }

    function decreaseQty(productId) {
        const item = cart.find(i => i.id === productId);
        if (item) {
            item.quantity--;
            if (item.quantity === 0) {
                removeItem(productId);
            } else {
                updateCart();
            }
        }
    }

    function removeItem(productId) {
        cart = cart.filter(item => item.id !== productId);
        updateCart();
    }

    function updateSummary() {
        const subtotal = cart.reduce((sum, item) => sum + (item.price * item.quantity), 0);
        const tax = subtotal * 0.11;
        const total = subtotal + tax - discount;

        document.getElementById('subtotalDisplay').textContent = formatRupiah(subtotal);
        document.getElementById('taxDisplay').textContent = formatRupiah(tax);
        document.getElementById('discountDisplay').textContent = formatRupiah(discount);
        document.getElementById('totalDisplay').textContent = formatRupiah(total);
    }

    function applyVoucher() {
        const voucherCode = document.getElementById('voucherCode').value;
        if (voucherCode) {
            // Here you can add voucher validation logic
            showToast('Info', 'Voucher validation not implemented yet', 'error');
        }
    }

    function applyDiscount() {
        const discountInput = parseFloat(document.getElementById('discountAmount').value) || 0;
        const discountType = document.querySelector('input[name="discountType"]:checked').value;
        
        // Calculate discount based on type
        const subtotal = cart.reduce((sum, item) => sum + (item.price * item.quantity), 0);
        
        if (discountType === 'percent') {
            // Calculate percent discount (max 100%)
            const percent = Math.min(discountInput, 100);
            discount = subtotal * (percent / 100);
        } else {
            // Direct amount discount (max subtotal)
            discount = Math.min(discountInput, subtotal);
        }
        
        updateSummary();
    }
    
    function updateDiscountPlaceholder() {
        const discountType = document.querySelector('input[name="discountType"]:checked').value;
        const discountInput = document.getElementById('discountAmount');
        
        if (discountType === 'percent') {
            discountInput.placeholder = 'Discount percent (%)';
            discountInput.max = '100';
        } else {
            discountInput.placeholder = 'Discount amount (Rp)';
            discountInput.removeAttribute('max');
        }
        
        // Reapply discount if there's a value
        if (discountInput.value) {
            applyDiscount();
        }
    }

    // Payment method selection
    document.querySelectorAll('.payment-method').forEach(method => {
        method.addEventListener('click', function() {
            document.querySelectorAll('.payment-method').forEach(m => m.classList.remove('active'));
            this.classList.add('active');
            paymentMethod = this.dataset.method;

            // Show/hide QR section
            const qrSection = document.getElementById('qrSection');
            if (paymentMethod === 'qr') {
                qrSection.style.display = 'block';
            } else {
                qrSection.style.display = 'none';
            }
        });
    });

    // Checkout
    async function checkout() {
        if (cart.length === 0) {
            showToast('Cart Empty!', 'Please add items to cart before checkout', 'error');
            return;
        }

        const customerName = document.getElementById('customerName').value;
        const tableNumber = document.getElementById('tableNumber').value;
        
        // Calculate amounts
        const subtotal = cart.reduce((sum, item) => sum + (item.price * item.quantity), 0);
        const tax = subtotal * 0.11;
        const subtotalAmount = subtotal + tax - discount;
        
        // Get discount type
        const discountType = document.querySelector('input[name="discountType"]:checked').value;
        
        const orderData = {
            customer_name: customerName || null,
            table_number: tableNumber || null,
            items: cart.map(item => ({
                product_id: item.id,
                quantity: item.quantity
            })),
            discount: discount,
            discount_type: discountType,
            subtotal_amount: subtotalAmount,
            payment_method: paymentMethod,
            voucher_code: document.getElementById('voucherCode').value || null
        };

        // Disable checkout button
        const checkoutBtn = document.getElementById('checkoutBtn');
        checkoutBtn.disabled = true;
        checkoutBtn.innerHTML = '<svg width="24" height="24" fill="none" stroke="currentColor" viewBox="0 0 24 24" style="animation: spin 1s linear infinite;"><circle cx="12" cy="12" r="10" stroke-width="4" stroke="currentColor" stroke-opacity="0.25"></circle><path d="M12 2a10 10 0 0 1 0 20" stroke-width="4"></path></svg> Processing...';

        try {
            const response = await fetch('{{ route("orders.store") }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: JSON.stringify(orderData)
            });

            const result = await response.json();

            if (result.success) {
                // Show success toast
                showToast(
                    '✅ Order Created Successfully!', 
                    `Sale #${result.sale_number} - Opening invoice...`,
                    'success'
                );
                
                // Open invoice in new tab
                const invoiceUrl = '{{ url("/sales") }}/' + result.sale_id + '/invoice';
                window.open(invoiceUrl, '_blank');
                
                // Reset cart after short delay
                setTimeout(() => {
                    cart = [];
                    discount = 0;
                    document.getElementById('customerName').value = '';
                    document.getElementById('tableNumber').value = '';
                    document.getElementById('voucherCode').value = '';
                    document.getElementById('discountAmount').value = '';
                    updateCart();
                }, 500);
            } else {
                showToast('Failed!', result.error || 'Failed to create order', 'error');
            }
        } catch (error) {
            console.error('Error:', error);
            showToast('Error!', 'Failed to create order. Please try again.', 'error');
        } finally {
            // Re-enable button
            checkoutBtn.disabled = false;
            checkoutBtn.innerHTML = '<svg width="24" height="24" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" /></svg> Checkout & Print Invoice';
        }
    }
</script>
@endpush
