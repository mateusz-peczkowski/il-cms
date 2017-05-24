@extends('cmsbackend.layout')

@section('content')
    <div class="row">
        <div class="col-xs-12">
            <div class="box">
                <div class="box-body">
                    @include('cmsbackend.parts.top_nav.pages', ['active' => 'sections', 'model' => $page])
                    <hr>
                </div>
            </div>
        </div>
    </div>
@endsection