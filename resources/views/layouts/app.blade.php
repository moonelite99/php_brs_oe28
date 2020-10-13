<!doctype html>
<html class="no-js" lang="">
<meta http-equiv="content-type" content="text/html;charset=UTF-8" />

<head>
    <meta charset="utf-8">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <title>{{ trans('Cirilla') }}</title>
    <meta name="description" content="">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link href="{{ asset('vendor/bootstrap-4.1/bootstrap.min.css') }}" rel="stylesheet" media="all">
    <link rel="shortcut icon" href="{{ asset(config('img.favicon')) }}">
    <link rel="stylesheet" href="{{ asset('css/normalize.css') }}">
    <link rel="stylesheet" href="{{ asset('css/main.css') }}">
    <link rel="stylesheet" href="{{ asset('css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('css/animate.min.css') }}">
    <link rel="stylesheet" href="{{ asset('css/fontawesome-all.min.css') }}">
    <link rel="stylesheet" href="{{ asset('fonts/flaticon.css') }}">
    <link rel="stylesheet" href="{{ asset('css/owl.carousel.min.css') }}">
    <link rel="stylesheet" href="{{ asset('css/owl.theme.default.min.css') }}">
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    <link href="{{ asset('vendor/font-awesome-4.7/css/font-awesome.min.css') }}" rel="stylesheet" media="all">
    <script src="{{ asset('js/modernizr-3.6.0.min.js') }}"></script>
    <script src="{{ asset('ckeditor/ckeditor.js') }}"></script>
</head>

<body>
    @if (session('fail_status'))
        <div class="toast noti text-danger" data-delay="{{ config('default.noti_time') }}">
            <div class="toast-header">
                <strong class="mr-auto">{{ trans('msg.notification') }}</strong>
                <button type="button" class="ml-2 mb-1 close" data-dismiss="toast">&times;</button>
            </div>
            <div class="toast-body">
                {{ session('fail_status') }}
            </div>
        </div>
    @endif
    @if (session('status'))
        <div class="toast noti text-success" data-delay="{{ config('default.noti_time') }}">
            <div class="toast-header">
                <strong class="mr-auto">{{ trans('msg.notification') }}</strong>
                <button type="button" class="ml-2 mb-1 close" data-dismiss="toast">&times;</button>
            </div>
            <div class="toast-body">
                {{ session('status') }}
            </div>
        </div>
    @endif
    <div id="preloader"></div>
    <a href="#wrapper" data-type="section-switch" class="scrollup">
        <i class="fas fa-angle-double-up"></i>
    </a>
    <div id="wrapper" class="wrapper">
        <header class="header-one">
            <div id="header-main-menu" class="header-main-menu header-sticky">
                <div class="container">
                    <div class="row">
                        <div class="col-lg-8 col-md-3 col-sm-4 col-4 possition-static">
                            <div class="site-logo-mobile">
                                <a href="{{ route('home') }}" class="sticky-logo-light"><img
                                        src="{{ asset(config('img.light_logo')) }}"></a>
                                <a href="{{ route('home') }}" class="sticky-logo-dark"><img
                                        src="{{ asset(config('img.dark_logo')) }}"></a>
                            </div>
                            <nav class="site-nav">
                                <ul id="site-menu" class="site-menu">
                                    <li>
                                        <div class="site-logo-desktop">
                                            <a href="{{ route('home') }}" >
                                                <img  src="{{ asset(config('img.light_logo')) }}"></a>
                                        </div>
                                    </li>
                                    <li>
                                        <a href="{{ route('books') }}">{{ trans('msg.book') }}</a>
                                    </li>
                                    <li>
                                        <a href="#">{{ trans('msg.review') }}</a>
                                    </li>
                                    @auth
                                        @if (Auth::user()->role == config('role.user'))
                                            <li><a href="{{ route('contacts.create') }}">{{ trans('msg.contact') }}</a></li>
                                        @endif
                                    @endauth
                                </ul>
                            </nav>
                        </div>
                        <div class="col-lg-4 col-md-9 col-sm-8 col-8 d-flex align-items-center justify-content-end">
                            <div class="nav-action-elements-layout1">
                                <nav class="site-nav">
                                    <ul id="site-menu" class="site-menu">
                                        <li>
                                            <button class="login-btn">
                                                <a href="#search"><i class="flaticon-search"></i></a>
                                            </button>
                                        </li>
                                        @guest
                                            <li>
                                                <button type="button" class="login-btn">
                                                    <a class="login-btn"
                                                        href="{{ route('login') }}">{{ trans('msg.login') }}
                                                    </a>
                                                </button>
                                            </li>
                                            <li>
                                                <button type="button" class="login-btn">
                                                    <a class="login-btn"
                                                        href="{{ route('register') }}">{{ trans('msg.register') }}
                                                    </a>
                                                </button>
                                            </li>
                                        @else
                                            <li><a href="#">{{ Auth::user()->name }}</a>
                                                <ul class="dropdown-menu-col-1 just-left">
                                                    <li>
                                                        @if (Auth::user()->role == config('role.admin'))
                                                            <a href="{{ route('admin_index') }}">
                                                                {{ trans('msg.admin') }}
                                                            </a>
                                                        @endif
                                                        <a id="logout" href="{{ route('logout') }}">
                                                            {{ trans('msg.logout') }}
                                                        </a>
                                                    </li>
                                                </ul>
                                            </li>
                                            <form id="logout-form" action="{{ route('logout') }}" method="POST"
                                                class="d-none">
                                                @csrf
                                            </form>
                                        @endguest
                                        <li><a href="#">{{ trans('msg.language') }}</a>
                                            <ul class="dropdown-menu-col-1 just-left">
                                                <li>
                                                    <a id="en" href="#">{{ trans('msg.english') }}
                                                    </a>
                                                    <a id="vi" href="#">{{ trans('msg.vietnamese') }}
                                                    </a>
                                                </li>
                                            </ul>
                                            <form id="language-form" action="{{ route('switch_lang') }}" method="POST"
                                                class="d-none">
                                                @csrf
                                                <input type="hidden" id="locale" name="locale">
                                            </form>
                                        </li>
                                    </ul>
                                </nav>
                            </div>
                            <div class="mob-menu-open toggle-menu">
                                <span class="bar"></span>
                                <span class="bar"></span>
                                <span class="bar"></span>
                                <span class="bar"></span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="header-bottom d-none d-lg-block">
            </div>
        </header>
        @yield('content')
        <footer class="ranna-bg-dark">
            <div class="container">
                <div class="footer-logo">
                    <a href="{{ route('home') }}">
                        <img src="{{ asset('img/logo-light.png') }}" class="img-fluid">
                    </a>
                </div>
                <div class="footer-menu">
                    <ul class="inner-share">
                        <li>
                            <a href="#">
                                <i class="fab fa-facebook-f"></i>
                            </a>
                        </li>
                        <li>
                            <a href="#">
                                <i class="fab fa-twitter"></i>
                            </a>
                        </li>
                        <li>
                            <a href="#">
                                <i class="fab fa-linkedin-in"></i>
                            </a>
                        </li>
                        <li>
                            <a href="#">
                                <i class="fab fa-google-plus-g"></i>
                            </a>
                        </li>
                        <li>
                            <a href="#">
                                <i class="fab fa-youtube"></i>
                            </a>
                        </li>
                    </ul>
                </div>
            </div>
        </footer>
    </div>
    <div id="search" class="search-wrap">
        <button type="button" class="close">×</button>
        <form class="search-form">
            <input type="search" id="ooooo" value="" />
            <button type="submit" class="search-btn"><i class="flaticon-search"></i></button>
        </form>
    </div>
    <script src="{{ asset('vendor/jquery-3.2.1.min.js') }}"></script>
    <script src="{{ asset('vendor/bootstrap-4.1/popper.min.js') }}"></script>
    <script src="{{ asset('vendor/bootstrap-4.1/bootstrap.min.js') }}"></script>
    <script src="{{ asset('js/plugins.js') }}"></script>
    <script src="{{ asset('js/owl.carousel.min.js') }}"></script>
    <script src="{{ asset('js/main.js') }}"></script>
    <script src="{{ asset('js/home.js') }}"></script>
</body>

</html>
