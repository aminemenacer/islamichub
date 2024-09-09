<!DOCTYPE html>
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

    <!-- Admin LTE CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/admin-lte@3.2/dist/css/adminlte.min.css">

    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

  
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">

    <link href="{{ asset('css/app.css') }}" rel="stylesheet">

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
        <nav class="navbar navbar-expand-md navbar-light bg-white shadow-sm py-1">
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
                        <li class="nav-item mt-3">
                            <h6><a style="color: black;" class="nav-link ml-3 pl-3" href="/quran"><b>Home</b></a></h6>
                        </li>
                        <li class="nav-item mt-3">
                            <h6><a style="color: black;" class="nav-link ml-3 pl-3" href="/contact"><b>Contact</b></a></h6>
                        </li>
                        <li class="nav-item mt-3">
                            <h6><a style="color: black;" class="nav-link ml-3 pl-3" href="/about"><b>About Us</b></a></h6>
                        </li>
                        <li class="nav-item mt-3">
                            <h6><a style="color: black;" class="nav-link ml-3 pl-3" href="/faq"><b>FAQ's</b></a></h6>
                        </li>
                        <li class="nav-item mt-3">
                            <h6><a style="color: black;" class="nav-link ml-3 pl-3" href="/join_us"><b>Mailing List</b></a></h6>
                        </li>
                        <li class="nav-item mt-3">
                            <h6><a style="color: black;" class="nav-link ml-3 pl-3" href="/pricing"><b>Pricings</b></a></h6>
                        </li>
                        <li class="nav-item mt-3">
                            <h6><a style="color: black;" class="nav-link ml-3 pl-3" href="/updates"><b>Updates</b></a></h6>
                        </li>
                        <li class="nav-item mt-3">
                            <h6><a style="color: black;" class="nav-link ml-3 pl-3" href="/group_notes"><b>The Board</b></a></h6>
                        </li>
                        @guest
                        @if (Route::has('login'))
                        <li class="nav-item pl-3 mt-3">
                            <h6><a class="nav-link" href="{{ route('login') }}"><b>{{ __('Login') }}</b></a></h6>
                        </li>
                        @endif
                        @if (Route::has('register'))
                        <li class="nav-item pl-3 mt-3">
                            <h6><a class="nav-link" href="{{ route('register') }}"><b>{{ __('Register') }}</b></a></h6>
                        </li>
                        @endif
                        @else
                        <li class="nav-item dropdown pl-3">
                            <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button"
                                data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                <i class="bi bi-person-circle pr-2 " style="font-size: 1.8rem"></i>
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
                        <li class="nav-item mt-2 pl-4">
                            <button class="button-63" style="padding: 12px">
                                <a style="text-decoration: none;color:white"
                                href="https://www.gofundme.com/f/empowerment-through-quran-support-islamic-connects-mission">
                                <strong>Donate Here</strong>
                                </a>
                            </button>
                        </li>
                    </ul>
                </div>
            </div>
        </nav>

        <main>
            @yield('content')
        </main>
    </div>

    <!-- Bootstrap JavaScript -->
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.min.js" integrity="sha384-0pUGZvbkm6XF6gxjEnlmuGrJXVbNuzT9qBBavbLwCsOGabYfZo0T0to5eqruptLy" crossorigin="anonymous"></script>
    <!-- Your application's JavaScript -->
    <script src="{{ mix('js/app.js') }}"></script>
</body>
</html>

<!-- Custom Styles -->
<style>
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
