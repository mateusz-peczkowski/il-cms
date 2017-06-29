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
                    <form role="form" method="POST" action="{{ route('sitemap.update', $record->id) }}">
                        {{ csrf_field() }}
                        {{ method_field('PUT') }}
                        <input type="hidden" name="id" value="{{ $record->id }}">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group{{ $errors->has('url') ? ' has-error' : '' }}">
                                    <label>{{ __('URL') }}{{ $errors->has('name') ? ' - '.(__($errors->first('url'))) : '' }}</label>
                                    <input type="text" id="url" name="url" class="form-control" value="{{ old('url') ? : $record->url }}" required autofocus />
                                </div>
                                <div class="form-group">
                                    <label>{{ __('Typ') }}</label>
                                    <?php $type = old('type') ? : $record->type ?>
                                    <select name="type" id="type" class="form-control">
                                        <option value="page" {{ $type == 'page' ? ' selected' : '' }}>{{ __('Strona')  }}</option>
                                        <option value="module" {{ $type == 'module' ? ' selected' : '' }}>{{ __('Moduł')  }}</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>{{ __('Częstotliwość aktualizacji') }}</label>
                                    <?php $update = old('update_frequency') ? : $record->update_frequency ?>
                                    <select name="update_frequency" id="update_frequency" class="form-control">
                                        <option value="daily" {{ $update == 'daily' ? ' selected' : '' }}>{{ __('Codziennie')  }}</option>
                                        <option value="weekly" {{ $update == 'weekly' ? ' selected' : '' }}>{{ __('Co tydzień')  }}</option>
                                        <option value="monthly" {{ $update == 'monthly' ? ' selected' : '' }}>{{ __('Co miesiąc')  }}</option>
                                        <option value="yearly" {{ $update == 'yearly' ? ' selected' : '' }}>{{ __('Co rok')  }}</option>
                                    </select>
                                </div>
                                <div class="form-group{{ $errors->has('priorty') ? ' has-error' : '' }}">
                                    <label>{{ __('Priorytet') }}{{ $errors->has('priorty') ? ' - '.(__($errors->first('priorty'))) : '' }}</label>
                                    <input type="text" id="priorty" name="priorty" class="form-control" value="{{ old('priorty') ? : $record->priorty }}" required />
                                </div>
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