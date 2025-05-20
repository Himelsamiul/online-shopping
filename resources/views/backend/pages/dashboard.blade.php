@extends('backend.master')

@section('content')
<!-- Custom Dashboard CSS -->
<style>
  /* Add smooth sliding gradient color effect */
  .card-stats {
    position: relative;
    overflow: hidden;
    background: linear-gradient(90deg, #ffadad, #ffd6a5, #fdffb6, #caffbf, #9bf6ff, #a0c4ff, #bdb2ff, #ffc3a0);
    background-size: 300% 100%;
    animation: slideGradient 5s linear infinite;
    border-radius: 12px;  /* For rounded corners */
    transition: all 0.3s ease;
  }

  @keyframes slideGradient {
    0% { background-position: 0% 0%; }
    50% { background-position: 100% 0%; }
    100% { background-position: 0% 0%; }
  }

  .dashboard-icon {
    transition: transform 0.3s ease, box-shadow 0.3s ease;
    border-radius: 12px;
    padding: 18px;
  }

  .dashboard-icon:hover {
    transform: scale(1.1);
    box-shadow: 0 8px 20px rgba(0, 0, 0, 0.15);
  }

  .card-stats .card-body {
    padding: 1.2rem;
  }

  .card-category {
    font-size: 0.9rem;
    color: #6c757d;
  }

  .card-title {
    font-size: 1.5rem;
    font-weight: 700;
    margin-top: 0.3rem;
  }

  .dashboard-heading {
    text-align: center;
    color: rgb(66, 113, 160);
    font-size: 2rem;
    font-weight: 700;
    margin-bottom: 20px;
  }

  .card-stats:hover {
    cursor: pointer;
    box-shadow: 0 12px 25px rgba(0,0,0,0.2);
    transform: scale(1.05);
  }

  a.card-link {
    text-decoration: none;
    color: inherit;
  }
</style>

<div class="container">
  <div class="page-inner">
    <div class="d-flex justify-content-center pt-2 pb-4">
      <div>
        <h3 class="dashboard-heading">Dashboard</h3>
      </div>
    </div>

    <div class="row">
      @php
        $stats = [
          [
            'label' => 'Total Category', 
            'value' => $category, 
            'icon' => 'fas fa-layer-group', 
            'color' => 'bg-primary',
            'link' => route('categories.list')
          ],
          [
            'label' => 'Total Units', 
            'value' => $unit, 
            'icon' => 'fas fa-balance-scale', 
            'color' => 'bg-info',
            'link' => route('units.list')
          ],
          [
            'label' => 'Total Products', 
            'value' => $product, 
            'icon' => 'fas fa-box-open', 
            'color' => 'bg-success',
            'link' => route('products.list')
          ],
          [
            'label' => 'Total Orders', 
            'value' => $orderCount, 
            'icon' => 'fas fa-shopping-cart', 
            'color' => 'bg-warning',
            'link' => route('order.list')
          ],
          [
            'label' => 'Total Customers', 
            'value' => $customerCount, 
            'icon' => 'fas fa-users', 
            'color' => 'bg-secondary',
            'link' => route('customers')
          ],
          [
            'label' => 'Total Sale (Paid)', 
            'value' => 'BDT. ' . number_format($totalPaidAmount, 2), 
            'icon' => 'fas fa-dollar-sign', 
            'color' => 'bg-dark',
            // 'link' => route('orders.index', ['filter' => 'paid'])  // Optional link, commented out properly
          ],
          [
            'label' => 'Total Sale (Pending)', 
            'value' => 'BDT. ' . number_format($totalPendingAmount, 2), 
            'icon' => 'fas fa-clock', 
            'color' => 'bg-warning',
            // 'link' => route('orders.index', ['filter' => 'pending'])  // Optional link, commented out properly
          ],
          [
            'label' => 'Total Message', 
            'value' => $contactCount, 
            'icon' => 'fas fa-envelope', 
            'color' => 'bg-danger',
            'link' => route('contactusview')
          ],
          [
            'label' => 'Total Review', 
            'value' => $reviewCount, 
            'icon' => 'fas fa-star', 
            'color' => 'bg-success',
            'link' => route('review')
          ],
        ];
      @endphp

      @foreach($stats as $stat)
      <div class="col-sm-6 col-md-3 mb-4">
        @if(isset($stat['link']))
          <a href="{{ $stat['link'] }}" class="card-link">
        @else
          <div>
        @endif
          <div class="card card-stats card-round shadow-sm">
            <div class="card-body">
              <div class="row align-items-center">
                <div class="col-icon">
                  <div class="dashboard-icon text-white text-center {{ $stat['color'] }}">
                    <i class="{{ $stat['icon'] }} fa-2x"></i>
                  </div>
                </div>
                <div class="col col-stats ms-3 ms-sm-0">
                  <div class="numbers">
                    <p class="card-category">{{ $stat['label'] }}</p>
                    <h4 class="card-title">{{ $stat['value'] }}</h4>
                  </div>
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

<script>
  document.querySelectorAll('.dashboard-icon').forEach(icon => {
    icon.addEventListener('mouseenter', () => icon.style.opacity = 0.9);
    icon.addEventListener('mouseleave', () => icon.style.opacity = 1);
  });
</script>
@endsection
