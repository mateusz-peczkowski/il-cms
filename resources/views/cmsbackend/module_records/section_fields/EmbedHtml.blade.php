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
            <label>{{ __('Kod HTML') }}</label>
            <textarea rows="12" name="data[{{ $slug }}][html]" class="form-control" required>{{ isset($data->html) ? $data->html : '' }}</textarea>
        </div>
    </div>
    <hr>
</div>