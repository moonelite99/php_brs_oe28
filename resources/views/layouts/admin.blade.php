<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>{{ trans('msg.admin') }}</title>
    <link rel="shortcut icon" href="{{ asset(config('img.favicon')) }}">
    <link href="{{ asset('css/admin/font-face.css') }}" rel="stylesheet" media="all">
    <link href="{{ asset('vendor/font-awesome-4.7/css/font-awesome.min.css') }}" rel="stylesheet" media="all">
    <link href="{{ asset('vendor/font-awesome-5/css/fontawesome-all.min.css') }}" rel="stylesheet" media="all">
    <link href="{{ asset('vendor/mdi-font/css/material-design-iconic-font.min.css') }}" rel="stylesheet" media="all">
    <link href="{{ asset('vendor/bootstrap-4.1/bootstrap.min.css') }}" rel="stylesheet" media="all">
    <link href="{{ asset('vendor/animsition/animsition.min.css') }}" rel="stylesheet" media="all">
    <link href="{{ asset('vendor/bootstrap-progressbar/bootstrap-progressbar-3.3.4.min.css') }}" rel="stylesheet"
        media="all">
    <link href="{{ asset('vendor/wow/animate.css') }}" rel="stylesheet" media="all">
    <link href="{{ asset('vendor/css-hamburgers/hamburgers.min.css') }}" rel="stylesheet" media="all">
    <link href="{{ asset('vendor/slick/slick.css') }}" rel="stylesheet" media="all">
    <link href="{{ asset('vendor/select2/select2.min.css') }}" rel="stylesheet" media="all">
    <link href="{{ asset('vendor/perfect-scrollbar/perfect-scrollbar.css') }}" rel="stylesheet" media="all">
    <link href="{{ asset('css/admin/theme.css') }}" rel="stylesheet" media="all">
    <script src="{{ asset('js/bootstrap.js') }}"></script>
    <script src="{{ asset('js/admin/pusher.js') }}"></script>
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
    <div class="page-wrapper">
        <aside class="menu-sidebar d-none d-lg-block">
            <div class="logo">
                <a href="{{ route('home') }}">
                    <img src="{{ asset(config('img.dark_logo')) }}" alt="Cirilla" />
                </a>
            </div>
            <div class="menu-sidebar__content js-scrollbar1">
                <nav class="navbar-sidebar">
                    <ul class="list-unstyled navbar__list">
                        <li class="active has-sub">
                            <a href="{{ route('admin_index') }}">
                                <i class="fas fa-tachometer-alt"></i>
                                {{ trans('msg.dashboard') }}
                            </a>
                        </li>
                        <li class="active has-sub">
                            <a href="{{ route('books.index') }}">
                                <i class="fa fa-book"></i>&nbsp;
                                {{ trans('msg.book') }}
                            </a>
                        </li>
                        <li class="active has-sub">
                            <a href="{{ route('users.index') }}">
                                <i class="fa fa-user"></i>&nbsp;
                                {{ trans('msg.user') }}
                            </a>
                        </li>
                        <li class="active has-sub">
                            <a href="{{ route('requests', config('default.req_unsolved')) }}">
                                <i class="fas fa-ticket-alt"></i>&nbsp;
                                {{ trans('msg.requests') }}
                            </a>
                        </li>
                        <li class="active has-sub">
                            <a href="{{ route('update') }}">
                                <i class="fas fa-sync-alt"></i>&nbsp;
                                {{ trans('msg.update') }}
                            </a>
                        </li>
                    </ul>
                </nav>
            </div>
        </aside>
        <div class="page-container">
            <header class="header-desktop">
                <div class="section__content section__content--p30">
                    <div class="container-fluid">
                        <div class="header-wrap">
                            <div class="account-item clearfix js-item-menu pull-right">
                                <div class="content">
                                    <a class="js-acc-btn" href="#">{{ Auth::user()->name }}</a>
                                </div>
                                <div class="account-dropdown js-dropdown">
                                    <div class="account-dropdown__item">
                                        <a id="en" href="#">
                                            {{ trans('msg.english') }}
                                        </a>
                                        <a id="vi" href="#">
                                            {{ trans('msg.vietnamese') }}
                                        </a>
                                        <form id="language-form" action="{{ route('switch_lang') }}" method="POST"
                                            class="d-none">
                                            @csrf
                                            <input type="hidden" id="locale" name="locale">
                                        </form>
                                    </div>
                                    <div class="account-dropdown__footer">
                                        <a id="logout" href="#">
                                            {{ trans('msg.logout') }}
                                        </a>
                                        <form id="logout-form" action="{{ route('logout') }}" method="POST"
                                            class="d-none">
                                            @csrf
                                        </form>
                                    </div>
                                </div>
                            </div>
                            <input type="hidden" id="suffix" value="{{ trans('msg.write_new_review') }}">
                            <div class="noti-wrap pull-right">
                                <div class="noti__item js-item-menu">
                                    <i class="zmdi zmdi-notifications" id="bell"></i>
                                    <div class="notifi-dropdown js-dropdown noti-drop" id="noti-dropdown">
                                        @foreach (Auth::user()->notifications()->take(config('default.max_noti'))->get() as $notification)
                                            <div class="notifi__item">
                                                <div class="bg-c3 img-cir img-40">
                                                    <i class="zmdi zmdi-file-text"></i>
                                                </div>
                                                <div class="content">
                                                    <a href="{{ $notification->data['link'] }}">
                                                        <p>{{ $notification->data['name'] . trans('msg.write_new_review')}} </p>
                                                        <span class="date">{{ $notification->data['time'] }}</span>
                                                    </a>
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </header>
            <div class="main-content">
                @yield('content')
            </div>
        </div>
    </div>
    <script src="{{ asset('vendor/jquery-3.2.1.min.js') }}"></script>
    <script src="{{ asset('vendor/bootstrap-4.1/popper.min.js') }}"></script>
    <script src="{{ asset('vendor/bootstrap-4.1/bootstrap.min.js') }}"></script>
    <script src="{{ asset('vendor/slick/slick.min.js') }}"></script>
    <script src="{{ asset('vendor/wow/wow.min.js') }}"></script>
    <script src="{{ asset('vendor/bootstrap-progressbar/bootstrap-progressbar.min.js') }}"></script>
    <script src="{{ asset('vendor/counter-up/jquery.waypoints.min.js') }}"></script>
    <script src="{{ asset('vendor/counter-up/jquery.counterup.min.js') }}"></script>
    <script src="{{ asset('vendor/circle-progress/circle-progress.min.js') }}"></script>
    <script src="{{ asset('vendor/perfect-scrollbar/perfect-scrollbar.js') }}"></script>
    <script src="{{ asset('vendor/chartjs/Chart.bundle.min.js') }}"></script>
    <script src="{{ asset('vendor/select2/select2.min.js') }}"></script>
    <script src="{{ asset('js/admin/main.js') }}"></script>
    <script src="{{ asset('js/home.js') }}"></script>
    <script src="{{ asset('js/admin/admin.js') }}"></script>
</body>

</html>
