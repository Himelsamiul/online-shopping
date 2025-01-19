@extends('backend.master') <!-- Extends the layout.blade.php -->
@section('content')
<div class="page-inner">
  <!-- Page Header -->
  <div class="d-flex align-items-left align-items-md-center flex-column flex-md-row pt-2 pb-4">
    <div>
      <h3 class="fw-bold mb-3">Dashboard</h3>
      <h6 class="op-7 mb-2">Free Bootstrap 5 Admin Dashboard</h6>
    </div>
    <div class="ms-md-auto py-2 py-md-0">
      <a href="#" class="btn btn-label-info btn-round me-2">Manage</a>
      <a href="#" class="btn btn-primary btn-round">Add Customer</a>
    </div>
  </div>

  <!-- Statistics Cards -->
  <div class="row">
    <!-- Visitors Card -->
    <div class="col-sm-6 col-md-3">
      <div class="card card-stats card-round">
        <div class="card-body">
          <div class="row align-items-center">
            <div class="col-icon">
              <div class="icon-big text-center icon-primary bubble-shadow-small">
                <i class="fas fa-users"></i>
              </div>
            </div>
            <div class="col col-stats ms-3 ms-sm-0">
              <div class="numbers">
                <p class="card-category">Visitors</p>
                <h4 class="card-title">1,294</h4>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    <!-- Add other cards here -->
  </div>
</div>
@endsection
