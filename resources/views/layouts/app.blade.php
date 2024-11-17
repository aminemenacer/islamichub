<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="description" content="Welcome to Islamic Connect, your hub for Islamic teachings, Quranic resources, podcasts, and AI-powered accessibility tools. Explore our website for educational content, community engagement, and more.">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- CSS Assets -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/admin-lte@3.2/dist/css/adminlte.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">

    <!-- Google Analytics -->
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            if (navigator.doNotTrack !== "1") {
                const script = document.createElement('script');
                script.async = true;
                script.src = 'https://www.googletagmanager.com/gtag/js?id=G-XXXXXX';
                document.head.appendChild(script);
                script.onload = () => {
                    window.dataLayer = window.dataLayer || [];
                    function gtag() { dataLayer.push(arguments); }
                    gtag('js', new Date());
                    gtag('config', 'G-XXXXXX');
                };
            }
        });
    </script>
</head>
<body>
    <div id="app">
        <!-- Navbar -->
        <nav class="navbar navbar-expand-md navbar-light bg-light shadow-sm py-1">
    <div class="container-fluid">
    <a class="navbar-brand" href="{{ url('/') }}" aria-label="Home">
        <img 
            src="/images/logo_main.png" 
            width="300"
            height="200"
            alt="Islamic Connect Logo"
            loading="lazy"
            height="auto" 
            class="img-fluid"
        >
    </a>

        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent"
            aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav justify-content-end pr-4 flex-grow-1">
                <li class="nav-item mt-3">
                    <h6><a class="nav-link text-dark ml-3 pl-3" href="/quran"><b>Home</b></a></h6>
                </li>
                <li class="nav-item mt-3">
                    <h6><a class="nav-link text-dark ml-3 pl-3" href="/contact"><b>Contact</b></a></h6>
                </li>
                <li class="nav-item mt-3">
                    <h6><a class="nav-link text-dark ml-3 pl-3" href="/about"><b>About Us</b></a></h6>
                </li>
                <li class="nav-item mt-3">
                    <h6><a class="nav-link text-dark ml-3 pl-3" href="/mission"><b>Our Mission</b></a></h6>
                </li>
                <li class="nav-item mt-3">
                    <h6><a class="nav-link text-dark ml-3 pl-3" href="/faq"><b>FAQ's</b></a></h6>
                </li>
                <li class="nav-item mt-3">
                    <h6><a class="nav-link text-dark ml-3 pl-3" href="/updates"><b>Updates</b></a></h6>
                </li>
                <li class="nav-item mt-3">
                    <h6><a class="nav-link text-dark ml-3 pl-3 pr-3" href="/support"><b>Donation</b></a></h6>
                </li>
                @guest
                @if (Route::has('login'))
                <li class="nav-item display-6 pl-3 mt-3">
                    <h6><a class="nav-link text-dark" href="{{ route('login') }}"><b>{{ __('Login') }}</b></a></h6>
                </li>
                @endif
                @if (Route::has('register'))
                <li class="nav-item display-6 pl-3 mt-3">
                    <h6><a class="nav-link text-dark" href="{{ route('register') }}"><b>{{ __('Register') }}</b></a></h6>
                </li>
                @endif
                @else
                <li class="nav-item dropdown pl-3">
                    <a id="navbarDropdown" class="nav-link dropdown-toggle text-dark" href="#" role="button"
                        data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                        <i class="bi bi-person-circle pr-2" style="font-size: 1.8rem"></i>
                        {{ Auth::user()->name }}
                    </a>
                    <div class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                        <a class="dropdown-item" href="/bookmarks">Bookmarks</a>
                        <a class="dropdown-item" href="/notes">Notes & Reflections</a>
                        <a class="dropdown-item" href="/profile">Profile</a>
                        <a class="dropdown-item" href="{{ route('logout') }}"
                            onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
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
    </div>
</nav>


        <!-- Main Content -->
        <main>
            @yield('content')
        </main>
    </div>

    <!-- Scripts -->
    <script src="{{ mix('js/app.js') }}"></script>
</body>
</html>

<!-- Custom Styles -->
<style>
    .nav-link {
        color: black;
        text-decoration: none;
    }

    .nav-link:hover {
        color: #00BFA6;
    }

    /* .button-33 {
        background-color: #00BFA6;
        border-radius: 10px;
        color: white;
        padding: 7px 20px;
        border: none;
        font-size: 16px;
        cursor: pointer;
        transition: all 250ms;
    }

    .button-33:hover {
        background-color: #008f79;
    } */
</style>
