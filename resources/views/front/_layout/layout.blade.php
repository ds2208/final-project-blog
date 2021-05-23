<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <!-- SEO -->
        <title>@yield('seo_title', __("Best blog site")) - Best blog</title>
        <meta name="description" content='@yield("seo_description", __("You are welcome on our site..."))'>
        <!-- seo facebook -->
        <meta property="og:site_name" content="{{config('app.name')}}">
        <meta property="og:type" content="@yield('seo_type', 'blogs')">
        <meta property="og:title" content="@yield('seo_title', 'Best blog site')">
        <meta property="og:description"   content="@yield('seo_description', __('You are welcome on our site...'))">
        <meta property="og:image" content="@yield('seo_image', url('/themes/front/img/logo.png'))">
        <meta property="og:url" content="{{url()->current()}}">
        <!-- seo twitter -->
        <meta name="twitter:card" content="{{config('app.name')}}">
        <meta name="twitter:title" content="@yield('seo_title', 'Best blog site')">
        <meta name="twitter:description" content="@yield('seo_description', __('You are welcome on our site...'))">
        <meta name="twitter:image" content="@yield('seo_image', url('/themes/front/img/logo.png'))">
        @stack('head_meta')
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="robots" content="all,follow">
        <!-- Bootstrap CSS-->
        <link rel="stylesheet" href="{{url('/themes/front/vendor/bootstrap/css/bootstrap.min.css')}}">
        <!-- Font Awesome CSS-->
        <link rel="stylesheet" href="{{url('/themes/front/vendor/font-awesome/css/font-awesome.min.css')}}">
        <!-- Custom icon font-->
        <link rel="stylesheet" href="{{url('/themes/front/css/fontastic.css')}}">
        <!-- Google fonts - Open Sans-->
        <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,700">
        <!-- Fancybox-->
        <link rel="stylesheet" href="{{url('/themes/front/vendor/@fancyapps/fancybox/jquery.fancybox.min.css')}}">
        <!-- theme stylesheet-->
        <link rel="stylesheet" href="{{url('/themes/front/css/style.default.css')}}" id="theme-stylesheet">
        <!-- Custom stylesheet - for your changes-->
        <link rel="stylesheet" href="{{url('/themes/front/css/custom.css')}}">
        <!-- Favicon-->
        <link rel="shortcut icon" href="{{url('/themes/front/img/favicon.ico')}}">
        <!-- Toastr -->
        <link rel="stylesheet" href="{{url('themes/front/plugins/toastr/toastr.min.css')}}">
        <!-- Tweaks for older IEs--><!--[if lt IE 9]>
            <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
            <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script><![endif]-->
        @stack('links')
    </head>
    <body>
        @include('front._layout.partials.header')

        @yield('content')
        <!-- Page Footer-->
        @include('front._layout.partials.footer')
        <!-- JavaScript files-->
        <script src="{{url('/themes/front/vendor/jquery/jquery.min.js')}}"></script>
        <script src="{{url('/themes/front/vendor/popper.js/umd/popper.min.js')}}"></script>
        <script src="{{url('/themes/front/vendor/bootstrap/js/bootstrap.min.js')}}"></script>
        <script src="{{url('/themes/front/vendor/jquery.cookie/jquery.cookie.js')}}"></script>
        <script src="{{url('/themes/front/vendor/@fancyapps/fancybox/jquery.fancybox.min.js')}}"></script>
        <!-- Toastr -->
        <script src="{{url('themes/front/plugins/toastr/toastr.min.js')}}" type="text/javascript"></script>
        <script type="text/javascript">
let systemMessage = "{{session()->pull('system_message')}}";
if (systemMessage !== "") {
    toastr.success(systemMessage);
}
let systemError = "{{session()->pull('system_error')}}";
if (systemError !== "") {
    toastr.error(systemError);
}
        </script>

        <script type="text/javascript">
            let title = "@yield('seo_title')";
            switch (title) {
                case 'Home':
                    $('.navbar-nav #home').addClass('active');
                    break;
                case 'Blogs':
                    $('.navbar-nav #blog').addClass('active');
                    break;
                case 'Contact Us':
                    $('.navbar-nav #contact').addClass('active');
                    break;
            }
        </script>

        <script src="{{url('/themes/front/js/front.js')}}"></script>

        @stack('scripts')

    </body>
</html>