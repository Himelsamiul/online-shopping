@extends('backend.master')

@section('content')
<div class="container">
    <h2 class="text-center mb-4 fw-bold">Order List</h2>

    <!-- ✅ Date Filter Form -->
    <form method="GET" class="row mb-4 g-2 align-items-end">
        <div class="col-md-3">
            <label for="start_date" class="form-label">Start Date</label>
            <input type="date" name="start_date" id="start_date"
                value="{{ request('start_date') }}"
                class="form-control"
                max="{{ date('Y-m-d') }}">
        </div>

        <div class="col-md-3">
            <label for="end_date" class="form-label">End Date</label>
            <input type="date" name="end_date" id="end_date"
                value="{{ request('end_date') }}"
                class="form-control"
                max="{{ date('Y-m-d') }}">
        </div>

        <div class="col-md-3 d-flex gap-2">
            <button type="submit" class="btn btn-primary">Filter</button>
            <a href="{{ route('order.list') }}" class="btn btn-secondary">Reset</a>
        </div>
    </form>

    <!-- ✅ Download PDF Button -->
    <div class="d-flex justify-content-end mb-3">
        <button class="btn btn-danger" id="downloadPDF">Download PDF</button>
    </div>

    <!-- ✅ SweetAlert Success -->
    @if(session('success'))
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                Swal.fire({
                    icon: 'success',
                    title: 'Success',
                    text: '{{ session('success') }}',
                    showConfirmButton: false,
                    timer: 1500
                });
            });
        </script>
    @endif

    <!-- ✅ PDF Content Area -->
    <div id="orderContent" class="bg-white p-3 border rounded">
        <table class="table table-bordered table-hover mt-3">
            <thead class="text-white" style="background-color: #343a40;">
                <tr>
                    <th>SL</th>
                    <th>Customer Name</th>
                    <th>Address</th>
                    <th>Total Amount</th>
                    <th>Transaction ID</th>
                    <th>Payment Method</th>
                    <th>Payment Status</th>
                    <th>Order Date</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                @php $pageTotal = 0; @endphp
                @foreach($orders as $key => $data)
                    @php $pageTotal += $data->total_amount; @endphp
                    <tr style="background-color: {{ $key % 2 == 0 ? '#f8f9fa' : '#ffffff' }};">
                        <td>{{ $orders->firstItem() + $key }}</td>
                        <td>{{ $data->name }}</td>
                        <td>{{ $data->address }}</td>
                        <td>BDT. {{ number_format($data->total_amount, 2) }}</td>
                        <td>{{ $data->transaction_id }}</td>
                        <td>
                            @if(strtolower($data->payment_method) == 'sslcommerz')
                                <span class="badge text-black" style="background-color: orange !important;">SSLCommerz</span>
                            @elseif(strtolower($data->payment_method) == 'cashon')
                                <span class="badge text-white" style="background-color: green !important;">CashOn</span>
                            @else
                                <span class="badge bg-secondary text-white">{{ ucfirst($data->payment_method) }}</span>
                            @endif
                        </td>
                        <td>{{ ucfirst($data->payment_status) }}</td>
                        <td>{{ \Carbon\Carbon::parse($data->created_at)->format('d M Y') }}</td>
                        <td>
                            <a href="{{ route('order.details', $data->id) }}" class="btn btn-info btn-sm">Details</a>
                        </td>
                    </tr>
                @endforeach
            </tbody>
            <tfoot class="table-light">
                <tr>
                    <td colspan="3" class="text-end fw-bold">Total on This Page:</td>
                    <td colspan="4" class="fw-bold text-success">BDT. {{ number_format($pageTotal, 2) }}</td>
                </tr>
            </tfoot>
        </table>
    </div>

    <!-- ✅ Pagination -->
    <div class="d-flex justify-content-center mt-4">
        {{ $orders->appends(request()->all())->links('pagination::bootstrap-4') }}
    </div>

    <!-- ✅ Scripts and Styling -->
    <style>
        table {
            width: 100%;
            border-collapse: collapse;
        }

        tr {
            page-break-inside: avoid;
        }

        .badge {
            padding: 5px 10px;
            font-size: 0.85rem;
            border-radius: 5px;
        }

        @media print {
            #downloadPDF, form {
                display: none;
            }

            .table td, .table th {
                font-size: 12px;
            }
        }
    </style>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.10.1/html2pdf.bundle.min.js"></script>
    <script>
        document.getElementById('downloadPDF').addEventListener('click', function () {
            const element = document.getElementById('orderContent');

            const opt = {
                margin: 0.2,
                filename: 'order-report.pdf',
                image: { type: 'jpeg', quality: 0.98 },
                html2canvas: { scale: 2, scrollY: 0, useCORS: true },
                jsPDF: { unit: 'in', format: 'a4', orientation: 'landscape', autoPaging: true }
            };

            html2pdf().set(opt).from(element).save();
        });
    </script>
</div>
@endsection
