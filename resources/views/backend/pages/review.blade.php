@extends('backend.master')


@section('content')
<div class="container">
    <h2>All Reviews</h2>

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Customer Name</th>
                <th>Product Name</th>
                <th>Ratings</th>
                <th>Review</th>
            </tr>
        </thead>
        <tbody>

            @foreach ($review as $data)
            <tr>
                <td>{{ $data->customer->name }}</td>
                <td>{{ $data->product->name }}</td>
                <td>{{ $data->rating }}</td>
                <td>{{ $data->review }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection