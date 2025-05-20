@extends('backend.master')

@section('content')
<style>
    :root {
        --primary-color: #198754;
        --secondary-color: #f8f9fa;
        --hover-color: #e9f7ef;
        --text-color: #4a4a4a;
        --border-color: #e0e0e0;
    }
    
    body {
        font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        background-color: #f5f5f5;
        color: var(--text-color);
    }
    
    .container {
        background: #fff;
        padding: 25px;
        border-radius: 12px;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.05);
        margin-top: 20px;
        margin-bottom: 40px;
    }
    
    h2 {
        color: var(--primary-color);
        font-weight: 700;
        margin-bottom: 25px;
        padding-bottom: 12px;
        border-bottom: 2px solid var(--border-color);
        position: relative;
    }
    
    h2::after {
        content: '';
        position: absolute;
        bottom: -2px;
        left: 0;
        width: 120px;
        height: 3px;
        background: var(--primary-color);
    }
    
    .search-card {
        background: var(--secondary-color);
        border-radius: 10px;
        padding: 20px;
        margin-bottom: 25px;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.05);
    }
    
    .form-label {
        font-weight: 600;
        color: #555;
    }
    
    .btn-search {
        background: var(--primary-color);
        border: none;
        padding: 8px 20px;
        font-weight: 600;
        transition: all 0.3s;
    }
    
    .btn-search:hover {
        background: #157347;
        transform: translateY(-2px);
    }
    
    .btn-print {
        background: #0d6efd;
        border: none;
        padding: 8px 20px;
        font-weight: 600;
        transition: all 0.3s;
    }
    
    .btn-print:hover {
        background: #0b5ed7;
        transform: translateY(-2px);
    }
    
    .table-responsive {
        border-radius: 10px;
        overflow: hidden;
        box-shadow: 0 0 20px rgba(0, 0, 0, 0.05);
    }
    
    .table {
        margin-bottom: 0;
        font-size: 14px;
    }
    
    .table thead {
        background-color: var(--primary-color);
        color: white;
    }
    
    .table th {
        font-weight: 600;
        padding: 12px 15px;
        text-transform: uppercase;
        font-size: 13px;
        letter-spacing: 0.5px;
    }
    
    .table td {
        padding: 12px 15px;
        vertical-align: middle;
        border-top: 1px solid var(--border-color);
    }
    
    .table tbody tr:hover {
        background-color: var(--hover-color);
    }
    
    .table tfoot td {
        font-weight: 700;
        background-color: var(--secondary-color);
    }
    
    .badge {
        padding: 6px 10px;
        font-weight: 600;
        font-size: 12px;
    }
    
    .badge-success {
        background-color: #d1e7dd;
        color: #0f5132;
    }
    
    .badge-warning {
        background-color: #fff3cd;
        color: #664d03;
    }
    
    .badge-danger {
        background-color: #f8d7da;
        color: #842029;
    }
    
    .pagination {
        margin-top: 25px;
    }
    
    .page-item.active .page-link {
        background-color: var(--primary-color);
        border-color: var(--primary-color);
    }
    
    .page-link {
        color: var(--primary-color);
    }
    
    /* Print-specific styles */
    @media print {
        body * {
            visibility: hidden;
        }
        .print-section, .print-section * {
            visibility: visible;
        }
        .print-section {
            position: absolute;
            left: 0;
            top: 0;
            width: 100%;
            padding: 20px;
            margin: 0;
        }
        .no-print {
            display: none !important;
        }
        .table {
            width: 100% !important;
            font-size: 12px !important;
        }
        .table th, .table td {
            padding: 8px !important;
        }
        .table thead th {
            background-color: #198754 !important;
            color: white !important;
            -webkit-print-color-adjust: exact;
            print-color-adjust: exact;
        }
        h2 {
            color: #000 !important;
            text-align: center;
            margin-top: 0;
        }
        .table tfoot td {
            background-color: #f8f9fa !important;
            -webkit-print-color-adjust: exact;
            print-color-adjust: exact;
        }
        .print-header {
            text-align: center;
            margin-bottom: 20px;
        }
        .print-footer {
            text-align: center;
            margin-top: 20px;
            font-size: 12px;
            color: #666;
        }
    }
    
    @media (max-width: 768px) {
        .container {
            padding: 15px;
        }
        
        .search-card {
            padding: 15px;
        }
        
        .btn-search, .btn-print {
            width: 100%;
            margin-bottom: 10px;
        }
        
        .table-responsive {
            border: 1px solid var(--border-color);
        }
        
        .table thead {
            display: none;
        }
        
        .table, .table tbody, .table tr, .table td {
            display: block;
            width: 100%;
        }
        
        .table tr {
            margin-bottom: 15px;
            border: 1px solid var(--border-color);
            border-radius: 5px;
        }
        
        .table td {
            text-align: right;
            padding-left: 50%;
            position: relative;
            border-top: none;
            border-bottom: 1px solid var(--border-color);
        }
        
        .table td::before {
            content: attr(data-label);
            position: absolute;
            left: 15px;
            width: calc(50% - 15px);
            padding-right: 15px;
            font-weight: 600;
            text-align: left;
            color: var(--primary-color);
        }
        
        .table tfoot tr {
            display: table-row;
        }
        
        .table tfoot td {
            display: table-cell;
            text-align: center;
        }
        
        .table tfoot td[colspan] {
            text-align: right;
        }
    }
</style>

<div class="container">
    <h2 class="no-print">All Orders Report</h2>

    <!-- Simple Date Filter Form -->
    <div class="search-card no-print">
        <form method="GET" action="{{ route('report') }}" class="row g-3">
            <div class="col-md-4">
                <label for="start_date" class="form-label">Start Date</label>
                <input type="date" id="start_date" name="start_date" class="form-control" max="{{ date('Y-m-d') }}" value="{{ request('start_date') }}">
            </div>
            <div class="col-md-4">
                <label for="end_date" class="form-label">End Date</label>
                <input type="date" id="end_date" name="end_date" class="form-control" max="{{ date('Y-m-d') }}" value="{{ request('end_date') ?? date('Y-m-d') }}">
            </div>
            <div class="col-md-4 d-flex align-items-end gap-3">
                <button type="submit" class="btn btn-search">
                    <i class="fas fa-search me-2"></i>Filter
                </button>
                <button type="button" onclick="printReport()" class="btn btn-print">
                    <i class="fas fa-print me-2"></i>Print
                </button>
            </div>
        </form>
    </div>

    <!-- Print Section (only visible when printing) -->
    <div class="print-section d-none">
        <div class="print-header">
            <h2>Orders Report</h2>
            <p>
                <strong>Date Range:</strong> 
                {{ request('start_date') ? \Carbon\Carbon::parse(request('start_date'))->format('d M Y') : 'All time' }} 
                to 
                {{ request('end_date') ? \Carbon\Carbon::parse(request('end_date'))->format('d M Y') : date('d M Y') }}
            </p>
        </div>
        
        <div class="table-responsive">
            <table class="table">
                <thead>
                    <tr>
                        <th>SL</th>
                        <th>Order Date</th>
                        <th>Customer</th>
                        <th>Address</th>
                        <th>Payment</th>
                        <th>Status</th>
                        <th>Product</th>
                        <th>Total</th>
                        <th>Unit Price</th>
                        <th>Qty</th>
                    </tr>
                </thead>
                <tbody>
                    @php 
                        $sl = ($orders->currentPage() - 1) * $orders->perPage() + 1; 
                        $grandTotal = 0;
                    @endphp

                    @foreach ($orders as $order)
                        @foreach ($order->orderDetails as $detail)
                            <tr>
                                <td>{{ $sl++ }}</td>
                                <td>{{ \Carbon\Carbon::parse($order->created_at)->format('d M Y') }}</td>
                                <td>{{ $order->name }}</td>
                                <td>{{ Str::limit($order->address, 20) }}</td>
                                <td>{{ ucfirst($order->payment_method) }}</td>
                                <td>{{ ucfirst($order->payment_status) }}</td>
                                <td>{{ $detail->product->name ?? 'N/A' }}</td>
                                <td>BDT {{ number_format($order->total_amount, 2) }}</td>
                                <td>{{ number_format($detail->unit_price, 2) }}</td>
                                <td>{{ $detail->quantity }}</td>
                            </tr>
                        @endforeach
                        @php
                            $grandTotal += $order->total_amount;
                        @endphp
                    @endforeach
                </tbody>
                <tfoot>
                    <tr>
                        <td colspan="7" class="text-end"><strong>Grand Total Amount:</strong></td>
                        <td colspan="3"><strong>BDT {{ number_format($grandTotal, 2) }}</strong></td>
                    </tr>
                </tfoot>
            </table>
        </div>
        
        <div class="print-footer">
            Printed on {{ date('d M Y H:i') }} | Page 1 of 1
        </div>
    </div>

    <!-- Regular View Table -->
    <div class="table-responsive no-print">
        <table class="table table-hover">
            <thead>
                <tr>
                    <th>SL</th>
                    <th>Order Date</th>
                    <th>Customer</th>
                    <th>Address</th>
                    <th>Payment</th>
                    <th>Status</th>
                    <th>Product</th>
                    <th>Total</th>
                    <th>Unit Price</th>
                    <th>Qty</th>
                </tr>
            </thead>
            <tbody>
                @php 
                    $sl = ($orders->currentPage() - 1) * $orders->perPage() + 1; 
                    $grandTotal = 0;
                @endphp

                @foreach ($orders as $order)
                    @foreach ($order->orderDetails as $detail)
                        <tr>
                            <td data-label="SL">{{ $sl++ }}</td>
                            <td data-label="Order Date">{{ \Carbon\Carbon::parse($order->created_at)->format('d M Y') }}</td>
                            <td data-label="Customer">{{ $order->name }}</td>
                            <td data-label="Address">{{ Str::limit($order->address, 20) }}</td>
                            <td data-label="Payment">
                                <span class="badge bg-info text-dark">{{ ucfirst($order->payment_method) }}</span>
                            </td>
                            <td data-label="Status">
                                @if($order->payment_status == 'completed')
                                    <span class="badge badge-success">{{ ucfirst($order->payment_status) }}</span>
                                @elseif($order->payment_status == 'pending')
                                    <span class="badge badge-warning">{{ ucfirst($order->payment_status) }}</span>
                                @else
                                    <span class="badge badge-danger">{{ ucfirst($order->payment_status) }}</span>
                                @endif
                            </td>
                            <td data-label="Product">{{ $detail->product->name ?? 'N/A' }}</td>
                            <td data-label="Total">BDT {{ number_format($order->total_amount, 2) }}</td>
                            <td data-label="Unit Price">{{ number_format($detail->unit_price, 2) }}</td>
                            <td data-label="Qty">{{ $detail->quantity }}</td>
                        </tr>
                    @endforeach
                    @php
                        $grandTotal += $order->total_amount;
                    @endphp
                @endforeach
            </tbody>
            <tfoot>
                <tr>
                    <td colspan="7" class="text-end"><strong>Grand Total Amount:</strong></td>
                    <td colspan="3"><strong>BDT {{ number_format($grandTotal, 2) }}</strong></td>
                </tr>
            </tfoot>
        </table>
    </div>

    <!-- Pagination -->
    <div class="pagination justify-content-center no-print">
        {{ $orders->appends(request()->query())->links() }}
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        // Auto-fill today's date if empty
        if (!document.getElementById('end_date').value) {
            document.getElementById('end_date').value = new Date().toISOString().split('T')[0];
        }
        
        // Add icons dynamically if FontAwesome is not loaded
        if (!document.querySelector('.fa')) {
            const searchBtn = document.querySelector('.btn-search');
            const printBtn = document.querySelector('.btn-print');
            
            if (searchBtn) {
                searchBtn.innerHTML = '🔍 ' + searchBtn.textContent;
            }
            
            if (printBtn) {
                printBtn.innerHTML = '🖨️ ' + printBtn.textContent;
            }
        }
    });

    function printReport() {
        // Clone the print section
        const printSection = document.querySelector('.print-section').cloneNode(true);
        printSection.classList.remove('d-none');
        
        // Create a new window for printing
        const printWindow = window.open('', '_blank');
        printWindow.document.write(`
            <html>
                <head>
                    <title>Orders Report</title>
                    <style>
                        body {
                            font-family: Arial, sans-serif;
                            font-size: 12px;
                            padding: 20px;
                            margin: 0;
                        }
                        h2 {
                            text-align: center;
                            color: #000;
                            margin-bottom: 10px;
                        }
                        .print-header {
                            margin-bottom: 20px;
                            text-align: center;
                        }
                        .print-header p {
                            margin: 5px 0;
                        }
                        table {
                            width: 100%;
                            border-collapse: collapse;
                            margin-top: 10px;
                        }
                        th {
                            background-color: #198754;
                            color: white;
                            padding: 8px;
                            text-align: left;
                        }
                        td {
                            padding: 8px;
                            border-bottom: 1px solid #ddd;
                        }
                        tfoot td {
                            font-weight: bold;
                            background-color: #f8f9fa;
                        }
                        .print-footer {
                            text-align: center;
                            margin-top: 20px;
                            font-size: 11px;
                            color: #666;
                        }
                    </style>
                </head>
                <body>
                    ${printSection.innerHTML}
                </body>
            </html>
        `);
        printWindow.document.close();
        
        // Trigger print after content loads
        setTimeout(() => {
            printWindow.print();
            printWindow.close();
        }, 500);
    }
</script>
@endsection