<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="icon" type="image/x-icon" href="{{asset('/images/bus.png')}}">
  <title>Admin | Dashboard 3</title>

  <!-- Google Font: Source Sans Pro -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <!-- Font Awesome Icons -->
  <link rel="stylesheet" href="{{asset('plugins/fontawesome-free/css/all.min.css')}}">
  <!-- IonIcons -->
  <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="{{asset('css/adminlte.min.css')}}">
  {{-- <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script> --}}
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.js"></script>
  <link rel="stylesheet" href="https://cdn.datatables.net/1.12.1/css/jquery.dataTables.min.css">
</head>
<!--
`body` tag options:

  Apply one or more of the following classes to to the body tag
  to get the desired effect

  * sidebar-collapse
  * sidebar-mini
-->
<body class="hold-transition sidebar-mini">
<div class="wrapper">
  <!-- Navbar -->
  <nav class="main-header navbar navbar-expand navbar-white navbar-light">
    <!-- Left navbar links -->
    <ul class="navbar-nav">
      <li class="nav-item">
        <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
      </li>
      {{-- <li class="nav-item d-none d-sm-inline-block">
        <a href="index3.html" class="nav-link">Home</a>
      </li>
      <li class="nav-item d-none d-sm-inline-block">
        <a href="#" class="nav-link">Contact</a>
      </li> --}}
    </ul>
    <ul class="navbar-nav ml-auto">
      <li class="nav-item">
        <a class="nav-link"  href="{{route('logout')}}" >
          <i class="fas fa-user"></i> Log out
        </a>
      </li>
    </ul>
  </nav>
  <!-- Main Sidebar Container -->
  <aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="{{ route('dashboard') }}" class="brand-link">
      <img src="{{asset('/images/bus.png')}}" alt="AdminLTE Logo" class="brand-image img-circle elevation-3" style="opacity: .8">
      <span class="brand-text font-weight-light">Admin Dashboard</span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
      <!-- Sidebar Menu -->
      <nav class="mt-2">
        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">

          <li class="nav-header">Bus Booking System</li>

          <li class="nav-item">
            <a href="{{ url('agents') }}" class="nav-link">
              <i class="nav-icon fas fa-users fa-lg "></i>
              <p>
                Agents
              </p>
            </a>
          </li>

          <li class="nav-item">
            <a href="{{ url('agent/bank') }}" class="nav-link">
              <i class="nav-icon fas fa-users fa-lg "></i>
              <p>
                Agent Bank Details
              </p>
            </a>
          </li>
          {{-- <li class="nav-item">
            <a href="{{ url('users') }}" class="nav-link">
              <i class="nav-icon fas fa-columns"></i>
              <p>
                  Users
              </p>
            </a>
          </li> --}}
          <li class="nav-item">
            <a href="{{ url('bus') }}" class="nav-link">
              <i class="nav-icon fas fa-bus fa-2x"></i>
              <p>
                  Buses
              </p>
            </a>
          </li>
          <li class="nav-item">
            <a href="{{ url('city') }}" class="nav-link">
              <i class="nav-icon fas fa-city fa-lg"></i>
              <p>
                  Cities
              </p>
            </a>
          </li>
          <li class="nav-item">
            <a href="{{ url('confirmed-seat') }}" class="nav-link">
              <i class="fas fa-luggage-cart fa-lg"></i>
              <p>
                  Booking List
              </p>
            </a>
          </li>
          <li class="nav-item">
            <a href="{{ url('payment') }}" class="nav-link">
              <i class="fas fa-money-check-alt fa-lg"></i>
              <p>
                  Payment
              </p>
            </a>
          </li>
          <li class="nav-item">
            <a href="{{ url('policy') }}" class="nav-link">
              <i class="fas fa-cog fa-lg"></i>
              <p>
                  Settings
              </p>
            </a>
          </li>
          {{-- <li class="nav-item">
            <a href="{{ url('date-price') }}" class="nav-link">
              <i class="nav-icon fas fa-columns"></i>
              <p>
                  Date Price
              </p>
            </a>
          </li> --}}
          {{-- <li class="nav-item">
            <a href="{{ url('drop-point') }}" class="nav-link">
              <i class="nav-icon fas fa-columns"></i>
              <p>
                  Drop Point
              </p>
            </a>
          </li> --}}
          {{-- <li class="nav-item">
            <a href="{{ url('payment') }}" class="nav-link">
              <i class="nav-icon fas fa-columns"></i>
              <p>
                  Payment
              </p>
            </a>
          </li> --}}
          {{-- <li class="nav-item">
            <a href="{{ url('route') }}" class="nav-link">
              <i class="nav-icon fas fa-columns"></i>
              <p>
                  Route
              </p>
            </a>
          </li> --}}
          {{-- <li class="nav-item">
            <a href="{{ url('seat') }}" class="nav-link">
              <i class="nav-icon fas fa-columns"></i>
              <p>
                  Seat
              </p>
            </a>
          </li> --}}
        </ul>
      </nav>
      <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
  </aside>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0">Dashboard</h1>
          </div><!-- /.col -->
          {{-- <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active">Dashboard</li>
            </ol>
          </div> --}}
          <!-- /.col -->
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->
    @if (session('success'))
    <div class="alert alert-success mx-5">
        {{ session('success') }}
    </div>
    @endif
    @if (session('error'))
    <div class="alert alert-danger mx-5">
        {{ session('error') }}
    </div>
    @endif
    <main class="px-4">
        @yield('content')
    </main>

</div>
<!-- ./wrapper -->

<!-- REQUIRED SCRIPTS -->

<!-- jQuery -->
<script>
  $(document).ready(function(){
    setTimeout(function() {
      $('.alert').fadeOut('fast');
    }, 3000);
  });
</script>
{{-- <script src="{{asset('/jquery/jquery.min.js')}}"></script>  --}}
<!-- Bootstrap -->
<script src="{{ asset('bootstrap/js/bootstrap.bundle.min.js') }}"></script>
<!-- AdminLTE -->
<script src="{{ asset('/js/adminlte.js') }}"></script>

<!-- OPTIONAL SCRIPTS -->
<script src="{{ asset('/chart.js/Chart.min.js') }}"></script>
<!-- AdminLTE for demo purposes -->
<script src="{{ asset('/js/demo.js') }}"></script>
<!-- AdminLTE dashboard demo (This is only for demo purposes) -->
<script src="{{ asset('/js/pages/dashboard3.js') }}"></script>
<script src="{{ asset('js/app.js') }}"></script>
<script src="https://cdn.datatables.net/1.12.1/js/jquery.dataTables.min.js"></script>
    <script src="{{ asset('vendor/datatables/buttons.server-side.js') }}"></script>
       @stack('scripts')
</body>
</html>
