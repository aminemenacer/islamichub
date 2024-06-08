<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <!-- Title -->
    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- External CSS Libraries -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/5.3.0/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/admin-lte@3.2/dist/css/adminlte.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.7.2/font/bootstrap-icons.css" rel="stylesheet">

    <!-- Compiled CSS -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <link rel="icon" href="{{ asset('images/favicon.ico') }}">

    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <script async src="https://www.googletagmanager.com/gtag/js?id=G-QWLL07EBX9"></script>
    <script>
        window.dataLayer = window.dataLayer || [];
        function gtag() { dataLayer.push(arguments); }
        gtag('js', new Date());
        gtag('config', 'G-QWLL07EBX9');
    </script>
</head>

<body>
    <div id="app">
        <nav class="navbar navbar-expand-md navbar-light bg-white shadow-sm">
            <div class="container-fluid">
                <a class="navbar-brand" href="{{ url('/') }}">
                    <img src="/images/logo_main.png" width="275" height="54" class="d-inline-block align-top" alt="">
                </a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
                    data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent"
                    aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <!-- Left Side Of Navbar -->
                    <ul class="navbar-nav justify-content-end pr-4 flex-grow-1">
                        <!-- Navigation Items -->
                        <li class="nav-item mt-3">
                            <h6><a style="font-family:inter; color: black;" class="nav-link ml-4 pl-3"
                                    href="/">Home</a></h6>
                        </li>
                        <li class="nav-item mt-3">
                            <h6><a style="font-family:inter; color: black;" class="nav-link ml-4 pl-3"
                                    href="/contact">Contact</a></h6>
                        </li>
                        <li class="nav-item mt-3">
                            <h6><a style="font-family:inter; color: black;" class="nav-link ml-4 pl-3"
                                    href="/about">About Us</a></h6>
                        </li>
                        <li class="nav-item mt-3">
                            <h6><a style="font-family:inter; color: black;" class="nav-link ml-4 pl-3"
                                    href="/updates">Updates</a></h6>
                        </li>
                        <li class="nav-item mt-3">
                            <h6><a style="font-family:inter; color: black;" class="nav-link ml-4 pl-3 pr-5"
                                    href="/join_us">Mailing List</a></h6>
                        </li>
                    </ul>
                    <!-- Right Side Of Navbar -->
                    <ul class="navbar-nav mt-1" style="align-items: center">
                        @guest
                        @if (Route::has('login'))
                        <li class="nav-item">
                            <h6><a class="nav-link" href="{{ route('login') }}">{{ __('Login') }}</a></h6>
                        </li>
                        @endif
                        @if (Route::has('register'))
                        <li class="nav-item">
                            <h6><a class="nav-link" href="{{ route('register') }}">{{ __('Register') }}</a></h6>
                        </li>
                        @endif
                        @else
                        <li class="nav-item dropdown">
                            <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button"
                                data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                <i class="bi bi-person-circle pr-2" style="font-size: 1.8rem"></i>
                                {{ Auth::user()->name }}
                            </a>
                            <div class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                                <a class="dropdown-item" href="/bookmarks">Bookmarks</a>
                                <a class="dropdown-item" href="/notes">Notes & Reflections</a>
                                <a class="dropdown-item" href="/profile">Profile</a>
                                <a class="dropdown-item" href="{{ route('logout') }}"
                                    onclick="event.preventDefault(); document.getElementById('logout-form').submit();">{{ __('Logout') }}</a>
                                <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">@csrf
                                </form>
                            </div>
                        </li>
                        @endguest
                        <li class="nav-item mt-2 pl-4">
                            <button class="button-33"><a style="text-decoration: none;color:white"
                                    href="https://www.gofundme.com/f/empowerment-through-quran-support-islamic-connects-mission">Support
                                    Us</a></button>
                        </li>
                    </ul>
                </div>
            </div>
        </nav>

        <main>
            @yield('content')
        </main>
    </div>

    <!-- Custom JS -->
    <script src="{{ asset('js/app.js') }}" defer></script>

    <!-- External JS Libraries -->
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/5.3.0/js/bootstrap.min.js"></script>

    <!-- Tooltip and Dropdown Initialization -->
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
            var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
                return new bootstrap.Tooltip(tooltipTriggerEl);
            });

            var dropdownElementList = [].slice.call(document.querySelectorAll('.dropdown-toggle'));
            var dropdownList = dropdownElementList.map(function (dropdownToggleEl) {
                return new bootstrap.Dropdown(dropdownToggleEl);
            });
        });
    </script>
</body>
</html>
<style scoped>
    .button-33 {
        background-color: #00BFA6;
        border-radius: 10px;
        color: white;
        cursor: pointer;
        display: inline-block;
        font-family: CerebriSans-Regular, -apple-system, system-ui, Roboto, sans-serif;
        padding: 7px 20px;
        text-align: center;
        text-decoration: none;
        transition: all 250ms;
        border: 0;
        font-size: 16px;
        user-select: none;
        -webkit-user-select: none;
        touch-action: manipulation;
    }

    .button-33:hover {
        background-color: #00a58a;
    }

    /* Hide sidebar on tablet screen sizes */
    @media (min-width: 768px) and (max-width: 1024px) and (max-width: 575px) {
        #tablet-sidebar {
            display: none;
        }
    }
</style>
