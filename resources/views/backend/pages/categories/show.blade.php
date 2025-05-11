@extends('backend.master')

@section('content')
    <div class="container">
        <h2 class="page-title">Category Details</h2>

        <div class="card">
            <div class="card-header">
                <h3 id="category-name" data-id="{{ $category->id }}">{{ $category->name }}</h3>
            </div>
            <div class="card-body">
                <p><strong>Description:</strong> <span id="category-description">{{ $category->description }}</span></p>
                <p><strong>Status:</strong> 
                    <span id="category-status" class="status {{ $category->status }}">{{ ucfirst($category->status) }}</span>
                </p>
                <p><strong>Image:</strong></p>
                @if($category->image)
                    <img class="category-image" src="{{ asset('image/category/' . $category->image) }}?t={{ time() }}" alt="{{ $category->name }}" onclick="openImageModal(this.src)">
                @else
                    <p class="no-image">No image available</p>
                @endif
            </div>
        </div>

        <a href="{{ route('categories.list') }}" class="btn btn-back">Back to Categories</a>
    </div>

    <!-- Image Modal -->
    <div id="imageModal" class="modal">
        <span class="modal-close" onclick="closeImageModal()">&times;</span>
        <img class="modal-content" id="modalImage">
    </div>

    <style>
        body {
            background: linear-gradient(135deg, #f5f7fa 0%, #c3cfe2 100%);
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            min-height: 100vh;
        }

        .container {
            max-width: 800px;
            margin: 40px auto;
            padding: 20px;
            animation: slideIn 0.5s ease-out;
        }

        .page-title {
            color: #2c3e50;
            text-align: center;
            margin-bottom: 30px;
            font-size: 2.5em;
            text-transform: uppercase;
            letter-spacing: 2px;
            animation: fadeIn 1s ease-in;
        }

        .card {
            background: #ffffff;
            border-radius: 15px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
            overflow: hidden;
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }

        .card:hover {
            transform: translateY(-10px);
            box-shadow: 0 15px 40px rgba(0, 0, 0, 0.2);
        }

        .card-header {
            background: linear-gradient(to right, #3498db, #2980b9);
            color: white;
            padding: 20px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .card-header h3 {
            margin: 0;
            font-size: 1.8em;
            transition: color 0.3s ease;
        }

        .card-body {
            padding: 30px;
            line-height: 1.8;
        }

        .card-body p {
            margin: 15px 0;
            font-size: 1.1em;
            color: #34495e;
        }

        .status {
            padding: 5px 10px;
            border-radius: 12px;
            color: white;
            font-weight: bold;
        }

        .status.active {
            background: #2ecc71;
        }

        .status.inactive {
            background: #e74c3c;
        }

        .category-image {
            border-radius: 10px;
            cursor: pointer;
            transition: transform 0.3s ease, opacity 0.3s ease;
        }

        .category-image:hover {
            transform: scale(1.05);
            opacity: 0.9;
        }

        .no-image {
            color: #e74c3c;
            font-style: italic;
        }

        .btn {
            padding: 10px 20px;
            border: none;
            border-radius: 25px;
            cursor: pointer;
            font-size: 1em;
            transition: background 0.3s ease, transform 0.2s ease;
            text-transform: uppercase;
            letter-spacing: 1px;
        }

        .btn-back {
            display: inline-block;
            margin-top: 20px;
            background: #3498db;
            color: #fff;
            text-decoration: none;
        }

        .btn-back:hover {
            background: #2980b9;
            transform: scale(1.1);
        }

        .modal {
            display: none;
            position: fixed;
            z-index: 1000;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.8);
            justify-content: center;
            align-items: center;
        }

        .modal-content {
            max-width: 90%;
            max-height: 90%;
            border-radius: 10px;
        }

        .modal-close {
            position: absolute;
            top: 20px;
            right: 30px;
            color: #fff;
            font-size: 40px;
            cursor: pointer;
            transition: color 0.3s ease;
        }

        .modal-close:hover {
            color: #e74c3c;
        }

        @keyframes slideIn {
            from { transform: translateY(50px); opacity: 0; }
            to { transform: translateY(0); opacity: 1; }
        }

        @keyframes fadeIn {
            from { opacity: 0; }
            to { opacity: 1; }
        }

        @media (max-width: 600px) {
            .container {
                padding: 10px;
            }

            .card-header h3 {
                font-size: 1.5em;
            }

            .card-body {
                padding: 20px;
            }

            .btn {
                padding: 8px 15px;
                font-size: 0.9em;
            }
        }
    </style>

    <script>
        // Image Modal Functions
        function openImageModal(src) {
            const modal = document.getElementById('imageModal');
            const modalImg = document.getElementById('modalImage');
            modal.style.display = 'flex';
            modalImg.src = src;
            modal.classList.add('fade-in');
            setTimeout(() => modal.classList.remove('fade-in'), 500);
        }

        function closeImageModal() {
            const modal = document.getElementById('imageModal');
            modal.style.display = 'none';
        }

        // Add updated animation
        const style = document.createElement('style');
        style.textContent = `
            .updated {
                animation: flash 0.5s ease;
            }
            @keyframes flash {
                0% { background: #f1c40f; }
                100% { background: none; }
            }
        `;
        document.head.appendChild(style);

        // Initialize animations
        document.addEventListener('DOMContentLoaded', () => {
            document.querySelectorAll('.card').forEach(card => {
                card.style.opacity = '0';
                setTimeout(() => {
                    card.style.transition = 'opacity 0.5s ease';
                    card.style.opacity = '1';
                }, 100);
            });
        });
    </script>
@endsection
