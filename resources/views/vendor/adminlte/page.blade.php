@extends('adminlte::master')

@section('adminlte_css')
    <link rel="stylesheet"
          href="{{ asset('vendor/adminlte/dist/css/skins/skin-' . config('adminlte.skin', 'blue') . '.min.css')}} ">
    @stack('css')
    @yield('css')
@stop

@section('body_class', 'skin-' . config('adminlte.skin', 'blue') . ' sidebar-mini ' . (config('adminlte.layout') ? [
    'boxed' => 'layout-boxed',
    'fixed' => 'fixed',
    'top-nav' => 'layout-top-nav'
][config('adminlte.layout')] : '') . (config('adminlte.collapse_sidebar') ? ' sidebar-collapse ' : ''))

@section('body')
    <div class="wrapper">

        <!-- Main Header -->
        <header class="main-header">
            @if(config('adminlte.layout') == 'top-nav')
            <nav class="navbar navbar-static-top">
                <div class="container">
                    <div class="navbar-header">
                        <a href="{{ url(config('adminlte.dashboard_url', 'home')) }}" class="navbar-brand">
                            {!! config('adminlte.logo', '<b>Admin</b>LTE') !!}
                        </a>
                        <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar-collapse">
                            <i class="fa fa-bars"></i>
                        </button>
                    </div>

                    <!-- Collect the nav links, forms, and other content for toggling -->
                    <div class="collapse navbar-collapse pull-left" id="navbar-collapse">
                        <ul class="nav navbar-nav">
                            @each('adminlte::partials.menu-item-top-nav', $adminlte->menu(), 'item')
                        </ul>
                    </div>
                    <!-- /.navbar-collapse -->
            @else
            <!-- Logo -->
            <a href="{{ Auth::user()->is_admin ? url(config('adminlte.admin_dashboard_url', 'home')) : url(config('adminlte.dashboard_url', 'home')) }}" class="logo">
                <!-- mini logo for sidebar mini 50x50 pixels -->
                <span class="logo-mini">{!! config('adminlte.logo_mini', '<b>A</b>LT') !!}</span>
                <!-- logo for regular state and mobile devices -->
                <span class="logo-lg">{!! config('adminlte.logo', '<b>Admin</b>LTE') !!}</span>
            </a>

            <!-- Header Navbar -->
            <nav class="navbar navbar-static-top" role="navigation">
                <!-- Sidebar toggle button-->
                <a href="#" class="sidebar-toggle" data-toggle="push-menu" role="button">
                    <span class="sr-only">{{ trans('adminlte::adminlte.toggle_navigation') }}</span>
                </a>
            @endif
                <!-- Navbar Right Menu -->
                <div class="navbar-custom-menu">

                    <ul class="nav navbar-nav">


                        <li class="dropdown messages-menu">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                                <i class="fa fa-envelope-o"></i>
                                <span class="label label-success">4</span>
                            </a>
                            <ul class="dropdown-menu">
                                <li class="header">You have N messages</li>
                                <li>
                                    <!-- inner menu: contains the actual data -->
                                    <ul class="menu">
                                        <li><!-- start message -->
                                            <a href="#">
                                                <div class="pull-left">
                                                    <img src="/img/default-img.jpg" class="img-circle" alt="User Image">
                                                </div>
                                                <h4>
                                                    Support Team
                                                    <small><i class="fa fa-clock-o"></i> 5 mins</small>
                                                </h4>
                                                <p>Message 1</p>
                                            </a>
                                        </li>
                                        <!-- end message -->
                                    </ul>
                                </li>
                                <li class="footer"><a href="#">See All Messages</a></li>
                            </ul>
                        </li>



                        <!-- Notifications: style can be found in dropdown.less -->
                        <li class="dropdown notifications-menu">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                                <i class="fa fa-bell-o"></i>
                                <span class="label label-warning">10</span>
                            </a>
                            <ul class="dropdown-menu">
                                <li class="header">You have 10 notifications</li>
                                <li>
                                    <!-- inner menu: contains the actual data -->
                                    <ul class="menu">
                                        <li>
                                            <a href="#">
                                            <i class="fa fa-users text-aqua"></i> 5 new alarms joined today
                                            </a>
                                        </li>
                                        <li>
                                            <a href="#">
                                                <i class="fa fa-warning text-yellow"></i> Very long description here that may not fit into the
                                                page and may cause design problems
                                            </a>
                                        </li>
                                        <li>
                                            <a href="#">
                                                <i class="fa fa-users text-red"></i> 5 new members joined
                                            </a>
                                        </li>
                                        <li>
                                            <a href="#">
                                                <i class="fa fa-user text-light-blue"></i> You changed your username
                                            </a>
                                        </li>
                                    </ul>
                                </li>
                                <li class="footer"><a href="#">View all</a></li>
                            </ul>
                        </li>



                        <!-- Tasks: style can be found in dropdown.less -->
                        <li class="dropdown tasks-menu">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                                <i class="fa fa-flag-o"></i>
                                <span class="label label-danger">9</span>
                            </a>
                            <ul class="dropdown-menu">
                                <li class="header">You have 9 tasks</li>
                                <li>
                                    <!-- inner menu: contains the actual data -->
                                    <ul class="menu">
                                        <li><!-- Task item -->
                                            <a href="#">
                                                <h3>
                                                    Design some buttons
                                                    <small class="pull-right">20%</small>
                                                </h3>
                                                <div class="progress xs">
                                                    <div class="progress-bar progress-bar-aqua" style="width: 20%" role="progressbar" aria-valuenow="20" aria-valuemin="0" aria-valuemax="100">
                                                        <span class="sr-only">20% Complete</span>
                                                    </div>
                                                </div>
                                            </a>
                                        </li>
                                        <!-- end task item -->
                                        <li><!-- Task item -->
                                            <a href="#">
                                                <h3>
                                                    Create a nice theme
                                                    <small class="pull-right">40%</small>
                                                </h3>
                                                <div class="progress xs">
                                                    <div class="progress-bar progress-bar-green" style="width: 40%" role="progressbar" aria-valuenow="20" aria-valuemin="0" aria-valuemax="100">
                                                        <span class="sr-only">40% Complete</span>
                                                    </div>
                                                </div>
                                            </a>
                                        </li>
                                        <!-- end task item -->
                                        <li><!-- Task item -->
                                            <a href="#">
                                                <h3>
                                                    Some task I need to do
                                                    <small class="pull-right">60%</small>
                                                </h3>
                                                <div class="progress xs">
                                                    <div class="progress-bar progress-bar-red" style="width: 60%" role="progressbar" aria-valuenow="20" aria-valuemin="0" aria-valuemax="100">
                                                        <span class="sr-only">60% Complete</span>
                                                    </div>
                                                </div>
                                            </a>
                                        </li>
                                        <!-- end task item -->
                                        <li><!-- Task item -->
                                            <a href="#">
                                                <h3>
                                                    Make beautiful transitions
                                                    <small class="pull-right">80%</small>
                                                </h3>
                                                <div class="progress xs">
                                                    <div class="progress-bar progress-bar-yellow" style="width: 80%" role="progressbar" aria-valuenow="20" aria-valuemin="0" aria-valuemax="100">
                                                        <span class="sr-only">80% Complete</span>
                                                    </div>
                                                </div>
                                            </a>
                                        </li>
                                        <!-- end task item -->
                                    </ul>
                                </li>
                                <li class="footer">
                                    <a href="#">View all tasks</a>
                                </li>
                            </ul>
                        </li>



                        <!-- User Account: style can be found in dropdown.less -->
                        <li class="dropdown user user-menu">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                                <img src="/img/default-img.jpg" class="user-image" alt="Logo">
                                <span class="hidden-xs">{{ Auth::user()->name }}</span>
                            </a>
                            <ul class="dropdown-menu">
                                <!-- User image -->
                                <li class="user-header">
                                    <img src="/img/default-img.jpg" class="img-circle" alt="Logo">
                                    <p>
                                    {{ Auth::user()->name }}
                                        <small>Subscription date: 00/00/0000</small>
                                    </p>
                                </li>
                                <!-- Menu Body -->
                                <li class="user-body">
                                    <div class="row">
                                        <div class="col-xs-4 text-center">
                                            <a href="#">Info 1</a>
                                        </div>
                                        <div class="col-xs-4 text-center">
                                            <a href="#">Info 2</a>
                                        </div>
                                        <div class="col-xs-4 text-center">
                                            <a href="#">Info 3</a>
                                        </div>
                                    </div>
                                    <!-- /.row -->
                                </li>
                                <!-- Menu Footer-->
                                <li class="user-footer">
                                    <div class="pull-left">
                                        <a href="#" class="btn btn-default btn-flat">Profile</a>
                                    </div>
                                    <div class="pull-right">
                                        <a href="#" class="btn btn-default btn-flat" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                            <i class="fa fa-fw fa-power-off"></i>Log Out
                                        </a>
                                        <form id="logout-form" action="{{ url(config('adminlte.logout_url', 'auth/logout')) }}" method="POST" style="display: none;">
                                            @if(config('adminlte.logout_method'))
                                                {{ method_field(config('adminlte.logout_method')) }}
                                            @endif
                                            {{ csrf_field() }}
                                        </form>
                                    </div>
                                </li>
                            </ul>
                        </li>

                        <!-- Control Sidebar Toggle Button -->
                        @yield('widgets_button')
                        
                        <!--li>
                            {{-- @if(config('adminlte.logout_method') == 'GET' || !config('adminlte.logout_method') && version_compare(\Illuminate\Foundation\Application::VERSION, '5.3.0', '<')) --}}
                                <a href="{{-- url(config('adminlte.logout_url', 'auth/logout')) --}}">
                                    <i class="fa fa-fw fa-power-off"></i> {{-- trans('adminlte::adminlte.log_out') --}}
                                </a>
                            {{-- @else --}}
                                <a href="#" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                    <i class="fa fa-fw fa-power-off"></i> {{-- trans('adminlte::adminlte.log_out') --}}
                                </a>
                                <form id="logout-form" action="{{-- url(config('adminlte.logout_url', 'auth/logout')) --}}" method="POST" style="display: none;">
                                    {{-- @if(config('adminlte.logout_method')) --}}
                                        {{-- method_field(config('adminlte.logout_method')) --}}
                                    {{-- @endif --}}
                                    {{-- csrf_field() --}}
                                </form>
                            {{-- @endif --}}
                        </li-->


                    </ul>
                </div>
                @if(config('adminlte.layout') == 'top-nav')
                </div>
                @endif
            </nav>
        </header>

        @if(config('adminlte.layout') != 'top-nav')
        <!-- Left side column. contains the logo and sidebar -->
        <aside class="main-sidebar">

            <!-- sidebar: style can be found in sidebar.less -->
            <section class="sidebar">

                <!-- Sidebar user panel -->
                <div class="user-panel">
                  <div class="pull-left image">
                    <img src="{{ asset('img/default-img.jpg') }}" class="img-circle" alt="User Image">
                  </div>
                  <div class="pull-left info">
                    <p>{{Auth::user()->name }} {!! Auth::user()->is_admin ? ' (<span style="color:#d33030;">Admin</span>)' : '' !!}</p>
                    <!-- Status -->
                    <!--a href="#"><i class="fa fa-circle text-success"></i> Online</a-->
                  </div>
                </div>

                <!-- Sidebar Menu -->
                <ul class="sidebar-menu" data-widget="tree">
                    @each('adminlte::partials.menu-item', $adminlte->menu(), 'item')
                </ul>
                <!-- /.sidebar-menu -->
            </section>
            <!-- /.sidebar -->
        </aside>
        @endif

        <!-- Content Wrapper. Contains page content -->
        <div class="content-wrapper">
            @if(config('adminlte.layout') == 'top-nav')
            <div class="container">
            @endif

            <!-- Content Header (Page header) -->
            <section class="content-header">
                @yield('content_header')

                <!-- alert section -->
                @if (Session::has('success-message'))
                    <div class="alert alert-success alert-dismissible fade in">
                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                        <h4><i class="icon fa fa-check"></i> {!! Session::get('success-message') !!}</h4>
                    </div>
                @elseif (Session::has('error-message'))
                    <div class="alert alert-danger alert-dismissible fade in">
                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                        <h4><i class="icon fa fa-ban"></i> Errore</h4>
                        {!! Session::get('error-message') !!}
                    </div>
                @elseif (Session::has('message'))
                    <div class="alert alert-info alert-dismissible fade in">
                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                        <h4><i class="icon fa fa-info"></i> {!! Session::get('message') !!}</h4>
                    </div>
                @elseif ($errors->any())  {{-- for forms validation errors --}}
                    <div class="alert alert-danger alert-dismissible fade in">
                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                        <h4><i class="icon fa fa-ban"></i> Error</h4>
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif
                <!-- stop alert section -->

            </section>

            <!-- Main content -->
            <section class="content">

                @yield('content')

            </section>
            <!-- /.content -->
            @if(config('adminlte.layout') == 'top-nav')
            </div>
            <!-- /.container -->
            @endif
        </div>
        <!-- /.content-wrapper -->

        <footer class="main-footer">
            <div class="pull-right hidden-xs">
                <b>{{ env('APP_NAME', '') }}</b> - <small>version {{ env('APP_VERSION', '') }}</small>
            </div>
            <strong>Copyright &copy; {{ date('Y') }} <a href=""></a>.</strong> All rights reserved.
        </footer>



        <!-- Control Sidebar -->
        <aside class="container control-sidebar control-sidebar-dark">
            <div class="control-sidebar-content">
                <h3 class="row control-sidebar-heading text-center">Availables Widgets List</h3>
                <div class="row control-sidebar-heading text-center">
                    <span class="col-xs-3"><i class="fa fa-area-chart"></i></span>
                    <span class="col-xs-3"><i class="fa fa-pie-chart"></i></span>
                    <span class="col-xs-3"><i class="fa fa-bar-chart"></i></span>
                    <span class="col-xs-3"><i class="fa fa-line-chart"></i></span>      
                </div>


                <!--div class="header-title">
                    <h1>Inactive Widgets</h1>
                </div-->
                <div class="inactive-widgets">      
                    <div class="grid-stack grid-stack-inactive">
                    </div>
                </div>



                <ul id="grid___ZZZZ___1" class="gr___________id-stack gr_____________id-stack-1 control-sidebar-menu text-center">

                    {{-- @for ($i = 1; $i <= 10 ; $i++)
                    <!--li id="widget-{{ $i }}" class="grid-stack-item" style="height: 100px; background-color: green; border:1px solid #FFF;">
                        <div class="">
                            Widget-{{ $i }}
                        </div>
                    </li--> 
                    @endfor --}}

                </ul>
                <div id="grid1" class="gr___id-st____ack dx"> </div>
            </div>
        </aside>
        <!-- /.control-sidebar -->
        <!-- Add the sidebar's background. This div must be placed immediately after the control sidebar -->
        <div class="control-sidebar-bg"></div>

        <!--jQuery-UI draggable droppable sortable + ajax-->
        <!--script>
            $( ".draggable" ).draggable({
                scroll: true,  //  not works -> verify!
                scrollSensitivity: 100,
                scrollSpeed: 100,
                containment: ".content-wrapper",  // or onlyl ".content" ?
                cursor: "move",
                cursorAt: { top: 56, left: 56 },
                start: function() {
                    $(this).css('z-index', 9999);
                    $(this).css('box-shadow', '2px 2px 2px 1px, -2px -2px 2px 1px #888');
                    $(this).css('transform', 'scale(1.2,1.2)');
                },
                drag: function() {
                    // counts[ 1 ]++;
                    // updateCounterStatus( $drag_counter, counts[ 1 ] );
                },
                stop: function() {
                    $(this).css('z-index', 'auto');
                    $(this).css('box-shadow', 'none');
                    $(this).css('transform', 'inherit');
                },
                // snap in drop-target
                snap: ".drop-target",
                snapMode: "inner",
                snapTolerance: 30,
                // resize when dropped
                // ...
            });
        </script-->







    </div>
    <!-- ./wrapper -->
@stop

@section('adminlte_js')
    <script src="{{ asset('vendor/adminlte/dist/js/adminlte.min.js') }}"></script>
    @stack('js')
    @yield('js')

@stop
