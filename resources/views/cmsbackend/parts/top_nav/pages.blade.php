<div class="btn-group">
    <a href="{{ route('pages.edit', $model->id) }}" class="btn {{ $active == 'edit' ? 'btn-default disabled' : 'btn-success' }}">{{ __('Ogólne') }}</a>
    <a href="{{ route('pages.gallery', $model->id) }}" class="btn {{ $active == 'gallery' ? 'btn-default disabled' : 'btn-success' }}">{{ __('Zdjęcia') }}</a>
    <a href="{{ route('pages.sections', $model->id) }}" class="btn {{ $active == 'sections' ? 'btn-default disabled' : 'btn-success' }}">{{ __('Sekcje') }}</a>
    <a href="{{ route('pages.options', $model->id) }}" class="btn {{ $active == 'options' ? 'btn-default disabled' : 'btn-success' }}">{{ __('Opcje') }}</a>
    <a href="{{ route('seo', ['pages', $model->id]) }}" class="btn {{ $active == 'seo' ? 'btn-default disabled' : 'btn-success' }}">{{ __('Meta dane') }}</a>
    @can('edit_dev', 'App\User')
        <a href="{{ route('pages.advanced', $model->id) }}" class="btn {{ $active == 'advanced' ? 'btn-default disabled' : 'btn-success' }}">{{ __('Zaawansowane') }}</a>
    @endcan
</div>