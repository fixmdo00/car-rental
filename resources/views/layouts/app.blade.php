<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=Nunito" rel="stylesheet">

    <!-- Scripts -->
    @vite(['resources/sass/app.scss', 'resources/js/app.js'])
    <style>
        .custom-container {
            max-width: 1000px;
            margin: 0 auto;
        }

        .card-img-top {
            width: 100%;
            height: 50%;
            /* Atur tinggi gambar agar seragam */
            object-fit: cover;
            /* Memastikan gambar menyesuaikan dengan area tanpa mengubah aspek rasio */
        }
    </style>
</head>

<body>
    <div class="custom-container">
        <nav class="px-4 navbar navbar-expand-lg navbar-light bg-light">
            <a class="navbar-brand" href="#">Car Rental</a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav"
                aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                @guest
                @else
                    <ul class="navbar-nav mr-auto">
                        <li class="nav-item">
                            <a class="nav-link @if (request()->is('cars') || request()->is('home') || request()->is('/')) active @endif" href="/cars">Cars</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link @if (request()->is('my-cars')) active @endif" href="/my-cars">My Cars</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link @if (request()->is('active-rentals')) active @endif"
                                href="/active-rentals">Active Rentals</a>
                        </li>
                    </ul>
                @endguest

                <ul class="navbar-nav ms-auto">
                    <!-- Authentication Links -->
                    @guest
                        @if (Route::has('login'))
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('login') }}">{{ __('Login') }}</a>
                            </li>
                        @endif

                        @if (Route::has('register'))
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('register') }}">{{ __('Register') }}</a>
                            </li>
                        @endif
                    @else
                        <li class="nav-item dropdown">
                            <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button"
                                data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                {{ Auth::user()->name }}
                            </a>

                            <div class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                                <a class="dropdown-item" href="{{ route('logout') }}"
                                    onclick="event.preventDefault();
                                                 document.getElementById('logout-form').submit();">
                                    {{ __('Logout') }}
                                </a>

                                <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                    @csrf
                                </form>
                            </div>
                        </li>
                    @endguest
                </ul>
            </div>
        </nav>

        <div class="mt-4">
            <!-- Your content goes here -->
            @yield('content')
        </div>
    </div>

    <!-- Bootstrap JS and dependencies -->
    {{-- <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.3/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script> --}}
</body>

</html>
