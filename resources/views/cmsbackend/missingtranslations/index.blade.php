@extends('cmsbackend.layout')

@section('content')
    @if(isset($translations))
        <div class="row">
            <div class="col-xs-12">
                <div class="box">
                    <div class="box-body">
                        @if(Session::has('status'))
                            @if(empty($translations))
                                <br /><br />
                            @endif
                            <div class="alert alert-{{ Session::get('status_type') }} alert-dismissible" data-autohide="true">
                                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                                <h4 class="mb-0"><i class="icon fa fa-check"></i> {{ Session::get('status') }}!</h4>
                            </div>
                        @endif
                        @if(!empty($translations))
                            <form action="{{ route('missing.translations.create') }}" method="POST">
                                {{ csrf_field() }}
                                <table class="table table-bordered table-striped">
                                    <thead>
                                    <tr>
                                        <th style="width: 35px;">{{ __('Lp.') }}</th>
                                        <th>{{ __('Klucz') }}</th>
                                        <th>{{ __('Istniejące tłumaczenie') }}</th>
                                        <th>{{ __('Brakujące tłumaczenie') }}</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($translations as $key => $languages)
                                        <tr>
                                            <td style="text-align: center;">{{ $loop->index + 1 }}</td>
                                            <td>{{ $key }}</td>
                                            <td><label>{{ key($languages['translatedValue']) }}</label><br>{{ $languages['translatedValue'][key($languages['translatedValue'])] }}</td>
                                            <td>
                                                @foreach($languages[0] as $slug => $language)
                                                    <div class="form-group">
                                                        <label>{{ $language }} <input class="form-control" type="text" name="missing_translation[{{ $key }}][{{ $slug }}]" ></label>
                                                    </div>
                                                @endforeach
                                            </td>
                                        </tr>
                                    @endforeach
                                    </tbody>
                                    <tfoot>
                                    <tr>
                                        <th style="width: 35px;">{{ __('Lp.') }}</th>
                                        <th>{{ __('Klucz') }}</th>
                                        <th>{{ __('Istniejce tłumaczenie') }}</th>
                                        <th>{{ __('Brakujące tłumaczenie') }}</th>
                                    </tr>
                                    </tfoot>
                                </table>
                                <div class="col-xs-12">
                                    <div class="text-center mb-0">
                                        <button type="reset" class="btn btn-danger margin">{{ __('Wyczyść formularz') }}</button>
                                        <button type="submit" class="btn btn-success margin">{{ __('Zapisz') }}</button>
                                    </div>
                                </div>
                            </form>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    @endif
@endsection