@extends('cmsbackend.layout')

@section('content')
    <div class="row">
        <div class="col-xs-12">
            <div class="box">
                <div class="box-body">
                    <div class="btn-group">
                        <a href="{{ route('pages.edit', $page->id) }}" class="btn btn-default disabled">{{ __('Ogólne') }}</a>
                        <a href="{{ route('pages.gallery', $page->id) }}" class="btn btn-success">{{ __('Zdjęcia') }}</a>
                        <a href="{{ route('pages.sections', $page->id) }}" class="btn btn-success">{{ __('Sekcje') }}</a>
                        <a href="{{ route('pages.options', $page->id) }}" class="btn btn-success">{{ __('Opcje') }}</a>
                        @can('edit_dev', 'App\User')
                            <a href="{{ route('pages.advanced', $page->id) }}" class="btn btn-success">{{ __('Zaawansowane') }}</a>
                        @endcan
                    </div>
                    <hr>
                    @if(Session::has('status'))
                        <div class="alert alert-{{ Session::get('status_type') }} alert-dismissible" data-autohide="true">
                            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                            <h4 class="mb-0"><i class="icon fa fa-check"></i> {{ Session::get('status') }}!</h4>
                        </div>
                    @endif
                    <form role="form" method="POST" action="{{ route('pages.update', $page->id) }}">
                        {{ csrf_field() }}
                        {{ method_field('PUT') }}
                        <input type="hidden" name="id" value="{{ $page->id }}">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
                                    <label>{{ __('Tytuł') }}{{ $errors->has('name') ? ' - '.(__($errors->first('name'))) : '' }}</label>
                                    <input type="text" id="name" name="name" class="form-control" value="{{ old('name') ? : $page->name }}" required autofocus />
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>{{ __('URL') }}</label>
                                    <input name="url" id="url" class="form-control" required value="{{ old('url') ? : $page->url }}">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>{{ __('Opis') }}</label>
                                    <textarea name="description" id="description" class="form-control">{{ old('description') ? : $page->description }}</textarea>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>{{ __('Zdjęcie') }}</label>
                                    @if($page->thumbnail)
                                    <input type="text" class="form-control" value="{{ $page->thumbnail }}" disabled>
                                        <br />
                                    @endif
                                    <input type="file" id="thumbnail" name="thumbnail" accept="image/*" />
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