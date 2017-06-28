<div class="row">
    <div class="col-md-6">
        <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
            <label>{{ __('Tytuł sekcji') }}{{ $errors->has('name') ? ' - '.(__($errors->first('title'))) : '' }}</label>
            <input type="text" name="data[{{ $slug }}][title]" class="form-control" value="{{ isset($data->title) ? $data->title : '' }}" required autofocus />
        </div>
    </div>
    <div class="col-md-6">
        <div class="form-group">
            <label>{{ __('Nagłówek sekcji') }}</label>
            <input type="text" name="data[{{ $slug }}][header]" class="form-control" value="{{ isset($data->header) ? $data->header : '' }}">
        </div>
    </div>
    <div class="col-md-12">
        <div class="form-group">
            <label>{{ __('Galeria') }}</label>
            {{-- TODO: dodać zarządanie galerią gdy skończone będzie zarządzanie mediami --}}
        </div>
    </div>
    <hr>
</div>