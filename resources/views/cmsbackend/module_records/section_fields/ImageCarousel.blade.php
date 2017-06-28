<div class="row">
    <div class="col-md-6">
        <div class="form-group">
            <label>{{ __('Tytuł sekcji') }}</label>
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
            <label>{{ __('Slider') }}</label>
            {{-- TODO: dodać zarządanie galerią gdy skończone będzie zarządzanie mediami --}}
            {!! isset($data->carousel) ? $data->carousel : '' !!}
        </div>
    </div>
    <hr>
</div>