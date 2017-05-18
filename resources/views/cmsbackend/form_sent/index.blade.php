@extends('cmsbackend.layout')

@section('content')
    @if(isset($forms))
    <div class="row">
        <div class="col-xs-12">
            <div class="box">
                <div class="box-body">
                    @if(!$forms->isEmpty())
                    <table class="table table-bordered table-striped with-images">
                        <thead>
                            <tr>
                                <th style="width: 35px;">{{ __('Lp.') }}</th>
                                <th>{{ __('Nazwa') }}</th>
                                <th>{{ __('Liczba przesłanych formularzy') }}</th>
                                <th>{{ __('Ostatni wysłany') }} <small class="text-muted">({{ __('strefa czasowa: :timezone', ['timezone' => config('app.timezone')]) }})</small></th>
                                <th style="width: 35px;">&nbsp;</th>
                            </tr>
                        </thead>
                        <tbody>
                        @foreach($forms as $num => $form)
                            <tr>
                                <td style="text-align: center;">{{ $num+1 }}</td>
                                <td>{{ $form->title }}</td>
                                <td>{{ count($form->submits) }}</td>
                                <td>{{ count($form->submits) ? $form->last_submit[0]->created_at : '-' }}</td>
                                <td><a href="{{ route('forms.sent.form', $form->id) }}" class="text-purple" title="{{ __('Wyświetl wysłane') }}"><i class="fa fa-list"></i></a></td>
                            </tr>
                        @endforeach
                        </tbody>
                        <tfoot>
                            <tr>
                                <th style="width: 35px;">{{ __('Lp.') }}</th>
                                <th>{{ __('Nazwa') }}</th>
                                <th>{{ __('Liczba przesłanych formularzy') }}</th>
                                <th>{{ __('Ostatni wysłany') }} <small class="text-muted">({{ __('strefa czasowa: :timezone', ['timezone' => config('app.timezone')]) }})</small></th>
                                <th style="width: 35px;">&nbsp;</th>
                            </tr>
                        </tfoot>
                    </table>
                    <div class="pull-right">
                        {{ $forms->links() }}
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
    @endif
@endsection