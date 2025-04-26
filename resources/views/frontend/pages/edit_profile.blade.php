@extends('frontend.master')

@section('content')
<div class="container py-5">
    <h2 class="mb-4 text-center">Edit Profile</h2>

    <div class="card mx-auto" style="max-width: 600px;">
        <div class="card-body">

            <form action="{{ route('profile.update') }}" method="POST" enctype="multipart/form-data">
                @csrf

                {{-- Name --}}
                <div class="mb-3">
                    <label for="name" class="form-label">Name</label>
                    <input type="text" 
                           name="name" 
                           id="name" 
                           class="form-control" 
                           value="{{ old('name', $customer->name) }}" 
                           required>
                </div>

                {{-- Phone Number --}}
                <div class="mb-3">
                    <label for="phoneno" class="form-label">Phone Number</label>
                    <input type="text" 
                           name="phoneno" 
                           id="phoneno" 
                           class="form-control" 
                           value="{{ old('phoneno', $customer->phoneno) }}" 
                           required>
                </div>

                {{-- Address --}}
                <div class="mb-3">
                    <label for="address" class="form-label">Address</label>
                    <textarea name="address" 
                              id="address" 
                              rows="3" 
                              class="form-control" 
                              required>{{ old('address', $customer->address) }}</textarea>
                </div>

                {{-- Profile Image --}}
                <div class="mb-3">
                    <label for="image" class="form-label">Profile Image</label>
                    <input type="file" name="image" id="image" class="form-control">

                    @if($customer->image)
                        <img src="{{ url('image/category/customer/' . $customer->image) }}" 
                             alt="Current Image" 
                             class="rounded mt-2" 
                             style="width: 100px; height: 100px; object-fit: cover;">
                    @endif
                </div>

                {{-- Save Button --}}
                <div class="d-grid">
                    <button type="submit" class="btn btn-primary">Update Profile</button>
                </div>

            </form>

        </div>
    </div>

</div>
@endsection
