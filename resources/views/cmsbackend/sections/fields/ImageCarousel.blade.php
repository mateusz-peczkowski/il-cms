<div class="row">
    <div class="col-md-6">
        <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
            <label>{{ __('Tytuł sekcji') }}{{ $errors->has('name') ? ' - '.(__($errors->first('title'))) : '' }}</label>
            <input type="text" id="title" name="name" class="form-control" value="{{ old('title') ? : $section->title }}" required autofocus />
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
            <label>{{ __('Galeria') }}</label>
            {{-- TODO: dodać zarządanie galerią gdy skończone będzie zarządzanie mediami --}}
            {!! $section->options['carousel'] !!}
        </div>
    </div>
    <hr>
</div>