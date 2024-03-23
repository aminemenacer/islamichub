<!DOCTYPE html>

<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Islamic connect</title>
  <link rel="stylesheet" href="/css/app.css">

<body class="hold-transition sidebar-mini">
  <div class="wrapper" id="app">

    <nav class="main-header  navbar navbar-expand navbar-white navbar-light">

      <ul class="navbar-nav mt-2 mr-5 mx-auto">
        <li class="nav-item">
          <h5><a style="font-family:inter" class="nav-link ml-4 pl-3" style="color: grey;" href="/quran">Quran</a></h5>
        </li>
        <li class="nav-item">
          <h5><a style="font-family:inter" class="nav-link ml-4 pl-3" style="color: grey;" href="/ahadith">Ahadith</a>
          </h5>
        </li>
        <li class="nav-item">
          <h5><a style="font-family:inter" class="nav-link ml-4 pl-3" style="color: grey;" href="/charity">Donations</a>
          </h5>
        </li>
        <li class="nav-item">
          <h5><a style="font-family:inter" class="nav-link ml-4 pl-3" style="color: grey;" href="/contact">Contact
              Us</a></h5>
        </li>
        <ul class="navbar-nav ml-auto mt-1 pl-5 mr-4">
                            
          @guest
          @if (Route::has('login'))
          <li class="nav-item">
              <h5><a style="font-family:inter" class="nav-link" href="{{ route('login') }}">{{ __('Login') }}</a></h5>
          </li>
          @endif

          @if (Route::has('register'))
          <li class="nav-item">
              <h5><a style="font-family:inter" class="nav-link" href="{{ route('register') }}">{{ __('Register') }}</a></h5>
          </li>
          @endif
          @else
          <li class="nav-item dropdown ml-5">
              <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button"
                  data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                  {{ Auth::user()->name }}
              </a>

              <div class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
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

    </nav>


    <aside class="main-sidebar sidebar-light-primary elevation-4">

      <a href="/" class="brand-link">
        <img src="/images/logo11.png" width="220" height="58" alt="">
      </a>

      <div class="sidebar">

        <nav class="mt-2">
          <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">

            <li class="nav-item">
              <a href="/dashboard" class="nav-link">
                <i class="nav-icon fas fa-th"></i>
                <p>
                  Dashboard
                </p>
              </a>
            </li>
            <li class="nav-item">
              <a href="/users" class="nav-link">
                <i class="nav-icon fas fa-th"></i>
                <p>
                  Users
                </p>
              </a>
            </li>
            <li class="nav-item">
              <a href="/feedback" class="nav-link">
                <i class="nav-icon fas fa-th"></i>
                <p>
                  Feedback
                </p>
              </a>
            </li>
            <li class="nav-item">
              <a href="/payments" class="nav-link">
                <i class="nav-icon fas fa-th"></i>
                <p>
                  Donations
                </p>
              </a>
            </li>
            <li class="nav-item">
              <a href="/mailing_list" class="nav-link">
                <i class="nav-icon fas fa-th"></i>
                <p>
                  Mailing List
                </p>
              </a>
            </li>
            <li class="nav-item">
              <a href="/correction" class="nav-link">
                <i class="nav-icon fas fa-th"></i>
                <p>
                  Correction
                </p>
              </a>
            </li>
           
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

</body>

</html>