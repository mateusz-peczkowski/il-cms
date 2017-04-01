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
                                            <a href="#" data-href="{{ route('trash.destroy', ['user', $user->id]) }}" class="text-red" data-toggle="modal" data-target="#confirm-destroy" title="{{ __('Usuń na stałe') }}"><i class="fa fa-trash"></i></a>
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
                                                <a href="#" data-href="{{ route('trash.destroy', ['redirect', $redirect->id]) }}" class="text-red" data-toggle="modal" data-target="#confirm-destroy" title="{{ __('Usuń na stałe') }}"><i class="fa fa-trash"></i></a>
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
                                                <a href="#" data-href="{{ route('trash.destroy', ['language', $language->id]) }}" class="text-red" data-toggle="modal" data-target="#confirm-destroy" title="{{ __('Usuń na stałe') }}"><i class="fa fa-trash"></i></a>
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
                                        <td><img src="{{ $translation->updater->image ? : '/backend/img/blank.jpg' }}" class="user-circle-image" width="25" height="25" alt=""> {{ $translation->updater->name }} <small class="text-muted">({{ $translation->updated_at }})</small></td>
                                        @can('revokeDestroy', 'App\User')
                                            <td class="text-right">
                                                <a href="#" data-href="{{ route('trash.revoke', ['translation', $translation->id]) }}" class="text-blue" data-toggle="modal" data-target="#confirm-revoke" title="{{ __('Przywróć') }}"><i class="fa fa-reply"></i></a>
                                                <a href="#" data-href="{{ route('trash.destroy', ['translation', $translation->id]) }}" class="text-red" data-toggle="modal" data-target="#confirm-destroy" title="{{ __('Usuń na stałe') }}"><i class="fa fa-trash"></i></a>
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
                    <a class="btn btn-success pull-right btn-ok">{{ __('Przywróć element') }}</a>
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
                    <a class="btn btn-danger pull-right btn-ok">{{ __('Usuń element') }}</a>
                </div>
            </div>
        </div>
    </div>
@endsection