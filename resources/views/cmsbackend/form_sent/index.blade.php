@extends('cmsbackend.layout')

@section('content')
    @if(isset($forms))
    <div class="row">
        <div class="col-xs-12">
            <div class="box">
                <div class="box-body">
                    @if(CMS::isMoreLocales())
                    <div class="btn-group pull-right text-uppercase">
                        <a href="{{ route('forms.changelocale', CMS::getDefaultLocale()) }}" class="btn btn-{{ (Session::get('cms_locale_form') == CMS::getDefaultLocale() || !Session::has('cms_locale_form')) ? 'success' : 'default' }}">{{ CMS::getDefaultLocale() }}</a>
                        @foreach(CMS::getMoreDefaultLocales() as $lang)
                            <a href="{{ route('forms.changelocale', $lang->slug) }}" class="btn btn-{{ Session::get('cms_locale_form') == $lang->slug ? 'success' : 'default' }}">{{ $lang->slug }}</a>
                        @endforeach
                        <br />
                        <br />
                    </div>
                    @endif
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
                                @if(count($form->submits))
                                    <td><a href="{{ route('forms.sent.form', $form->id) }}" class="text-purple" title="{{ __('Wyświetl wysłane') }}"><i class="fa fa-list"></i></a></td>
                                @else
                                    <td>&nbsp;</td>
                                @endif
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