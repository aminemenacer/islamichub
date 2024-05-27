<aside id="tablet-sidebar" class="main-sidebar sidebar-light-primary elevation-4" style="left:0px; height: 100vh;">
 <div class="sidebar">
  <nav class="mt-2">
   <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
    @if(auth()->user()->role === 'admin')
    <!-- Admin Dashboard -->
    <li class="nav-item">
     <a href="/dashboard" class="nav-link">
      <i class="bi bi-speedometer mr-1"></i>
      <p class="mr-2">Dashboard</p>
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
     <a class="nav-link" href="{{ route('logout') }}"
      onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
      <i class="bi bi-plug-fill" style="font-size: 22px"></i>
      <p class="mb-2">{{ __('Logout') }}</p>
     </a>
     <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
      @csrf
     </form>
    </li>
    <!-- Other admin links -->
    @endif

    @if(auth()->user()->role === 'user')
    <!-- User Dashboard -->
    <li class="nav-item">
     <a href="/home" class="nav-link">
      <i class="bi bi-house-fill mr-3"></i>
      <p>Home</p>
     </a>
    </li>
    <li class="nav-item">
     <a href="/bookmarks" class="nav-link">
      <i class="bi bi-bookmark-fill mr-3"></i>
      <p>Bookmarks</p>
     </a>
    </li>
    <li class="nav-item">
     <a href="/notes" class="nav-link">
      <i class="bi bi-file-earmark-text-fill mr-3"></i>
      <p>Notes</p>
     </a>
    </li>
    <li class="nav-item">
     <a href="/profile" class="nav-link">
      <i class="bi bi-person-circle mr-3"></i>
      <p>Profile</p>
     </a>
    </li>
    <!-- Other user links -->
    @endif

   </ul>
  </nav>
 </div>
</aside>