@extends('cmsbackend.layout')

@section('content')
    @if(isset($users))
    <div class="row">
        <div class="col-xs-12">
            <div class="box">
                <div class="box-body">
                    @if($current_user_role_id >= $required_role->id)
                    <a href="{{ route('users.create') }}" class="btn btn-success">{{ __('Dodaj użytkownika') }}</a>
                    <br /><br />
                    @else
                        <div class="alert alert-warning alert-dismissible">
                            {!! __('Posiadasz za małe uprawnienia aby móc edytować i dodawać użytkowników (wymagane przynajmniej: <strong>:role_name</strong>). Możesz jedynie przeglądać użytkowników', ['role_name' => $required_role->title]) !!}
                        </div>
                    @endif
                    @if(Session::has('status'))
                        <div class="alert alert-{{ Session::get('status_type') }} alert-dismissible" data-autohide="true">
                            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                            <h4 class="mb-0"><i class="icon fa fa-check"></i> {{ Session::get('status') }}!</h4>
                        </div>
                    @endif
                    <table class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th>{{ __('Imię i nazwisko') }}</th>
                                <th>{{ __('Adres e-mail') }}</th>
                                <th>{{ __('Poziom dostępu') }}</th>
                                @if($current_user_role_id >= $required_role->id)
                                    <th style="width: 70px;">&nbsp;</th>
                                @endif
                            </tr>
                        </thead>
                        <tbody>
                        @foreach($users as $user)
                            @if(Auth::id() == $user->id)
                                <tr>
                                    <td><strong>{{ $user->name }}</strong></td>
                                    <td><strong>{{ $user->email }}</strong></td>
                                    <td><strong>{{ $user->user_role->title }}</strong></td>
                                    @if($current_user_role_id >= $required_role->id)
                                        <td>&nbsp;</td>
                                    @endif
                                </tr>
                            @else
                                <tr>
                                    <td>{!! $user->status == 2 ? '<s>' : '' !!}{{ $user->name }}{!! $user->status == 2 ? '</s>' : '' !!}</td>
                                    <td>{!! $user->status == 2 ? '<s>' : '' !!}{{ $user->email }}{!! $user->status == 2 ? '</s>' : '' !!}</td>
                                    <td>{!! $user->status == 2 ? '<s>' : '' !!}{{ $user->user_role->title }}{!! $user->status == 2 ? '</s>' : '' !!}</td>
                                    @if($current_user_role_id >= $required_role->id && $current_user_role_id >= $user->role)
                                        <td class="text-right">
                                            <a href="{{ route('users.edit', $user->id) }}" class="text-light-blue"><i class="fa fa-edit"></i></a>
                                            @if($user->status == 1)
                                                <a href="#" data-href="{{ route('users.deactivate', $user->id) }}" class="text-yellow" data-toggle="modal" data-target="#confirm-deactivate"><i class="fa fa-close"></i></a>
                                            @else
                                                <a href="{{ route('users.activate', $user->id) }}" class="text-green"><i class="fa fa-check"></i></a>
                                            @endif
                                            <a href="#" data-href="{{ route('users.delete', $user->id) }}" class="text-red" data-toggle="modal" data-target="#confirm-delete"><i class="fa fa-trash"></i></a>
                                        </td>
                                    @elseif($current_user_role_id >= $required_role->id)
                                        <td>&nbsp;</td>
                                    @endif
                                </tr>
                            @endif
                        @endforeach
                        </tbody>
                        <tfoot>
                            <tr>
                                <th>{{ __('Imię i nazwisko') }}</th>
                                <th>{{ __('Adres e-mail') }}</th>
                                <th>{{ __('Poziom dostępu') }}</th>
                                @if($current_user_role_id >= $required_role->id)
                                    <th>&nbsp;</th>
                                @endif
                            </tr>
                        </tfoot>
                    </table>
                    <div class="pull-right">
                        {{ $users->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
    @endif
@endsection

@section('modals')
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