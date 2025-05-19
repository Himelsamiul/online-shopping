@extends('frontend.master')

@section('content')
<style>
  /* Styling for invoice container */
  .invoice-container {
    max-width: 800px;
    margin: 2rem auto;
    padding: 2rem;
    background: #fff;
    border: 1px solid #ddd;
    box-shadow: 0 0 10px rgba(0,0,0,0.1);
    font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    color: #333;
  }

  /* Headings */
  .invoice-container h1,
  .invoice-container h4 {
    color: #222;
  }

  /* Table styles */
  table {
    width: 100%;
    border-collapse: collapse;
  }

  table th, table td {
    padding: 0.75rem;
    border: 1px solid #ccc;
  }

  table thead {
    background-color: #343a40;
    color: white;
  }

  /* Totals section */
  .totals {
    max-width: 350px;
    margin-left: auto;
    margin-top: 1rem;
    font-weight: 700;
  }

  .totals div {
    display: flex;
    justify-content: space-between;
    padding: 0.3rem 0;
  }

  .totals hr {
    border-top: 3px solid #000;
    margin: 1rem 0;
  }

  /* Signature section */
  .signature-section {
    margin-top: 3rem;
    width: 200px;
    border-top: 2px solid #000;
    padding-top: 0.4rem;
    text-align: center;
    font-style: italic;
  }

  /* Print button styling */
  .print-btn {
    display: block;
    margin: 1.5rem auto;
    padding: 0.5rem 1.5rem;
    font-size: 1rem;
    cursor: pointer;
    background-color: #007bff;
    color: white;
    border: none;
    border-radius: 4px;
  }

  /* Hide non-invoice elements when printing */
  @media print {
    .print-btn {
      display: none;
    }
    header,
    footer {
      display: none !important;
    }
    .row {
      display: flex !important;
    }
    .col-md-6 {
      float: none !important;
      width: 50% !important;
      display: block !important;
    }
  }
</style>

<div class="invoice-container">
  <h1 class="text-center mb-4 fw-bold">Order Pay Slip</h1>

  <!-- Customer & Order Info -->
  <div class="row mb-4">
    <div class="col-md-6">
      <h4 class="mb-3">Customer Details</h4>
      <p><strong>Name:</strong> {{ $customer->name }}</p>
      <p><strong>Phone:</strong> {{ $customer->phoneno }}</p>
      <p><strong>Address:</strong> {{ $order->address }}</p>
    </div>
    <div class="col-md-6 text-md-end">
      <h4 class="mb-3">Order Info</h4>
      <p><strong>Order ID:</strong> {{ $order->id }}</p>
      <p><strong>Order Date:</strong> {{ \Carbon\Carbon::parse($order->created_at)->format('d M Y, h:i A') }}</p>
    </div>
  </div>

  <!-- Order Items Table -->
  <h4 class="mb-3">Ordered Menu Items</h4>
  <table>
    <thead>
      <tr>
        <th>Product Name</th>
        <th class="text-end">Unit Price (BDT)</th>
        <th class="text-end">Quantity</th>
        <th class="text-end">Subtotal (BDT)</th>
      </tr>
    </thead>
    <tbody>
      @php $totalBeforeDiscount = 0; @endphp
      @foreach ($order->orderDetails as $item)
        @php $totalBeforeDiscount += $item->subtotal; @endphp
        <tr>
          <td>{{ $item->product->name }}</td>
          <td class="text-end">{{ number_format($item->unit_price, 2) }}</td>
          <td class="text-end">{{ $item->quantity }}</td>
          <td class="text-end">{{ number_format($item->subtotal, 2) }}</td>
        </tr>
      @endforeach
    </tbody>
  </table>

  @php
    // Apply 20% discount if total is over 1000
    $discount = $totalBeforeDiscount > 1000 ? $totalBeforeDiscount * 0.20 : 0;

    // Total after discount
    $afterDiscount = $totalBeforeDiscount - $discount;

    // Add 10% VAT on discounted amount
    $vat = $afterDiscount * 0.10;

    // Final grand total after discount and VAT
    $grandTotal = $afterDiscount + $vat;
  @endphp

  <!-- Totals Summary -->
  <div class="totals">
    <div><span>Total (Before Discount):</span><span>{{ number_format($totalBeforeDiscount, 2) }} BDT</span></div>
    <div><span>Discount:</span><span>-{{ number_format($discount, 2) }} BDT</span></div>
    <div><span>Total (After Discount):</span><span>{{ number_format($afterDiscount, 2) }} BDT</span></div>
    <div><span>VAT (10%):</span><span>+{{ number_format($vat, 2) }} BDT</span></div>
    <div><span>Shipping Cost:</span><span>0.00 BDT</span></div>
    <hr>
    <div><span>Grand Total:</span><span>{{ number_format($grandTotal, 2) }} BDT</span></div>
  </div>

  <!-- Signature and Thank You -->
  <div class="signature-section" style="float: left;">
    Customer Signature
  </div>
  <div style="clear: both;"></div>

  <div class="text-center mt-4">
    <p>Thank you for your order!</p>
  </div>

  <!-- Print Button -->
  <button class="print-btn" onclick="window.print()">Print Invoice</button>
</div>
@endsection
