<!DOCTYPE html>
<html>
<head>
    @include('cmsbackend.parts.head')
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
                @if(Auth::user())
                <div class="navbar-custom-menu">
                    <ul class="nav navbar-nav">
                        @if(!Auth::user()->last_attmept_error->isEmpty())
                        <li class="user-lastfail hidden-sm hidden-xs">
                            <p>
                                {{ __('Ostatnia nieudana próba zalogowania') }}: <strong>{{ Auth::user()->last_attmept_error->first()->created_at }}</strong>
                            </p>
                        </li>
                        @endif
                        @if(Session::get('cms_locale') AND CMS::isMoreLocales())
                        <li class="dropdown language language-menu">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                                <span class="text-uppercase">{{ CMS::getLocale() }} <i class="fa fa-angle-down"></i></span>
                            </a>
                            <ul class="dropdown-menu">
                                @foreach(CMS::getMoreLocales() as $lang)
                                    <li><a href="{{ route('changelocale', $lang->slug) }}" class="text-uppercase">{{ $lang->slug }}</a></li>
                                @endforeach
                            </ul>
                        </li>
                        @endif
                        <li class="dropdown user user-menu">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                                <img src="{{ Auth::user()->image ? : '/backend/img/blank.jpg' }}" class="user-image" alt="User Image">
                                <span class="hidden-xs">{{ Auth::user()->name }}</span>
                            </a>
                            <ul class="dropdown-menu">
                                <li class="user-header">
                                    <img src="{{ Auth::user()->image ? : '/backend/img/blank.jpg' }}" class="img-circle" alt="User Image">
                                    <p>
                                        {{ Auth::user()->name }}
                                        @if(Auth::user()->created_at)
                                        <small>{{ __('Użytkownik od') }}: <strong>{{ Auth::user()->created_at->toDateString() }}</strong></small>
                                        @endif
                                        <small>{{ __('Poziom dostępu') }}: <strong>{{ Auth::user()->user_role->title }}</strong></small>
                                    </p>
                                </li>
                                <li class="user-footer">
                                    <a href="#" class="btn btn-danger btn-block" data-ajax-send="{{ route('logout') }}" data-ajax-redirect="{{ route('login') }}" data-ajax-token="{{ csrf_token() }}">{{ __('Wyloguj się') }}</a>
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
                    <li{{ str_contains(Route::currentRouteName(), 'users') ? ' class=active' : '' }}><a href="{{ route('users') }}"><i class="fa fa-users"></i> <span>{{ __('Użytkownicy') }}</span></a></li>
                    <li class="treeview{{ (str_contains(Route::currentRouteName(), 'settings') || str_contains(Route::currentRouteName(), 'languages') || str_contains(Route::currentRouteName(), 'translations') || str_contains(Route::currentRouteName(), 'redirects')) ? ' active' : '' }}">
                        <a href="#">
                            <i class="fa fa-wrench"></i> <span>{{ __('Ustawienia') }}</span>
                            <span class="pull-right-container"><i class="fa fa-angle-left pull-right"></i></span>
                        </a>
                        <ul class="treeview-menu">
                            <li{{ str_contains(Route::currentRouteName(), 'settings/main') ? ' class=active' : '' }}><a href="{{ route('dashboard') }}"> {{ __('Główne ustawienia') }}</a></li>
                            <li{{ str_contains(Route::currentRouteName(), 'languages') ? ' class=active' : '' }}><a href="{{ route('languages') }}"> {{ __('Języki') }}</a></li>
                            <li{{ str_contains(Route::currentRouteName(), 'translations') ? ' class=active' : '' }}><a href="{{ route('translations') }}"> {{ __('Tłumaczenia') }}</a></li>
                            <li{{ str_contains(Route::currentRouteName(), 'redirects') ? ' class=active' : '' }}><a href="{{ route('redirects') }}"> {{ __('Przekierowania') }}</a></li>
                        </ul>
                    </li>
                    <li><hr></li>
                    <li{{ str_contains(Route::currentRouteName(), 'trash') ? ' class=active' : '' }}><a href="{{ route('trash') }}"><i class="fa fa-trash"></i> <span>{{ __('Usunięte elementy') }}</span></a></li>
                    <li><hr></li>
                    <li{{ str_contains(Route::currentRouteName(), 'documentation') ? ' class=active' : '' }}><a href="{{ route('documentation') }}"><i class="fa fa-folder-open"></i> <span>{{ __('Dokumentacja') }}</span></a></li>
                    @can('seechangelog', 'App\User')
                        <li><hr></li>
                        <li{{ str_contains(Route::currentRouteName(), 'changelog') ? ' class=active' : '' }}><a href="{{ route('changelog') }}"><i class="fa fa-book"></i> <span>{{ __('Dziennik zmian') }}</span></a></li>
                    @endcan
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
        @yield('modals')
    </div>

    <script src="/backend/plugins/jQuery/jquery-2.2.3.min.js"></script>
    <script src="/backend/plugins/bootstrap/bootstrap.min.js"></script>
    <script src="/backend/plugins/slimScroll/jquery.slimscroll.min.js"></script>
    <script src="/backend/plugins/fastclick/fastclick.min.js"></script>
    <script src="/backend/plugins/iCheck/icheck.min.js"></script>
    <script src="/backend/plugins/datatables/jquery.dataTables.min.js"></script>
    <script src="/backend/plugins/datatables/dataTables.bootstrap.min.js"></script>
    <script src="/backend/plugins/select2/select2.full.min.js"></script>
    <script src="/backend/js/app.min.js"></script>
    <script src="/backend/js/custom.js"></script>

    @yield('scripts')

</body>
</html>
