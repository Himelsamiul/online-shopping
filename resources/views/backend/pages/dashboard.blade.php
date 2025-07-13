@extends('backend.master')

@section('content')
<style>
  .dashboard-container {
    background-color: #f8f9fa;
    padding: 2rem 0;
  }

  .dashboard-heading {
    text-align: center;
    color: #2c3e50;
    font-size: 2rem;
    font-weight: 600;
    margin-bottom: 2rem;
    letter-spacing: 0.5px;
  }

  .card-stats {
    border: none;
    border-radius: 8px;
    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.05);
    transition: all 0.3s ease;
    height: 100%;
    overflow: hidden;
    position: relative;
    border-left: 4px solid;
  }

  /* Base card colors */
  .card-primary { background-color: rgba(52, 152, 219, 0.1); border-left-color: #3498db; }
  .card-info { background-color: rgba(41, 128, 185, 0.1); border-left-color: #2980b9; }
  .card-success { background-color: rgba(39, 174, 96, 0.1); border-left-color: #27ae60; }
  .card-warning { background-color: rgba(243, 156, 18, 0.1); border-left-color: #f39c12; }
  .card-secondary { background-color: rgba(127, 140, 141, 0.1); border-left-color: #7f8c8d; }
  .card-dark { background-color: rgba(52, 73, 94, 0.1); border-left-color: #34495e; }
  .card-danger { background-color: rgba(231, 76, 60, 0.1); border-left-color: #e74c3c; }

  /* Hover colors */
  .card-primary:hover { background-color: rgba(52, 152, 219, 0.2); }
  .card-info:hover { background-color: rgba(41, 128, 185, 0.2); }
  .card-success:hover { background-color: rgba(39, 174, 96, 0.2); }
  .card-warning:hover { background-color: rgba(243, 156, 18, 0.2); }
  .card-secondary:hover { background-color: rgba(127, 140, 141, 0.2); }
  .card-dark:hover { background-color: rgba(52, 73, 94, 0.2); }
  .card-danger:hover { background-color: rgba(231, 76, 60, 0.2); }

  .card-stats:hover {
    transform: translateY(-5px);
    box-shadow: 0 8px 25px rgba(0, 0, 0, 0.1);
  }

  .card-body {
    padding: 1.5rem;
  }

  .dashboard-icon {
    width: 60px;
    height: 60px;
    border-radius: 8px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 1.5rem;
    color: white;
    transition: all 0.3s ease;
  }

  .card-category {
    font-size: 0.85rem;
    color: #7f8c8d;
    font-weight: 500;
    text-transform: uppercase;
    letter-spacing: 0.5px;
    margin-bottom: 0.5rem;
  }

  .card-title {
    font-size: 1.5rem;
    font-weight: 600;
    color: #2c3e50;
    margin: 0;
  }

  .card-link {
    text-decoration: none;
    color: inherit;
    display: block;
    height: 100%;
  }

  /* Icon colors */
  .bg-primary { background-color: #3498db; }
  .bg-info { background-color: #2980b9; }
  .bg-success { background-color: #27ae60; }
  .bg-warning { background-color: #f39c12; }
  .bg-secondary { background-color: #7f8c8d; }
  .bg-dark { background-color: #34495e; }
  .bg-danger { background-color: #e74c3c; }
</style>

<div class="dashboard-container">
  <div class="container">
    <div class="page-inner">
      <div class="d-flex justify-content-center">
        <div>
          <h3 class="dashboard-heading">Dashboard Overview</h3>
        </div>
      </div>

      <div class="row">
        @php
          $stats = [
            [
              'label' => 'Total Categories', 
              'value' => $category, 
              'icon' => 'fas fa-layer-group', 
              'color' => 'bg-primary',
              'card-color' => 'card-primary',
              'link' => route('categories.list')
            ],
            [
              'label' => 'Total Units', 
              'value' => $unit, 
              'icon' => 'fas fa-balance-scale', 
              'color' => 'bg-info',
              'card-color' => 'card-info',
              'link' => route('units.list')
            ],
            [
              'label' => 'Total Products', 
              'value' => $product, 
              'icon' => 'fas fa-box-open', 
              'color' => 'bg-success',
              'card-color' => 'card-success',
              'link' => route('products.list')
            ],
            [
              'label' => 'Total Orders', 
              'value' => $orderCount, 
              'icon' => 'fas fa-shopping-cart', 
              'color' => 'bg-warning',
              'card-color' => 'card-warning',
              'link' => route('order.list')
            ],
            [
              'label' => 'Total Customers', 
              'value' => $customerCount, 
              'icon' => 'fas fa-users', 
              'color' => 'bg-secondary',
              'card-color' => 'card-secondary',
              'link' => route('customers')
            ],
            [
  'label' => 'Total Sale (SSLCommerz Paid)', 
  'value' => 'BDT. ' . number_format($totalPaidAmountSSL, 2), 
  'icon' => 'fas fa-dollar-sign', 
  'color' => 'bg-dark',
  'card-color' => 'card-dark'
],
[
  'label' => 'Total COD Collected', 
  'value' => 'BDT. ' . number_format($totalCollectedAmountCOD, 2), 
  'icon' => 'fas fa-check-circle', 
  'color' => 'bg-success',
  'card-color' => 'card-success'
],
[
  'label' => 'Total COD Pending', 
  'value' => 'BDT. ' . number_format($totalPendingAmountCOD, 2), 
  'icon' => 'fas fa-clock', 
  'color' => 'bg-warning',
  'card-color' => 'card-warning'
],
[
  'label' => 'Total Order Amount',
  'value' => 'BDT. ' . number_format($totalOrderAmount, 2),
  'icon' => 'fas fa-receipt',
  'color' => 'bg-info',
  'card-color' => 'card-info'
],
[
  'label' => 'Total Collection',
  'value' => 'BDT. ' . number_format($totalCollection, 2),
  'icon' => 'fas fa-wallet',
  'color' => 'bg-success',
  'card-color' => 'card-success'
],

            [
              'label' => 'Total Messages', 
              'value' => $contactCount, 
              'icon' => 'fas fa-envelope', 
              'color' => 'bg-danger',
              'card-color' => 'card-danger',
              'link' => route('contactusview')
            ],
            [
              'label' => 'Total Reviews', 
              'value' => $reviewCount, 
              'icon' => 'fas fa-star', 
              'color' => 'bg-success',
              'card-color' => 'card-success',
              'link' => route('review')
            ],
          ];
        @endphp

        @foreach($stats as $stat)
        <div class="col-sm-6 col-md-4 col-lg-3 mb-4">
          @if(isset($stat['link']))
            <a href="{{ $stat['link'] }}" class="card-link">
          @else
            <div>
          @endif
            <div class="card card-stats {{ $stat['card-color'] }} shadow-sm">
              <div class="card-body">
                <div class="d-flex align-items-center">
                  <div class="dashboard-icon {{ $stat['color'] }} me-3">
                    <i class="{{ $stat['icon'] }}"></i>
                  </div>
                  <div>
                    <p class="card-category">{{ $stat['label'] }}</p>
                    <h4 class="card-title">{{ $stat['value'] }}</h4>
                  </div>
                </div>
              </div>
            </div>
          @if(isset($stat['link']))
            </a>
          @else
            </div>
          @endif
        </div>
        @endforeach
      </div>
    </div>
  </div>
</div>

<script>
  document.querySelectorAll('.dashboard-icon').forEach(icon => {
    icon.addEventListener('mouseenter', () => {
      icon.style.transform = 'scale(1.1)';
    });
    icon.addEventListener('mouseleave', () => {
      icon.style.transform = 'scale(1)';
    });
  });
</script>
@endsection