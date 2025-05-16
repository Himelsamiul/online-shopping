@extends('backend.master')

@section('content')
<div class="container mt-4">
    <div class="border p-4 rounded"
         style="background-color: #f9f9f9; box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1); max-width: 800px; margin: 0 auto;"
         id="printable-area">

        <!-- Company Header -->
        <div class="text-center mb-4">
            <h1 style="font-size: 36px; color: #003366; font-weight: 800; margin-bottom: 5px;">Easy Shop</h1>
            <h3 style="font-size: 20px; font-weight: bold; color: #555;">Order Details : #{{ $order->id }}</h3>
        </div>

        <!-- Customer and Company Details Side by Side -->
        <div class="row mb-4">
            <div class="col-6">
                <div class="detail-line"><strong>Customer</strong>       : {{ $order->name }}</div>
                <div class="detail-line"><strong>Email</strong>          : {{ $order->email }}</div>
                <div class="detail-line"><strong>Payment Method</strong> : {{ $order->payment_method }}</div>
                <div class="detail-line"><strong>Payment Status</strong> : {{ ucfirst($order->payment_status) }}</div>
                
                <div class="detail-line">
                    <strong>Original Total</strong> : 
                    BDT {{ number_format($order->orderDetails->sum(function($detail) {
                        return $detail->unit_price * $detail->quantity;
                    }), 2) }}
                </div>
                <div class="detail-line">
                    <strong>Discount</strong> : 
                    BDT {{ number_format(
                        $order->orderDetails->sum(function($detail) {
                            return $detail->unit_price * $detail->quantity;
                        }) - $order->total_amount, 2) }}
                </div>
                <div class="detail-line"><strong>Payment Amount</strong> : BDT {{ number_format($order->total_amount, 2) }}</div>
            </div>

            <div class="col-6">
                <div class="detail-line"><strong>Company Location</strong> : Dhaka</div>
                <div class="detail-line"><strong>Company Email</strong>    : info@shoppaholic.com</div>
                <div class="detail-line"><strong>Phone Number</strong>     : +880 1234 567890</div>
                <div class="detail-line"><strong>Printed By</strong>       : Admin</div>
                <div class="detail-line"><strong>Address</strong>          : {{ $order->address }}</div>
            </div>
        </div>

        <!-- Items Table -->
        <h4 class="text-center mb-4" style="font-weight: bold; color: #003366;">Ordered Items</h4>
        <table class="table table-bordered" style="font-size: 14px;">
            <thead style="background-color: #003366; color: #fff;">
                <tr>
                    <th>Product</th>
                    <th>Unit Price</th>
                    <th>Quantity</th>
                    <th>Total</th>
                </tr>
            </thead>
            <tbody>
                @foreach($order->orderDetails as $detail)
                <tr>
                    <td>{{ $detail->product->name ?? 'N/A' }}</td>
                    <td>BDT {{ number_format($detail->unit_price, 2) }}</td>
                    <td>{{ $detail->quantity }}</td>
                    <td>BDT {{ number_format($detail->unit_price * $detail->quantity, 2) }}</td>
                </tr>
                @endforeach
            </tbody>
            <tfoot>
                <tr>
                    <td colspan="3" style="text-align: right;"><strong>Payable (After Discount)</strong></td>
                    <td>BDT {{ number_format($order->total_amount, 2) }}</td>
                </tr>
            </tfoot>
        </table>

        <!-- Signature Section -->
        <div class="mt-5 signature-section" style="display: flex; justify-content: space-between; align-items: center;">
            <div style="text-align: center; border-top: 1px solid #000; width: 200px;">
                <span style="display: block;">Customer Signature</span>
            </div>
            <div style="text-align: center; border-top: 1px solid #000; width: 200px;">
                <span style="display: block;">Authorized Signature</span>
            </div>
        </div>

        <!-- Print Button -->
        <div class="mt-4 text-center">
            <button class="btn btn-success" style="width: 200px;" onclick="window.print()">Print</button>
        </div>

    </div>
</div>

<!-- Print & Screen Specific CSS -->
<style>
    .detail-line {
        display: flex;
        gap: 10px;
        font-size: 14px;
        margin-bottom: 5px;
    }

    .detail-line strong {
        width: 180px;
        display: inline-block;
    }

    @media print {
        body * {
            visibility: hidden;
        }

        #printable-area, #printable-area * {
            visibility: visible;
        }

        #printable-area {
            position: absolute;
            left: 0;
            top: 0;
            width: 100%;
            margin: 0;
            padding: 0;
            border: none !important;
            box-shadow: none !important;
            background: white !important;
            min-height: 100vh;
            overflow: visible;
        }

        .btn-success {
            display: none !important;
        }

        @page {
            margin: 10mm;
            size: A4;
            scale: 0.85;
        }

        h1 {
            font-size: 30px;
            font-weight: 800;
            color: #003366;
            margin-bottom: 5px;
        }

        h3 {
            font-size: 18px;
            font-weight: bold;
            color: #555;
            margin-bottom: 20px;
        }

        h4 {
            text-align: center;
            color: #003366;
            font-size: 20px;
        }

        table {
            width: 100%;
            margin: 10px 0;
            border-collapse: collapse;
        }

        table th {
            background-color: #003366;
            color: #fff;
            padding: 10px;
        }

        table th, table td {
            border: 1px solid #000;
            padding: 8px;
            text-align: center;
        }

        .signature-section {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-top: 20px;
            padding-top: 20px;
            page-break-before: auto;
            page-break-inside: avoid;
        }

        .table {
            page-break-inside: avoid;
        }

        .detail-line {
            page-break-inside: avoid;
        }

        .signature-section {
            page-break-before: always;
        }

        .table, .signature-section {
            page-break-before: avoid !important;
        }
    }
</style>

@endsection
