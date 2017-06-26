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
            <label>{{ __('Treść sekcji') }}</label>
            {{-- TODO: prztestować czy wpięty edytor WYSIWYG się nadaje --}}
            <textarea rows="12" name="content" id="content" class="form-control" required>{{ old('content') ? : $section->content }}</textarea>
        </div>
    </div>
    <hr>
</div>
