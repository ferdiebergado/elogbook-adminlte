<!DOCTYPE html>

<html lang="{{ app()->getLocale() }}">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }} @yield('title')</title>

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
    <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
<![endif]-->

<!-- Styles -->
<link href="{{ mix('css/app.css') }}" rel="stylesheet">
@stack('styles')

</head>

<body class="hold-transition skin-blue sidebar-mini">

    <div id="app">

        <!-- Site wrapper -->
        <div class="wrapper">

          <header class="main-header">

            <!-- Logo -->
            <a href="/" class="logo">
                <!-- mini logo for sidebar mini 50x50 pixels -->
                <span class="logo-mini"><b>e</b>LB</span>
                <!-- logo for regular state and mobile devices -->
                <span class="logo-lg"><b>{{ config('app.name') }}</b></span>
            </a>            
            <!-- Header Navbar: style can be found in header.less -->
            <nav class="navbar navbar-static-top">
              <!-- Sidebar toggle button-->
              <a href="#" class="sidebar-toggle" data-toggle="push-menu" role="button">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </a>

            <div class="navbar-custom-menu">
                <ul class="nav navbar-nav">

                    @auth

                    <!-- User Account: style can be found in dropdown.less -->
                    <li class="dropdown user user-menu">
                      <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                        <img src="{{ $avatar }}" class="user-image" alt="User Image">
                        <span class="hidden-xs">{{ auth()->user()->name }}</span>
                    </a>
                    <ul class="dropdown-menu">
                        <!-- User image -->
                        <li class="user-header">
                          <img src="{{ $avatar }}" class="img-circle" alt="User Image">

                          <p>
                            {{ auth()->user()->name }}
                            <small>Member since {{ auth()->user()->created_at->diffForHumans() }}</small>
                        </p>
                    </li>
                    <!-- Menu Footer-->
                    <li class="user-footer">
                      <div class="pull-left">
                        <a href="{{ route('users.show', auth()->user()->id) }}" class="btn btn-default btn-flat">Profile</a>
                    </div>
                    <div class="pull-right">
                        <a id="logout" class="btn btn-default btn-flat">Sign out</a>
                    </div>
                </li>
            </ul>
        </li>

        @else 

        <li><a href="{{ route('login') }}">Login</a></li>
        <li><a href="{{ route('register') }}">Register</a></li>

        @endauth

    </ul>
</div>
</nav>
</header>

<!-- =============================================== -->
@auth

<!-- Left side column. contains the sidebar -->
<aside class="main-sidebar">
    <!-- sidebar: style can be found in sidebar.less -->
    <section class="sidebar">
        <ul class="sidebar-menu" data-widget="tree">
            <li class="header">MAIN NAVIGATION</li>
            <li class="treeview">
              <a href="#">
                <i class="fa fa-dashboard"></i> <span>Dashboard</span>
                <span class="pull-right-container">
                  <i class="fa fa-angle-left pull-right"></i>
              </span>
          </a>
          <ul class="treeview-menu">
            <li><a href="#"><i class="fa fa-circle-o"></i> Dashboard v1</a></li>
            <li><a href="#"><i class="fa fa-circle-o"></i> Dashboard v2</a></li>
        </ul>
    </li>

<li class="treeview">
  <a href="#">
    <i class="fa fa-edit"></i> <span>Documents</span>
    <span class="pull-right-container">
      <i class="fa fa-angle-left pull-right"></i>
  </span>
</a>
<ul class="treeview-menu">
    <li><a href="#"><i class="fa fa-circle-o"></i> Received</a></li>
    <li><a href="#"><i class="fa fa-circle-o"></i> Released</a></li>
    <li><a href="#"><i class="fa fa-circle-o"></i> All</a></li>
</ul>
</li>

</ul>
</section>
<!-- /.sidebar -->
</aside>

@endauth

<!-- =============================================== -->

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <section class="content-header">
        @include('sections.messages')
    </section>
    @auth
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        @yield('content-header')
        <small>@yield('content-description')</small>
    </h1>
    <ol class="breadcrumb">
        <li><a href="/"><i class="fa fa-dashboard"></i> Home</a></li>
    </ol>
</section>

@endauth

<!-- Main content -->
<section class="content">

@unless (Route::currentRouteName() === 'users.show')
  <!-- Default box -->
  <div class="box box-primary">
    <div class="box-header with-border">
      <h3 class="box-title">@yield('title')</h3>
  </div>
  <div class="box-body">
@endunless
      @yield('content')
@unless (Route::currentRouteName() === 'users.show')
  </div>
  <!-- /.box-body -->
  <div class="box-footer">
    @yield('box-footer')
  </div>
  <!-- /.box-footer-->
</div>
<!-- /.box -->
@endunless
</section>
<!-- /.content -->
</div>
<!-- /.content-wrapper -->

<form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
    {{ csrf_field() }}
</form>

<footer class="main-footer">

    <b>{{ config('app.name') }}</b> <small> v. {{ config('app.version') }} </small><small class="label label-info">{{ config('app.release') }}</small>
  <div class="pull-right hidden-xs">
  <small><strong>Copyright &copy; {{ \Carbon\Carbon::now()->year }} <a href="https://www.facebook.com/ferdie.bergado">{{ config('app.author') }}</a></strong>, <a href="https://www.pup.edu.ph/gs/msit.aspx">MSIT</a></small>
  </div>

</footer>

</div>
<!-- ./wrapper -->

</div>
<!-- #app -->

<!-- Scripts -->
<script src="{{ mix('js/app.js') }}"></script>
@stack('scripts')

</body>
</html>
