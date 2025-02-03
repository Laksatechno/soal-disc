<!-- resources/views/layouts/app.blade.php -->

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="icon" href="{{ asset('andaramedical.ico') }}" type="image/x-icon">
    <title>@yield('title', 'TEST DISC')</title>
    
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Additional CSS can go here -->
    @vite(['resources/css/app.css','resources/js/app.js'])
    @stack('styles')
</head>
<body>

    <!-- Header Section -->
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <div class="container">
            <a class="navbar-brand" href="{{ url('/') }}">TEST DISC Andara Medical</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    {{-- <li class="nav-item">
                        <a class="nav-link" href="{{ route('home') }}">Home</a>
                    </li> --}}
                    {{-- <li class="nav-item">
                        <a class="nav-link" href="{{ route('test.index') }}">Test</a>
                    </li> --}}
                    <!-- Add other links here as necessary -->
                </ul>
            </div>
        </div>
    </nav>

    <!-- Main Content -->
    {{-- <div class="container mt-4"> --}}
        @yield('content') <!-- This will be where the content from other views gets injected -->
    {{-- </div> --}}

    <!-- Footer Section -->
    <footer class="bg-light text-center py-4 mt-4">
        <p>&copy; 2025 Test DISC Application YOFA GROUP. All rights reserved.</p>
    </footer>

    <!-- Bootstrap JS (with Popper.js) -->
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.10.2/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    @stack('scripts') <!-- For additional JS or scripts -->
</body>
</html>
