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
            <label>{{ __('Lokalizacja') }}</label>
            <input type="text" name="data[{{ $slug }}][location]" id="location" class="form-control" value="{{ isset($data->location) ? $data->location : '' }}" required>
        </div>
    </div>
    <div class="col-md-12" style="height: 400px;">
        <?php Mapper::location(isset($data->location) ? $data->location : 'default')->map(); ?>
        {!! Mapper::render() !!}
    </div>
    <hr>
</div>