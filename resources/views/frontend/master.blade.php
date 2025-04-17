<!DOCTYPE html>
<html lang="en">
<head>
    <title>@yield('title', 'Kaira Fashion Store')</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- Bootstrap & Custom CSS -->
    <link rel="stylesheet" href="{{ asset('css/vendor.css') }}">
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet">

    @stack('styles')

    <style>
        html, body {
            height: 100%;
            margin: 0;
        }

        body {
            display: flex;
            flex-direction: column;
        }

        main {
            flex: 1;
        }

        /* Optional horizontal scroll bar for products */
        .scrolling-wrapper {
            overflow-x: auto;
            display: flex;
            gap: 1rem;
            padding-bottom: 1rem;
        }

        .scrolling-wrapper::-webkit-scrollbar {
            height: 8px;
        }

        .scrolling-wrapper::-webkit-scrollbar-thumb {
            background: #bbb;
            border-radius: 4px;
        }

        .scrolling-wrapper::-webkit-scrollbar-track {
            background: #f2f2f2;
        }
    </style>
</head>
<body>

    @include('frontend.partials.header')

    <main class="container mt-4">
        @yield('content')
    </main>

    @include('frontend.partials.footer')

    <!-- Scripts -->
    <script src="{{ asset('js/script.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"></script>

    @stack('scripts')
</body>
</html>
