@extends('cmsbackend.layout')

@section('content')
    <div class="row">
        <div class="col-xs-12">
            <div class="box">
                <div class="box-body">
                    <div class="btn-group">
                        <a href="{{ route('pages.edit', $page->id) }}" class="btn btn-success">{{ __('Ogólne') }}</a>
                        <a href="{{ route('pages.gallery', $page->id) }}" class="btn btn-default disabled">{{ __('Zdjęcia') }}</a>
                        <a href="{{ route('pages.sections', $page->id) }}" class="btn btn-success">{{ __('Sekcje') }}</a>
                        <a href="{{ route('pages.options', $page->id) }}" class="btn btn-success">{{ __('Opcje') }}</a>
                        @can('edit_dev', 'App\User')
                            <a href="{{ route('pages.advanced', $page->id) }}" class="btn btn-success">{{ __('Zaawansowane') }}</a>
                        @endcan
                    </div>
                    <hr>
                </div>
            </div>
        </div>
    </div>
@endsection