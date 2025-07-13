@extends('backend.master')

@section('content')
<div class="container-fluid px-4 mt-4">

    <!-- Page Header -->
    <div class="d-flex justify-content-between align-items-center mb-4 animate__animated animate__fadeIn">
        <div>
            <h2 class="fw-800 text-gradient-primary">Payment Collection</h2>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="#">Dashboard</a></li>
                    <li class="breadcrumb-item active" aria-current="page">COD Payments</li>
                </ol>
            </nav>
        </div>
    </div>

    <!-- Alert Notification -->
    @if(session('success'))
    <div class="alert alert-success alert-dismissible fade show animate__animated animate__fadeIn" role="alert">
        <div class="d-flex align-items-center">
            <div class="flex-shrink-0">
                <i class="fas fa-check-circle fa-lg"></i>
            </div>
            <div class="flex-grow-1 ms-3">
                <p class="mb-0">{{ session('success') }}</p>
            </div>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    </div>
    @endif

    <!-- Filter Card -->
    <!-- Date Filter Card - Add this right after your alert notification -->
<div class="card shadow-sm mb-4">
    <div class="card-body">
        <form method="GET" action="">
            <div class="row g-3 align-items-end">
                <div class="col-md-3">
                    <label class="form-label small text-uppercase fw-bold">From Date</label>
                    <input type="date" name="start_date" class="form-control form-control-sm" 
                           value="{{ request('start_date') }}">
                </div>
                <div class="col-md-3">
                    <label class="form-label small text-uppercase fw-bold">To Date</label>
                    <input type="date" name="end_date" class="form-control form-control-sm" 
                           value="{{ request('end_date') }}">
                </div>
                <div class="col-md-3">
                    <button type="submit" class="btn btn-sm btn-primary">
                        <i class="fas fa-filter me-1"></i> Apply Filter
                    </button>
                    <a href="{{ url()->current() }}" class="btn btn-sm btn-outline-secondary">
                        <i class="fas fa-undo me-1"></i> Clear
                    </a>
                </div>
            </div>
        </form>
    </div>
</div>

    <!-- Stats Cards - Side by Side -->
    <div class="row mb-4 animate__animated animate__fadeIn animate__delay-1s">
        <div class="col-md-6">
            <div class="card stats-card bg-gradient-success-hover">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="stats-title">Paid Orders</h6>
                            <h3 class="stats-count">{{ $orders->where('payment_status', 'paid')->count() }}</h3>
                        </div>
                        <div class="stats-icon">
                            <i class="fas fa-check-circle"></i>
                        </div>
                    </div>
                    <div class="stats-progress">
                        <div class="progress">
                            <div class="progress-bar" style="width: {{ $orders->count() ? ($orders->where('payment_status', 'paid')->count()/$orders->count())*100 : 0 }}%"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="card stats-card bg-gradient-warning-hover">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="stats-title">Unpaid Orders</h6>
                            <h3 class="stats-count">{{ $orders->where('payment_status', 'unpaid')->count() }}</h3>
                        </div>
                        <div class="stats-icon">
                            <i class="fas fa-exclamation-circle"></i>
                        </div>
                    </div>
                    <div class="stats-progress">
                        <div class="progress">
                            <div class="progress-bar" style="width: {{ $orders->count() ? ($orders->where('payment_status', 'unpaid')->count()/$orders->count())*100 : 0 }}%"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Orders Table -->
    <div class="card shadow-sm animate__animated animate__fadeIn animate__delay-2s">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0" id="paymentTable">
                    <thead class="table-light">
                        <tr>
                            <th class="text-center">Order ID</th>
                            <th>Customer</th>
                            <th class="text-end">Total Amount</th>
                            <th class="text-end">Collected</th>
                            <th class="text-end">Due</th>
                            <th>Payment Method</th>
                            <th>Transaction ID</th>
                            <th>Status</th>
                            <th class="text-center">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($orders as $order)
                            <tr class="animate__animated animate__fadeIn">
                                <td class="text-center">
                                    <span class="badge bg-primary bg-opacity-10 text-primary order-id">#{{ $order->id }}</span>
                                </td>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <div class="avatar-sm me-2">
                                            <span class=" bg-primary text-white">{{ substr($order->name, 0, 1) }}</span>
                                        </div>
                                        <div>
                                            <h6 class="mb-0">{{ $order->name }}</h6>
                                            <small class="text-muted">{{ $order->email }}</small>
                                        </div>
                                    </div>
                                </td>
                                <td class="text-end fw-bold">BDT&nbsp;{{ number_format($order->total_amount, 2) }}</td>
                                <td class="text-end">BDT&nbsp;{{ number_format($order->collected_amount ?? 0, 2) }}</td>
                                <td class="text-end fw-bold">
                                    @php
                                        $due = $order->total_amount - ($order->collected_amount ?? 0);
                                    @endphp
                                    <span class="{{ $due > 0 ? 'text-danger' : 'text-success' }}">
                                        BDT&nbsp;{{ number_format($due, 2) }}
                                    </span>
                                </td>
                                <td>
                                    <span class="badge bg-info bg-opacity-10 text-info text-uppercase">
                                        {{ str_replace('_', ' ', $order->payment_method) }}
                                    </span>
                                </td>
                                <td>
                                    <span class="font-monospace small">{{ $order->transaction_id ?? 'N/A' }}</span>
                                </td>
                                <td>
                                    @if(strtolower(trim($order->payment_status)) === 'paid')
                                        <span class="badge bg-success bg-opacity-10 text-success rounded-pill">
                                            <i class="fas fa-check-circle me-1"></i> Paid
                                        </span>
                                    @else
                                        <span class="badge bg-warning bg-opacity-10 text-warning rounded-pill">
                                            <i class="fas fa-exclamation-circle me-1"></i> Unpaid
                                        </span>
                                    @endif
                                </td>
                               <td class="text-center">
    @if(strtolower(trim($order->payment_status)) === 'unpaid')
        <form action="{{ route('cod.collect', $order->id) }}" method="POST">
            @csrf
            <input type="hidden" name="collected_amount" value="{{ $order->total_amount }}">
            <div class="input-group input-group-sm" style="width: 200px;">
                <input type="text" 
                       class="form-control text-end" 
                       value="${{ number_format($order->total_amount, 2) }}" 
                       readonly
                       style="background-color:rgb(29, 62, 95); border-right: 0;">
                <button type="submit" class="btn btn-success">
                    <i class="fas fa-hand-holding-usd"></i> Collect
                </button>
            </div>
        </form>
    @else
        <span class="badge bg-success bg-opacity-10 text-success">
            <i class="fas fa-check-circle me-1"></i> Collected
        </span>
    @endif
</td>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="9" class="text-center py-5">
                                    <div class="empty-state">
                                        <i class="fas fa-money-bill-wave fa-3x text-muted mb-3"></i>
                                        <h5 class="text-muted">No payment records found</h5>
                                        <p class="text-muted">When new COD orders are placed, they will appear here</p>
                                        <button class="btn btn-primary mt-3">
                                            <i class="fas fa-sync me-1"></i> Refresh
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
        @if($orders instanceof \Illuminate\Pagination\AbstractPaginator)
        <div class="card-footer bg-white border-top">
            <div class="d-flex justify-content-between align-items-center">
                <div class="showing-entries">
                    Showing {{ $orders->firstItem() }} to {{ $orders->lastItem() }} of {{ $orders->total() }} entries
                </div>
                <div>
                    {{ $orders->links() }}
                </div>
            </div>
        </div>
        @endif
    </div>
</div>

<!-- CSS Styles -->
<style>
    /* Base Styles */
    body {
        background-color: #f8f9fa;
    }
    
    /* Card Styles */
    .card {
        border: none;
        border-radius: 10px;
        overflow: hidden;
        transition: all 0.3s ease;
    }
    
    .card:hover {
        transform: translateY(-5px);
        box-shadow: 0 10px 20px rgba(0,0,0,0.1);
    }
    
    /* Stats Card Styles */
    .stats-card {
        position: relative;
        overflow: hidden;
        border: none;
        transition: all 0.3s ease;
    }
    
    .stats-card:hover {
        transform: translateY(-5px);
    }
    
    .stats-card .stats-title {
        font-size: 0.8rem;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        color: #6c757d;
        margin-bottom: 0.5rem;
    }
    
    .stats-card .stats-count {
        font-size: 1.5rem;
        font-weight: 700;
        margin-bottom: 0.5rem;
    }
    
    .stats-card .stats-icon {
        font-size: 1.5rem;
        opacity: 0.2;
        transition: all 0.3s ease;
    }
    
    .stats-card:hover .stats-icon {
        opacity: 0.5;
    }
    
    .stats-card .stats-progress {
        height: 4px;
        background-color: rgba(255,255,255,0.2);
        border-radius: 2px;
        overflow: hidden;
    }
    
    /* Gradient Backgrounds */
    .bg-gradient-success-hover {
        background-color: #fff;
        border: 1px solid rgba(25, 135, 84, 0.2);
    }
    
    .bg-gradient-success-hover:hover {
        background: linear-gradient(135deg, #198754 0%, #157347 100%);
        color: white;
    }
    
    .bg-gradient-warning-hover {
        background-color: #fff;
        border: 1px solid rgba(255, 193, 7, 0.2);
    }
    
    .bg-gradient-warning-hover:hover {
        background: linear-gradient(135deg, #ffc107 0%, #fd7e14 100%);
        color: white;
    }
    
    /* Table Styles */
    .table {
        margin-bottom: 0;
    }
    
    .table th {
        border-top: none;
        font-weight: 600;
        text-transform: uppercase;
        font-size: 0.75rem;
        letter-spacing: 0.5px;
        color: #6c757d;
        background-color:rgb(177, 213, 250);
        padding: 1rem;
    }
    
    .table td {
        padding: 1rem;
        vertical-align: middle;
        border-top: 1px solid #f1f1f1;
    }
    
    .table-hover tbody tr:hover {
        background-color: rgba(13, 110, 253, 0.05);
    }
    
    /* Avatar Styles */
    .avatar-sm {
        width: 36px;
        height: 36px;
        display: flex;
        align-items: center;
        justify-content: center;
        border-radius: 50%;
    }
    
    .avatar-text {
        font-weight: 600;
        text-transform: uppercase;
    }
    
    /* Badge Styles */
    .badge {
        padding: 0.35em 0.65em;
        font-weight: 500;
    }
    
    .badge.bg-opacity-10 {
        --bs-bg-opacity: 0.1;
    }
    
    /* Order ID Badge */
    .order-id {
        padding: 0.5rem 0.75rem;
        border-radius: 6px;
    }
    
    /* Empty State */
    .empty-state {
        padding: 2rem;
    }
    
    /* Text Gradient */
    .text-gradient-primary {
        background: linear-gradient(135deg, #0d6efd 0%, #0b5ed7 100%);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
    }
    
    /* Responsive Adjustments */
    @media (max-width: 768px) {
        .stats-card .stats-count {
            font-size: 1.2rem;
        }
        
        .table-responsive {
            border-radius: 0.5rem;
            border: 1px solid #eee;
        }
    }
</style>

<!-- JavaScript -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>

<script>
    $(document).ready(function() {
        // Initialize datepicker
        
        
        // Handle collect payment form submission
        $('.collect-form').on('submit', function(e) {
            e.preventDefault();
            var form = $(this);
            var button = form.find('.collect-btn');
            
            button.prop('disabled', true).html('<i class="fas fa-spinner fa-spin"></i> Processing...');
            
            $.ajax({
                type: "POST",
                url: form.attr('action'),
                data: form.serialize(),
                success: function(response) {
                    if(response.success) {
                        // Replace entire form with "Paid" badge
                        form.parent().html('<span class="badge bg-success bg-opacity-10 text-success"><i class="fas fa-check-circle me-1"></i> Paid</span>');
                        
                        // Update status column
                        form.closest('tr').find('td:nth-child(8)').html(
                            '<span class="badge bg-success bg-opacity-10 text-success rounded-pill">' +
                            '<i class="fas fa-check-circle me-1"></i> Paid</span>'
                        );
                        
                        // Update due amount to show $0.00
                        form.closest('tr').find('td:nth-child(5)').html(
                            '<span class="text-success">$0.00</span>'
                        );
                        
                        // Reload stats cards
                        location.reload();
                    }
                },
                error: function() {
                    button.prop('disabled', false).html('<i class="fas fa-hand-holding-usd"></i> Collect');
                    alert('Error processing payment');
                }
            });
        });
        
        // Filter buttons
        $('#applyFilter').click(function() {
            alert('Filter functionality will be implemented here');
        });
        
        $('#resetFilter').click(function() {
            $('#startDate').val('');
            $('#endDate').val('');
        });
    });
</script>
@endsection