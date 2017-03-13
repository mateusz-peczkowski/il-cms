@extends('cmsbackend.layout')

@section('content')
    <div class="row">
        <div class="col-xs-12">
            <div class="box">
                <div class="box-body">
                    @if(Session::has('status'))
                        <div class="alert alert-{{ Session::get('status_type') }} alert-dismissible" data-autohide="true">
                            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                            <h4 class="mb-0"><i class="icon fa fa-check"></i> {{ Session::get('status') }}!</h4>
                        </div>
                    @endif
                    <form role="form" method="POST" action="{{ route('users') }}">
                        {{ csrf_field() }}
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>{{ __('Imię i nazwisko') }}</label>
                                    <input type="text" id="name" name="user_name" class="form-control" value="{{ old('user_name') }}" required />
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>{{ __('Adres e-mail') }} {{ __('(służy do logowania)') }}</label>
                                    <input type="text" id="email" name="user_email" class="form-control" value="{{ old('user_email') }}" required />
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>{{ __('Hasło') }} {{ __('(zalecane: :pass)', ['pass' => bin2hex(openssl_random_pseudo_bytes(4))]) }}</label>
                                    <input type="password" id="password" name="user_password" class="form-control" value="{{ old('user_password') }}" required autofocus>
                                </div>
                            </div>
                            @if(isset($roles))
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>{{ __('Poziom uprawnień') }}</label>
                                    <select class="form-control select2" name="user_role" id="role" style="width: 100%;">
                                        @foreach($roles as $num => $role)
                                            @if($role->id <= $current_user_role->id)
                                                <option{{ $num == 0 ? ' selected' : '' }} value="{{ $role->id }}">{{ $role->title }}</option>
                                            @endif
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            @endif
                            <div class="col-xs-12">
                                <div class="text-center mb-0">
                                    <button type="reset" class="btn btn-danger margin">{{ __('Wyczyść formularz') }}</button>
                                    <button type="submit" class="btn btn-success margin">{{ __('Dodaj użytkownika') }}</button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection