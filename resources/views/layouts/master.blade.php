<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta name="keywords" content="elogbook, Electronic Log Book, document management">
  <meta name="author" content="{{ config('app.author') }}">
  <meta name="description" content="A web application to manage the recording of documents">  
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
<body class="hold-transition skin-{{ config('app.theme') }} sidebar-mini">
  <!-- Site wrapper -->
  <div class="wrapper">
    <header class="main-header">
      <!-- Logo -->
      <a href="{{ auth()->check() && auth()->user()->can('admin') ? route('admin.home') : '/' }}" class="logo">
        <!-- mini logo for sidebar mini 50x50 pixels -->
        <span class="logo-mini">eL</span>
        <!-- logo for regular state and mobile devices -->
        <span class="logo-lg">{{ config('app.name') }}</span>
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
            @include('sections.usernav')
            @else 
            <li><a href="{{ route('login') }}"><i class="fa fa-sign-in"></i> Login</a></li>
            <li><a href="{{ route('register') }}"><i class="fa fa-user-plus"></i> Register</a></li>
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
      <!-- Sidebar user panel -->
{{--       <div class="user-panel">
        <div class="pull-left image">
          <img src="{{ $avatar }}" class="img-circle" alt="User Image">
        </div>
        <div class="pull-left info">
          <p>{{ auth()->user()->name }}</p>
          <a href="javascript:this.logout-form.submit()"><i class="fa fa-circle text-success"></i> Online</a>
        </div>
      </div> --}}
      <section class="sidebar">
        <ul class="sidebar-menu" data-widget="tree">
          @can ('admin')
          <li class="header">ADMINISTRATION</li>                  
          <li class="treeview {{ Route::is('admin.*') ? 'active' : '' }}">
            <a href="#">
              <i class="fa fa-dashboard"></i> <span>Dashboard</span>
              <span class="pull-right-container">
                <i class="fa fa-angle-left pull-right"></i>
              </span>
            </a>
            <ul class="treeview-menu clearfix">
              <li class="{{ Route::is('admin.environment') ? 'active' : '' }}"><a href="{{ route('admin.environment') }}"><i class="fa fa-desktop"></i> <span> Application</span></a></li>
              <li class="{{ Route::is('admin.info') ? 'active' : '' }}"><a href="{{ route('admin.info') }}"><i class="fa fa-server"></i><span>Server</span></a></li>             
            </ul>
          </li>
          <li class="{{ Route::is('admin.commands') ? 'active' : '' }}">
            <a href="{{ route('admin.commands') }}">
              <i class="fa fa-terminal"></i> <span>Console</span>
            </a>
          </li>        
          <li class="treeview {{ Route::is('admin.*') ? 'active' : '' }}">
            <a href="#">
              <i class="fa fa-database"></i> <span>Entities</span>
              <span class="pull-right-container">
                <i class="fa fa-angle-left pull-right"></i>
              </span>
            </a>
            <ul class="treeview-menu clearfix">
              <li class="{{ Route::is('admin.documents') ? 'active' : '' }}"><a href="{{ route('admin.documents') }}"><i class="fa fa-book"></i><span> Documents</span></a></li>             
              <li class="{{ Route::is('admin.transactions') ? 'active' : '' }}"><a href="{{ route('admin.transactions') }}"><i class="fa fa-tasks"></i> <span> Transactions</span></a></li>
            </ul>
          </li>        
          @else     
          <li class="header">MAIN NAVIGATION</li>
          <li class="{{ (Route::currentRouteName() === 'home') ? 'active' : '' }}">
            <a href="/">
              <i class="fa fa-home"></i> <span>Home</span>
            </a>
          </li>
          <li class="{{ Route::currentRouteNamed('documents.*') ? 'active' : '' }}">
            <a href="{{ route('documents.index') }}">
              <i class="fa fa-book"></i> <span>Documents</span>
              <span class="pull-right-container">
                <span class="label label-primary pull-right">{{ $document_count }}</span>
              </span>              
            </a>
          </li>
          <li class="treeview {{ Route::currentRouteNamed('transactions.*') ? 'active' : '' }}">
            <a href="#">
              <i class="fa fa-table"></i> <span>Transactions</span>
              <span class="pull-right-container">
                <i class="fa fa-angle-left pull-right"></i>
              </span>
            </a>
            <ul class="treeview-menu clearfix">
              <li class="{{ (Route::currentRouteName() === 'transactions.index' && request()->task === 'P') ? 'active' : '' }}"><a href="{{ route('transactions.index', ['task' => 'P']) }}"><i class="fa fa-history"></i><span>Pending</span>
                <span class="pull-right-container">                  
                  <span class="label label-warning pull-right">{{ $transaction_pending }}</span>
                </span>
              </a></li>              
              <li class="{{ (Route::currentRouteName() === 'transactions.index' && request()->task === 'I') ? 'active' : '' }}"><a href="{{ route('transactions.index', ['task' => 'I']) }}"><i class="fa fa-arrow-right"></i><span>Received</span>
                <span class="pull-right-container">                  
                  <span class="label label-primary pull-right">{{ $transaction_received }}</span>
                </span>
              </a></li>
              <li class="{{ (Route::currentRouteName() === 'transactions.index' && request()->task === 'O') ? 'active' : '' }}"><a href="{{ route('transactions.index', ['task' => 'O']) }}"><i class="fa fa-arrow-left"></i><span>Released</span>
                <span class="pull-right-container">                  
                  <span class="label label-success pull-right">{{ $transaction_released }}</span>
                </span>
              </a></li>
              <li class="{{ (Route::currentRouteName() === 'transactions.index' && request()->task === null) ? 'active' : '' }}"><a href="{{ route('transactions.index', ['task' => null]) }}"><i class="fa fa-exchange"></i><span>All</span>
                <span class="pull-right-container">
                  <span class="label label-info pull-right">{{ $transaction_count }}</span>
                </span>                  
              </a>
            </li>
          </ul>
        </li>
        <li class="{{ (Route::currentRouteName() === 'offices.active') ? 'active' : '' }}">
          <a href="{{ route('offices.active') }}">
            <i class="fa fa-building"></i> <span>Active Offices</span>
            <span class="pull-right-container">
              <span class="label label-info pull-right">{{ $active_offices_count }}</span>
            </span>
          </a>
        </li>        
        @endcan
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
      @cannot('admin')
      <h1>
        {{ auth()->user()->office->name }}
        <br><small>{{ ((strpos(auth()->user()->office->name,'Office of the Director') === 0) || strpos(auth()->user()->office->bureauservice->name, 'Not Applicable') === 0) ? auth()->user()->office->strand->name : auth()->user()->office->bureauservice->name }}</small>
      </h1>
      @endcannot
      <ol class="breadcrumb">
        <br><br>
        <li><a href="/" title="Home"><i class="fa fa-home"></i> Home</a></li>
        @yield('breadcrumb')
      </ol>
    </section>
    @endauth
    <!-- Main content -->
    <section class="content">
      @unless (Route::currentRouteName() === 'users.show')
      <!-- Default box -->
      <div class="box box-primary">
        <div class="box-header with-border">
          <h3 class="box-title">&nbsp;<b>@yield('title-icon') &nbsp; @yield('title')</b><br><small>&nbsp;&nbsp;@yield('subtitle')</small></h3>
        </div>
        <div class="box-body">
          <div class="container-fluid">
            @endunless
            @yield('content')
            @unless (Route::currentRouteName() === 'users.show')
          </div>
        </div>
        <!-- /.box-body -->
        <div class="box-footer">
          <div class="container-fluid">
            @unless (Route::is('*.index') || (Route::is('home')))
            @include('includes.backbutton')
            @endunless
            @yield('box-footer')        
          </div>
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
    <a href="{{ config('app.pages.github') }}"><b>{{ config('app.name') }}</b></a> <small> v. {{ config('app.version') . $version }} </small><small class="label label-info">{{ config('app.release') }}</small>
    <div class="pull-right hidden-xs">
      <small><strong>Copyright &copy; {{ \Carbon\Carbon::now()->year }} <a href="{{ config('app.pages.facebook') }}">{{ config('app.author') }}</a></strong>, <a href="{{ config('app.pages.msit') }}">MSITc</a></small>
    </div>
  </footer>
</div>
<!-- ./wrapper -->
<!-- Scripts -->
<script src="{{ mix('js/app.js') }}"></script>
@stack('scripts')
</body>
</html>
