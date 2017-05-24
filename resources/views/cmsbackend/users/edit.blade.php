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
                    <form role="form" method="POST" action="{{ route('users.update', $user->id) }}">
                        {{ csrf_field() }}
                        {{ method_field('PUT') }}
                        <input type="hidden" name="id" value="{{ $user->id }}">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>{{ __('Imię i nazwisko') }}</label>
                                    <input type="text" id="user_name" name="user_name" class="form-control" value="{{ old('user_name') ? : $user->name }}" required />
                                </div>
                                <div class="form-group">
                                    <label>{{ __('Hasło') }} <small class="text-muted">({{ __('wypełnić wyłącznie w przypadku zmiany') }}, {{ __('zalecane: :pass', ['pass' => bin2hex(openssl_random_pseudo_bytes(4))]) }})</small></label>
                                    <input type="password" id="user_password" name="user_password" class="form-control" value="{{ old('user_password') }}">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>{{ __('Adres e-mail') }} <small class="text-muted">({{ __('służy do logowania') }})</small></label>
                                    <input type="email" id="user_email" name="user_email" class="form-control" value="{{ old('user_email') ? : $user->email }}" required />
                                </div>
                                @if(isset($roles))
                                <div class="form-group">
                                    <label>{{ __('Poziom uprawnień') }}</label>
                                    <select class="form-control select2" name="user_role" id="role" style="width: 100%;">
                                        @foreach($roles as $num => $role)
                                            @if(Auth::user()->role >= $role->id)
                                                <option{{ $role->id == $user->role ? ' selected' : '' }} value="{{ $role->id }}">{{ $role->title }}</option>
                                            @endif
                                        @endforeach
                                    </select>
                                </div>
                                @endif
                            </div>
                            <div class="col-xs-12">
                                <div class="text-center mb-0">
                                    <button type="reset" class="btn btn-danger margin">{{ __('Wyczyść formularz') }}</button>
                                    <button type="submit" class="btn btn-success margin">{{ __('Zapisz') }}</button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection