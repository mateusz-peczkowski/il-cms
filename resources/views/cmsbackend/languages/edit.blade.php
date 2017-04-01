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
                    <form role="form" method="POST" action="{{ route('languages.update', $language->id) }}">
                        {{ csrf_field() }}
                        {{ method_field('PUT') }}
                        <input type="hidden" name="id" value="{{ $language->id }}">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>{{ __('Tytuł') }}</label>
                                    <input type="text" id="language_title" name="language_title" class="form-control" value="{{ old('language_title') ? : $language->title }}" required />
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>{{ __('Slug') }} <small>({{ __('np. pl') }})</small></label>
                                    <input type="text" id="language_slug" name="language_slug" class="form-control" value="{{ old('language_slug') ? : $language->slug }}" required />
                                </div>
                            </div>
                            @if(!$language->is_default)
                            <div class="col-md-6">
                                <div class="form-group">
                                    <div class="checkbox icheck">
                                        <label>
                                            <input type="checkbox" name="language_is_default"{{ old('language_is_default') ? ' checked' : '' }}> {{ __('Domyślny język') }} <small>({{ __('Przełączenie spowoduje zmianę domyślnego języka strony oraz systemu') }})</small>
                                        </label>
                                    </div>
                                </div>
                            </div>
                            @endif
                            <div class="col-xs-12">
                                <div class="text-center mb-0">
                                    <button type="reset" class="btn btn-danger margin">{{ __('Wyczyść formularz') }}</button>
                                    <button type="submit" class="btn btn-success margin">{{ __('Edytuj język') }}</button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection