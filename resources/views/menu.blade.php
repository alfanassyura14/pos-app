@extends('layouts.app')

@php
    $pageTitle = 'Menu';
    $showBackButton = true;
@endphp

@push('styles')
    /* Categories Section */
    .section-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 1.5rem;
    }

    .section-header h2 {
        font-size: 1.25rem;
        font-weight: bold;
    }

    .add-btn {
        background: linear-gradient(135deg, #ec4899 0%, #db2777 100%);
        color: white;
        border: none;
        padding: 0.75rem 1.5rem;
        border-radius: 12px;
        cursor: pointer;
        font-weight: 500;
        transition: all 0.3s;
        box-shadow: 0 4px 15px rgba(236, 72, 153, 0.4);
    }

    .add-btn:hover {
        transform: translateY(-2px);
        box-shadow: 0 6px 20px rgba(236, 72, 153, 0.5);
    }

    .categories-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(140px, 1fr));
        gap: 1rem;
        margin-bottom: 3rem;
    }

    .category-card {
        background: rgba(45, 55, 72, 0.5);
        backdrop-filter: blur(10px);
        border: 1px solid rgba(107, 114, 128, 0.3);
        border-radius: 16px;
        padding: 1.5rem;
        text-align: center;
        cursor: pointer;
        transition: all 0.3s;
        position: relative;
    }

    .category-card:hover {
        background: rgba(55, 65, 81, 0.6);
        transform: translateY(-4px);
        box-shadow: 0 8px 20px rgba(0, 0, 0, 0.3);
    }

    .category-card.active {
        background: linear-gradient(135deg, #ec4899 0%, #8b5cf6 100%);
        border-color: transparent;
    }

    .category-icon {
        font-size: 3rem;
        margin-bottom: 0.5rem;
        filter: drop-shadow(0 4px 10px rgba(0, 0, 0, 0.3));
    }

    .category-name {
        font-weight: 600;
        font-size: 0.9rem;
        margin-bottom: 0.25rem;
    }

    .category-count {
        font-size: 0.75rem;
        color: #9ca3af;
    }

    .category-card.active .category-count {
        color: rgba(255, 255, 255, 0.8);
    }

    /* Menu Tabs */
    .menu-tabs {
        display: flex;
        gap: 1rem;
        margin-bottom: 2rem;
        flex-wrap: wrap;
    }

    .menu-tab {
        background: rgba(45, 55, 72, 0.5);
        border: 1px solid rgba(107, 114, 128, 0.3);
        color: #9ca3af;
        padding: 0.75rem 1.5rem;
        border-radius: 12px;
        cursor: pointer;
        font-weight: 500;
        transition: all 0.3s;
    }

    .menu-tab.active {
        background: linear-gradient(135deg, #ec4899 0%, #8b5cf6 100%);
        color: white;
        border-color: transparent;
    }

    .menu-tab:hover:not(.active) {
        background: rgba(55, 65, 81, 0.6);
        color: white;
    }

    /* Products Table */
    .table-container {
        background: rgba(45, 55, 72, 0.3);
        border-radius: 16px;
        overflow: hidden;
    }

    .products-table {
        width: 100%;
        border-collapse: collapse;
    }

    .products-table thead {
        background: rgba(55, 65, 81, 0.5);
    }

    .products-table th {
        padding: 1rem;
        text-align: left;
        font-weight: 600;
        color: #9ca3af;
        font-size: 0.875rem;
    }

    .products-table td {
        padding: 1rem;
        border-top: 1px solid rgba(107, 114, 128, 0.2);
    }

    .products-table tbody tr {
        transition: background 0.3s;
    }

    .products-table tbody tr:hover {
        background: rgba(55, 65, 81, 0.3);
    }

    .product-info {
        display: flex;
        align-items: center;
        gap: 1rem;
    }

    .product-image {
        width: 60px;
        height: 60px;
        border-radius: 12px;
        object-fit: cover;
        background: rgba(107, 114, 128, 0.3);
    }

    .product-details h3 {
        font-weight: 600;
        margin-bottom: 0.25rem;
    }

    .product-details p {
        font-size: 0.75rem;
        color: #9ca3af;
    }

    .status-badge {
        padding: 0.375rem 0.75rem;
        border-radius: 8px;
        font-size: 0.75rem;
        font-weight: 500;
    }

    .status-badge.in-stock {
        background: rgba(16, 185, 129, 0.2);
        color: #10b981;
    }

    .status-badge.out-stock {
        background: rgba(239, 68, 68, 0.2);
        color: #ef4444;
    }

    .status-badge.low-stock {
        background: rgba(251, 191, 36, 0.2);
        color: #fbbf24;
    }

    .action-buttons {
        display: flex;
        gap: 0.5rem;
    }

    .icon-btn {
        background: rgba(107, 114, 128, 0.3);
        border: none;
        color: white;
        width: 36px;
        height: 36px;
        border-radius: 8px;
        cursor: pointer;
        display: flex;
        align-items: center;
        justify-content: center;
        transition: all 0.3s;
    }

    .icon-btn:hover {
        background: rgba(107, 114, 128, 0.5);
    }

    .icon-btn.edit:hover {
        background: #3b82f6;
    }

    .icon-btn.delete:hover {
        background: #ef4444;
    }

    /* Modal Styles */
    .modal {
        display: none;
        position: fixed;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: rgba(0, 0, 0, 0.75);
        backdrop-filter: blur(4px);
        z-index: 1000;
        align-items: center;
        justify-content: center;
    }

    .modal.active {
        display: flex;
    }

    .modal-content {
        background: linear-gradient(135deg, #2d3748 0%, #1a202c 100%);
        border-radius: 20px;
        padding: 2rem;
        max-width: 500px;
        width: 90%;
        max-height: 90vh;
        overflow-y: auto;
        border: 1px solid rgba(107, 114, 128, 0.3);
        box-shadow: 0 20px 60px rgba(0, 0, 0, 0.5);
    }

    .modal-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 2rem;
    }

    .modal-header h2 {
        font-size: 1.5rem;
        font-weight: bold;
    }

    .close-btn {
        background: rgba(107, 114, 128, 0.3);
        border: none;
        color: white;
        width: 36px;
        height: 36px;
        border-radius: 50%;
        cursor: pointer;
        display: flex;
        align-items: center;
        justify-content: center;
        transition: all 0.3s;
    }

    .close-btn:hover {
        background: #ef4444;
    }

    .form-group {
        margin-bottom: 1.5rem;
    }

    .form-group label {
        display: block;
        margin-bottom: 0.5rem;
        font-weight: 500;
        color: #e5e7eb;
    }

    .form-group input,
    .form-group select,
    .form-group textarea {
        width: 100%;
        padding: 0.75rem;
        background: rgba(55, 65, 81, 0.5);
        border: 1px solid rgba(107, 114, 128, 0.3);
        border-radius: 8px;
        color: white;
        font-size: 0.875rem;
        transition: all 0.3s;
    }

    .form-group input:focus,
    .form-group select:focus,
    .form-group textarea:focus {
        outline: none;
        border-color: #ec4899;
        box-shadow: 0 0 0 3px rgba(236, 72, 153, 0.1);
    }

    .form-group textarea {
        resize: vertical;
        min-height: 100px;
    }

    .image-upload {
        background: rgba(55, 65, 81, 0.3);
        border: 2px dashed rgba(107, 114, 128, 0.5);
        border-radius: 12px;
        padding: 2rem;
        text-align: center;
        cursor: pointer;
        transition: all 0.3s;
    }

    .image-upload:hover {
        border-color: #ec4899;
        background: rgba(55, 65, 81, 0.5);
    }

    .image-upload.has-image {
        padding: 0;
        border: none;
        background: transparent;
        cursor: default;
    }

    .image-preview {
        max-width: 100%;
        max-height: 300px;
        border-radius: 12px;
        display: block;
        margin: 0 auto;
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.2);
    }

    .image-preview-wrapper {
        position: relative;
        display: inline-block;
        width: 100%;
    }

    .remove-image-btn {
        position: absolute;
        top: 0.5rem;
        right: 0.5rem;
        background: rgba(239, 68, 68, 0.9);
        color: white;
        border: none;
        width: 32px;
        height: 32px;
        border-radius: 50%;
        cursor: pointer;
        display: flex;
        align-items: center;
        justify-content: center;
        transition: all 0.3s;
        z-index: 10;
    }

    .remove-image-btn:hover {
        background: #dc2626;
        transform: scale(1.1);
    }

    .icon-selector {
        display: grid;
        grid-template-columns: repeat(6, 1fr);
        gap: 0.5rem;
        margin-top: 0.5rem;
    }

    .icon-option {
        font-size: 2rem;
        padding: 0.5rem;
        background: rgba(55, 65, 81, 0.3);
        border: 2px solid transparent;
        border-radius: 8px;
        cursor: pointer;
        transition: all 0.3s;
        text-align: center;
    }

    .icon-option:hover,
    .icon-option.selected {
        border-color: #ec4899;
        background: rgba(236, 72, 153, 0.2);
    }

    .modal-actions {
        display: flex;
        gap: 1rem;
        margin-top: 2rem;
    }

    .btn {
        flex: 1;
        padding: 0.75rem 1.5rem;
        border: none;
        border-radius: 12px;
        font-weight: 500;
        cursor: pointer;
        transition: all 0.3s;
    }

    .btn-cancel {
        background: rgba(107, 114, 128, 0.3);
        color: white;
    }

    .btn-cancel:hover {
        background: rgba(107, 114, 128, 0.5);
    }

    .btn-save {
        background: linear-gradient(135deg, #ec4899 0%, #db2777 100%);
        color: white;
        box-shadow: 0 4px 15px rgba(236, 72, 153, 0.4);
    }

    .btn-save:hover {
        transform: translateY(-2px);
        box-shadow: 0 6px 20px rgba(236, 72, 153, 0.5);
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
@endpush

@section('content')
    <!-- Categories Section -->
    <div class="section-header">
        <h2>Categories</h2>
        <button class="add-btn" id="addCategoryBtn">Add New Category</button>
    </div>

    <div class="categories-grid">
        <div class="category-card active" data-category="all">
            <div class="category-icon">
                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24" width="48" height="48">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z"></path>
                </svg>
            </div>
            <div class="category-name">All</div>
            <div class="category-count">{{ $products->count() }} items</div>
        </div>

        @foreach($categories ?? [] as $category)
        <div class="category-card" data-category="{{ $category->id }}">
            <div class="category-icon">
                {!! $category->icon ?? '📦' !!}
            </div>
            <div class="category-name">{{ $category->c_name }}</div>
            <div class="category-count">{{ $category->products_count }} items</div>
            <div class="action-buttons" style="position: absolute; top: 0.5rem; right: 0.5rem; display: none;">
                <button class="icon-btn edit" data-id="{{ $category->id }}" data-name="{{ $category->c_name }}" data-description="{{ $category->c_description }}" data-icon="{{ $category->icon }}" data-menu-type="{{ $category->menu_type }}">
                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24" width="16" height="16">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                    </svg>
                </button>
                <button class="icon-btn delete" data-id="{{ $category->id }}" data-name="{{ $category->c_name }}">
                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24" width="16" height="16">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                    </svg>
                </button>
            </div>
        </div>
        @endforeach
    </div>

    <!-- Special Menu Section -->
    <div class="section-header">
        <h2>Special menu all items</h2>
        <button class="add-btn" id="addProductBtn">Add Menu Item</button>
    </div>

    <div class="menu-tabs">
        <button class="menu-tab active" data-menu-type="all">Normal Menu</button>
        @foreach($menuTypes ?? [] as $menuType)
        <button class="menu-tab" data-menu-type="{{ $menuType }}">{{ $menuType }}</button>
        @endforeach
    </div>

    <!-- Products Table -->
    <div class="table-container">
        <table class="products-table">
            <thead>
                <tr>
                    <th style="width: 40px;">
                        <input type="checkbox" id="select-all">
                    </th>
                    <th>Product</th>
                    <th>Product Name</th>
                    <th>Item ID</th>
                    <th>Stock</th>
                    <th>Category</th>
                    <th>Price</th>
                    <th>Availability</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody id="products-tbody">
                @foreach($products ?? [] as $product)
                <tr class="product-row" data-category="{{ $product->category_id }}" data-menu-type="{{ $product->category->menu_type ?? 'Normal Menu' }}">
                    <td>
                        <input type="checkbox" class="product-checkbox">
                    </td>
                    <td>
                        <div class="product-info">
                            <img src="{{ $product->p_image ? asset('storage/' . $product->p_image) : 'https://via.placeholder.com/60' }}" alt="{{ $product->p_name }}" class="product-image">
                        </div>
                    </td>
                    <td>
                        <div class="product-details">
                            <h3>{{ $product->p_name }}</h3>
                            <p>{{ Str::limit($product->p_description, 50) }}</p>
                        </div>
                    </td>
                    <td>#{{ str_pad($product->id, 7, '0', STR_PAD_LEFT) }}</td>
                    <td>{{ $product->p_stock }} items</td>
                    <td>{{ $product->category->c_name ?? 'N/A' }}</td>
                    <td>Rp. {{ number_format($product->p_price, 0, ',', '.') }}</td>
                    <td>
                        <span class="status-badge {{ $product->p_status == 'In Stock' ? 'in-stock' : ($product->p_status == 'Out of Stock' ? 'out-stock' : 'low-stock') }}">
                            {{ $product->p_status }}
                        </span>
                    </td>
                    <td>
                        <div class="action-buttons">
                            <button class="icon-btn edit product-edit" data-id="{{ $product->id }}" data-name="{{ $product->p_name }}" data-description="{{ $product->p_description }}" data-price="{{ $product->p_price }}" data-stock="{{ $product->p_stock }}" data-category="{{ $product->category_id }}" data-image="{{ $product->p_image }}">
                                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24" width="16" height="16">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                </svg>
                            </button>
                            <button class="icon-btn delete product-delete" data-id="{{ $product->id }}" data-name="{{ $product->p_name }}">
                                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24" width="16" height="16">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                </svg>
                            </button>
                        </div>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <!-- Category Modal -->
    <div class="modal" id="categoryModal">
        <div class="modal-content">
            <div class="modal-header">
                <h2 id="categoryModalTitle">Add New Category</h2>
                <button class="close-btn" id="closeCategoryModal">
                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24" width="20" height="20">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                </button>
            </div>

            <form id="categoryForm" method="POST" action="{{ route('categories.store') }}">
                @csrf
                <input type="hidden" name="_method" id="categoryMethod" value="POST">
                <input type="hidden" name="category_id" id="categoryId">

                <div class="form-group">
                    <label>Select Icon here</label>
                    <div class="image-upload" style="padding: 1rem; text-align: left;">
                        <div style="color: #9ca3af; font-size: 0.875rem; margin-bottom: 0.5rem;">Select icon</div>
                        <button type="button" class="btn" id="toggleIconSelector" style="background: rgba(107, 114, 128, 0.3); padding: 0.5rem 1rem;">Change Icon</button>
                    </div>
                    <input type="hidden" name="icon" id="categoryIcon" value="📦">
                    <div class="icon-selector" id="iconSelector" style="display: none;">
                        <div class="icon-option" data-icon="🍕">🍕</div>
                        <div class="icon-option" data-icon="🍔">🍔</div>
                        <div class="icon-option" data-icon="🍗">🍗</div>
                        <div class="icon-option" data-icon="🎂">🎂</div>
                        <div class="icon-option" data-icon="🥤">🥤</div>
                        <div class="icon-option" data-icon="🍤">🍤</div>
                        <div class="icon-option" data-icon="🍜">🍜</div>
                        <div class="icon-option" data-icon="🍝">🍝</div>
                        <div class="icon-option" data-icon="🍛">🍛</div>
                        <div class="icon-option" data-icon="🍱">🍱</div>
                        <div class="icon-option" data-icon="🍣">🍣</div>
                        <div class="icon-option" data-icon="🥗">🥗</div>
                    </div>
                </div>

                <div class="form-group">
                    <label for="categoryName">Category Name</label>
                    <input type="text" id="categoryName" name="c_name" placeholder="Enter Category Name" required>
                </div>

                <div class="form-group">
                    <label for="categoryMenuType">Select Menu</label>
                    <select id="categoryMenuType" name="menu_type" required>
                        @foreach($menuTypes ?? [] as $menuType)
                        <option value="{{ $menuType }}">{{ $menuType }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="form-group">
                    <label for="categoryDescription">Description</label>
                    <textarea id="categoryDescription" name="c_description" placeholder="write your category description here"></textarea>
                </div>

                <div class="modal-actions">
                    <button type="button" class="btn btn-cancel" id="cancelCategoryBtn">Cancel</button>
                    <button type="submit" class="btn btn-save">Save</button>
                </div>
            </form>
        </div>
    </div>

    <!-- Product Modal -->
    <div class="modal" id="productModal">
        <div class="modal-content">
            <div class="modal-header">
                <h2 id="productModalTitle">Add Menu Item</h2>
                <button class="close-btn" id="closeProductModal">
                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24" width="20" height="20">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                </button>
            </div>

            <form id="productForm" method="POST" action="{{ route('products.store') }}" enctype="multipart/form-data">
                @csrf
                <input type="hidden" name="_method" id="productMethod" value="POST">
                <input type="hidden" name="product_id" id="productId">

                <div class="form-group">
                    <label>Product Image</label>
                    <div class="image-upload" id="imageUploadArea">
                        <svg fill="none" stroke="currentColor" viewBox="0 0 24 24" width="48" height="48" style="margin: 0 auto; color: #9ca3af;">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                        </svg>
                        <p style="color: #9ca3af; margin-top: 0.5rem;">Click to upload product image</p>
                        <input type="file" id="productImage" name="p_image" accept="image/*" style="display: none;">
                    </div>
                    <div class="image-preview-wrapper" id="imagePreviewWrapper" style="display: none;">
                        <img id="imagePreview" class="image-preview">
                        <button type="button" class="remove-image-btn" id="removeImageBtn" title="Remove image">
                            <svg width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                            </svg>
                        </button>
                    </div>
                </div>

                <div class="form-group">
                    <label for="productName">Product Name</label>
                    <input type="text" id="productName" name="p_name" placeholder="Enter Product Name" required>
                </div>

                <div class="form-group">
                    <label for="productCategory">Category</label>
                    <select id="productCategory" name="category_id" required>
                        @foreach($categories ?? [] as $category)
                        <option value="{{ $category->id }}">{{ $category->c_name }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="form-group">
                    <label for="productDescription">Description</label>
                    <textarea id="productDescription" name="p_description" placeholder="Enter product description"></textarea>
                </div>

                <div class="form-group">
                    <label for="productPrice">Price (Rp.)</label>
                    <input type="text" id="productPrice" name="p_price" placeholder="0" required>
                </div>

                <div class="form-group">
                    <label for="productStock">Stock Quantity</label>
                    <input type="number" id="productStock" name="p_stock" placeholder="0" min="0" required>
                </div>

                <div class="modal-actions">
                    <button type="button" class="btn btn-cancel" id="cancelProductBtn">Cancel</button>
                    <button type="submit" class="btn btn-save">Save</button>
                </div>
            </form>
        </div>
    </div>
@endsection

@push('scripts')
<script>
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

    // Show toast if there's a session success message
    @if(session('success'))
        showToast('Success!', '{{ session('success') }}', 'success');
    @endif

    @if(session('error'))
        showToast('Error!', '{{ session('error') }}', 'error');
    @endif

    // DOM Elements
    const categoryModal = document.getElementById('categoryModal');
    const productModal = document.getElementById('productModal');
    const categoryForm = document.getElementById('categoryForm');
    const productForm = document.getElementById('productForm');

    // Category Modal Functions
    function openCategoryModal() {
        categoryModal.classList.add('active');
        document.getElementById('categoryModalTitle').textContent = 'Add New Category';
        categoryForm.action = "{{ route('categories.store') }}";
        document.getElementById('categoryMethod').value = 'POST';
        categoryForm.reset();
        document.getElementById('categoryIcon').value = '📦';
    }

    function closeCategoryModal() {
        categoryModal.classList.remove('active');
    }

    // Product Modal Functions  
    function openProductModal() {
        productModal.classList.add('active');
        document.getElementById('productModalTitle').textContent = 'Add Menu Item';
        productForm.action = "{{ route('products.store') }}";
        document.getElementById('productMethod').value = 'POST';
        productForm.reset();
        resetImageUpload();
        document.getElementById('productPrice').value = '';
    }

    function closeProductModal() {
        productModal.classList.remove('active');
    }

    function resetImageUpload() {
        document.getElementById('imageUploadArea').style.display = 'block';
        document.getElementById('imagePreviewWrapper').style.display = 'none';
        document.getElementById('imagePreview').src = '';
        document.getElementById('productImage').value = '';
    }

    // Event Listeners
    document.getElementById('addCategoryBtn').addEventListener('click', openCategoryModal);
    document.getElementById('closeCategoryModal').addEventListener('click', closeCategoryModal);
    document.getElementById('cancelCategoryBtn').addEventListener('click', closeCategoryModal);

    document.getElementById('addProductBtn').addEventListener('click', openProductModal);
    document.getElementById('closeProductModal').addEventListener('click', closeProductModal);
    document.getElementById('cancelProductBtn').addEventListener('click', closeProductModal);

    // Icon selector toggle
    document.getElementById('toggleIconSelector').addEventListener('click', function() {
        const selector = document.getElementById('iconSelector');
        selector.style.display = selector.style.display === 'none' ? 'grid' : 'none';
    });

    // Icon selection
    document.querySelectorAll('.icon-option').forEach(option => {
        option.addEventListener('click', function() {
            const icon = this.getAttribute('data-icon');
            document.getElementById('categoryIcon').value = icon;
            document.querySelectorAll('.icon-option').forEach(opt => opt.classList.remove('selected'));
            this.classList.add('selected');
        });
    });

    // Image upload area click
    document.getElementById('imageUploadArea').addEventListener('click', function() {
        document.getElementById('productImage').click();
    });

    // Image preview
    document.getElementById('productImage').addEventListener('change', function() {
        if (this.files && this.files[0]) {
            const reader = new FileReader();
            reader.onload = function(e) {
                document.getElementById('imagePreview').src = e.target.result;
                document.getElementById('imageUploadArea').style.display = 'none';
                document.getElementById('imagePreviewWrapper').style.display = 'block';
            };
            reader.readAsDataURL(this.files[0]);
        }
    });

    // Remove image button
    document.getElementById('removeImageBtn').addEventListener('click', function() {
        resetImageUpload();
    });

    // Price formatting
    const priceInput = document.getElementById('productPrice');
    
    // Format price as user types
    priceInput.addEventListener('input', function(e) {
        let value = e.target.value.replace(/\D/g, ''); // Remove non-digits
        if (value) {
            // Format with thousand separator
            value = parseInt(value).toLocaleString('id-ID');
        }
        e.target.value = value;
    });

    // Convert formatted price back to integer before submit
    productForm.addEventListener('submit', function(e) {
        const priceFormatted = document.getElementById('productPrice').value;
        const priceValue = priceFormatted.replace(/\D/g, ''); // Remove all non-digits
        
        // Update input value with integer only
        document.getElementById('productPrice').value = priceValue;
    });

    // Category filtering
    document.querySelectorAll('.category-card').forEach(card => {
        card.addEventListener('click', function(e) {
            // Don't filter if clicking action buttons
            if (e.target.closest('.action-buttons')) return;
            
            const categoryId = this.getAttribute('data-category');
            document.querySelectorAll('.category-card').forEach(c => c.classList.remove('active'));
            this.classList.add('active');

            const rows = document.querySelectorAll('.product-row');
            rows.forEach(row => {
                if (categoryId === 'all' || row.dataset.category == categoryId) {
                    row.style.display = '';
                } else {
                    row.style.display = 'none';
                }
            });
        });
    });

    // Menu type filtering
    document.querySelectorAll('.menu-tab').forEach(tab => {
        tab.addEventListener('click', function() {
            const menuType = this.getAttribute('data-menu-type');
            document.querySelectorAll('.menu-tab').forEach(t => t.classList.remove('active'));
            this.classList.add('active');

            const rows = document.querySelectorAll('.product-row');
            rows.forEach(row => {
                if (menuType === 'all' || row.dataset.menuType === menuType) {
                    row.style.display = '';
                } else {
                    row.style.display = 'none';
                }
            });
        });
    });

    // Category Edit
    document.querySelectorAll('.category-card .edit').forEach(btn => {
        btn.addEventListener('click', function(e) {
            e.stopPropagation();
            const id = this.getAttribute('data-id');
            const name = this.getAttribute('data-name');
            const description = this.getAttribute('data-description');
            const icon = this.getAttribute('data-icon');
            const menuType = this.getAttribute('data-menu-type');

            categoryModal.classList.add('active');
            document.getElementById('categoryModalTitle').textContent = 'Edit Category';
            categoryForm.action = `/categories/${id}`;
            document.getElementById('categoryMethod').value = 'PUT';
            document.getElementById('categoryId').value = id;
            document.getElementById('categoryName').value = name;
            document.getElementById('categoryDescription').value = description;
            document.getElementById('categoryIcon').value = icon;
            document.getElementById('categoryMenuType').value = menuType;
        });
    });

    // Category Delete
    document.querySelectorAll('.category-card .delete').forEach(btn => {
        btn.addEventListener('click', function(e) {
            e.stopPropagation();
            const id = this.getAttribute('data-id');
            const name = this.getAttribute('data-name');

            if (confirm(`Are you sure you want to delete "${name}" category?`)) {
                const form = document.createElement('form');
                form.method = 'POST';
                form.action = `/categories/${id}`;
                form.innerHTML = `
                    @csrf
                    <input type="hidden" name="_method" value="DELETE">
                `;
                document.body.appendChild(form);
                form.submit();
            }
        });
    });

    // Product Edit
    document.querySelectorAll('.product-edit').forEach(btn => {
        btn.addEventListener('click', function() {
            const id = this.getAttribute('data-id');
            const name = this.getAttribute('data-name');
            const description = this.getAttribute('data-description');
            const price = this.getAttribute('data-price');
            const stock = this.getAttribute('data-stock');
            const categoryId = this.getAttribute('data-category');
            const image = this.getAttribute('data-image');

            productModal.classList.add('active');
            document.getElementById('productModalTitle').textContent = 'Edit Menu Item';
            productForm.action = `/products/${id}`;
            document.getElementById('productMethod').value = 'PUT';
            document.getElementById('productId').value = id;
            document.getElementById('productName').value = name;
            document.getElementById('productDescription').value = description;
            
            // Format price with thousand separator
            const formattedPrice = parseInt(price).toLocaleString('id-ID');
            document.getElementById('productPrice').value = formattedPrice;
            
            document.getElementById('productStock').value = stock;
            document.getElementById('productCategory').value = categoryId;
            
            // Handle image preview
            if (image && image !== 'null') {
                document.getElementById('imagePreview').src = `/storage/${image}`;
                document.getElementById('imageUploadArea').style.display = 'none';
                document.getElementById('imagePreviewWrapper').style.display = 'block';
            } else {
                resetImageUpload();
            }
        });
    });

    // Product Delete
    document.querySelectorAll('.product-delete').forEach(btn => {
        btn.addEventListener('click', function() {
            const id = this.getAttribute('data-id');
            const name = this.getAttribute('data-name');

            if (confirm(`Are you sure you want to delete "${name}"?`)) {
                const form = document.createElement('form');
                form.method = 'POST';
                form.action = `/products/${id}`;
                form.innerHTML = `
                    @csrf
                    <input type="hidden" name="_method" value="DELETE">
                `;
                document.body.appendChild(form);
                form.submit();
            }
        });
    });

    // Close modals when clicking outside
    window.onclick = function(event) {
        if (event.target.classList.contains('modal')) {
            event.target.classList.remove('active');
        }
    };

    // Show edit/delete buttons on hover for categories
    document.querySelectorAll('.category-card').forEach(card => {
        card.addEventListener('mouseenter', function() {
            const actions = this.querySelector('.action-buttons');
            if (actions) actions.style.display = 'flex';
        });
        card.addEventListener('mouseleave', function() {
            const actions = this.querySelector('.action-buttons');
            if (actions) actions.style.display = 'none';
        });
    });
</script>
@endpush
