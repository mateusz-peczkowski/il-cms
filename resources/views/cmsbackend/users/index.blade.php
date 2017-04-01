@extends('cmsbackend.layout')

@section('content')
    @if(isset($users))
    <div class="row">
        <div class="col-xs-12">
            <div class="box">
                <div class="box-body">
                    @can('add', 'App\User')
                    <span class="btn btn-success" data-toggle="modal" data-target="#add-new">{{ __('Dodaj użytkownika') }}</span>
                        @if(!$users->isEmpty())
                            <br /><br />
                        @endif
                    @else
                        <div class="alert alert-warning alert-dismissible">
                            {!! __('Posiadasz za małe uprawnienia aby móc edytować i dodawać użytkowników (wymagane przynajmniej: <strong>administrator</strong>). Możesz jedynie przeglądać użytkowników') !!}
                        </div>
                    @endcan
                    @if(Session::has('status'))
                        @if($users->isEmpty())
                            <br /><br />
                        @endif
                        <div class="alert alert-{{ Session::get('status_type') }} alert-dismissible" data-autohide="true">
                            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                            <h4 class="mb-0"><i class="icon fa fa-check"></i> {{ Session::get('status') }}!</h4>
                        </div>
                    @endif
                    @if(!$users->isEmpty())
                    <table class="table table-bordered table-striped with-images">
                        <thead>
                            <tr>
                                <th style="width: 35px;">{{ __('Lp.') }}</th>
                                <th>{{ __('Imię i nazwisko') }}</th>
                                <th>{{ __('Adres e-mail') }}</th>
                                <th>{{ __('Poziom dostępu') }}</th>
                                <th><strong>{{ __('Ostatnia edycja') }}</strong> <small class="text-muted">({{ __('strefa czasowa: :timezone', ['timezone' => config('app.timezone')]) }})</small></th>
                                @can('edit', 'App\User')
                                    <th style="width: 70px;">&nbsp;</th>
                                @endcan
                            </tr>
                        </thead>
                        <tbody>
                        @foreach($users as $num => $user)
                            <tr>
                                @if(Auth::id() == $user->id)
                                    <td style="text-align: center;"><strong>{{ $num+1 }}</strong></td>
                                    <td><strong>{{ $user->name }}</strong></td>
                                    <td><strong>{{ $user->email }}</strong></td>
                                    <td><strong>{{ $user->user_role->title }}</strong></td>
                                    @if($user->who_updated)
                                        <td><img src="{{ $user->updater->image ? : '/backend/img/blank.jpg' }}" class="user-circle-image" width="25" height="25" alt=""> {{ $user->updater->name }} <small class="text-muted">({{ $user->updated_at }})</small></td>
                                    @else
                                        <td>&nbsp;</td>
                                    @endif
                                    @can('edit', 'App\User')
                                        <td>&nbsp;</td>
                                    @endcan
                                @else
                                    <td style="text-align: center;">{!! $user->status == 2 ? '<s>' : '' !!}{{ $num+1 }}{!! $user->status == 2 ? '</s>' : '' !!}</td>
                                    <td>{!! $user->status == 2 ? '<s>' : '' !!}{{ $user->name }}{!! $user->status == 2 ? '</s>' : '' !!}</td>
                                    <td>{!! $user->status == 2 ? '<s>' : '' !!}{{ $user->email }}{!! $user->status == 2 ? '</s>' : '' !!}</td>
                                    <td>{!! $user->status == 2 ? '<s>' : '' !!}{{ $user->user_role->title }}{!! $user->status == 2 ? '</s>' : '' !!}</td>
                                    @if($user->who_updated)
                                        <td><img src="{{ $user->updater->image ? : '/backend/img/blank.jpg' }}" class="user-circle-image" width="25" height="25" alt=""> {{ $user->updater->name }} <small class="text-muted">({{ $user->updated_at }})</small></td>
                                    @else
                                        <td>&nbsp;</td>
                                    @endif
                                    @can('edit', 'App\User')
                                    <td class="text-right">
                                                @if($user->role <= Auth::user()->role)
                                                <a href="{{ route('users.edit', $user->id) }}" class="text-light-blue" title="{{ __('Edytuj') }}"><i class="fa fa-edit"></i></a>
                                                @if($user->status == 1)
                                                    <a href="#" data-href="{{ route('users.deactivate', $user->id) }}" class="text-yellow" data-toggle="modal" data-target="#confirm-deactivate" title="{{ __('Zdezaktywuj') }}"><i class="fa fa-close"></i></a>
                                                @else
                                                    <a href="{{ route('users.activate', $user->id) }}" class="text-green" title="{{ __('Aktywuj') }}"><i class="fa fa-check"></i></a>
                                                @endif
                                                <a href="#" data-href="{{ route('users.delete', $user->id) }}" class="text-red" data-toggle="modal" data-target="#confirm-delete" title="{{ __('Usuń') }}"><i class="fa fa-trash"></i></a>
                                                @endif
                                    </td>
                                    @endcan
                                @endif
                            </tr>
                        @endforeach
                        </tbody>
                        <tfoot>
                            <tr>
                                <th style="width: 35px;">{{ __('Lp.') }}</th>
                                <th>{{ __('Imię i nazwisko') }}</th>
                                <th>{{ __('Adres e-mail') }}</th>
                                <th>{{ __('Poziom dostępu') }}</th>
                                <th><strong>{{ __('Ostatnia edycja') }}</strong> <small class="text-muted">({{ __('strefa czasowa: :timezone', ['timezone' => config('app.timezone')]) }})</small></th>
                                @can('edit', 'App\User')
                                    <th>&nbsp;</th>
                                @endcan
                            </tr>
                        </tfoot>
                    </table>
                    <div class="pull-right">
                        {{ $users->links() }}
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
    @endif
@endsection

@section('modals')
    @can('add', 'App\User')
        <div class="modal fade" id="add-new" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <form role="form" method="POST" action="{{ route('users') }}" class="modal-content">
                    {{ csrf_field() }}
                    <div class="modal-header">
                        {{ __('Dodaj użytkownika') }}
                    </div>
                    <div class="modal-body">
                        <div class="form-group">
                            <label>{{ __('Imię i nazwisko') }}</label>
                            <input type="text" id="user_name" name="user_name" class="form-control" value="{{ old('user_name') }}" required autofocus />
                        </div>
                        <div class="form-group">
                            <label>{{ __('Adres e-mail') }} <small class="text-muted">({{ __('służy do logowania') }})</small></label>
                            <input type="email" id="user_email" name="user_email" class="form-control" value="{{ old('user_email') }}" required autofocus />
                        </div>
                        <div class="form-group">
                            <label>{{ __('Hasło') }} <small class="text-muted">({{ __('zalecane: :pass', ['pass' => bin2hex(openssl_random_pseudo_bytes(4))]) }})</small></label>
                            <input type="password" id="user_password" name="user_password" class="form-control" value="{{ old('user_password') }}" required autofocus>
                        </div>
                        @if(isset($roles))
                        <div class="form-group">
                            <label>{{ __('Poziom uprawnień') }}</label>
                            <select class="form-control select2" name="user_role" id="role" style="width: 100%;">
                                @foreach($roles as $num => $role)
                                    @if($role->id <= Auth::user()->role)
                                        <option{{ $num == 0 ? ' selected' : '' }} value="{{ $role->id }}">{{ $role->title }}</option>
                                    @endif
                                @endforeach
                            </select>
                        </div>
                        @endif
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger pull-left" data-dismiss="modal">{{ __('Anuluj') }}</button>
                        <button type="submit" class="btn btn-success margin">{{ __('Dodaj użytkownika') }}</button>
                    </div>
                </form>
            </div>
        </div>
    @endcan
    <div class="modal fade" id="confirm-delete" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    {{ __('Czy jesteś tego pewien?') }}
                </div>
                <div class="modal-body">
                    {!! __('Po usunięciu konto użytkownika zostanie zablokowane a ten wylogowany z systemu.<br />Usuniętego użytkownika można przywrócić z Usuniętych elementów') !!}
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-success pull-left" data-dismiss="modal">{{ __('Anuluj') }}</button>
                    <a class="btn btn-danger pull-right btn-ok">{{ __('Usuń użytkownika') }}</a>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="confirm-deactivate" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    {{ __('Czy jesteś tego pewien?') }}
                </div>
                <div class="modal-body">
                    {!! __('Po zdezaktywowaniu konta użytkownik nie będzie mógł logować się w systemie, a jeżeli jest aktualnie zalogowany to zostanie wylogowany.') !!}
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-success pull-left" data-dismiss="modal">{{ __('Anuluj') }}</button>
                    <a class="btn btn-danger pull-right btn-ok">{{ __('Zdezaktywuj użytkownika') }}</a>
                </div>
            </div>
        </div>
    </div>
@endsection