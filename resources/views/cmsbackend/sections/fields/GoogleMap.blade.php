<div class="row">
    <div class="col-md-6">
        <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
            <label>{{ __('Tytuł sekcji') }}{{ $errors->has('name') ? ' - '.(__($errors->first('title'))) : '' }}</label>
            <input type="text" id="title" name="title" class="form-control" value="{{ old('title') ? : $section->title }}" required autofocus />
        </div>
    </div>
    <div class="col-md-6">
        <div class="form-group">
            <label>{{ __('Nagłówek sekcji') }}</label>
            <input type="text" name="header" id="header" class="form-control" value="{{ old('header') ? : $section->header }}">
        </div>
    </div>
    <div class="col-md-12">
        <div class="form-group">
            <label>{{ __('Lokalizacja') }}</label>
            <input type="text" name="options[location]" id="location" class="form-control" value="{{ old('options[location]') ? : isset($section->options['location']) ? $section->options['location'] : '' }}" required>
        </div>
    </div>
    <div class="col-md-12" style="height: 400px;">
        {!! Mapper::render() !!}
    </div>
    <hr>
</div>