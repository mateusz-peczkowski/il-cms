@extends('cmsbackend.layout')

@section('content')
    <div class="row">
        <div class="col-xs-12">
            <div class="box">
                <div class="box-body">
                    @if(Session::has('status'))
                        @if($pages->isEmpty())
                            <br /><br />
                        @endif
                        <div class="alert alert-{{ Session::get('status_type')  }} alert-dismissible" data-autohide="true">
                            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                            <h4 class="mb-0"><i class="icon fa fa-check"></i> {{ Session::get('status') }}!</h4>
                        </div>
                    @endif
                        @if($activity)
                            <div class="js-ajax-paginate">
                                <div class="responsive-table">
                                    <h4>{{ __('Zdarzenia systemowe') }}</h4>
                                    <table class="table table-bordered table-striped with-images">
                                        <thead>
                                            <tr>
                                                <th style="width: 185px;">{{ __('Typ zdarzenia') }}</th>
                                                <th>{{ __('Użytkownik') }}</th>
                                                <th>{{ __('Aktywność') }}</th>
                                                <th>{{ __('Szczegóły') }}</th>
                                                <th>{{ __('Data i czas') }}</th>
                                            </tr>
                                        </thead>
                                        <tbody>

                                        @foreach($activity as $log)

                                            <tr>
                                                <td>{{ $log->description }}</td>
                                                @if(is_object($log->causer) AND isset($log->causer->name))
                                                    <td>{{ $log->causer->name }}</td>
                                                @else
                                                    <td>&nbsp;</td>
                                                @endif
                                                <td>{{ isset($log->properties['attributes']['title']) ? $log->properties['attributes']['title'] : (isset($log->properties['attributes']['name']) ? $log->properties['attributes']['name'] : '') }}</td>
                                                <td>{!! $log->properties !!}</td>
                                                <td>{{ \Carbon\Carbon::parse($log->created_at)->format('Y-m-d H:i:s') }}</td>
                                            </tr>
                                        @endforeach
                                        </tbody>
                                    </table>
                                </div>
                                {{ $activity->links() }}
                            </div>
                        @endif

                        @if($userActivity)
                            <div class="js-ajax-paginate">
                                <div class="responsive-table">
                                    <h4>{{ __('Zdarzenia użytkowników') }}</h4>
                                    <table class="table table-bordered table-striped with-images">
                                        <thead>
                                            <tr>
                                                <th style="width: 185px;">{{ __('Typ zdarzenia') }}</th>
                                                <th>{{ __('Użytkownik') }}</th>
                                                <th>{{ __('Szczegóły') }}</th>
                                                <th>{{ __('Data i czas') }}</th>
                                            </tr>
                                        </thead>
                                        <tbody>

                                        @foreach($userActivity as $log)

                                            <tr>
                                                <td>{{ $log->description }}</td>
                                                <td>{{ is_object($log->causer) ? $log->causer->name : '' }}</td>
                                                <td>{!! $log->properties !!}</td>
                                                <td>{{ \Carbon\Carbon::parse($log->created_at)->format('Y-m-d H:i:s') }}</td>
                                            </tr>
                                        @endforeach
                                        </tbody>
                                    </table>
                                </div>
                                {{ $userActivity->links() }}
                            </div>
                        @endif
                </div>
            </div>
        </div>
    </div>


@endsection

@section('scripts')
    <script>
        var jsAjaxCall = function() {
            $('.js-ajax-paginate').each(function(index) {
                var parent = $(this);
                parent.find('ul.pagination').eq(0).find('a').click(function(e) {
                   e.preventDefault();
                    $.get($(this).attr('href'), function(dataajax) {
                        var content = $(dataajax).find('.js-ajax-paginate').eq(index).html();
                        parent.html(content);
                        jsAjaxCall();
                    });
                });
            });
        }
        jsAjaxCall();
    </script>
@endsection