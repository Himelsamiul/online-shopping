@extends('backend.master')

@section('content')
<style>
    body {
        font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    }
    .container {
        background: #fff;
        padding: 20px;
        border-radius: 10px;
    }
    h2 {
        color: #4a4a4a;
        font-weight: 600;
        margin-bottom: 25px;
        border-bottom: 2px solid #e0e0e0;
        padding-bottom: 10px;
    }
    table {
        font-size: 14px;
    }
    thead {
        background-color: #198754;
        color: #fff;
    }
    tr:hover {
        background-color: #f0f8ff;
    }
    .btn-print {
        float: right;
    }
    @media print {
        .btn, .form-label, .form-control, form, .pagination {
            display: none !important;
        }
        h2 {
            color: #000;
        }
        table {
            width: 100%;
            border: 1px solid #000;
        }
        th, td {
            border: 1px solid #000;
        }
    }
</style>

<div class="container">
    <h2>All Orders Report</h2>

    <!-- Search Form -->
    <form method="GET" action="{{ route('report') }}" class="row g-3 mb-4">
        <div class="col-md-4">
            <label for="start_date" class="form-label">Start Date</label>
            <input type="date" id="start_date" name="start_date" class="form-control" max="{{ date('Y-m-d') }}" value="{{ request('start_date') }}">
        </div>
        <div class="col-md-4">
            <label for="end_date" class="form-label">End Date</label>
            <input type="date" id="end_date" name="end_date" class="form-control" max="{{ date('Y-m-d') }}" value="{{ request('end_date') }}">
        </div>
        <div class="col-md-4 align-self-end d-flex justify-content-between">
            <button type="submit" class="btn btn-success">Search</button>
            <button onclick="window.print()" class="btn btn-primary btn-print">Print Report</button>
        </div>
    </form>

    <!-- Orders Table -->
    <table class="table table-bordered table-hover">
        <thead>
            <tr>
                <th>SL</th>
                <th>Date</th>
                <th>Customer Name</th>
                {{-- <th>Email</th> --}}
                <th>Address</th>
                <th>Payment Method</th>
                <th>Payment Status</th>
                <th>Product</th>
                <th>Total Amount</th>
                <th>Unit Price</th>
                <th>Quantity</th>
            </tr>
        </thead>
        <tbody>
            @php 
                $sl = 1; 
                $grandTotal = 0;
            @endphp

            @foreach ($orders as $order)
                @foreach ($order->orderDetails as $detail)
                    <tr>
                        <td>{{ $sl++ }}</td>
                        <td>{{ \Carbon\Carbon::parse($order->created_at)->format('d M Y') }}</td>
                        <td>{{ $order->name }}</td>
                        {{-- <td>{{ $order->email }}</td> --}}
                        <td>{{ $order->address }}</td>
                        <td>{{ ucfirst($order->payment_method) }}</td>
                        <td>{{ ucfirst($order->payment_status) }}</td>
                        <td>{{ $detail->product->name ?? 'N/A' }}</td>
                        <td>BDT. {{ number_format($order->total_amount, 2) }}</td>
                        <td>{{ number_format($detail->unit_price, 2) }}</td>
                        <td>{{ $detail->quantity }}</td>
                    </tr>
                @endforeach
                @php
                    $grandTotal += $order->total_amount;
                @endphp
            @endforeach
        </tbody>

        <!-- Grand Total Row -->
        <tfoot>
            <tr>
                <td colspan="7" style="text-align: right;"><strong>Grand Total Amount:</strong></td>
                <td colspan="3"><strong>BDT {{ number_format($grandTotal, 2) }}</strong></td>
            </tr>
        </tfoot>
    </table>

    <!-- Pagination -->
    <div class="pagination justify-content-center">
        {{ $orders->appends(request()->query())->links() }}
    </div>
</div>

<script>
    // Auto-fill today's date if empty
    document.addEventListener('DOMContentLoaded', function () {
        const today = new Date().toISOString().split('T')[0];
        if (!document.getElementById('end_date').value) {
            document.getElementById('end_date').value = today;
        }
    });
</script>
@endsection
