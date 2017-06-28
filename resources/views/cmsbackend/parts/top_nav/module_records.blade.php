<?php
    $structures = json_decode($module->sections_structure);
?>
<div class="btn-group">
    <a href="{{ route('records.edit', [$record->module_id, $record->id]) }}" class="btn {{ $active == 'edit' ? 'btn-default disabled' : 'btn-success' }}">{{ __('Ogólne') }}</a>
    @if($structures)
    <a href="{{ route('records.section', [$record->module_id, $record->id]) }}" class="btn {{ $active == 'section' ? 'btn-default disabled' : 'btn-success' }}">{{ __('Sekcje') }}</a>
    @endif
    @if($module->has_details)
    <a href="{{ route('seo', ['module_records', $record->id]) }}" class="btn {{ $active == 'seo' ? 'btn-default disabled' : 'btn-success' }}">{{ __('Meta dane') }}</a>
    @endif
</div>
@if($structures || $module->has_details)
    <hr>
@endif