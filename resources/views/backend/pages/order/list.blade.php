@extends('backend.master')

@section('content')
<div class="container">
    <h2 class="text-center mb-4 fw-bold">Order List</h2>

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
                    <!-- <th>Email</th> -->
                    <th>Address</th>
                    <th>Total Amount</th>
                    <th>Transaction ID</th>
                    <th>Payment Method</th>
                    <th>Payment Status</th> <!-- Payment Status Column -->
                    <th>Order Date</th><!-- New Order Date Column -->
                    <th>Action</th> <!-- Action Column -->
                </tr>
            </thead>
            <tbody>
                @foreach($orders as $key => $data)
                    <tr style="background-color: {{ $key % 2 == 0 ? '#f8f9fa' : '#ffffff' }};">
                        <td>{{ $orders->firstItem() + $key }}</td>
                        <td>{{ $data->name }}</td>
                        <!-- <td>{{ $data->email }}</td> -->
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
                        <td>{{ ucfirst($data->payment_status) }}</td> <!-- Payment Status Column Data -->
                        <td>{{ \Carbon\Carbon::parse($data->created_at)->format('d M Y') }}</td> <!-- Order Date Column Data -->
                        <td>
                            <a href="{{ route('order.details', $data->id) }}" class="btn btn-info btn-sm">Details</a>
                        </td>
                    </tr>
                @endforeach
            </tbody>
            <tfoot class="table-light">
                <tr>
                    <td colspan="3" class="text-end fw-bold">Total Order Amount:</td>
                    <td colspan="4" class="fw-bold text-success">BDT. {{ number_format($totalOrderAmount, 2) }}</td>
                </tr>
            </tfoot>
        </table>
    </div>

    <!-- ✅ Pagination -->
    <div class="d-flex justify-content-center mt-4">
        {{ $orders->links('pagination::bootstrap-4') }}
    </div>

    <!-- ✅ Custom Styles -->
    <style>
        table {
            width: 100%;
            border-collapse: collapse;
            page-break-inside: auto;
        }

        tr {
            page-break-inside: avoid;
            page-break-after: auto;
        }

        td, th {
            page-break-inside: avoid;
            white-space: nowrap;
        }

        tbody {
            display: table-row-group;
        }

        .badge {
            padding: 5px 10px;
            font-size: 0.85rem;
            border-radius: 5px;
        }

        .btn-danger {
            font-weight: 500;
            padding: 6px 18px;
        }

        @media print {
            #downloadPDF {
                display: none;
            }

            /* Ensure proper table cell rendering in PDF */
            .table td, .table th {
                font-size: 12px; /* Adjust font size for PDF */
                white-space: normal; /* Ensure content wraps correctly */
                word-wrap: break-word; /* Break long words for proper rendering */
                height: auto; /* Allow cells to expand based on content */
            }

            .table {
                width: 100%;
                table-layout: auto; /* Automatically adjust column widths */
            }

            /* Ensure the payment status and order date columns are correctly shown */
            .table td:nth-child(8), .table th:nth-child(8),
            .table td:nth-child(9), .table th:nth-child(9) {
                word-wrap: break-word;
            }
        }
    </style>

    <!-- ✅ JS for html2pdf -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.10.1/html2pdf.bundle.min.js"></script>
    <script>
        document.getElementById('downloadPDF').addEventListener('click', function () {
            const element = document.getElementById('orderContent');

            // Re-render content before generating the PDF
            const htmlContent = element.innerHTML;
            element.innerHTML = htmlContent;  // Force content re-rendering

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
