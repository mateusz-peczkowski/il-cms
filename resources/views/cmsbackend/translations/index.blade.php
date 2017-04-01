@extends('cmsbackend.layout')

@section('content')
    @if(isset($translations))
        <div class="row">
            <div class="col-xs-12">
                <div class="box">
                    <div class="box-body">
                        @can('add_dev', 'App\User')
                            <span class="btn btn-success" data-toggle="modal" data-target="#add-new">{{ __('Dodaj tłumaczenie') }}</span>
                            @if(!$translations->isEmpty())
                                <br /><br />
                            @endif
                        @else
                            <div class="alert alert-warning alert-dismissible">
                                {!! __('Posiadasz za małe uprawnienia aby móc edytować i dodawać tłumaczenia (wymagane przynajmniej: <strong>developer</strong>). Możesz jedynie przeglądać listę tłumaczeń') !!}
                            </div>
                        @endcan
                        @if(Session::has('status'))
                            @if($translations->isEmpty())
                                <br /><br />
                            @endif
                            <div class="alert alert-{{ Session::get('status_type') }} alert-dismissible" data-autohide="true">
                                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                                <h4 class="mb-0"><i class="icon fa fa-check"></i> {{ Session::get('status') }}!</h4>
                            </div>
                        @endif
                        @if(!$translations->isEmpty())
                        <table class="table table-bordered table-striped">
                            <thead>
                            <tr>
                                <th style="width: 35px;">{{ __('Lp.') }}</th>
                                <th>{{ __('Klucz') }}</th>
                                <th>{{ __('Wartość') }}</th>
                                <th><strong>{{ __('Ostatnia edycja') }}</strong> <small class="text-muted">({{ __('strefa czasowa: :timezone', ['timezone' => config('app.timezone')]) }})</small></th>
                                @can('edit_dev', 'App\User')
                                    <th style="width: 70px;">&nbsp;</th>
                                @endcan
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($translations as $num => $translation)
                                <tr>
                                    <td style="text-align: center;">{!! $translation->status == 2 ? '<s>' : '' !!}{{ $num+1 }}{!! $translation->status == 2 ? '</s>' : '' !!}</td>
                                    <td>{!! $translation->status == 2 ? '<s>' : '' !!}{{ $translation->key }}{!! $translation->status == 2 ? '</s>' : '' !!}</td>
                                    <td>{!! $translation->status == 2 ? '<s>' : '' !!}{{ $translation->value }}{!! $translation->status == 2 ? '</s>' : '' !!}</td>
                                    @if($translation->who_updated)
                                        <td><img src="{{ $translation->updater->image ? : '/backend/img/blank.jpg' }}" class="user-circle-image" width="25" height="25" alt=""> {{ $translation->updater->name }} <small class="text-muted">({{ $translation->updated_at }})</small></td>
                                    @else
                                        <td>&nbsp;</td>
                                    @endif
                                    @can('edit_dev', 'App\User')
                                        <td class="text-center">
                                            <a href="{{ route('translations.edit', $translation->id) }}" class="text-light-blue" title="{{ __('Edytuj') }}"><i class="fa fa-edit"></i></a>
                                            @if($translation->status == 1)
                                                <a href="#" data-href="{{ route('translations.deactivate', $translation->id) }}" class="text-yellow" data-toggle="modal" data-target="#confirm-deactivate" title="{{ __('Zdezaktywuj') }}"><i class="fa fa-close"></i></a>
                                            @else
                                                <a href="{{ route('translations.activate', $translation->id) }}" class="text-green" title="{{ __('Aktywuj') }}"><i class="fa fa-check"></i></a>
                                            @endif
                                            <a href="#" data-href="{{ route('translations.delete', $translation->id) }}" class="text-red" data-toggle="modal" data-target="#confirm-delete" title="{{ __('Usuń') }}"><i class="fa fa-trash"></i></a>
                                        </td>
                                    @endcan
                                </tr>
                            @endforeach
                            </tbody>
                            <tfoot>
                            <tr>
                                <th style="width: 35px;">{{ __('Lp.') }}</th>
                                <th>{{ __('Z adresu') }}</th>
                                <th>{{ __('Na adres') }}</th>
                                <th><strong>{{ __('Ostatnia edycja') }}</strong> <small class="text-muted">({{ __('strefa czasowa: :timezone', ['timezone' => config('app.timezone')]) }})</small></th>
                                @can('edit_dev', 'App\User')
                                    <th style="width: 70px;">&nbsp;</th>
                                @endcan
                            </tr>
                            </tfoot>
                        </table>
                        <div class="pull-right">
                            {{ $translations->links() }}
                        </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    @endif
@endsection

@section('modals')
    @can('add_dev', 'App\User')
    <div class="modal fade" id="add-new" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <form role="form" method="POST" action="{{ route('translations') }}" class="modal-content">
                {{ csrf_field() }}
                <div class="modal-header">
                    {{ __('Dodaj tłumaczenie') }}
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label>{{ __('Klucz') }}</label>
                        <input type="text" id="translation_key" name="translation_key" class="form-control" value="{{ old('translation_key') }}" required />
                    </div>
                    <div class="form-group">
                        <label>{{ __('Wartość') }}</label>
                        <input type="text" id="translation_value" name="translation_value" class="form-control" value="{{ old('translation_value') }}" required />
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger pull-left" data-dismiss="modal">{{ __('Anuluj') }}</button>
                    <button type="submit" class="btn btn-success margin">{{ __('Dodaj tłumaczenie') }}</button>
                </div>
            </form>
        </div>
    </div>
    @endcan
    <div class="modal fade" id="confirm-delete" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    {{ __('Czy jesteś tego pewien?') }}
                </div>
                <div class="modal-body">
                    {!! __('Po usunięciu tłumaczenie zostanie wyłączone i trafi do elementów usuniętych. Usunięte tłumaczenie można przywrócić lub usunąć na stałe.') !!}
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-success pull-left" data-dismiss="modal">{{ __('Anuluj') }}</button>
                    <a class="btn btn-danger pull-right btn-ok">{{ __('Usuń tłumaczenie') }}</a>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="confirm-deactivate" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    {{ __('Czy jesteś tego pewien?') }}
                </div>
                <div class="modal-body">
                    {!! __('Po zdezaktywowaniu tłumaczenia będzie ono niedostępne.') !!}
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-success pull-left" data-dismiss="modal">{{ __('Anuluj') }}</button>
                    <a class="btn btn-danger pull-right btn-ok">{{ __('Zdezaktywuj tłumaczenie') }}</a>
                </div>
            </div>
        </div>
    </div>
@endsection
