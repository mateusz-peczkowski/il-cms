@extends('cmsbackend.layout')

@section('content')
    <div class="row">
        <div class="col-xs-12">
            <div class="box">
                <div class="box-body">
                    @if(Session::has('status'))
                        <div class="alert alert-{{ Session::get('status_type') }} alert-dismissible" data-autohide="true">
                            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                            <h4 class="mb-0"><i class="icon fa fa-check"></i> {{ Session::get('status') }}!</h4>
                        </div>
                    @endif
                    <form role="form" method="POST" action="{{ route('pages.sections.value', $option->id) }}">
                        {{ csrf_field() }}
                        {{ method_field('PUT') }}
                        <div class="row">
                            <div class="col-xs-12">
                                {!! $section !!}
                            </div>
                            <div class="col-xs-12">
                                <div class="text-center mb-0">
                                    @can('add_dev', 'App\User')
                                        <a href="{{ route('pages.options.edit', $option->id) }}" class="btn btn-info margin" title="{{ __('Edytuj strukturę') }}">{{ __('Edytuj strukturę') }}</a>
                                    @endcan
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

@section('scripts')
    <script>
        $('#show-type[data-donthide="false"]').slideUp();
        $('#type').on('change', function() {
            var allowArray = ['select', 'checkbox'];
            if($.inArray($(this).val(), allowArray) > -1) {
                $('#show-type').slideDown();
                $('#show-type #values').attr('required', 'required');
            } else {
                $('#show-type').slideUp();
                $('#show-type #values').removeAttr('required');
            }
        });
    </script>
@endsection