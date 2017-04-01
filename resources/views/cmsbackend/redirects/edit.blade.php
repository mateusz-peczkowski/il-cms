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
                    <form role="form" method="POST" action="{{ route('redirects.update', $redirect->id) }}">
                        {{ csrf_field() }}
                        {{ method_field('PUT') }}
                        <input type="hidden" name="id" value="{{ $redirect->id }}">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>{{ __('Z adresu') }} <small class="text-muted">({{ __('np. /adres-do-przekierowania/test') }})</small></label>
                                    <input type="text" id="redirect_from" name="redirect_from" class="form-control" value="{{ old('redirect_from') ? : $redirect->from }}" required />
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>{{ __('Na adres') }} <small class="text-muted">({{ __('np. /adres lub http://adres.pl/adres jeżeli przekierowanie zewnętrzne') }})</small></label>
                                    <input type="text" id="redirect_to" name="redirect_to" class="form-control" value="{{ old('redirect_to') ? : $redirect->to }}" required />
                                </div>
                            </div>
                            <div class="col-xs-12">
                                <div class="text-center mb-0">
                                    <button type="reset" class="btn btn-danger margin">{{ __('Wyczyść formularz') }}</button>
                                    <button type="submit" class="btn btn-success margin">{{ __('Edytuj przekierowanie') }}</button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection