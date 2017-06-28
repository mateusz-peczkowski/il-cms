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
            <label>{{ __('Treść sekcji') }}</label>
            <textarea rows="12" name="data[{{ $slug }}][content]" id="content" class="form-control" required>{{ isset($data->content) ? $data->content : '' }}</textarea>
        </div>
    </div>
    <hr>
</div>
