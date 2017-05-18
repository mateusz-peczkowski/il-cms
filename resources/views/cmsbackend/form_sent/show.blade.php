@extends('cmsbackend.layout')

@section('content')
    @if(isset($submits))
    <div class="row">
        <div class="col-xs-12">
            <div class="box">
                <div class="box-body">
                    @if($submits AND !$submits->isEmpty())
                    <table class="table table-bordered table-striped with-images">
                        <thead>
                            <tr>
                                <th style="width: 35px;">{{ __('Lp.') }}</th>
                                <th>{{ __('Data') }}</th>
                                <th>{{ __('Ip') }}</th>
                                <th>{{ __('Język') }}</th>
                                <th>{{ __('Treść') }}</th>
                            </tr>
                        </thead>
                        <tbody>
                        @foreach($submits as $num => $submit)
                            <tr>
                                <td style="text-align: center;">{{ $num+1 }}</td>
                                <td>{{ $submit->created_at }}</td>
                                <td>{{ $submit->ip }}</td>
                                <td>{{ $submit->language }}</td>
                                @if($submit->data)
                                    <td>
                                        @foreach(json_decode($submit->data) as $key => $value)
                                            <strong>{{ $key }}:</strong> {{ $value }}<br />
                                        @endforeach
                                    </td>
                                @else
                                    <td>&nbsp;</td>
                                @endif
                            </tr>
                        @endforeach
                        </tbody>
                        <tfoot>
                            <tr>
                                <th style="width: 35px;">{{ __('Lp.') }}</th>
                                <th>{{ __('Data') }}</th>
                                <th>{{ __('Ip') }}</th>
                                <th>{{ __('Język') }}</th>
                                <th>{{ __('Treść') }}</th>
                            </tr>
                        </tfoot>
                    </table>
                    <div class="pull-right">
                        {{ $submits->links() }}
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
    @endif
@endsection