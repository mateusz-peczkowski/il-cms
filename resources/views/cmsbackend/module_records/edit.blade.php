@extends('cmsbackend.layout')

@section('content')
    <div class="row">
        <div class="col-xs-12">
            <div class="box">
                <div class="box-body">
                    @if($module->has_details)
                        @include('cmsbackend.parts.top_nav.module_records', ['active' => 'edit', 'model' => $record])
                        <hr>
                    @endif
                    @if(Session::has('status'))
                        <div class="alert alert-{{ Session::get('status_type') }} alert-dismissible" data-autohide="true">
                            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                            <h4 class="mb-0"><i class="icon fa fa-check"></i> {{ Session::get('status') }}!</h4>
                        </div>
                    @endif
                    <form role="form" method="POST" action="{{ route('records.edit', [$module->id, $record->id]) }}">
                        {{ csrf_field() }}
                        {{ method_field('PUT') }}
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>{{ __('Tytuł') }}</label>
                                    <input type="text" id="title" name="title" class="form-control" value="{{ old('title') ? : $record->title }}" required />
                                </div>
                            </div>
                            @if($structures = json_decode($module->structure))
                                <?php $data = json_decode($record->data); ?>
                                <div class="col-md-12">
                                    <hr>
                                </div>
                                @foreach($structures as $structure)
                                    <?php
                                        $slug = $structure->slug;
                                    ?>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            @if($structure->type != 'checkbox')
                                                <label>{{ __($structure->title) }}</label>
                                            @else
                                                <br>
                                            @endif
                                            @if($structure->type == 'textarea')
                                                <textarea name="data[{{ $structure->slug }}]" id="data-{{ $structure->slug }}" class="form-control"{{ $structure->required ? ' required' : '' }}>{{ old('data['.$structure->slug.']') ? : (isset($data->$slug) ? $data->$slug : '') }}</textarea>
                                            @elseif($structure->type == 'file')
                                                    @if(isset($data->$slug))
                                                        <input type="text" value="{{ $data->$slug }}" class="form-control" disabled>
                                                    @endif
                                                    <input type="file" id="data-{{ $structure->slug }}" name="data[{{ $structure->slug }}]" accept="*" />
                                            @elseif($structure->type == 'checkbox')
                                                <label><input type="checkbox" id="data-{{ $structure->slug }}" name="data[{{ $structure->slug }}]" class="form-control"{{ $structure->required ? ' required' : '' }}{{ (old('data['.$structure->slug.']') || (isset($data->$slug) AND $data->$slug)) ? ' checked' : '' }} /> {{ __($structure->title) }}</label>
                                            @else
                                                <input type="{{ $structure->type }}" id="data-{{ $structure->slug }}" name="data[{{ $structure->slug }}]" class="form-control" value="{{ old('data['.$structure->slug.']') ? : (isset($data->$slug) ? $data->$slug : '') }}"{{ $structure->required ? ' required' : '' }} />
                                            @endif
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