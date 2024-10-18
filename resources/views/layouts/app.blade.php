<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token for Laravel -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Prefetch DNS for Fonts -->
    <link rel="dns-prefetch" href="//fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=Nunito" rel="stylesheet">

    <!-- Admin LTE CSS (for Admin Dashboard) -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/admin-lte@3.2/dist/css/adminlte.min.css">

    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

    <!-- Custom CSS -->
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Google Analytics -->
    <script async src="https://www.googletagmanager.com/gtag/js?id=G-QWLL07EBX9"></script>
    <script>
        window.dataLayer = window.dataLayer || [];
        function gtag(){ dataLayer.push(arguments); }
        gtag('js', new Date());
        gtag('config', 'G-QWLL07EBX9');
    </script>
</head>

<body>
    <div id="app">
        <nav class="navbar navbar-expand-md navbar-light bg-white shadow-sm py-1">
            <div class="container-fluid">
                <a class="navbar-brand" href="{{ url('/') }}">
                    <img src="/images/logo_main.png" width="275" height="54" class="d-inline-block align-top" alt="">
                </a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent"
                    aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <ul class="navbar-nav justify-content-end pr-4 flex-grow-1" style="color: black">
                        <li class="nav-item mt-3">
                            <h6><a class="nav-link display-5 ml-3 pl-3" href="/quran"><b>Home</b></a></h6>
                        </li>
                        <li class="nav-item mt-3">
                            <h6><a class="nav-link display-5 ml-3 pl-3" href="/contact"><b>Contact</b></a></h6>
                        </li>
                        <li class="nav-item mt-3">
                            <h6><a class="nav-link display-5 ml-3 pl-3" href="/about"><b>About Us</b></a></h6>
                        </li>
                        <li class="nav-item mt-3">
                            <h6><a class="nav-link display-5 ml-3 pl-3" href="/mission"><b>Our Mission</b></a></h6>
                        </li>
                        <li class="nav-item mt-3">
                            <h6><a class="nav-link display-5 ml-3 pl-3" href="/ai"><b>AI Tools</b></a></h6>
                        </li>
                        <li class="nav-item mt-3">
                            <h6><a class="nav-link display-5 ml-3 pl-3" href="/access"><b>Accessibility</b></a></h6>
                        </li>
                        <li class="nav-item mt-3">
                            <h6><a class="nav-link display-5 ml-3 pl-3" href="/faq"><b>FAQ's</b></a></h6>
                        </li>
                        <li class="nav-item mt-3">
                            <h6><a class="nav-link display-5 ml-3 pl-3" href="/updates"><b>Updates</b></a></h6>
                        </li>
                        <li class="nav-item mt-3">
                            <h6><a class="nav-link display-5 ml-3 pl-3 pr-3" href="/support"><b>Donation</b></a></h6>
                        </li>
                        @guest
                        @if (Route::has('login'))
                        <li class="nav-item display-5  pl-3 mt-3">
                            <h6><a class=" nav-link" href="{{ route('login') }}"><b>{{ __('Login') }}</b></a></h6>
                        </li>
                        @endif
                        @if (Route::has('register'))
                        <li class="nav-item display-5  mt-3">
                            <h6><a class=" nav-link" href="{{ route('register') }}"><b>{{ __('Register') }}</b></a>
                            </h6>
                        </li>
                        @endif
                        @else
                        <li class="nav-item dropdown pl-3">
                            <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button"
                                data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                <i class=" bi bi-person-circle pr-2 " style="font-size: 1.8rem"></i>
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

        <main>
            @yield('content')
        </main>
    </div>

    <!-- Bootstrap JS and Popper.js (for Bootstrap 5.x) -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
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
</style>