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
                                <th>{{ __('Imię i nazwisko') }}</th>
                                <th>{{ __('Adres e-mail') }}</th>
                                <th>{{ __('Poziom dostępu') }}</th>
                                @if($current_user_role_id >= 3)
                                    <th style="width: 50px;">&nbsp;</th>
                                @endif
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($users as $user)
                                <tr>
                                    <td>{{ $user->name }}</td>
                                    <td>{{ $user->email }}</td>
                                    <td>{{ $user->user_role->title }}</td>
                                    @if($current_user_role_id >= 3 && $current_user_role_id >= $user->role)
                                        <td class="text-right">
                                            <a href="#" data-href="{{ route('trash.revoke', ['user', $user->id]) }}" class="text-blue" data-toggle="modal" data-target="#confirm-revoke"><i class="fa fa-reply"></i></a>
                                            <a href="#" data-href="{{ route('trash.destroy', ['user', $user->id]) }}" class="text-red" data-toggle="modal" data-target="#confirm-destroy"><i class="fa fa-trash"></i></a>
                                        </td>
                                    @endif
                                </tr>
                            @endforeach
                            </tbody>
                            <tfoot>
                            <tr>
                                <th>{{ __('Imię i nazwisko') }}</th>
                                <th>{{ __('Adres e-mail') }}</th>
                                <th>{{ __('Poziom dostępu') }}</th>
                                @if($current_user_role_id >= 3)
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