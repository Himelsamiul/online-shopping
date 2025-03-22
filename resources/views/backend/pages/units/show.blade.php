@extends('backend.master')

@section('content')
    <div class="container">
        <h2 class="mb-4">Unit Details</h2>
        
        <div class="card">
            <div class="card-body">
                <h5 class="card-title">Unit Name: {{ $unit->name }}</h5>
                <a href="{{ route('units.list') }}" class="btn btn-primary mt-3">Back to List</a>
            </div>
        </div>
    </div>
@endsection
