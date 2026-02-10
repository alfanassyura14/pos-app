@extends('layouts.app')

@php
    $pageTitle = 'Reports';
    $showBackButton = false;
@endphp

@push('styles')
    .reports-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
        gap: 1.5rem;
        margin-bottom: 2rem;
    }

    .report-card {
        background: rgba(45, 55, 72, 0.5);
        backdrop-filter: blur(10px);
        border-radius: 1rem;
        padding: 1.5rem;
        border: 1px solid rgba(107, 114, 128, 0.3);
        transition: all 0.3s;
    }

    .report-card:hover {
        transform: translateY(-4px);
        box-shadow: 0 8px 20px rgba(0, 0, 0, 0.3);
    }

    .report-card h3 {
        font-size: 1.25rem;
        margin-bottom: 1rem;
    }

    .report-value {
        font-size: 2rem;
        font-weight: bold;
        color: #ec4899;
        margin-bottom: 0.5rem;
    }

    .report-description {
        color: #9ca3af;
        font-size: 0.875rem;
    }

    .export-section {
        display: flex;
        gap: 1rem;
        margin-top: 2rem;
    }

    .export-btn {
        flex: 1;
        background: linear-gradient(135deg, #ec4899 0%, #8b5cf6 100%);
        color: white;
        border: none;
        padding: 1rem;
        border-radius: 12px;
        cursor: pointer;
        font-weight: 500;
        transition: all 0.3s;
        box-shadow: 0 4px 15px rgba(236, 72, 153, 0.4);
    }

    .export-btn:hover {
        transform: translateY(-2px);
        box-shadow: 0 6px 20px rgba(236, 72, 153, 0.5);
    }
@endpush

@section('content')
    <div class="reports-container">
        <h2 style="margin-bottom: 2rem; font-size: 1.5rem;">Sales Reports</h2>

        <div class="reports-grid">
            <div class="report-card">
                <h3>Today's Sales</h3>
                <div class="report-value">Rp 2.500.000</div>
                <div class="report-description">+15% from yesterday</div>
            </div>

            <div class="report-card">
                <h3>Weekly Sales</h3>
                <div class="report-value">Rp 18.250.000</div>
                <div class="report-description">+8% from last week</div>
            </div>

            <div class="report-card">
                <h3>Monthly Sales</h3>
                <div class="report-value">Rp 72.890.000</div>
                <div class="report-description">+12% from last month</div>
            </div>

            <div class="report-card">
                <h3>Total Orders</h3>
                <div class="report-value">1,234</div>
                <div class="report-description">This month</div>
            </div>
        </div>

        <div class="export-section">
            <button class="export-btn" onclick="alert('Export PDF feature coming soon!')">
                📄 Export as PDF
            </button>
            <button class="export-btn" onclick="alert('Export Excel feature coming soon!')">
                📊 Export as Excel
            </button>
            <button class="export-btn" onclick="alert('Export CSV feature coming soon!')">
                📋 Export as CSV
            </button>
        </div>
    </div>
@endsection

@push('scripts')
<script>
    console.log('Reports page loaded successfully!');
    
    // Contoh: Auto refresh data setiap 30 detik
    // setInterval(() => {
    //     console.log('Refreshing report data...');
    //     // Fetch data baru dari server
    // }, 30000);
</script>
@endpush
