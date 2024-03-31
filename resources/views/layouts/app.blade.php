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
        <nav class="navbar navbar-expand-md navbar-light bg-white shadow-sm ">
            <div class="container-fluid">
                <a class="navbar-brand" href="{{ url('/') }}">
                    <img src="/images/logo11.png" width="275" height="54" class="d-inline-block align-top" alt="">
                </a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
                    data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent"
                    aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <!-- Left Side Of Navbar -->
                    <ul class="navbar-nav justify-content-end mt-2 pr-4 flex-grow-1 ">
                        <li class="nav-item mt-1">
                            <h5><a style="font-family:inter" class="nav-link ml-4 pl-3" style="color: black;"
                                    href="/quran">Quran</a></h5>
                        </li>
                        <li class="nav-item mt-1">
                            <h5><a style="font-family:inter" class="nav-link ml-4 pl-3" style="color: black;"
                                    href="/ahadith">Ahadith</a></h5>
                        </li>
                    
                        <li class="nav-item mt-1">
                            <h5><a style="font-family:inter" class="nav-link ml-4 pl-3" style="color: black;"
                                    href="/contact">Contact</a></h5>
                        </li>
    
                        <li class="nav-item mt-1">
                            <h5><a style="font-family:inter" class="nav-link ml-4 pl-3 pr-5" style="color: black;"
                                    href="/about">About Us</a></h5>
                        </li>

                        <li class="nav-item pr-2 mb-1">
                            <a href="/charity" type="button" class="btn btn-success btn-lg" style="font-family:inter">Support Us</a>
                        </li>
                        
                        
                        <!-- Right Side Of Navbar -->
                        
                            @guest
                            @if (Route::has('login'))
                            <li class="nav-item mt-1">
                                <h5><a style="font-family:inter" class="nav-link" href="{{ route('login') }}">{{ __('Login') }}</a></h5>
                            </li>
                            @endif

                            @if (Route::has('register'))
                            <li class="nav-item mt-1">
                                <h5><a style="font-family:inter" class="nav-link" href="{{ route('register') }}">{{ __('Register') }}</a></h5>
                            </li>
                           
                            @endif
                            @else
                            <li class="nav-item dropdown mt-1 ml-5">
                                <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button"
                                    data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                    {{ Auth::user()->name }}
                                </a>

                                <div class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                                    <a class="dropdown-item" style="color: black;" href="/dashboard">Dashboard</a>

                                    <a class="dropdown-item" href="{{ route('logout') }}" onclick="event.preventDefault();
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
            </div>
        </nav>



        <main class="py-4">
            @yield('content')
        </main>
    </div>
</body>

</html>

<style>
.donate {
    font-weight:300;
    background-color: #c3e6cb;
    border-radius: 10px;
    color: darkgreen;
    cursor: pointer;
    display: inline-block;
    font-family:serif;
    padding: 7px 20px;
    text-align: center;
    text-decoration: none;
    border: 0;
    font-size: 18px;
    user-select: none;
    -webkit-user-select: none;
    touch-action: manipulation;
}
</style>