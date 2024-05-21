<!DOCTYPE html>

<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Islamic Connect</title>
  <link rel="stylesheet" href="/css/app.css">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/5.3.0/css/bootstrap.min.css">
</head>

<body class="hold-transition sidebar-mini">
  <div class="wrapper" id="app">

    <nav class="navbar navbar-expand-md navbar-light bg-white shadow-sm">
      <div class="container-fluid">
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
          <!-- Left Side Of Navbar -->
          <ul class="navbar-nav justify-content-end pr-4 flex-grow-1">
            <li class="nav-item">
              <h5><a style="font-family:inter; color: black;" class="nav-link mt-3 ml-4 pl-3" href="/quran">Home</a></h5>
            </li>
            <li class="nav-item">
              <h5><a style="font-family:inter; color: black;" class="nav-link mt-3 ml-4 pl-3" href="/contact">Contact</a></h5>
            </li>
            <li class="nav-item">
              <h5><a style="font-family:inter; color: black;" class="nav-link mt-3 ml-4 pl-3" href="/about">About Us</a></h5>
            </li>
            <li class="nav-item">
              <h5><a style="font-family:inter; color: black;" class="nav-link mt-3 ml-4 pl-3" href="/updates">Updates</a></h5>
            </li>
            <li class="nav-item">
              <h5><a style="font-family:inter; color: black;" class="nav-link mt-3 ml-4 pl-3 pr-5" href="/join_us">Mailing List</a></h5>
            </li>

            
            @guest
              @if (Route::has('login'))
              <li class="nav-item mt-1">
                <h5><a style="font-family:inter;" class="nav-link" href="{{ route('login') }}">{{ __('Login') }}</a></h5>
              </li>
              @endif
              @if (Route::has('register'))
              <li class="nav-item mt-1">
                <h5><a style="font-family:inter;" class="nav-link" href="{{ route('register') }}">{{ __('Register') }}</a></h5>
              </li>
              @endif
            @else
            <li class="nav-item dropdown mt-1 ml-5">
              <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                <i class="bi bi-person-circle mr-2 mt-1" style="font-size: 1.8rem"></i>
                {{ Auth::user()->name }}
              </a>
              <div class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                <a class="dropdown-item" href="/dashboard">Dashboard</a>
                <a class="dropdown-item" href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
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

    <aside id="tablet-sidebar" class="main-sidebar sidebar-light-primary elevation-4">
      <a href="/" class="brand-link">
        <img src="/images/logo_main.png" width="220" height="45" alt="">
      </a>
      <div class="sidebar">
        <nav class="mt-2">
          <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
            <!-- admin dashboard -->
            @if(auth()->user()->role === 'admin')
            <li class="nav-item">
              <a href="/dashboard" class="nav-link">
                <i class="bi bi-speedometer mr-1"></i>
                <p>Dashboard</p>
              </a>
            </li>
            <li class="nav-item">
              <a href="/users" class="nav-link">
                <i class="bi bi-people-fill mr-1"></i>
                <p>Users</p>
              </a>
            </li>
            <li class="nav-item">
              <a href="/feedback" class="nav-link">
                <i class="bi bi-chat-left-text-fill mr-1"></i>
                <p>Feedback</p>
              </a>
            </li>
            <li class="nav-item">
              <a href="/payments" class="nav-link">
                <i class="bi bi-currency-exchange mr-1"></i>
                <p>Donations</p>
              </a>
            </li>
            <li class="nav-item">
              <a href="/mailing_list" class="nav-link">
                <i class="bi bi-envelope-at-fill mr-1"></i>
                <p>Mailing List</p>
              </a>
            </li>
            <li class="nav-item">
              <a href="/profile" class="nav-link">
                <i class="bi bi-people-fill mr-1"></i>
                <p>Profile</p>
              </a>
            </li>
            <li class="nav-item">
              <a href="/correction" class="nav-link">
                <i class="bi bi-bug-fill mr-1"></i>
                <p>Correction</p>
              </a>
            </li>
            <li class="nav-item">
              <a href="/bookmarks" class="nav-link">
                <i class="bi bi-bookmark-dash-fill mr-1"></i>
                <p>Bookmarks</p>
              </a>
            </li>
            <li class="nav-item">
              <a href="/notes" class="nav-link">
                <i class="bi bi-file-earmark-text-fill mr-1"></i>
                <p>Notes</p>
              </a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                <i class="bi bi-plug-fill" style="font-size: 22px"></i>
                <p class="mb-2">{{ __('Logout') }}</p>
              </a>
              <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                @csrf
              </form>
            </li>
            @endif
            
            <!-- user dashboard -->
            @if(auth()->user()->role === 'user')
            
            <li class="nav-item">
              <a href="/bookmarks" class="nav-link">
                <i class="bi bi-bookmark-dash-fill mr-1"></i>
                <p>Bookmarks</p>
              </a>
            </li>
            <li class="nav-item">
              <a href="/notes" class="nav-link">
                <i class="bi bi-file-earmark-text-fill mr-1"></i>
                <p>Notes</p>
              </a>
            </li>
            <li class="nav-item">
              <a href="/profile" class="nav-link">
                <i class="bi bi-people-fill mr-1"></i>
                <p>Profile</p>
              </a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                <i class="bi bi-plug-fill" style="font-size: 22px"></i>
                <p class="mb-2">{{ __('Logout') }}</p>
              </a>
              <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                @csrf
              </form>
            </li>
            @endif
          </ul>
        </nav>
      </div>
    </aside>

    <div class="content-wrapper">
      <!-- Main content -->
      <div class="content">
        <div class="container-fluid">
          @yield('content')
        </div><!-- /.container-fluid -->
      </div>
    </div>
  </div>

  <script src="/js/app.js"></script>
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/5.3.0/js/bootstrap.min.js"></script>

</body>

<style>
  /* Hide sidebar on tablet screen sizes */
  @media (min-width: 768px) and (max-width: 1024px) and (max-width: 575px) {
    #tablet-sidebar {
      display: none;
    }
  }
</style>

</html>
