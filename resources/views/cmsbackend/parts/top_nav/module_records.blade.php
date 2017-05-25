<div class="btn-group">
    <a href="{{ route('records.edit', [$model->module_id, $model->id]) }}" class="btn {{ $active == 'edit' ? 'btn-default disabled' : 'btn-success' }}">{{ __('Ogólne') }}</a>
    <a href="{{ route('seo', ['module_records', $model->id]) }}" class="btn {{ $active == 'seo' ? 'btn-default disabled' : 'btn-success' }}">{{ __('Meta dane') }}</a>
</div>