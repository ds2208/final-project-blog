<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta http-equiv="x-ua-compatible" content="ie=edge">

    <title>@yield('seo_title') | Starter</title>

    <!-- Font Awesome Icons -->
    <link rel="stylesheet" href="{{url('themes/admin/plugins/fontawesome-free/css/all.min.css')}}">
    <!-- DataTables -->
    <link href="{{url('/themes/admin/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css')}}" rel="stylesheet" type="text/css"/>
    <!-- Theme style -->
    <link rel="stylesheet" href="{{url('themes/admin/dist/css/adminlte.min.css')}}">
    <!-- Google Font: Source Sans Pro -->
    <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700" rel="stylesheet">
    <!-- select2 -->
    <link href="{{url('/themes/admin/plugins/select2/css/select2.min.css')}}" rel="stylesheet" type="text/css"/>
    <link href="{{url('/themes/admin/plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css')}}" rel="stylesheet" type="text/css"/>
    <!-- Toastr -->
    <link rel="stylesheet" href="{{url('themes/admin/plugins/toastr/toastr.min.css')}}">
    @stack('head_links')
</head>