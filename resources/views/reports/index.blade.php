@extends('layouts.app')

@php
    $pageTitle = 'Reports';
@endphp

@push('styles')
<style>
    .reports-container {
        padding: 2rem;
        max-width: 1400px;
        margin: 0 auto;
    }

    .report-tabs {
        display: flex;
        gap: 1rem;
        margin-bottom: 2rem;
    }

    .report-tab {
        padding: 1rem 2rem;
        background: rgba(55, 65, 81, 0.3);
        border: 1px solid rgba(107, 114, 128, 0.3);
        border-radius: 12px;
        color: rgba(255, 255, 255, 0.7);
        font-size: 0.875rem;
        font-weight: 500;
        cursor: pointer;
        transition: all 0.3s;
        text-decoration: none;
        display: inline-block;
    }

    .report-tab:hover {
        background: rgba(55, 65, 81, 0.5);
        color: white;
    }

    .report-tab.active {
        background: linear-gradient(135deg, #ec4899 0%, #8b5cf6 100%);
        border-color: transparent;
        color: white;
    }

    .report-cards {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
        gap: 1.5rem;
    }

    .report-card {
        background: rgba(45, 55, 72, 0.5);
        backdrop-filter: blur(10px);
        border: 1px solid rgba(107, 114, 128, 0.3);
        border-radius: 16px;
        padding: 2rem;
        cursor: pointer;
        transition: all 0.3s;
        text-decoration: none;
        color: white;
    }

    .report-card:hover {
        transform: translateY(-5px);
        border-color: #ec4899;
        box-shadow: 0 10px 30px rgba(236, 72, 153, 0.3);
    }

    .report-card-icon {
        width: 64px;
        height: 64px;
        border-radius: 16px;
        background: linear-gradient(135deg, rgba(236, 72, 153, 0.2) 0%, rgba(139, 92, 246, 0.2) 100%);
        display: flex;
        align-items: center;
        justify-content: center;
        margin-bottom: 1.5rem;
    }

    .report-card-icon svg {
        width: 32px;
        height: 32px;
        color: #ec4899;
    }

    .report-card h3 {
        font-size: 1.25rem;
        font-weight: bold;
        margin-bottom: 0.5rem;
    }

    .report-card p {
        color: rgba(255, 255, 255, 0.7);
        font-size: 0.875rem;
        line-height: 1.6;
    }
</style>
@endpush

@section('content')
<div class="reports-container">
    <div class="report-tabs">
        <a href="{{ route('reports.sales') }}" class="report-tab active">
            Sales Report
        </a>
        <div class="report-tab" style="opacity: 0.5; cursor: not-allowed;">
            Revenue Report
        </div>
        <div class="report-tab" style="opacity: 0.5; cursor: not-allowed;">
            Inventory Report
        </div>
    </div>

    <div class="report-cards">
        <a href="{{ route('reports.sales') }}" class="report-card">
            <div class="report-card-icon">
                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" />
                </svg>
            </div>
            <h3>Sales Report</h3>
            <p>View detailed sales transactions, filter by date range, search by invoice or customer name. Track revenue and performance metrics.</p>
        </a>

        <div class="report-card" style="opacity: 0.5; cursor: not-allowed;">
            <div class="report-card-icon">
                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
            </div>
            <h3>Revenue Report</h3>
            <p>Analyze revenue trends, compare periods, and view detailed breakdowns by category, payment method, and time.</p>
        </div>

        <div class="report-card" style="opacity: 0.5; cursor: not-allowed;">
            <div class="report-card-icon">
                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4" />
                </svg>
            </div>
            <h3>Inventory Report</h3>
            <p>Monitor stock levels, view product movement, identify fast-moving items, and track inventory value over time.</p>
        </div>
    </div>
</div>
@endsection
