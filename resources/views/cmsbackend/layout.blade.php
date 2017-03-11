<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>{{ config('app.name') }}</title>
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">

    <link rel="apple-touch-icon" sizes="57x57" href="/backend/favicons/apple-icon-57x57.png">
    <link rel="apple-touch-icon" sizes="60x60" href="/backend/favicons/apple-icon-60x60.png">
    <link rel="apple-touch-icon" sizes="72x72" href="/backend/favicons/apple-icon-72x72.png">
    <link rel="apple-touch-icon" sizes="76x76" href="/backend/favicons/apple-icon-76x76.png">
    <link rel="apple-touch-icon" sizes="114x114" href="/backend/favicons/apple-icon-114x114.png">
    <link rel="apple-touch-icon" sizes="120x120" href="/backend/favicons/apple-icon-120x120.png">
    <link rel="apple-touch-icon" sizes="144x144" href="/backend/favicons/apple-icon-144x144.png">
    <link rel="apple-touch-icon" sizes="152x152" href="/backend/favicons/apple-icon-152x152.png">
    <link rel="apple-touch-icon" sizes="180x180" href="/backend/favicons/apple-icon-180x180.png">
    <link rel="icon" type="image/png" sizes="192x192"  href="/backend/favicons/android-icon-192x192.png">
    <link rel="icon" type="image/png" sizes="32x32" href="/backend/favicons/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="96x96" href="/backend/favicons/favicon-96x96.png">
    <link rel="icon" type="image/png" sizes="16x16" href="/backend/favicons/favicon-16x16.png">
    <link rel="manifest" href="/backend/favicons/manifest.json">
    <meta name="msapplication-TileColor" content="#2196f3">
    <meta name="msapplication-TileImage" content="/backend/favicons/ms-icon-144x144.png">
    <meta name="theme-color" content="#2196f3">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.5.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/ionicons/2.0.1/css/ionicons.min.css">
    <link rel="stylesheet" href="/backend/css/bootstrap.min.css">
    <link rel="stylesheet" href="/backend/css/AdminLTE.min.css">
    <link rel="stylesheet" href="/backend/css/skin-blue-light.min.css">

    <link rel="stylesheet" href="/backend/plugins/iCheck/blue.css">

    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
    <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
    <style>
        .user-lastfail p {
            padding-top: 15px;
            margin-right: 10px;
            color: #fff;
        }
    </style>
</head>
<body class="hold-transition skin-blue-light fixed sidebar-mini">

    <div class="wrapper">
        <header class="main-header">
            <a href="{{ route('dashboard') }}" class="logo">
                <span class="logo-mini"><b>J</b>2</span>
                <span class="logo-lg">{!! config('app.namesystem') !!}</span>
            </a>
            <nav class="navbar navbar-static-top">
                <a href="#" class="sidebar-toggle" data-toggle="offcanvas" role="button">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </a>
                @if($current_user)
                <div class="navbar-custom-menu">
                    <ul class="nav navbar-nav">
                        @if(!$current_user_attempt_error->isEmpty())
                        <li class="user-lastfail hidden-sm hidden-xs">
                            <p>
                                {{ __('Ostatnia nieudana próba zalogowania') }}: <strong>{{ $current_user_attempt_error->first()->created_at }}</strong>
                            </p>
                        </li>
                        @endif
                        <li class="dropdown user user-menu">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                                <img src="{{ $current_user->image ? : '/backend/img/blank.jpg' }}" class="user-image" alt="User Image">
                                <span class="hidden-xs">{{ $current_user->name }}</span>
                            </a>
                            <ul class="dropdown-menu">
                                <li class="user-header">
                                    <img src="{{ $current_user->image ? : '/backend/img/blank.jpg' }}" class="img-circle" alt="User Image">
                                    <p>
                                        {{ $current_user->name }}
                                        <small>Użytkownik od: <strong>{{ $current_user->created_at->toDateString() }}</strong></small>
                                        <small>{{ __('Poziom dostępu') }}: <strong>{{ $current_user_role->title }}</strong></small>
                                    </p>
                                </li>
                                <li class="user-footer">
                                    <div class="pull-left">
                                        <a href="{{ route('profile') }}" class="btn btn-default btn-flat">{{ __('Profil') }}</a>
                                    </div>
                                    <div class="pull-right">
                                        <a href="#" class="btn btn-default btn-flat" data-ajax-send="{{ route('logout') }}" data-ajax-redirect="{{ route('login') }}" data-ajax-token="{{ csrf_token() }}">{{ __('Wyloguj się') }}</a>
                                    </div>
                                </li>
                            </ul>
                        </li>
                    </ul>
                </div>
                @endif
            </nav>
        </header>

        <aside class="main-sidebar">
            <section class="sidebar">
                <ul class="sidebar-menu">
                    <li{{ str_contains(Route::currentRouteName(), 'dashboard') ? ' class=active' : '' }}><a href="{{ route('dashboard') }}"><i class="fa fa-dashboard"></i> <span>{{ __('Pulpit nawigacyjny') }}</span></a></li>
                    <li{{ str_contains(Route::currentRouteName(), 'pages') ? ' class=active' : '' }}><a href="{{ route('dashboard') }}"><i class="fa fa-files-o"></i> <span>{{ __('Strony') }}</span></a></li>
                    <li{{ str_contains(Route::currentRouteName(), 'navigations') ? ' class=active' : '' }}><a href="{{ route('dashboard') }}"><i class="fa fa-compass"></i> <span>{{ __('Nawigacje') }}</span></a></li>
                    <li class="treeview{{ str_contains(Route::currentRouteName(), 'modules') ? ' active' : '' }}">
                        <a href="#">
                            <i class="fa fa-database"></i> <span>{{ __('Moduły') }}</span>
                            <span class="pull-right-container"><i class="fa fa-angle-left pull-right"></i></span>
                        </a>
                        <ul class="treeview-menu">
                            {{-- TODO: DOROBIC LISTING MODULOW --}}
                            <li{{ str_contains(Route::currentRouteName(), 'modules/{name}') ? ' class=active' : '' }}><a href="{{ route('dashboard') }}"> {{ __('moduł') }}</a></li>
                        </ul>
                    </li>
                    <li{{ str_contains(Route::currentRouteName(), 'files') ? ' class=active' : '' }}><a href="{{ route('dashboard') }}"><i class="fa fa-upload"></i> <span>{{ __('Menedżer plików') }}</span></a></li>
                    <li{{ str_contains(Route::currentRouteName(), 'forms') ? ' class=active' : '' }}><a href="{{ route('dashboard') }}"><i class="fa fa-edit"></i> <span>{{ __('Formularze') }}</span></a></li>
                    <li{{ str_contains(Route::currentRouteName(), 'users') ? ' class=active' : '' }}><a href="{{ route('dashboard') }}"><i class="fa fa-users"></i> <span>{{ __('Użytkownicy') }}</span></a></li>
                    <li class="treeview{{ str_contains(Route::currentRouteName(), 'settings') ? ' active' : '' }}">
                        <a href="#">
                            <i class="fa fa-wrench"></i> <span>{{ __('Ustawienia') }}</span>
                            <span class="pull-right-container"><i class="fa fa-angle-left pull-right"></i></span>
                        </a>
                        <ul class="treeview-menu">
                            <li{{ str_contains(Route::currentRouteName(), 'settings/main}') ? ' class=active' : '' }}><a href="{{ route('dashboard') }}"> {{ __('Główne ustawienia') }}</a></li>
                            <li{{ str_contains(Route::currentRouteName(), 'settings/languages}') ? ' class=active' : '' }}><a href="{{ route('dashboard') }}"> {{ __('Języki') }}</a></li>
                            <li{{ str_contains(Route::currentRouteName(), 'settings/translations}') ? ' class=active' : '' }}><a href="{{ route('dashboard') }}"> {{ __('Tłumaczenia') }}</a></li>
                            <li{{ str_contains(Route::currentRouteName(), 'settings/redirects}') ? ' class=active' : '' }}><a href="{{ route('dashboard') }}"> {{ __('Przekierowania') }}</a></li>
                        </ul>
                    </li>
                    <li><hr></li>
                    <li{{ str_contains(Route::currentRouteName(), 'trash') ? ' class=active' : '' }}><a href="{{ route('dashboard') }}"><i class="fa fa-trash"></i> <span>{{ __('Usunięte elementy') }}</span></a></li>
                </ul>
            </section>
            <!-- /.sidebar -->
        </aside>

        <div class="content-wrapper">
            @if(isset($pageTitle))
            <section class="content-header">
                <h1>
                    {{ $pageTitle }}
                </h1>
                @if(isset($breadcrumbs))
                    {!! $breadcrumbs->render() !!}
                @endif
            </section>
            @endif
            <section class="content">
                @yield('content')
            </section>
        </div>

        <footer class="main-footer">
            <div class="pull-right hidden-xs">
                <b>{{ __('Wersja') }}:</b> {{ config('app.version') }}
            </div>
            <strong>{{ __('Prawo autorskie') }} &copy; <a href="http://jampstudio.pl" target="_blank">JAMPstudio</a>.</strong> {{ __('Wszystkie prawa zastrzeżone') }}.
        </footer>

        <div class="control-sidebar-bg"></div>
        <div class="modal fade" id="errorModal" tabindex="-1" role="dialog" aria-labelledby="errorModalLabel">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        <h4 class="modal-title" id="exampleModalLabel">{{ __('Wystąpił błąd') }}</h4>
                    </div>
                    <div class="modal-body">
                        <p>{{ __('Podczas wykonywanej akcji wystąpił błąd. Poniżej przedstawiamy kod błędu. Gdyby się powtarzał prosimy o skontaktowanie się z administratorem JAMPcms2') }}</p>
                        <p class="response" style="overflow-x: auto;"></p>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-success" data-dismiss="modal">Close</button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="/backend/plugins/jQuery/jquery-2.2.3.min.js"></script>
    <script src="/backend/plugins/bootstrap/bootstrap.min.js"></script>
    <script src="/backend/plugins/slimScroll/jquery.slimscroll.min.js"></script>
    <script src="/backend/plugins/fastclick/fastclick.min.js"></script>
    <script src="/backend/plugins/iCheck/icheck.min.js"></script>
    <script src="/backend/js/app.min.js"></script>
    <script src="/backend/js/custom.js"></script>
    <script>
        $(function () {
            $('input').iCheck({
                checkboxClass: 'icheckbox_square-blue',
                radioClass: 'iradio_square-blue',
                increaseArea: '20%' // optional
            });
            console.log('%cCreated by: %cJAMPstudio.pl%c -> %chttp://jampstudio.pl','color: #444','background: #2196F3; color: #fff; padding: 4px;','color: #444','color: #009fe3');
        });
    </script>
</body>
</html>
