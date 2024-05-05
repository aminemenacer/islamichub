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
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/admin-lte@3.2/dist/css/adminlte.min.css">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

    <link rel="stylesheet" type="text/css" href="/css/stylesheet.css?v=1" />

    <!-- resources/views/layouts/app.blade.php -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <link rel="icon" href="{{ asset('images/favicon.ico') }}">

    <script src="{{ asset('js/app.js') }}" defer></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/admin-lte@3.2/dist/js/adminlte.min.js"></script>
    <script>
        var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
        var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
          return new bootstrap.Tooltip(tooltipTriggerEl)
        });
      </script>
</head>

<body>
    <div>
        <nav class="navbar navbar-expand-md navbar-light bg-white shadow-sm">
            <div class="container-fluid">
                <a class="navbar-brand" href="{{ url('/') }}">
                    <img src="/images/logo_main.png" width="275" height="54" class="d-inline-block align-top" alt="">
                </a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent"
                    aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
                    <span class="navbar-toggler-icon"></span>
                </button>
        
                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <!-- Left Side Of Navbar -->
                    <ul class="navbar-nav justify-content-end mt-2 pr-4 flex-grow-1">
                        <li class="nav-item mt-2">
                            <h5><a style="font-family:inter; color: black;" class="nav-link ml-4 pl-3" href="/quran">Home
                            </a></h5>
                        </li>
                        <li class="nav-item mt-2">
                            <h5><a style="font-family:inter; color: black;" class="nav-link ml-4 pl-3" href="/quran">Quran</a></h5>
                        </li>
                        <!-- <li class="nav-item mt-2">
                            <h5><a style="font-family:inter; color: black;" class="nav-link ml-4 pl-3" href="/ahadith">Ahadith</a></h5>
                        </li> -->
                        <li class="nav-item mt-2">
                            <h5><a style="font-family:inter; color: black;" class="nav-link ml-4 pl-3" href="/contact">Contact</a></h5>
                        </li>
                        <li class="nav-item mt-2">
                            <h5><a style="font-family:inter; color: black;" class="nav-link ml-4 pl-3" href="/about">About Us</a></h5>
                        </li>
                        <li class="nav-item mt-2">
                            <h5><a style="font-family:inter; color: black;" class="nav-link ml-4 pl-3" href="/updates">Updates</a></h5>
                        </li>
                        <li class="nav-item mt-2">
                            <h5><a style="font-family:inter; color: black;" class="nav-link ml-4 pl-3 pr-5" href="/join_us">Mailing List</a></h5>
                        </li>
                        
                        <!-- Right Side Of Navbar -->
                         @guest
                        @if (Route::has('login'))
                        <li class="nav-item mt-2">
                            <h5><a style="font-family:inter;" class="nav-link" href="{{ route('login') }}">{{ __('Login') }}</a></h5>
                        </li>
                        @endif
                        @if (Route::has('register'))
                        <li class="nav-item mt-2">
                            <h5><a style="font-family:inter;" class="nav-link" href="{{ route('register') }}">{{ __('Register') }}</a></h5>
                        </li>
                        @endif
                        @else
                        <li class="nav-item dropdown mt-1 ml-5">
                            <a id="navbarDropdown" class="nav-link dropdown-toggle mb-1" href="#" role="button"
                                data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                {{-- {{ Auth::user()->name }} --}}
                                <i class="bi bi-person-circle" style="font-size: 1.8rem"></i>
                            </a>
                            <div class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                                <a class="dropdown-item" href="/dashboard">Dashboard</a>
                                <a class="dropdown-item" href="/bookmarks">Bookmarks</a>
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
                        <li class="nav-item mt-2 pl-4 mb-1">
                            <button class="button-33">Support Us</button>
                        </li>
                    </ul>
                </div>
            </div>
        </nav>
        



        <main class="py-4">
            @yield('content')
        </main>
    </div>
</body>

</html>

<style>
.button-33 {
 background-color: #00BFA6;
 border-radius: 10px;
 color: white;
 cursor: pointer;
 display: inline-block;
 font-family: CerebriSans-Regular, -apple-system, system-ui, Roboto,sans-serif;
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