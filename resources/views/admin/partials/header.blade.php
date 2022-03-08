
  <!-- Navbar -->
  <nav class="main-header navbar navbar-expand navbar-white navbar-light">
    <!-- Left navbar links -->
    <ul class="navbar-nav">
      <li class="nav-item">
      <a class="nav-link" data-widget="pushmenu" href="{{ route('admin.dashboard') }}" role="button"><i class="fas fa-bars"></i></a>
      </li>
      <!--<li class="nav-item d-none d-sm-inline-block">
      <a href="index3.html" class="nav-link">Home</a>
      </li>
      <li class="nav-item d-none d-sm-inline-block">
      <a href="#" class="nav-link">Contact</a>
      </li>-->
    </ul>
  
    <!-- SEARCH FORM -->
    <form class="form-inline ml-3">
      <div class="input-group input-group-sm">
      <input class="form-control form-control-navbar" type="search" placeholder="Search" aria-label="Search">
      <div class="input-group-append">
        <button class="btn btn-navbar" type="submit">
        <i class="fas fa-search"></i>
        </button>
      </div>
      </div>
    </form>
  
    <!-- Right navbar links -->
    <ul class="navbar-nav ml-auto">
      
      <!-- Notifications Dropdown Menu -->
      <li class="nav-item dropdown">
      <a class="nav-link" data-toggle="dropdown" href="{{ route('admin.dashboard') }}">
        <i class="far fa-bell"></i>
        <span class="badge badge-warning navbar-badge">1</span>
      </a>
      <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
        <span class="dropdown-item dropdown-header">1 Notifications</span>
        <div class="dropdown-divider"></div>
        <a href="#" class="dropdown-item">
        <i class="fas fa-envelope mr-2"></i> 4 new messages
        <span class="float-right text-muted text-sm">3 mins</span>
        </a>
        <div class="dropdown-divider"></div>
        <a href="#" class="dropdown-item dropdown-footer">See All Notifications</a>
      </div>
      </li>
      
      <!-- Settings Dropdown Menu -->
      <li class="nav-item dropdown">
      <a class="nav-link" data-toggle="dropdown" href="#">
        <i class="far fa-user"></i>
      </a>
      <div class="dropdown-menu dropdown-menu-sm dropdown-menu-right">
        <a href="{{ route('admin.users.profile') }}" class="dropdown-item"><i class="fa fa-user"></i>&nbsp; My Profile</a>
        <a class="dropdown-item" href="{{ route('admin.logout') }}"><i class="fa fa-power-off"></i>&nbsp; Logout</a>
      </div>
      </li>
      
      <li class="nav-item dropdown">
      <a class="nav-link" data-toggle="dropdown" href="#">
        <i class=""></i>
      </a>
      <div class="dropdown-menu dropdown-menu-sm dropdown-menu-right">
        <a href="#" class="dropdown-item"><i class=""></i></a>
       </div>
      </li>
      
      <!--<li class="nav-item">
      <a class="nav-link" data-widget="control-sidebar" data-slide="true" href="#" role="button"><i
        class="fas fa-th-large"></i></a>
      </li>-->
    </ul>
    </nav>
    <!-- /.navbar -->
  