<form role="form" method="POST" action="{{ route('pages.update', $section->id) }}">
    {{ csrf_field() }}
    {{ method_field('PUT') }}
    <input type="hidden" name="id" value="{{ $section->id }}">
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
                <label>{{ __('Lokalizacja') }}</label>
                <input type="text" name="location" id="location" class="form-control" value="{{ old('content') ? : $section->content }}" required>
            </div>
        </div>
        <div class="col-md-12" style="height: 400px;">
            {!! Mapper::render() !!}
        </div>
        <hr>
    </div>
</form>