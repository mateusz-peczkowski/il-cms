@extends('cmsbackend.layout')

@section('content')
    @if(isset($translations))
        <div class="row">
            <div class="col-xs-12">
                <div class="box">
                    <div class="box-body">
                        @can('add_dev', 'App\User')
                            <span class="btn btn-success" data-toggle="modal" data-target="#add-new">{{ __('Dodaj tłumaczenie') }}</span>
                            @if(CMS::isMoreLocales())
                            <div class="btn-group pull-right text-uppercase">
                                <a href="{{ route('translations.changelocale', CMS::getDefaultLocale()) }}" class="btn btn-{{ (Session::get('cms_locale_translation') == CMS::getDefaultLocale() || !Session::has('cms_locale_translation')) ? 'success' : 'default' }}">{{ CMS::getDefaultLocale() }}</a>
                                @foreach(CMS::getMoreDefaultLocales() as $lang)
                                    <a href="{{ route('translations.changelocale', $lang->slug) }}" class="btn btn-{{ Session::get('cms_locale_translation') == $lang->slug ? 'success' : 'default' }}">{{ $lang->slug }}</a>
                                @endforeach
                            </div>
                            @endif
                            @if(!$translations->isEmpty())
                                <br /><br />
                            @endif
                        @else
                            <div class="alert alert-warning alert-dismissible">
                                {!! __('Posiadasz za małe uprawnienia aby móc edytować i dodawać tłumaczenia (wymagane przynajmniej: <strong>developer</strong>). Możesz jedynie przeglądać listę tłumaczeń') !!}
                            </div>
                            @if(CMS::isMoreLocales())
                                <div class="btn-group pull-right text-uppercase">
                                    <a href="{{ route('translations.changelocale', CMS::getDefaultLocale()) }}" class="btn btn-{{ (Session::get('cms_locale_translation') == CMS::getDefaultLocale() || !Session::has('cms_locale_translation')) ? 'success' : 'default' }}">{{ CMS::getDefaultLocale() }}</a>
                                    @foreach(CMS::getMoreDefaultLocales() as $lang)
                                        <a href="{{ route('translations.changelocale', $lang->slug) }}" class="btn btn-{{ Session::get('cms_locale_translation') == $lang->slug ? 'success' : 'default' }}">{{ $lang->slug }}</a>
                                    @endforeach
                                </div>
                            @endif
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
                                <th>{{ __('Tłumaczenie') }}</th>
                                <th><strong>{{ __('Ostatnia edycja') }}</strong> <small class="text-muted">({{ __('strefa czasowa: :timezone', ['timezone' => config('app.timezone')]) }})</small></th>
                                @can('edit_dev', 'App\User')
                                    <th style="width: {{ CMS::isMoreLocales() ? '90' : '70' }}px;">&nbsp;</th>
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
                                            @if(CMS::isMoreLocales())
                                            <a href="#" class="text-yellow" data-toggle="modal" data-target="#duplicate-modal" data-id="{{ $translation->id }}" title="{{ __('Zduplikuj') }}"><i class="fa fa-copy"></i></a>
                                            @endif
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
                                <th>{{ __('Klucz') }}</th>
                                <th>{{ __('Tłumaczenie') }}</th>
                                <th><strong>{{ __('Ostatnia edycja') }}</strong> <small class="text-muted">({{ __('strefa czasowa: :timezone', ['timezone' => config('app.timezone')]) }})</small></th>
                                @can('edit_dev', 'App\User')
                                    <th style="width: {{ CMS::isMoreLocales() ? '90' : '70' }}px;">&nbsp;</th>
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
                    <button type="submit" class="btn btn-success pull-right">{{ __('Zapisz') }}</button>
                </div>
            </form>
        </div>
    </div>
    @if(CMS::isMoreLocales())
    <div class="modal fade" id="duplicate-modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <form role="form" method="POST" action="{{ route('translations.duplicate') }}" class="modal-content">
                {{ csrf_field() }}
                <input type="hidden" id="translation_id" name="translation_id" class="form-control" value="" required />
                <div class="modal-header">
                    {{ __('Dla jakiego języka skopiować element?') }}
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label>{{ __('Wybierz język') }}</label>
                        <select class="form-control select2 text-uppercase" name="translation_language" id="translation_language" style="width: 100%;">
                            <?php $active = Session::get('cms_locale_translation') ? : CMS::getDefaultLocale(); ?>
                            @foreach(CMS::getLocalesExcept($active) as $lang)
                                <option{{ $lang->slug == old('translation_language') ? ' selected' : '' }} value="{{ $lang->slug }}">{{ $lang->title }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger pull-left" data-dismiss="modal">{{ __('Anuluj') }}</button>
                    <button type="submit" class="btn btn-success pull-right">{{ __('Zduplikuj') }}</button>
                </div>
            </form>
        </div>
    </div>
    @endif
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
                    <a class="btn btn-danger pull-right btn-ok">{{ __('Usuń') }}</a>
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
                    <a class="btn btn-danger pull-right btn-ok">{{ __('Zdezaktywuj') }}</a>
                </div>
            </div>
        </div>
    </div>
@endsection


@section('scripts')
    <script>
        $('#duplicate-modal').on('show.bs.modal', function (event) {
            var button = $(event.relatedTarget);
            var id = button.data('id');
            var modal = $(this);
            modal.find('#translation_id').val(id);
        })
    </script>
@endsection