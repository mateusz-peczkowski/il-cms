@extends('cmsbackend.layout')

@section('content')
    <div class="row">
        <div class="col-xs-12">
            <div class="box">
                <div class="box-body">
                    @include('cmsbackend.parts.top_nav.module_records', ['active' => 'section', 'record' => $record, 'model' => $module])
                    @if(Session::has('status'))
                        <div class="alert alert-{{ Session::get('status_type') }} alert-dismissible" data-autohide="true">
                            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                            <h4 class="mb-0"><i class="icon fa fa-check"></i> {{ Session::get('status') }}!</h4>
                        </div>
                    @endif
                    <form role="form" method="POST" action="{{ route('records.section', [$module->id, $record->id]) }}">
                        {{ csrf_field() }}
                        {{ method_field('PUT') }}
                        <div class="row">
                            @if($structures = json_decode($module->sections_structure))
                                @foreach($structures as $structure)
                                    <?php
                                        $slug = $structure->slug;
                                        $data = isset(json_decode($record->section_data)->$slug) ? json_decode($record->section_data)->$slug : null;
                                    ?>
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            @include('cmsbackend.module_records.section_fields.'.$structure->type)
                                            <hr>
                                        </div>
                                    </div>
                                @endforeach
                            @endif
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