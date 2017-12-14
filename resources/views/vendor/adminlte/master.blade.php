<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>
        @yield('title_prefix', config('adminlte.title_prefix', ''))
        @yield('title', config('adminlte.title', 'AdminLTE 2'))
        @yield('title_postfix', config('adminlte.title_postfix', ''))
    </title>
    
    <!-- Tell the browser to be responsive to screen width -->
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <!-- Bootstrap 3.3.7 -->
    <link rel="stylesheet" href="{{ asset('vendor/adminlte/vendor/bootstrap/dist/css/bootstrap.min.css') }}">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="{{ asset('vendor/adminlte/vendor/font-awesome/css/font-awesome.min.css') }}">
    <!-- Ionicons -->
    <link rel="stylesheet" href="{{ asset('vendor/adminlte/vendor/Ionicons/css/ionicons.min.css') }}">

    @if(config('adminlte.plugins.select2'))
        <!-- Select2 -->
        <link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/css/select2.css">
    @endif

    <!-- Theme style -->
    <link rel="stylesheet" href="{{ asset('vendor/adminlte/dist/css/AdminLTE.min.css') }}">

    @if(config('adminlte.plugins.datatables'))
        <!-- DataTables -->
        <link rel="stylesheet" href="//cdn.datatables.net/1.10.16/css/dataTables.bootstrap.min.css">
    @endif

    @yield('adminlte_css')

    <!-- Google Font -->
    <link rel="stylesheet" href="//fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">
    <!-- Custom style -->
    <link rel="stylesheet" href="{{ asset('css/custom-style.css') }}">
    <!-- gridstack css-->
    <link rel="stylesheet" href="{{ asset('css/gridstack/src/0.3.0-gridstack.min.css') }}" />
    <!--link rel="stylesheet" href="{{-- asset('css/gridstack/src/gridstack-extra.css') --}}" /-->
    <link rel="stylesheet" href="{{ asset('css/gridstack/src/third-party-integr/multiple-grids.css') }}" />

    <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
        <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->

</head>
<body class="hold-transition @yield('body_class')">

    {{-- @yield('body') spostato sotto ad alcune lib js --}}

    <script src="{{ asset('vendor/adminlte/vendor/jquery/dist/jquery.min.js') }}"></script>
    <script src="{{ asset('vendor/adminlte/vendor/bootstrap/dist/js/bootstrap.min.js') }}"></script>

    @if(config('adminlte.plugins.select2'))
        <!-- Select2 -->
        <script src="//cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/js/select2.min.js"></script>
    @endif

    @if(config('adminlte.plugins.datatables'))
        <!-- DataTables -->
        <script src="//cdn.datatables.net/1.10.16/js/jquery.dataTables.min.js"></script>
        <script src="//cdn.datatables.net/1.10.16/js/dataTables.bootstrap.min.js"></script>
    @endif

    <!-- jquery UI -->
    <script src="//code.jquery.com/ui/1.12.1/jquery-ui.js"></script>


    <!-- gridstack js drag drop jquery plugin -->
    <script src="{{ asset('js/lodash/4.17.4/lodash.js') }}"></script>
    <script src="{{ asset('js/jquery-ui-touch-punch/jquery.ui.touch-punch.min.js') }}"></script>
    <script src="{{ asset('js/gridstack/src/gridstack.js') }}"></script>
    <script src="{{ asset('js/gridstack/src/gridstack.jQueryUI.js') }}"></script>
    


    @yield('body')

    @yield('adminlte_js')

    

    <!-- custom scripts -->
    <script src="{{ asset('js/custom-scripts.js') }}"></script>

</body>
</html>
