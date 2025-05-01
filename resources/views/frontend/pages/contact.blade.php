@extends('frontend.master')

@section('content')

<div class="container py-5 d-flex justify-content-center align-items-center" style="min-height: 80vh;">
    <div class="card shadow-lg" style="width: 100%; max-width: 600px; background-color: #f8f9fa;">
        <div class="card-body">
            <div class="text-center mb-4">
                <h2 style="color: #343a40;">Contact Us</h2>
                <hr class="w-25 mx-auto" style="border-top: 2px solid #007bff;">
            </div>

            <form action="{{ route('contactus.submit') }}" method="POST" id="contactForm">
                @csrf
                <div class="row">
                    <div class="col-md-12 mb-3">
                        <label for="name" class="form-label" style="color: #007bff;">Your Name</label>
                        <input type="text" name="name" class="form-control" id="name" required style="border-color: #007bff;">
                    </div>
                    <div class="col-md-12 mb-3">
                        <label for="email" class="form-label" style="color: #007bff;">Your Email</label>
                        <input type="email" name="email" class="form-control" id="email" required style="border-color: #007bff;">
                    </div>
                    <div class="col-md-12 mb-3">
                        <label for="phone" class="form-label" style="color: #007bff;">Your Phone Number</label>
                        <input type="text" name="phone" class="form-control" id="phone" placeholder="Optional" oninput="validatePhone()" style="border-color: #007bff;">
                    </div>
                    <div class="col-md-12 mb-3">
                        <label for="message" class="form-label" style="color: #007bff;">Your Message</label>
                        <textarea name="message" class="form-control" id="message" rows="5" required style="border-color: #007bff;"></textarea>
                    </div>
                    <div class="col-md-12 text-center">
                        <button type="submit" class="btn btn-primary" style="background-color: #007bff; border-color: #007bff;">Send Message</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
    // Validate phone number to allow only numeric input
    function validatePhone() {
        let phoneInput = document.getElementById("phone");
        let phoneValue = phoneInput.value;

        if (isNaN(phoneValue)) {
            phoneInput.setCustomValidity("Phone number should only contain numbers");
        } else {
            phoneInput.setCustomValidity("");
        }
    }

    // Handle form submission
    document.getElementById("contactForm").addEventListener("submit", function(event) {
        event.preventDefault();

        let phoneValue = document.getElementById("phone").value;

        if (phoneValue && isNaN(phoneValue)) {
            Swal.fire({
                icon: 'error',
                title: 'Oops...',
                text: 'Phone number format is incorrect! Please enter a valid number.',
            });
        } else {
            Swal.fire({
                title: 'Are you sure?',
                text: "Do you want to send this message?",
                icon: 'question',
                showCancelButton: true,
                confirmButtonColor: '#007bff',
                cancelButtonColor: '#6c757d',
                confirmButtonText: 'Yes, send it!',
                cancelButtonText: 'Cancel'
            }).then((result) => {
                if (result.isConfirmed) {
                    document.getElementById("contactForm").submit();
                }
            });
        }
    });
</script>

@if(session('success'))
    <script>
        document.addEventListener("DOMContentLoaded", function () {
            Swal.fire({
                icon: 'success',
                title: 'Message Sent!',
                text: '{{ session('success') }}',
                confirmButtonColor: '#007bff',
                timer: 3000
            });
        });
    </script>
@endif

@endsection
