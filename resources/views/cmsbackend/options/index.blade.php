@extends('cmsbackend.layout')

@section('content')
    @if(isset($options))
        <div class="row">
            <div class="col-xs-12">
                <div class="box">
                    <div class="box-body">
                        @can('add_dev', 'App\User')
                            <span class="btn btn-success" data-toggle="modal" data-target="#add-new">{{ __('Dodaj opcje') }}</span>
                            @if(CMS::isMoreLocales())
                            <div class="btn-group pull-right text-uppercase">
                                <a href="{{ route('options.changelocale', CMS::getDefaultLocale()) }}" class="btn btn-{{ (Session::get('cms_locale_option') == CMS::getDefaultLocale() || !Session::has('cms_locale_option')) ? 'success' : 'default' }}">{{ CMS::getDefaultLocale() }}</a>
                                @foreach(CMS::getMoreDefaultLocales() as $lang)
                                    <a href="{{ route('options.changelocale', $lang->slug) }}" class="btn btn-{{ Session::get('cms_locale_option') == $lang->slug ? 'success' : 'default' }}">{{ $lang->slug }}</a>
                                @endforeach
                            </div>
                            @endif
                            @if(!$options->isEmpty())
                                <br /><br />
                            @endif
                        @else
                            <div class="alert alert-warning alert-dismissible">
                                {!! __('Posiadasz za małe uprawnienia aby móc edytować i dodawać opcje (wymagane przynajmniej: <strong>developer</strong>). Możesz jedynie przeglądać listę opcji') !!}
                            </div>
                        @endcan
                        @if(Session::has('status'))
                            @if($options->isEmpty())
                                <br /><br />
                            @endif
                            <div class="alert alert-{{ Session::get('status_type') }} alert-dismissible" data-autohide="true">
                                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                                <h4 class="mb-0"><i class="icon fa fa-check"></i> {{ Session::get('status') }}!</h4>
                            </div>
                        @endif
                        @if(!$options->isEmpty())
                        <table class="table table-bordered table-striped">
                            <thead>
                            <tr>
                                <th style="width: 35px;">{{ __('Lp.') }}</th>
                                <th>{{ __('Klucz') }}</th>
                                <th>{{ __('Wartość') }}</th>
                                <th><strong>{{ __('Ostatnia edycja') }}</strong> <small class="text-muted">({{ __('strefa czasowa: :timezone', ['timezone' => config('app.timezone')]) }})</small></th>
                                @can('edit_dev', 'App\User')
                                    <th style="width: {{ CMS::isMoreLocales() ? '90' : '70' }}px;">&nbsp;</th>
                                @endcan
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($options as $num => $option)
                                <tr>
                                    <td style="text-align: center;">{{ $num+1 }}</td>
                                    <td>{{ $option->key }}</td>
                                    <td>{{ $option->value }}</td>
                                    @if($option->who_updated)
                                        <td><img src="{{ $option->updater->image ? : '/backend/img/blank.jpg' }}" class="user-circle-image" width="25" height="25" alt=""> {{ $option->updater->name }} <small class="text-muted">({{ $option->updated_at }})</small></td>
                                    @else
                                        <td>&nbsp;</td>
                                    @endif
                                    @can('edit_dev', 'App\User')
                                        <td class="text-center">
                                            @if(CMS::isMoreLocales())
                                                <a href="#" class="text-yellow" data-toggle="modal" data-target="#duplicate-modal" data-id="{{ $option->id }}" title="{{ __('Zduplikuj') }}"><i class="fa fa-copy"></i></a>
                                            @endif
                                                <a href="{{ route('options.edit', $option->id) }}" class="text-light-blue" title="{{ __('Edytuj') }}"><i class="fa fa-edit"></i></a>
                                            <a href="#" data-href="{{ route('options.delete', $option->id) }}" class="text-red" data-toggle="modal" data-target="#confirm-delete" title="{{ __('Usuń') }}"><i class="fa fa-trash"></i></a>
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
                                    <th style="width: {{ CMS::isMoreLocales() ? '90' : '70' }}px;">&nbsp;</th>
                                @endcan
                            </tr>
                            </tfoot>
                        </table>
                        <div class="pull-right">
                            {{ $options->links() }}
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
            <form role="form" method="POST" action="{{ route('options') }}" class="modal-content">
                {{ csrf_field() }}
                <div class="modal-header">
                    {{ __('Dodaj opcje') }}
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label>{{ __('Klucz') }}</label>
                        <input type="text" id="option_key" name="option_key" class="form-control" value="{{ old('option_key') }}" required />
                    </div>
                    <div class="form-group">
                        <label>{{ __('Wartość') }}</label>
                        <input type="text" id="option_value" name="option_value" class="form-control" value="{{ old('option_value') }}" required />
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger pull-left" data-dismiss="modal">{{ __('Anuluj') }}</button>
                    <button type="submit" class="btn btn-success margin">{{ __('Zapisz') }}</button>
                </div>
            </form>
        </div>
    </div>
    @if(CMS::isMoreLocales())
    <div class="modal fade" id="duplicate-modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <form role="form" method="POST" action="{{ route('options.duplicate') }}" class="modal-content">
                {{ csrf_field() }}
                <input type="hidden" id="option_id" name="option_id" class="form-control" value="" required />
                <div class="modal-header">
                    {{ __('Dla jakiego języka skopiować element?') }}
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label>{{ __('Wybierz język') }}</label>
                        <select class="form-control select2 text-uppercase" name="option_language" id="option_language" style="width: 100%;">
                            <?php $active = Session::get('cms_locale_option') ? : CMS::getDefaultLocale(); ?>
                            @foreach(CMS::getLocalesExcept($active) as $lang)
                                <option{{ $lang->slug == old('option_language') ? ' selected' : '' }} value="{{ $lang->slug }}">{{ $lang->title }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger pull-left" data-dismiss="modal">{{ __('Anuluj') }}</button>
                    <button type="submit" class="btn btn-success margin">{{ __('Zduplikuj') }}</button>
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
                    {!! __('Po usunięciu opcja zostanie wymazana z systemu.') !!}
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-success pull-left" data-dismiss="modal">{{ __('Anuluj') }}</button>
                    <a class="btn btn-danger pull-right btn-ok">{{ __('Usuń') }}</a>
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
            modal.find('#option_id').val(id);
        })
    </script>
@endsection