<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Invoice #{{ $sale->sale_number }}</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', sans-serif;
            background: #f5f5f5;
            padding: 2rem;
        }

        .invoice-container {
            max-width: 800px;
            margin: 0 auto;
            background: white;
            border-radius: 16px;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1);
            overflow: hidden;
        }

        .invoice-header {
            background: linear-gradient(135deg, #ec4899 0%, #8b5cf6 100%);
            padding: 2rem;
            color: white;
        }

        .invoice-header h1 {
            font-size: 2rem;
            margin-bottom: 0.5rem;
        }

        .invoice-number {
            font-size: 1.125rem;
            opacity: 0.9;
        }

        .invoice-body {
            padding: 2rem;
        }

        .info-section {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 2rem;
            margin-bottom: 2rem;
            padding-bottom: 2rem;
            border-bottom: 2px solid #f0f0f0;
        }

        .info-block h3 {
            font-size: 0.875rem;
            color: #6b7280;
            margin-bottom: 0.5rem;
            text-transform: uppercase;
            letter-spacing: 0.05em;
        }

        .info-block p {
            font-size: 1rem;
            color: #1f2937;
            margin-bottom: 0.25rem;
        }

        .items-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 2rem;
        }

        .items-table thead {
            background: #f9fafb;
        }

        .items-table th {
            padding: 1rem;
            text-align: left;
            font-size: 0.875rem;
            color: #6b7280;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.05em;
        }

        .items-table td {
            padding: 1rem;
            border-bottom: 1px solid #f0f0f0;
            color: #1f2937;
        }

        .items-table tbody tr:last-child td {
            border-bottom: none;
        }

        .item-name {
            font-weight: 500;
            font-size: 1rem;
        }

        .text-right {
            text-align: right;
        }

        .text-center {
            text-align: center;
        }

        .summary-section {
            background: #f9fafb;
            padding: 1.5rem;
            border-radius: 12px;
            margin-bottom: 2rem;
        }

        .summary-row {
            display: flex;
            justify-content: space-between;
            padding: 0.75rem 0;
            font-size: 1rem;
        }

        .summary-row.total {
            border-top: 2px solid #e5e7eb;
            margin-top: 0.5rem;
            padding-top: 1rem;
            font-size: 1.5rem;
            font-weight: bold;
            color: #ec4899;
        }

        .footer-section {
            text-align: center;
            padding: 2rem;
            background: #f9fafb;
            color: #6b7280;
            font-size: 0.875rem;
        }

        .footer-section p {
            margin-bottom: 0.5rem;
        }

        .print-btn {
            position: fixed;
            bottom: 2rem;
            right: 2rem;
            padding: 1rem 2rem;
            background: linear-gradient(135deg, #ec4899 0%, #8b5cf6 100%);
            color: white;
            border: none;
            border-radius: 12px;
            font-size: 1rem;
            font-weight: 600;
            cursor: pointer;
            box-shadow: 0 4px 15px rgba(236, 72, 153, 0.4);
            transition: all 0.3s;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .print-btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(236, 72, 153, 0.5);
        }

        @media print {
            body {
                background: white;
                padding: 0;
            }

            .print-btn {
                display: none;
            }

            .invoice-container {
                box-shadow: none;
            }
        }
    </style>
</head>
<body>
    <div class="invoice-container">
        <!-- Header -->
        <div class="invoice-header">
            <h1>🍽️ PINGU</h1>
            <div class="invoice-number">Invoice #{{ $sale->sale_number }}</div>
        </div>

        <!-- Body -->
        <div class="invoice-body">
            <!-- Info Section -->
            <div class="info-section">
                <div class="info-block">
                    <h3>Invoice Details</h3>
                    <p><strong>Date:</strong> {{ $sale->created_at->format('F d, Y') }}</p>
                    <p><strong>Time:</strong> {{ $sale->created_at->format('h:i A') }}</p>
                    @if($sale->table_number)
                    <p><strong>Table:</strong> {{ $sale->table_number }}</p>
                    @endif
                    <p><strong>Customer:</strong> {{ $sale->customer_name }}</p>
                </div>

                <div class="info-block">
                    <h3>Served By</h3>
                    <p><strong>{{ $sale->user->u_name ?? 'Staff' }}</strong></p>
                    <p>{{ $sale->user->email ?? '' }}</p>
                    <p><strong>Payment:</strong> {{ ucfirst($sale->payment_method) }}</p>
                </div>
            </div>

            <!-- Items Table -->
            <table class="items-table">
                <thead>
                    <tr>
                        <th>Item</th>
                        <th>Category</th>
                        <th class="text-center">Qty</th>
                        <th class="text-right">Price</th>
                        <th class="text-right">Subtotal</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($sale->saleDetails as $item)
                    <tr>
                        <td>
                            <div class="item-name">{{ $item->product->p_name ?? 'Product' }}</div>
                        </td>
                        <td>{{ $item->product->category->c_name ?? '-' }}</td>
                        <td class="text-center">{{ $item->quantity }}</td>
                        <td class="text-right">Rp {{ number_format($item->price, 0, ',', '.') }}</td>
                        <td class="text-right">Rp {{ number_format($item->subtotal, 0, ',', '.') }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>

            <!-- Summary -->
            <div class="summary-section">
                <div class="summary-row">
                    <span>Subtotal</span>
                    <span>Rp {{ number_format($sale->subtotal, 0, ',', '.') }}</span>
                </div>
                <div class="summary-row">
                    <span>Tax (11%)</span>
                    <span>Rp {{ number_format($sale->tax, 0, ',', '.') }}</span>
                </div>
                @if($sale->discount > 0)
                <div class="summary-row">
                    <span>
                        Discount
                        @if($sale->discount_type === 'percent')
                            ({{ number_format(($sale->discount / $sale->subtotal) * 100, 1) }}%)
                        @endif
                    </span>
                    <span>-Rp {{ number_format($sale->discount, 0, ',', '.') }}</span>
                </div>
                @endif
                <div class="summary-row total">
                    <span>Total Amount</span>
                    <span>Rp {{ number_format($sale->subtotal_amount, 0, ',', '.') }}</span>
                </div>
            </div>
        </div>

        <!-- Footer -->
        <div class="footer-section">
            <p><strong>Thank you for your business!</strong></p>
            <p>🍽️ PINGU - Modern Point of Sale System</p>
            <p>{{ now()->format('Y') }} © All rights reserved</p>
        </div>
    </div>

    <!-- Print Button -->
    <button class="print-btn" onclick="window.print()">
        <svg width="24" height="24" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z" />
        </svg>
        Print Invoice
    </button>
</body>
</html>
