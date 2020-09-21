<!doctype html>
<html class="no-js" lang="">
<meta http-equiv="content-type" content="text/html;charset=UTF-8" />

<head>
    <meta charset="utf-8">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <title>{{ trans('Cirilla') }} | {{ trans('msg.home') }} </title>
    <meta name="description" content="">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="shortcut icon" href="{{ asset('img/favicon.png') }}">
    <link rel="stylesheet" href="{{ asset('css/normalize.css') }}">
    <link rel="stylesheet" href="{{ asset('css/main.css') }}">
    <link rel="stylesheet" href="{{ asset('css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('css/animate.min.css') }}">
    <link rel="stylesheet" href="{{ asset('css/fontawesome-all.min.css') }}">
    <link rel="stylesheet" href="{{ asset('fonts/flaticon.css') }}">
    <link rel="stylesheet" href="{{ asset('css/owl.carousel.min.css') }}">
    <link rel="stylesheet" href="{{ asset('css/owl.theme.default.min.css') }}">
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    <script src="{{ asset('js/modernizr-3.6.0.min.js') }}"></script>
</head>

<body>
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
                                <a href="index.html" class="sticky-logo-light"><img
                                        src="{{ asset('img/logo-light.png') }}"></a>
                                <a href="index.html" class="sticky-logo-dark"><img
                                        src="{{ asset('img/logo-dark.png') }}"></a>
                            </div>
                            <nav class="site-nav">
                                <ul id="site-menu" class="site-menu">
                                    <li>
                                        <a href="{{ route('home') }}">{{ trans('msg.home') }}</a>
                                    </li>
                                    <li>
                                        <a href="category.html">{{ trans('msg.category') }}</a>
                                    </li>
                                    <li>
                                        <a href="#">{{ trans('msg.book') }}</a>
                                    </li>
                                    <li>
                                        <a href="blog-grid.html">{{ trans('msg.review') }}</a>
                                    </li>
                                    <li><a href="contact.html">{{ trans('msg.contact') }}</a></li>
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
                                            <li class="nav-item dropdown">
                                            <li><a href="#">{{ Auth::user()->name }}</a>
                                                <ul class="dropdown-menu-col-1 just-left">
                                                    <li><a href="{{ route('logout') }}"
                                                            onclick="event.preventDefault();
                                                                            document.getElementById('logout-form').submit();">{{ trans('msg.logout') }}</a>
                                                    </li>
                                                </ul>
                                            </li>
                                            <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                                                <form id="logout-form" action="{{ route('logout') }}" method="POST"
                                                    class="d-none">
                                                    @csrf
                                                </form>
                                            </div>
                                            </li>
                                        @endguest
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
                    <a href="index.html">
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
            <input type="search" id="ooooo" value=""/>
            <button type="submit" class="search-btn"><i class="flaticon-search"></i></button>
        </form>
    </div>
    <script src="{{ asset('js/jquery-3.3.1.min.js') }}"></script>
    <script src="{{ asset('js/popper.min.js') }}"></script>
    <script src="{{ asset('js/bootstrap.min.js') }}"></script>
    <script src="{{ asset('js/plugins.js') }}"></script>
    <script src="{{ asset('js/owl.carousel.min.js') }}"></script>
    <script src="{{ asset('js/smoothscroll.min.js') }}"></script>
    <script src="{{ asset('js/main.js') }}"></script>
</body>

</html>
