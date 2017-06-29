@extends('cmsbackend.layout')

@section('content')
        <div class="row">
            <div class="col-xs-12">
                @if(isset($users) && $users->isEmpty())
                    @if(Session::has('status-user'))
                        <div class="alert alert-{{ Session::get('status_type') }} alert-dismissible" data-autohide="true">
                            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                            <h4 class="mb-0"><i class="icon fa fa-check"></i> {{ Session::get('status-user') }}!</h4>
                        </div>
                    @endif
                @endif
                @if(isset($users) && !$users->isEmpty())
                <div class="box">
                    <div class="box-header with-border">
                        <i class="fa fa-users"></i>
                        <h3 class="box-title">{{ __('Użytkownicy') }}</h3>
                    </div>
                    <div class="box-body">
                        @if(Session::has('status-user'))
                            <div class="alert alert-{{ Session::get('status_type') }} alert-dismissible" data-autohide="true">
                                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                                <h4 class="mb-0"><i class="icon fa fa-check"></i> {{ Session::get('status-user') }}!</h4>
                            </div>
                        @endif
                        <table class="table table-bordered table-striped">
                            <thead>
                            <tr>
                                <th class="text-center" style="width: 35px;">{{ __('Lp.') }}</th>
                                <th>{{ __('Imię i nazwisko') }}</th>
                                <th>{{ __('Adres e-mail') }}</th>
                                <th>{{ __('Poziom dostępu') }}</th>
                                <th><strong>{{ __('Usunięte przez') }}</strong> <small class="text-muted">({{ __('strefa czasowa: :timezone', ['timezone' => config('app.timezone')]) }})</small></th>
                                @can('revokeDestroy', 'App\User')
                                    <th style="width: 50px;">&nbsp;</th>
                                @endcan
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($users as $num => $user)
                                <tr>
                                    <td style="text-align: center;">{{ $num+1 }}</td>
                                    <td>{{ $user->name }}</td>
                                    <td>{{ $user->email }}</td>
                                    <td>{{ $user->user_role->title }}</td>
                                    <td><img src="{{ $user->updater->image ? : '/backend/img/blank.jpg' }}" class="user-circle-image" width="25" height="25" alt=""> {{ $user->updater->name }} <small class="text-muted">({{ $user->updated_at }})</small></td>
                                    @can('revokeDestroy', 'App\User')
                                        <td class="text-right">
                                            <a href="#" data-href="{{ route('trash.revoke', ['user', $user->id]) }}" class="text-blue" data-toggle="modal" data-target="#confirm-revoke"><i class="fa fa-reply" title="{{ __('Przywróć') }}"></i></a>
                                            <a href="#" data-href="{{ route('trash.destroy', ['user', $user->id, 'update']) }}" class="text-red" data-toggle="modal" data-target="#confirm-destroy" title="{{ __('Usuń na stałe') }}"><i class="fa fa-trash"></i></a>
                                        </td>
                                    @endcan
                                </tr>
                            @endforeach
                            </tbody>
                            <tfoot>
                            <tr>
                                <th class="text-center" style="width: 35px;">{{ __('Lp.') }}</th>
                                <th>{{ __('Imię i nazwisko') }}</th>
                                <th>{{ __('Adres e-mail') }}</th>
                                <th>{{ __('Poziom dostępu') }}</th>
                                <th><strong>{{ __('Usunięte przez') }}</strong> <small class="text-muted">({{ __('strefa czasowa: :timezone', ['timezone' => config('app.timezone')]) }})</small></th>
                                @can('revokeDestroy', 'App\User')
                                    <th>&nbsp;</th>
                                @endcan
                            </tr>
                            </tfoot>
                        </table>
                        <div class="pull-right">
                            {{ $users->links() }}
                        </div>
                    </div>
                </div>
                @endif


                @if(isset($redirects) && $redirects->isEmpty())
                    @if(Session::has('status-redirect'))
                        <div class="alert alert-{{ Session::get('status_type') }} alert-dismissible" data-autohide="true">
                            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                            <h4 class="mb-0"><i class="icon fa fa-check"></i> {{ Session::get('status-redirect') }}!</h4>
                        </div>
                    @endif
                @endif
                @if(isset($redirects) && !$redirects->isEmpty())
                    <div class="box">
                        <div class="box-header with-border">
                            <i class="fa fa-refresh"></i>
                            <h3 class="box-title">{{ __('Przekierowania') }}</h3>
                        </div>
                        <div class="box-body">
                            @if(Session::has('status-redirect'))
                                <div class="alert alert-{{ Session::get('status_type') }} alert-dismissible" data-autohide="true">
                                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                                    <h4 class="mb-0"><i class="icon fa fa-check"></i> {{ Session::get('status-redirect') }}!</h4>
                                </div>
                            @endif
                            <table class="table table-bordered table-striped">
                                <thead>
                                <tr>
                                    <th class="text-center" style="width: 35px;">{{ __('Lp.') }}</th>
                                    <th>{{ __('Z adresu') }}</th>
                                    <th>{{ __('Na adres') }}</th>
                                    <th><strong>{{ __('Usunięte przez') }}</strong> <small class="text-muted">({{ __('strefa czasowa: :timezone', ['timezone' => config('app.timezone')]) }})</small></th>
                                    @can('revokeDestroy', 'App\User')
                                        <th style="width: 50px;">&nbsp;</th>
                                    @endcan
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($redirects as $num => $redirect)
                                    <tr>
                                        <td style="text-align: center;">{{ $num+1 }}</td>
                                        <td>{{ $redirect->from }}</td>
                                        <td>{{ $redirect->to }}</td>
                                        <td><img src="{{ $redirect->updater->image ? : '/backend/img/blank.jpg' }}" class="user-circle-image" width="25" height="25" alt=""> {{ $redirect->updater->name }} <small class="text-muted">({{ $redirect->updated_at }})</small></td>
                                        @can('revokeDestroy', 'App\User')
                                            <td class="text-right">
                                                <a href="#" data-href="{{ route('trash.revoke', ['redirect', $redirect->id]) }}" class="text-blue" data-toggle="modal" data-target="#confirm-revoke" title="{{ __('Przywróć') }}"><i class="fa fa-reply"></i></a>
                                                <a href="#" data-href="{{ route('trash.destroy', ['redirect', $redirect->id, 'destroy']) }}" class="text-red" data-toggle="modal" data-target="#confirm-destroy" title="{{ __('Usuń na stałe') }}"><i class="fa fa-trash"></i></a>
                                            </td>
                                        @endcan
                                    </tr>
                                @endforeach
                                </tbody>
                                <tfoot>
                                <tr>
                                    <th class="text-center" style="width: 35px;">{{ __('Lp.') }}</th>
                                    <th>{{ __('Z adresu') }}</th>
                                    <th>{{ __('Na adres') }}</th>
                                    <th><strong>{{ __('Usunięte przez') }}</strong> <small class="text-muted">({{ __('strefa czasowa: :timezone', ['timezone' => config('app.timezone')]) }})</small></th>
                                    @can('revokeDestroy', 'App\User')
                                        <th style="width: 50px;">&nbsp;</th>
                                    @endcan
                                </tr>
                                </tfoot>
                            </table>
                            <div class="pull-right">
                                {{ $redirects->links() }}
                            </div>
                        </div>
                    </div>
                @endif


                @if(isset($languages) && $languages->isEmpty())
                    @if(Session::has('status-language'))
                        <div class="alert alert-{{ Session::get('status_type') }} alert-dismissible" data-autohide="true">
                            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                            <h4 class="mb-0"><i class="icon fa fa-check"></i> {{ Session::get('status-language') }}!</h4>
                        </div>
                    @endif
                @endif
                @if(isset($languages) && !$languages->isEmpty())
                    <div class="box">
                        <div class="box-header with-border">
                            <i class="fa fa-language"></i>
                            <h3 class="box-title">{{ __('Języki') }}</h3>
                        </div>
                        <div class="box-body">
                            @if(Session::has('status-language'))
                                <div class="alert alert-{{ Session::get('status_type') }} alert-dismissible" data-autohide="true">
                                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                                    <h4 class="mb-0"><i class="icon fa fa-check"></i> {{ Session::get('status-language') }}!</h4>
                                </div>
                            @endif
                            <table class="table table-bordered table-striped">
                                <thead>
                                <tr>
                                    <th class="text-center" style="width: 35px;">{{ __('Lp.') }}</th>
                                    <th>{{ __('Tytuł') }}</th>
                                    <th>{{ __('Slug') }}</th>
                                    <th><strong>{{ __('Usunięte przez') }}</strong> <small class="text-muted">({{ __('strefa czasowa: :timezone', ['timezone' => config('app.timezone')]) }})</small></th>
                                    @can('revokeDestroy', 'App\User')
                                        <th style="width: 50px;">&nbsp;</th>
                                    @endcan
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($languages as $num => $language)
                                    <tr>
                                        <td class="text-center">{{ $num+1 }}</td>
                                        <td>{{ $language->title }}</td>
                                        <td>{{ $language->slug }}</td>
                                        <td><img src="{{ $language->updater->image ? : '/backend/img/blank.jpg' }}" class="user-circle-image" width="25" height="25" alt=""> {{ $language->updater->name }} <small class="text-muted">({{ $language->updated_at }})</small></td>
                                        @can('revokeDestroy', 'App\User')
                                            <td class="text-right">
                                                <a href="#" data-href="{{ route('trash.revoke', ['language', $language->id]) }}" class="text-blue" data-toggle="modal" data-target="#confirm-revoke" title="{{ __('Przywróć') }}"><i class="fa fa-reply"></i></a>
                                                <a href="#" data-href="{{ route('trash.destroy', ['language', $language->id, 'update']) }}" class="text-red" data-toggle="modal" data-target="#confirm-destroy" title="{{ __('Usuń na stałe') }}"><i class="fa fa-trash"></i></a>
                                            </td>
                                        @endcan
                                    </tr>
                                @endforeach
                                </tbody>
                                <tfoot>
                                <tr>
                                    <th class="text-center" style="width: 35px;">{{ __('Lp.') }}</th>
                                    <th>{{ __('Tytuł') }}</th>
                                    <th>{{ __('Slug') }}</th>
                                    <th><strong>{{ __('Usunięte przez') }}</strong> <small class="text-muted">({{ __('strefa czasowa: :timezone', ['timezone' => config('app.timezone')]) }})</small></th>
                                    @can('revokeDestroy', 'App\User')
                                        <th style="width: 50px;">&nbsp;</th>
                                    @endcan
                                </tr>
                                </tfoot>
                            </table>
                            <div class="pull-right">
                                {{ $languages->links() }}
                            </div>
                        </div>
                    </div>
                @endif


                @if(isset($translations) && $translations->isEmpty())
                    @if(Session::has('status-translation'))
                        <div class="alert alert-{{ Session::get('status_type') }} alert-dismissible" data-autohide="true">
                            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                            <h4 class="mb-0"><i class="icon fa fa-check"></i> {{ Session::get('status-translation') }}!</h4>
                        </div>
                    @endif
                @endif
                @if(isset($translations) && !$translations->isEmpty())
                    <div class="box">
                        <div class="box-header with-border">
                            <i class="fa fa-key"></i>
                            <h3 class="box-title">{{ __('Tłumaczenia') }}</h3>
                        </div>
                        <div class="box-body">
                            @if(Session::has('status-translation'))
                                <div class="alert alert-{{ Session::get('status_type') }} alert-dismissible" data-autohide="true">
                                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                                    <h4 class="mb-0"><i class="icon fa fa-check"></i> {{ Session::get('status-translation') }}!</h4>
                                </div>
                            @endif
                            <table class="table table-bordered table-striped">
                                <thead>
                                <tr>
                                    <th class="text-center" style="width: 35px;">{{ __('Lp.') }}</th>
                                    <th>{{ __('Klucz') }}</th>
                                    <th>{{ __('Wartość') }}</th>
                                    @if(CMS::isMoreLocales())
                                        <th>{{ __('Język') }}</th>
                                    @endif
                                    <th><strong>{{ __('Usunięte przez') }}</strong> <small class="text-muted">({{ __('strefa czasowa: :timezone', ['timezone' => config('app.timezone')]) }})</small></th>
                                    @can('revokeDestroy', 'App\User')
                                        <th style="width: 50px;">&nbsp;</th>
                                    @endcan
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($translations as $num => $translation)
                                    <tr>
                                        <td style="text-align: center;">{{ $num+1 }}</td>
                                        <td>{{ $translation->key }}</td>
                                        <td>{{ $translation->value }}</td>
                                        @if(CMS::isMoreLocales())
                                            <td class="text-uppercase">{{ $translation->locale }}</td>
                                        @endif
                                        <td><img src="{{ $translation->updater->image ? : '/backend/img/blank.jpg' }}" class="user-circle-image" width="25" height="25" alt=""> {{ $translation->updater->name }} <small class="text-muted">({{ $translation->updated_at }})</small></td>
                                        @can('revokeDestroy', 'App\User')
                                            <td class="text-right">
                                                <a href="#" data-href="{{ route('trash.revoke', ['translation', $translation->id]) }}" class="text-blue" data-toggle="modal" data-target="#confirm-revoke" title="{{ __('Przywróć') }}"><i class="fa fa-reply"></i></a>
                                                <a href="#" data-href="{{ route('trash.destroy', ['translation', $translation->id, 'destroy']) }}" class="text-red" data-toggle="modal" data-target="#confirm-destroy" title="{{ __('Usuń na stałe') }}"><i class="fa fa-trash"></i></a>
                                            </td>
                                        @endcan
                                    </tr>
                                @endforeach
                                </tbody>
                                <tfoot>
                                <tr>
                                    <th class="text-center" style="width: 35px;">{{ __('Lp.') }}</th>
                                    <th>{{ __('Klucz') }}</th>
                                    <th>{{ __('Wartość') }}</th>
                                    @if(CMS::isMoreLocales())
                                        <th>{{ __('Język') }}</th>
                                    @endif
                                    <th><strong>{{ __('Usunięte przez') }}</strong> <small class="text-muted">({{ __('strefa czasowa: :timezone', ['timezone' => config('app.timezone')]) }})</small></th>
                                    @can('revokeDestroy', 'App\User')
                                        <th style="width: 50px;">&nbsp;</th>
                                    @endcan
                                </tr>
                                </tfoot>
                            </table>
                            <div class="pull-right">
                                {{ $translations->links() }}
                            </div>
                        </div>
                    </div>
                @endif


                @if(isset($forms) && $forms->isEmpty())
                    @if(Session::has('status-form'))
                        <div class="alert alert-{{ Session::get('status_type') }} alert-dismissible" data-autohide="true">
                            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                            <h4 class="mb-0"><i class="icon fa fa-check"></i> {{ Session::get('status-form') }}!</h4>
                        </div>
                    @endif
                @endif
                @if(isset($forms) && !$forms->isEmpty())
                    <div class="box">
                        <div class="box-header with-border">
                            <i class="fa fa-edit"></i>
                            <h3 class="box-title">{{ __('Formularze') }}</h3>
                        </div>
                        <div class="box-body">
                            @if(Session::has('status-form'))
                                <div class="alert alert-{{ Session::get('status_type') }} alert-dismissible" data-autohide="true">
                                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                                    <h4 class="mb-0"><i class="icon fa fa-check"></i> {{ Session::get('status-form') }}!</h4>
                                </div>
                            @endif
                            <table class="table table-bordered table-striped">
                                <thead>
                                <tr>
                                    <th style="width: 35px;">{{ __('Lp.') }}</th>
                                    <th>{{ __('Nazwa') }}</th>
                                    <th>{{ __('Liczba przesłanych formularzy') }}</th>
                                    <th>{{ __('Liczba kontrolek') }}</th>
                                    <th><strong>{{ __('Usunięte przez') }}</strong> <small class="text-muted">({{ __('strefa czasowa: :timezone', ['timezone' => config('app.timezone')]) }})</small></th>
                                    @can('revokeDestroy', 'App\User')
                                        <th style="width: 50px;">&nbsp;</th>
                                    @endcan
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($forms as $num => $form)
                                    <tr>
                                        <td style="text-align: center;">{{ $num+1 }}</td>
                                        <td>{{ $form->title }} ({{ $form->locale }})</td>
                                        <td>{{ count($form->submits) }}</td>
                                        <td>{{ count($form->controls) }}</td>
                                        @if($form->who_updated)
                                            <td><img src="{{ $form->updater->image ? : '/backend/img/blank.jpg' }}" class="user-circle-image" width="25" height="25" alt=""> {{ $form->updater->name }} <small class="text-muted">({{ $form->updated_at }})</small></td>
                                        @else
                                            <td>&nbsp;</td>
                                        @endif
                                        @can('revokeDestroy', 'App\User')
                                            <td class="text-right">
                                                <a href="#" data-href="{{ route('trash.revoke', ['form', $form->id]) }}" class="text-blue" data-toggle="modal" data-target="#confirm-revoke" title="{{ __('Przywróć') }}"><i class="fa fa-reply"></i></a>
                                                <a href="#" data-href="{{ route('trash.destroy', ['form', $form->id, 'destroy']) }}" class="text-red" data-toggle="modal" data-target="#confirm-destroy" title="{{ __('Usuń na stałe') }}"><i class="fa fa-trash"></i></a>
                                            </td>
                                        @endcan
                                    </tr>
                                @endforeach
                                </tbody>
                                <tfoot>
                                <tr>
                                    <th style="width: 35px;">{{ __('Lp.') }}</th>
                                    <th>{{ __('Nazwa') }}</th>
                                    <th>{{ __('Liczba przesłanych formularzy') }}</th>
                                    <th>{{ __('Liczba kontrolek') }}</th>
                                    <th><strong>{{ __('Usunięte przez') }}</strong> <small class="text-muted">({{ __('strefa czasowa: :timezone', ['timezone' => config('app.timezone')]) }})</small></th>
                                    @can('revokeDestroy', 'App\User')
                                        <th style="width: 50px;">&nbsp;</th>
                                    @endcan
                                </tr>
                                </tfoot>
                            </table>
                            <div class="pull-right">
                                {{ $forms->links() }}
                            </div>
                        </div>
                    </div>
                @endif


                @if(isset($pages) && $pages->isEmpty())
                        @if(Session::has('status-form'))
                            <div class="alert alert-{{ Session::get('status_type') }} alert-dismissible" data-autohide="true">
                                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                                <h4 class="mb-0"><i class="icon fa fa-check"></i> {{ Session::get('status-form') }}!</h4>
                            </div>
                        @endif
                    @endif
                    @if(isset($pages) && !$pages->isEmpty())
                        <div class="box">
                            <div class="box-header with-border">
                                <i class="fa fa-files-o"></i>
                                <h3 class="box-title">{{ __('Strony') }}</h3>
                            </div>
                            <div class="box-body">
                                @if(Session::has('status-page'))
                                    <div class="alert alert-{{ Session::get('status_type') }} alert-dismissible" data-autohide="true">
                                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                                        <h4 class="mb-0"><i class="icon fa fa-check"></i> {{ Session::get('status-page') }}!</h4>
                                    </div>
                                @endif
                                <table class="table table-bordered table-striped">
                                    <thead>
                                    <tr>
                                        <th style="width: 35px;">{{ __('Lp.') }}</th>
                                        <th>{{ __('Tytuł') }}</th>
                                        <th>{{ __('URL') }}</th>
                                        <th>{{ __('Data stworzenia') }} <small class="text-muted">({{ __('strefa czasowa: :timezone', ['timezone' => config('app.timezone')]) }})</small></th>
                                        <th><strong>{{ __('Usunięte przez') }}</strong> <small class="text-muted">({{ __('strefa czasowa: :timezone', ['timezone' => config('app.timezone')]) }})</small></th>
                                        @can('revokeDestroy', 'App\User')
                                            <th style="width: 50px;">&nbsp;</th>
                                        @endcan
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($pages as $num => $page)
                                        <tr>
                                            <td style="text-align: center;">{{ $num+1 }}</td>
                                            <td>{{ $page->name }} ({{ $page->locale }})</td>
                                            <td>{{ $page->url }}</td>
                                            <td>{{ $page->created_at }}</td>
                                            @if($page->who_updated)
                                                <td><img src="{{ $page->updater->image ? : '/backend/img/blank.jpg' }}" class="user-circle-image" width="25" height="25" alt=""> {{ $page->updater->name }} <small class="text-muted">({{ $page->updated_at }})</small></td>
                                            @else
                                                <td>&nbsp;</td>
                                            @endif
                                            @can('revokeDestroy', 'App\User')
                                                <td class="text-right">
                                                    <a href="#" data-href="{{ route('trash.revoke', ['page', $page->id]) }}" class="text-blue" data-toggle="modal" data-target="#confirm-revoke" title="{{ __('Przywróć') }}"><i class="fa fa-reply"></i></a>
                                                    <a href="#" data-href="{{ route('trash.destroy', ['page', $page->id, 'destroy']) }}" class="text-red" data-toggle="modal" data-target="#confirm-destroy" title="{{ __('Usuń na stałe') }}"><i class="fa fa-trash"></i></a>
                                                </td>
                                            @endcan
                                        </tr>
                                    @endforeach
                                    </tbody>
                                    <tfoot>
                                    <tr>
                                        <th style="width: 35px;">{{ __('Lp.') }}</th>
                                        <th>{{ __('Tytuł') }}</th>
                                        <th>{{ __('URL') }}</th>
                                        <th>{{ __('Data stworzenia') }} <small class="text-muted">({{ __('strefa czasowa: :timezone', ['timezone' => config('app.timezone')]) }})</small></th>
                                        <th><strong>{{ __('Usunięte przez') }}</strong> <small class="text-muted">({{ __('strefa czasowa: :timezone', ['timezone' => config('app.timezone')]) }})</small></th>
                                        @can('revokeDestroy', 'App\User')
                                            <th style="width: 50px;">&nbsp;</th>
                                        @endcan
                                    </tr>
                                    </tfoot>
                                </table>
                                <div class="pull-right">
                                    {{ $pages->links() }}
                                </div>
                            </div>
                        </div>
                    @endif


                @if(isset($modules) && $modules->isEmpty())
                        @if(Session::has('status-form'))
                            <div class="alert alert-{{ Session::get('status_type') }} alert-dismissible" data-autohide="true">
                                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                                <h4 class="mb-0"><i class="icon fa fa-check"></i> {{ Session::get('status-form') }}!</h4>
                            </div>
                        @endif
                    @endif
                    @if(isset($modules) && !$modules->isEmpty())
                        <div class="box">
                            <div class="box-header with-border">
                                <i class="fa fa-database"></i>
                                <h3 class="box-title">{{ __('Moduły') }}</h3>
                            </div>
                            <div class="box-body">
                                @if(Session::has('status-module'))
                                    <div class="alert alert-{{ Session::get('status_type') }} alert-dismissible" data-autohide="true">
                                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                                        <h4 class="mb-0"><i class="icon fa fa-check"></i> {{ Session::get('status-module') }}!</h4>
                                    </div>
                                @endif
                                <table class="table table-bordered table-striped">
                                    <thead>
                                    <tr>
                                        <th style="width: 35px;">{{ __('Lp.') }}</th>
                                        <th>{{ __('Tytuł') }}</th>
                                        <th><strong>{{ __('Usunięte przez') }}</strong> <small class="text-muted">({{ __('strefa czasowa: :timezone', ['timezone' => config('app.timezone')]) }})</small></th>
                                        @can('revokeDestroy', 'App\User')
                                            <th style="width: 50px;">&nbsp;</th>
                                        @endcan
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($modules as $num => $module)
                                        <tr>
                                            <td style="text-align: center;">{{ $num+1 }}</td>
                                            <td>{{ $module->title }}</td>
                                            @if($module->who_updated)
                                                <td><img src="{{ $module->updater->image ? : '/backend/img/blank.jpg' }}" class="user-circle-image" width="25" height="25" alt=""> {{ $module->updater->name }} <small class="text-muted">({{ $module->updated_at }})</small></td>
                                            @else
                                                <td>&nbsp;</td>
                                            @endif
                                            @can('revokeDestroy', 'App\User')
                                                <td class="text-right">
                                                    <a href="#" data-href="{{ route('trash.revoke', ['module', $module->id]) }}" class="text-blue" data-toggle="modal" data-target="#confirm-revoke" title="{{ __('Przywróć') }}"><i class="fa fa-reply"></i></a>
                                                    <a href="#" data-href="{{ route('trash.destroy', ['module', $module->id, 'destroy']) }}" class="text-red" data-toggle="modal" data-target="#confirm-destroy" title="{{ __('Usuń na stałe') }}"><i class="fa fa-trash"></i></a>
                                                </td>
                                            @endcan
                                        </tr>
                                    @endforeach
                                    </tbody>
                                    <tfoot>
                                    <tr>
                                        <th style="width: 35px;">{{ __('Lp.') }}</th>
                                        <th>{{ __('Tytuł') }}</th>
                                        <th><strong>{{ __('Usunięte przez') }}</strong> <small class="text-muted">({{ __('strefa czasowa: :timezone', ['timezone' => config('app.timezone')]) }})</small></th>
                                        @can('revokeDestroy', 'App\User')
                                            <th style="width: 50px;">&nbsp;</th>
                                        @endcan
                                    </tr>
                                    </tfoot>
                                </table>
                                <div class="pull-right">
                                    {{ $modules->links() }}
                                </div>
                            </div>
                        </div>
                    @endif


                @if(isset($navigations) && $navigations->isEmpty())
                        @if(Session::has('status-form'))
                            <div class="alert alert-{{ Session::get('status_type') }} alert-dismissible" data-autohide="true">
                                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                                <h4 class="mb-0"><i class="icon fa fa-check"></i> {{ Session::get('status-form') }}!</h4>
                            </div>
                        @endif
                    @endif
                    @if(isset($navigations) && !$navigations->isEmpty())
                        <div class="box">
                            <div class="box-header with-border">
                                <i class="fa fa-database"></i>
                                <h3 class="box-title">{{ __('Nawigacje') }}</h3>
                            </div>
                            <div class="box-body">
                                @if(Session::has('status-navigation'))
                                    <div class="alert alert-{{ Session::get('status_type') }} alert-dismissible" data-autohide="true">
                                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                                        <h4 class="mb-0"><i class="icon fa fa-check"></i> {{ Session::get('status-navigation') }}!</h4>
                                    </div>
                                @endif
                                <table class="table table-bordered table-striped">
                                    <thead>
                                    <tr>
                                        <th style="width: 35px;">{{ __('Lp.') }}</th>
                                        <th>{{ __('Tytuł') }}</th>
                                        <th><strong>{{ __('Usunięte przez') }}</strong> <small class="text-muted">({{ __('strefa czasowa: :timezone', ['timezone' => config('app.timezone')]) }})</small></th>
                                        @can('revokeDestroy', 'App\User')
                                            <th style="width: 50px;">&nbsp;</th>
                                        @endcan
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($navigations as $num => $navigation)
                                        <tr>
                                            <td style="text-align: center;">{{ $num+1 }}</td>
                                            <td>{{ $navigation->title }}</td>
                                            @if($navigation->who_updated)
                                                <td><img src="{{ $navigation->updater->image ? : '/backend/img/blank.jpg' }}" class="user-circle-image" width="25" height="25" alt=""> {{ $navigation->updater->name }} <small class="text-muted">({{ $navigation->updated_at }})</small></td>
                                            @else
                                                <td>&nbsp;</td>
                                            @endif
                                            @can('revokeDestroy', 'App\User')
                                                <td class="text-right">
                                                    <a href="#" data-href="{{ route('trash.revoke', ['navigation', $navigation->id]) }}" class="text-blue" data-toggle="modal" data-target="#confirm-revoke" title="{{ __('Przywróć') }}"><i class="fa fa-reply"></i></a>
                                                    <a href="#" data-href="{{ route('trash.destroy', ['navigation', $navigation->id, 'destroy']) }}" class="text-red" data-toggle="modal" data-target="#confirm-destroy" title="{{ __('Usuń na stałe') }}"><i class="fa fa-trash"></i></a>
                                                </td>
                                            @endcan
                                        </tr>
                                    @endforeach
                                    </tbody>
                                    <tfoot>
                                    <tr>
                                        <th style="width: 35px;">{{ __('Lp.') }}</th>
                                        <th>{{ __('Tytuł') }}</th>
                                        <th><strong>{{ __('Usunięte przez') }}</strong> <small class="text-muted">({{ __('strefa czasowa: :timezone', ['timezone' => config('app.timezone')]) }})</small></th>
                                        @can('revokeDestroy', 'App\User')
                                            <th style="width: 50px;">&nbsp;</th>
                                        @endcan
                                    </tr>
                                    </tfoot>
                                </table>
                                <div class="pull-right">
                                    {{ $navigations->links() }}
                                </div>
                            </div>
                        </div>
                @endif

                    @if(isset($sitemaps) && $sitemaps->isEmpty())
                        @if(Session::has('status-sitemap'))
                            <div class="alert alert-{{ Session::get('status_type') }} alert-dismissible" data-autohide="true">
                                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                                <h4 class="mb-0"><i class="icon fa fa-check"></i> {{ Session::get('status-sitemap') }}!</h4>
                            </div>
                        @endif
                    @endif
                    @if(isset($sitemaps) && !$sitemaps->isEmpty())
                        <div class="box">
                            <div class="box-header with-border">
                                <i class="fa fa-globe"></i>
                                <h3 class="box-title">{{ __('Mapa strony') }}</h3>
                            </div>
                            <div class="box-body">
                                @if(Session::has('status-sitemap'))
                                    <div class="alert alert-{{ Session::get('status_type') }} alert-dismissible" data-autohide="true">
                                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                                        <h4 class="mb-0"><i class="icon fa fa-check"></i> {{ Session::get('status-sitemap') }}!</h4>
                                    </div>
                                @endif
                                <table class="table table-bordered table-striped">
                                    <thead>
                                    <tr>
                                        <th style="width: 35px;">{{ __('Lp.') }}</th>
                                        <th>{{ __('URL') }}</th>
                                        <th><strong>{{ __('Usunięte przez') }}</strong> <small class="text-muted">({{ __('strefa czasowa: :timezone', ['timezone' => config('app.timezone')]) }})</small></th>
                                        @can('revokeDestroy', 'App\User')
                                            <th style="width: 50px;">&nbsp;</th>
                                        @endcan
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($sitemaps as $num => $sitemap)
                                        <tr>
                                            <td style="text-align: center;">{{ $num+1 }}</td>
                                            <td>{{ $sitemap->url }}</td>
                                            @if($sitemap->who_updated)
                                                <td><img src="{{ $sitemap->updater->image ? : '/backend/img/blank.jpg' }}" class="user-circle-image" width="25" height="25" alt=""> {{ $sitemap->updater->name }} <small class="text-muted">({{ $sitemap->updated_at }})</small></td>
                                            @else
                                                <td>&nbsp;</td>
                                            @endif
                                            @can('revokeDestroy', 'App\User')
                                                <td class="text-right">
                                                    <a href="#" data-href="{{ route('trash.revoke', ['sitemap', $sitemap->id, '1']) }}" class="text-blue" data-toggle="modal" data-target="#confirm-revoke" title="{{ __('Przywróć') }}"><i class="fa fa-reply"></i></a>
                                                    <a href="#" data-href="{{ route('trash.destroy', ['sitemap', $sitemap->id, 'destroy']) }}" class="text-red" data-toggle="modal" data-target="#confirm-destroy" title="{{ __('Usuń na stałe') }}"><i class="fa fa-trash"></i></a>
                                                </td>
                                            @endcan
                                        </tr>
                                    @endforeach
                                    </tbody>
                                    <tfoot>
                                    <tr>
                                        <th style="width: 35px;">{{ __('Lp.') }}</th>
                                        <th>{{ __('URL') }}</th>
                                        <th><strong>{{ __('Usunięte przez') }}</strong> <small class="text-muted">({{ __('strefa czasowa: :timezone', ['timezone' => config('app.timezone')]) }})</small></th>
                                        @can('revokeDestroy', 'App\User')
                                            <th style="width: 50px;">&nbsp;</th>
                                        @endcan
                                    </tr>
                                    </tfoot>
                                </table>
                                <div class="pull-right">
                                    {{ $sitemaps->links() }}
                                </div>
                            </div>
                        </div>
                    @endif
            </div>
        </div>
@endsection

@section('modals')
    <div class="modal fade" id="confirm-revoke" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    {{ __('Czy na pewno chcesz przywrócić element?') }}
                </div>
                <div class="modal-body">
                    {!! __('Element po przywróceniu wróci do swojej zakładki ze statusem nieaktywny. Aby aktywować przywrócony element przejdź do podstrony i go zaktywuj') !!}
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger pull-left" data-dismiss="modal">{{ __('Anuluj') }}</button>
                    <a class="btn btn-success pull-right btn-ok">{{ __('Przywróć') }}</a>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="confirm-destroy" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    {{ __('Czy na pewno chcesz usunąć element?') }}
                </div>
                <div class="modal-body">
                    {!! __('Po usunięciu elementu z kosza nie będzie możliwości jego przywrócenia!') !!}
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-success pull-left" data-dismiss="modal">{{ __('Anuluj') }}</button>
                    <a class="btn btn-danger pull-right btn-ok">{{ __('Usuń') }}</a>
                </div>
            </div>
        </div>
    </div>
@endsection