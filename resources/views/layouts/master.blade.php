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

      <ul class="navbar-nav mt-2 mr-5 mr-auto">
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
      </ul>

    </nav>


    <aside class="main-sidebar sidebar-light-primary elevation-4">

      <a href="/" class="brand-link">
        <img src="/images/logo1.png" width="220" height="58" alt="">
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
            <li class="nav-item">
              <a href="/login" class="nav-link">
                <i class="nav-icon fas fa-th"></i>
                <p>
                  Logout
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