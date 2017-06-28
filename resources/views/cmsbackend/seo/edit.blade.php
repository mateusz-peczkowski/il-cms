@extends('cmsbackend.layout')

@section('content')
    <div class="row">
        <div class="col-xs-12">
            <div class="box">
                <div class="box-body">
                    @include('cmsbackend.parts.top_nav.'.$model_name, ['active' => 'seo', 'model' => $model])
                    <hr>
                    @if(Session::has('status'))
                        <div class="alert alert-{{ Session::get('status_type') }} alert-dismissible" data-autohide="true">
                            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                            <h4 class="mb-0"><i class="icon fa fa-check"></i> {{ Session::get('status') }}!</h4>
                        </div>
                    @endif
                    <form role="form" method="POST" action="{{ route('seo', [$model_name, $model->id]) }}">
                        {{ csrf_field() }}
                        @if($seo)
                            {{ method_field('PUT') }}
                            <input type="hidden" name="seo_id" value="{{ $seo->id }}">
                        @endif
                        <?php
                            $meta_title = old('meta_title') ? : ($seo ? $seo->meta_title : '');
                            $meta_description = old('meta_description') ? : ($seo ? $seo->meta_description : '');
                            $meta_keys = old('meta_keys') ? : ($seo ? $seo->meta_keys : '');
                            $page_head = old('page_head') ? : ($seo ? $seo->page_head : '');
                            $page_footer = old('page_footer') ? : ($seo ? $seo->page_footer : '');
                            $include_opengraph = old('include_opengraph') ? : ($seo ? $seo->include_opengraph : false);
                        ?>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>{{ __('Meta title') }}</label>
                                    <input type="text" id="meta_title" name="meta_title" class="form-control" value="{{ $meta_title }}" autofocus />
                                </div>
                                <div class="form-group">
                                    <label>{{ __('Meta description') }}</label>
                                    <textarea name="meta_description" id="meta_description" class="form-control">{{ $meta_description }}</textarea>
                                </div>
                                <div class="form-group">
                                    <label>{{ __('Meta keys') }}</label>
                                    <input type="text" id="meta_keys" name="meta_keys" class="form-control" value="{{ $meta_keys }}" />
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>{{ __('Page head') }}</label>
                                    <textarea name="page_head" id="page_head" class="form-control">{{ $page_head }}</textarea>
                                </div>

                                <div class="form-group">
                                    <label>{{ __('Page footer') }}</label>
                                    <textarea name="page_footer" id="page_footer" class="form-control">{{ $page_footer }}</textarea>
                                </div>
                                <div class="form-group">
                                    <label><input type="checkbox" name="include_opengraph" id="include_opengraph" class="form-control" value="1"  @if($include_opengraph) checked @endif  >&nbsp;{{ __('Include open graph tags?') }}</label>
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