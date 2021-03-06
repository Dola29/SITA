
<!DOCTYPE html>
<!--
This is a starter template page. Use this page to start your new project from
scratch. This page gets rid of all links and provides the needed markup only.
-->
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta http-equiv="x-ua-compatible" content="ie=edge">

  <title>{{ config('app.name', 'SITA') }}</title>

  <link rel="stylesheet" href="{{ asset('css/app.css') }}">

</head>
<body class="hold-transition sidebar-mini">
<div class="wrapper" id="app">

  <!-- Navbar -->
  <nav class="main-header navbar navbar-expand navbar-white navbar-light">
    <!-- Left navbar links -->
    <ul class="navbar-nav">
      <li class="nav-item">
        <a class="nav-link" data-widget="pushmenu" href="#"><i class="fas fa-bars"></i></a>
      </li>
      {{-- <li class="nav-item d-none d-sm-inline-block">
        <a href="index3.html" class="nav-link">Home</a>
      </li>
      <li class="nav-item d-none d-sm-inline-block">
        <a href="#" class="nav-link">Contact</a>
      </li> --}}
    </ul>

    {{-- <!-- SEARCH FORM -->
    <form class="form-inline ml-3">
      <div class="input-group input-group-sm">
        <input class="form-control form-control-navbar" type="search" placeholder="Search" aria-label="Search">
        <div class="input-group-append">
          <button class="btn btn-navbar" type="submit">
            <i class="fas fa-search"></i>
          </button>
        </div>
      </div>
    </form> --}}

    <!-- Right navbar links -->
    <ul class="navbar-nav ml-auto">
      {{-- <!-- Messages Dropdown Menu -->
      <li class="nav-item dropdown">
        <a class="nav-link" data-toggle="dropdown" href="#">
          <i class="far fa-comments"></i>
          <span class="badge badge-danger navbar-badge">3</span>
        </a>
        <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
          <a href="#" class="dropdown-item">
            <!-- Message Start -->
            <div class="media">
              <img src="dist/img/user1-128x128.jpg" alt="User Avatar" class="img-size-50 mr-3 img-circle">
              <div class="media-body">
                <h3 class="dropdown-item-title">
                  Brad Diesel
                  <span class="float-right text-sm text-danger"><i class="fas fa-star"></i></span>
                </h3>
                <p class="text-sm">Call me whenever you can...</p>
                <p class="text-sm text-muted"><i class="far fa-clock mr-1"></i> 4 Hours Ago</p>
              </div>
            </div>
            <!-- Message End -->
          </a>
          <div class="dropdown-divider"></div>
          <a href="#" class="dropdown-item">
            <!-- Message Start -->
            <div class="media">
              <img src="dist/img/user8-128x128.jpg" alt="User Avatar" class="img-size-50 img-circle mr-3">
              <div class="media-body">
                <h3 class="dropdown-item-title">
                  John Pierce
                  <span class="float-right text-sm text-muted"><i class="fas fa-star"></i></span>
                </h3>
                <p class="text-sm">I got your message bro</p>
                <p class="text-sm text-muted"><i class="far fa-clock mr-1"></i> 4 Hours Ago</p>
              </div>
            </div>
            <!-- Message End -->
          </a>
          <div class="dropdown-divider"></div>
          <a href="#" class="dropdown-item">
            <!-- Message Start -->
            <div class="media">
              <img src="dist/img/user3-128x128.jpg" alt="User Avatar" class="img-size-50 img-circle mr-3">
              <div class="media-body">
                <h3 class="dropdown-item-title">
                  Nora Silvester
                  <span class="float-right text-sm text-warning"><i class="fas fa-star"></i></span>
                </h3>
                <p class="text-sm">The subject goes here</p>
                <p class="text-sm text-muted"><i class="far fa-clock mr-1"></i> 4 Hours Ago</p>
              </div>
            </div>
            <!-- Message End -->
          </a>
          <div class="dropdown-divider"></div>
          <a href="#" class="dropdown-item dropdown-footer">See All Messages</a>
        </div>
      </li> --}}     
      <!-- Notifications Dropdown Menu -->
      
      {{-- <li class="nav-item">
        <a class="nav-link" data-widget="control-sidebar" data-slide="true" href="#"><i
            class="fas fa-th-large"></i></a>
      </li> --}}
      <b-dropdown id="dropdown-user-info"  variant="outline-primary" text="{{auth()->user()->name}}" class="m-md-2">
        <b-dropdown-item>
          <a class="nav-link" href="{{ route('logout') }}" 
                onclick="event.preventDefault();
                document.getElementById('logout-form').submit();"
               {{ __('Logout') }}> logout
            <i class="fas fa-sign-out-alt"></i>
          </a>
          <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
              @csrf
          </form>
        </b-dropdown-item> 
      </b-dropdown>
    </ul>
  </nav>
  <!-- /.navbar -->

  <!-- Main Sidebar Container -->
  <aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="#" class="brand-link">
      <img src="./img/logo.jpg" alt="SITA" class="brand-image img-circle elevation-3"style="opacity: .8">
      <span class="brand-text font-weight-light">SITA</span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
      <!-- Sidebar user panel (optional) -->
      <div class="user-panel mt-3 pb-3 mb-3 d-flex">
        <div class="image">
          <img src="./img/user.png" class="img-circle elevation-2" alt="User Image">
        </div>
        <div class="info">
          <a href="#" class="d-block">{{ Auth::user()->name }}</a>
        </div>
      </div>

      <!-- Sidebar Menu -->
      <nav class="mt-2">
        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
          <!-- Add icons to the links using the .nav-icon class
               with font-awesome or any other icon font library -->
          {{-- <li class="nav-item has-treeview menu-open">
            <a href="#" class="nav-link active">
              <i class="nav-icon fas fa-tachometer-alt"></i>
              <p>
                Starter Pages
                <i class="right fas fa-angle-left"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="#" class="nav-link active">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Active Page</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="#" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Inactive Page</p>
                </a>
              </li>
            </ul>
          </li> --}}
          {{-- <li class="nav-item">
            <router-link to="/home" class="nav-link" active-class="active">
              <i class="nav-icon fas fa-th"  aria-hidden="true"></i>
              <p>
                Dashboard
               
              </p>
            </router-link>
          </li> --}}
          {{-- <li class="nav-item has-treeview">
            <a href="#" class="nav-link">
              <i class="nav-icon fas fa-chart-line"></i>
              <p>
                Reportes                
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <router-link to="/reporte-inventario" class="nav-link" active-class="active">
                  <i class="nav-icon fas fa-arrow-right"  aria-hidden="true"></i>
                  <p>
                    Reporte de Inventario
                  </p>
                </router-link>
              </li>
            </ul>
          </li>   --}}
          <li class="nav-item">
            <router-link to="/trabajo" class="nav-link" active-class="active">
              <i class="nav-icon fas fa-pencil-ruler"  aria-hidden="true"></i>
              <p>
                Trabajos Academicos
              </p>
            </router-link>
          </li> 
          <li class="nav-item">
            <router-link to="/sustentante" class="nav-link" active-class="active">
              <i class="nav-icon fas fa-user-graduate"  aria-hidden="true"></i>
              <p>
                Sustentates
              </p>
            </router-link>
          </li> 
          <li class="nav-item">
            <router-link to="/asesor" class="nav-link" active-class="active">
              <i class="nav-icon fas fa-user"  aria-hidden="true"></i>
              <p>
                Asesores
              </p>
            </router-link>
          </li>      
          @if(auth()->user()->is_admin == 'si')
          <li class="nav-item has-treeview">
            <a href="#" class="nav-link">
              <i class="nav-icon fas fa-cogs"></i>
              <p>
                Configuracion                
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <router-link to="/facultad" class="nav-link" active-class="active">
                  <i class="nav-icon fas fa-landmark"  aria-hidden="true"></i>
                  <p>
                    Facultad
                  </p>
                </router-link>
              </li>                  
              <li class="nav-item">
                <router-link to="/escuela" class="nav-link" active-class="active">
                  <i class="nav-icon  fas fa-building" aria-hidden="true"></i>
                  <p>
                    Escuela
                  </p>
                </router-link>
              </li>
              <li class="nav-item">
                <router-link to="/carrera" class="nav-link" active-class="active">
                  <i class="nav-icon  fas fa-graduation-cap" aria-hidden="true"></i>
                  <p>
                    Carreras
                  </p>
                </router-link>
              </li>
              <li class="nav-item">
                <router-link to="/recinto" class="nav-link" active-class="active">
                  <i class="nav-icon  fas fa-building" aria-hidden="true"></i>
                  <p>
                    Recintos
                  </p>
                </router-link>
              </li>
              <li class="nav-item">
                <router-link to="/ubicacion" class="nav-link" active-class="active">
                  <i class="nav-icon  fas fa-map-marker-alt" aria-hidden="true"></i>
                  <p>
                    Ubicaciones
                  </p>
                </router-link>
              </li>   
              <li class="nav-item">
                <router-link to="/usuario" class="nav-link" active-class="active">
                  <i class="nav-icon  fas fa-users" aria-hidden="true"></i>
                  <p>
                    Usuarios
                  </p>
                </router-link>
              </li>           
            </ul>
          </li> 
          @endif 
          
          
        </ul>
      </nav>
      <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
  </aside>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    {{-- <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0 text-dark">Starter Page</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active">Starter Page</li>
            </ol>
          </div><!-- /.col -->
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header --> --}}

    <!-- Main content -->
    <div class="content">
      <div class="container-fluid">
        <div class="row">
            <router-view></router-view>
        </div>
        <!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->

  <!-- Control Sidebar -->
  <aside class="control-sidebar control-sidebar-dark">
    <!-- Control sidebar content goes here -->
    <div class="p-3">
      <h5>Title</h5>
      <p>Sidebar content</p>
    </div>
  </aside>
  <!-- /.control-sidebar -->

  <!-- Main Footer -->
  <footer class="main-footer">
    <!-- To the right -->
    <div class="float-right d-none d-sm-inline">
      <strong>SITA</strong>
    </div>
    <!-- Default to the left -->
    <strong>Copyright &copy; <?=date('y')?> <a href="">Daniel Leal</a>.</strong> All rights reserved.
  </footer>
</div>
<!-- ./wrapper -->

@auth
  <script>
    window.user = @json(auth()->user());
  </script>  
@endauth

<!-- REQUIRED SCRIPTS -->
<script src="/js/app.js"></script>
</body>
</html>
