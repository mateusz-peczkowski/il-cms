@extends('auth.layout')

@section('content')
    <p class="login-box-msg">{{ __('Zaloguj się do systemu') }}</p>
    <form role="form" method="POST" action="{{ route('login') }}">
        {{ csrf_field() }}
        <div class="form-group has-feedback{{ $errors->has('email') ? ' has-error' : '' }}">
            <label for="email">{{ __('Podaj adres e-mail') }}</label>
            <input type="email" id="email" name="email" class="form-control" value="{{ old('email') }}">
            <span class="glyphicon glyphicon-envelope form-control-feedback"></span>
            @if ($errors->has('email'))
                <span class="help-block">
                <strong>{{ __($errors->first('email')) }}</strong>
            </span>
            @endif
        </div>
        <div class="form-group has-feedback{{ $errors->has('password') ? ' has-error' : '' }}">
            <label for="password">{{ __('Podaj Twoje hasło') }}</label>
            <input type="password" id="password" name="password" class="form-control" value="{{ old('password') }}">
            <span class="glyphicon glyphicon-lock form-control-feedback"></span>
            @if ($errors->has('password'))
                <span class="help-block">
                <strong>{{ __($errors->first('password')) }}</strong>
            </span>
            @endif
        </div>
        <div class="row">
            <div class="col-xs-8">
                <div class="checkbox icheck">
                    <label>
                        <input type="checkbox" name="remember" {{ old('remember') ? 'checked' : '' }}> {{ __('Zapamiętaj mnie') }}
                    </label>
                </div>
            </div>
            <div class="col-xs-4">
                <button type="submit" class="btn btn-primary btn-block btn-flat">{{ __('Zaloguj się') }}</button>
            </div>
        </div>
    </form>
@endsection