@extends('cmsbackend.layout')

@section('content')
    @if(isset($module))
        <div class="row">
            <div class="col-xs-12">
                <div class="box">
                    <div class="box-body">
                        <span class="btn btn-success" data-toggle="modal" data-target="#add-new">{{ __('Dodaj rekord') }}</span>
                        @if(CMS::isMoreLocales())
                            <div class="btn-group pull-right text-uppercase">
                                <a href="{{ route('records.changelocale', [$module->id, CMS::getDefaultLocale()]) }}" class="btn btn-{{ (Session::get('cms_locale_module_'.$module->slug) == CMS::getDefaultLocale() || !Session::has('cms_locale_module_'.$module->slug)) ? 'success' : 'default' }}">{{ CMS::getDefaultLocale() }}</a>
                                @foreach(CMS::getMoreDefaultLocales() as $lang)
                                    <a href="{{ route('records.changelocale', [$module->id, $lang->slug]) }}" class="btn btn-{{ Session::get('cms_locale_module_'.$module->slug) == $lang->slug ? 'success' : 'default' }}">{{ $lang->slug }}</a>
                                @endforeach
                            </div>
                        @endif
                        @if(Session::has('status'))
                            <br />
                            <br />
                            <div class="alert alert-{{ Session::get('status_type') }} alert-dismissible" data-autohide="true">
                                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                                <h4 class="mb-0"><i class="icon fa fa-check"></i> {{ Session::get('status') }}!</h4>
                            </div>
                        @endif
                        @if(isset($records) AND !$records->isEmpty())
                            <br />
                            <br />
                            <table class="table table-bordered table-striped">
                                <thead>
                                <tr>
                                    <th style="width: 35px;">{{ __('Lp.') }}</th>
                                    <th>{{ __('Tytuł') }}</th>
                                    <th><strong>{{ __('Ostatnia edycja') }}</strong> <small class="text-muted">({{ __('strefa czasowa: :timezone', ['timezone' => config('app.timezone')]) }})</small></th>
                                    <th style="width: 105px;">&nbsp;</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($records as $num => $record)
                                    <tr>
                                        <td style="text-align: center;">{!! $record->status == 2 ? '<s>' : '' !!}{{ $num+1 }}{!! $record->status == 2 ? '</s>' : '' !!}</td>
                                        <td>{!! $record->status == 2 ? '<s>' : '' !!}{{ $record->title }}{!! $record->status == 2 ? '</s>' : '' !!}</td>
                                        @if($record->who_updated)
                                            <td><img src="{{ $record->updater->image ? : '/backend/img/blank.jpg' }}" class="user-circle-image" width="25" height="25" alt=""> {{ $record->updater->name }} <small class="text-muted">({{ $record->updated_at }})</small></td>
                                        @else
                                            <td>&nbsp;</td>
                                        @endif
                                        <td class="text-center">
                                            <a href="{{ route('records.edit', [$module->id, $record->id]) }}" class="text-light-blue" title="{{ __('Edytuj') }}"><i class="fa fa-edit"></i></a>
                                                <a href="#" class="text-yellow" data-toggle="modal" data-target="#duplicate-modal" data-id="{{ $record->id }}" title="{{ __('Zduplikuj') }}"><i class="fa fa-copy"></i></a>
                                            @if($record->status == 1)
                                                <a href="#" data-href="{{ route('records.deactivate', [$module->id, $record->id]) }}" class="text-yellow" data-toggle="modal" data-target="#confirm-deactivate" title="{{ __('Zdezaktywuj') }}"><i class="fa fa-close"></i></a>
                                            @else
                                                <a href="{{ route('records.activate', [$module->id, $record->id]) }}" class="text-green" title="{{ __('Aktywuj') }}"><i class="fa fa-check"></i></a>
                                            @endif
                                            <a href="#" data-href="{{ route('records.destroy', [$module->id, $record->id]) }}" class="text-red" data-toggle="modal" data-target="#confirm-delete" title="{{ __('Usuń') }}"><i class="fa fa-trash"></i></a>
                                        </td>
                                    </tr>
                                @endforeach
                                </tbody>
                                <tfoot>
                                <tr>
                                    <th style="width: 35px;">{{ __('Lp.') }}</th>
                                    <th>{{ __('Tytuł') }}</th>
                                    <th><strong>{{ __('Ostatnia edycja') }}</strong> <small class="text-muted">({{ __('strefa czasowa: :timezone', ['timezone' => config('app.timezone')]) }})</small></th>
                                    <th style="width: 105px;">&nbsp;</th>
                                </tr>
                                </tfoot>
                            </table>
                            <div class="pull-right">
                                {{ $records->links() }}
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
                {{Form::open(['route' => ['records', $module->id], 'files' => true, 'method' => 'POST', 'class' => 'modal-content'])}}
                    {{ csrf_field() }}
                    <div class="modal-header">
                        {{ __('Dodaj rekord') }}
                    </div>
                    <div class="modal-body">
                        <div class="form-group">
                            <label>{{ __('Tytuł') }}</label>
                            <input type="text" id="title" name="title" class="form-control" value="{{ old('title') }}" required />
                        </div>
                        @if($structures = json_decode($module->structure))
                            <hr>
                            @foreach($structures as $structure)
                                <div class="form-group">
                                    @if($structure->type != 'checkbox')
                                        <label>{{ __($structure->title) }}</label>
                                    @endif
                                    @if($structure->type == 'textarea')
                                        <textarea name="data[{{ $structure->slug }}]" id="data-{{ $structure->slug }}" class="form-control"{{ $structure->required ? ' required' : '' }}>{{ old('data['.$structure->slug.']') }}</textarea>
                                    @elseif($structure->type == 'file')
                                        <input type="file" id="data-{{ $structure->slug }}" name="data[{{ $structure->slug }}]" accept="*"{{ $structure->required ? ' required' : '' }} />
                                    @elseif($structure->type == 'checkbox')
                                        <label><input type="checkbox" id="data-{{ $structure->slug }}" name="data[{{ $structure->slug }}]" class="form-control"{{ $structure->required ? ' required' : '' }}{{ old('data['.$structure->slug.']') ? ' checked' : '' }} /> {{ __($structure->title) }}</label>
                                    @else
                                        <input type="{{ $structure->type }}" id="data-{{ $structure->slug }}" name="data[{{ $structure->slug }}]" class="form-control" value="{{ old('data['.$structure->slug.']') }}"{{ $structure->required ? ' required' : '' }} />
                                    @endif
                                </div>
                            @endforeach
                        @endif
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger pull-left" data-dismiss="modal">{{ __('Anuluj') }}</button>
                        <button type="submit" class="btn btn-success pull-right">{{ __('Zapisz') }}</button>
                    </div>
                {{Form::close()}}
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
                    {!! __('Po usunięciu rekord zostanie usunięty na stałe z systemu. Operacji tej nie da się odwrócić.') !!}
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
                    {!! __('Po zdezaktywowaniu rekord będze niedostępny na stronie.') !!}
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-success pull-left" data-dismiss="modal">{{ __('Anuluj') }}</button>
                    <a class="btn btn-danger pull-right btn-ok">{{ __('Zdezaktywuj') }}</a>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="duplicate-modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <form role="form" method="POST" action="{{ route('records.duplicate', $module->id) }}" class="modal-content">
                {{ csrf_field() }}
                <input type="hidden" id="record_id" name="record_id" class="form-control" value="" required />
                <div class="modal-header">
                    @if(CMS::isMoreLocales())
                        {{ __('Dla jakiego języka skopiować element?') }}
                    @else
                        {{ __('Czy jesteś tego pewien?') }}
                    @endif
                </div>
                <div class="modal-body">
                <?php $active = Session::get('cms_locale_form') ? : CMS::getDefaultLocale(); ?>
                    @if(CMS::isMoreLocales())
                        <p class="text-muted">{{ __('Rekord zostanie skopiowany łącznie ze wszystkimi danymi.') }} {{ __('Z listy poniżej wybierz w jakim języku skopiowany rekord ma być dostępny') }}</p>
                        <div class="form-group">
                            <label>{{ __('Wybierz język') }}</label>
                            <select class="form-control select2 text-uppercase" name="form_language" id="form_language" style="width: 100%;">
                                <option{{ $active == old('form_language') ? ' selected' : '' }} value="{{ $active }}">{{ __('Skopiuj w tym samym języku') }}</option>
                                @foreach(CMS::getLocalesExcept($active) as $lang)
                                    <option{{ $lang->slug == old('form_language') ? ' selected' : '' }} value="{{ $lang->slug }}">{{ $lang->title }}</option>
                                @endforeach
                            </select>
                        </div>
                    @else
                        <p class="text-muted">{{ __('Rekord zostanie skopiowany łącznie ze wszystkimi danymi.') }}</p>
                        <input type="hidden" id="form_language" name="form_language" class="form-control" value="{{ $active }}" required />
                    @endif
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger pull-left" data-dismiss="modal">{{ __('Anuluj') }}</button>
                    <button type="submit" class="btn btn-success pull-right">{{ __('Zduplikuj') }}</button>
                </div>
            </form>
        </div>
    </div>
@endsection

@section('scripts')
    <script>
        $('#duplicate-modal').on('show.bs.modal', function (event) {
            var button = $(event.relatedTarget);
            var id = button.data('id');
            var modal = $(this);
            modal.find('#record_id').val(id);
        })
    </script>
@endsection
