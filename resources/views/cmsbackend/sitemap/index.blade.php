@extends('cmsbackend.layout')

@section('content')
    @if(isset($records))
    <div class="row">
        <div class="col-xs-12">
            <div class="box">
                <div class="box-body">
                    @can('add_dev', 'App\User')
                        <span class="btn btn-success" data-toggle="modal" data-target="#add-new" id="create-new">{{ __('Dodaj rekord') }}</span>
                        <a href="#" class="btn btn-warning" data-toggle="modal" data-href="{{ route('sitemap.scan') }}" data-target="#confirm-scan" id="create-scan">{{ __('Wygeneruj z istniejących danych') }}</a>
                        @if(!$records->isEmpty())
                            <br /><br />
                        @endif
                    @else
                        <div class="alert alert-warning alert-dismissible">
                            {!! __('Posiadasz za małe uprawnienia aby móc dodawać strony (wymagane przynajmniej: <strong>developer</strong>). Możesz jedynie przeglądać listę stron oraz je edytować') !!}
                        </div>
                    @endcan
                    @if(Session::has('status'))
                        @if($records->isEmpty())
                            <br /><br />
                        @endif
                        <div class="alert alert-{{ Session::get('status_type')  }} alert-dismissible" data-autohide="true">
                            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                            <h4 class="mb-0"><i class="icon fa fa-check"></i> {{ Session::get('status') }}!</h4>
                        </div>
                    @endif
                    @if(!$records->isEmpty())
                    <table class="table table-bordered table-striped with-images">
                        <thead>
                            <tr>
                                <th style="width: 35px;">{{ __('Lp.') }}</th>
                                <th>{{ __('URL') }}</th>
                                <th>{{ __('Typ') }}</th>
                                <th>{{ __('Częstotliwość aktualizacji') }}</th>
                                <th>{{ __('Priorytet') }}</th>
                                <th>{{ __('Data stworzenia') }} <small class="text-muted">({{ __('strefa czasowa: :timezone', ['timezone' => config('app.timezone')]) }})</small></th>
                                <th><strong>{{ __('Ostatnia edycja') }}</strong> <small class="text-muted">({{ __('strefa czasowa: :timezone', ['timezone' => config('app.timezone')]) }})</small></th>
                                <th style="width: {{ CMS::isMoreLocales() ? '105' : '85' }}px;">&nbsp;</th>
                            </tr>
                        </thead>
                        <tbody>
                        @foreach($records as $num => $page)
                            <tr>
                                <td style="text-align: center;">{!! $page->status == 2 ? '<s>' : '' !!}{{ $num+1 }}{!! $page->status == 2 ? '</s>' : '' !!}</td>
                                <td>{{ $page->url }}</td>
                                <td>{{ $page->element_type }}</td>
                                <td>{{ $page->update_frequency }}</td>
                                <td>{{ $page->priorty }}</td>
                                <td>{{ $page->created_at }}</td>
                                @if($page->who_updated)
                                    <td><img src="{{ $page->updater->image ? : '/backend/img/blank.jpg' }}" class="user-circle-image" width="25" height="25" alt=""> {{ $page->updater->name }} <small class="text-muted">({{ $page->updated_at }})</small></td>
                                @else
                                    <td>&nbsp;</td>
                                @endif
                                <td class="text-center">
                                    <a href="{{ route('sitemap.edit', $page->id) }}" class="text-light-blue" title="{{ __('Edytuj') }}"><i class="fa fa-edit"></i></a>
                                    @can('add_dev', 'App\User')
                                    <a href="#" data-href="{{ route('sitemap.delete', $page->id) }}" class="text-red" data-toggle="modal" data-target="#confirm-delete" title="{{ __('Usuń') }}"><i class="fa fa-trash"></i></a>
                                    @endcan
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                        <tfoot>
                            <tr>
                                <th style="width: 35px;">{{ __('Lp.') }}</th>
                                <th>{{ __('URL') }}</th>
                                <th>{{ __('Typ') }}</th>
                                <th>{{ __('Częstotliwość aktualizacji') }}</th>
                                <th>{{ __('Priorytet') }}</th>
                                <th>{{ __('Data stworzenia') }} <small class="text-muted">({{ __('strefa czasowa: :timezone', ['timezone' => config('app.timezone')]) }})</small></th>
                                <th><strong>{{ __('Ostatnia edycja') }}</strong> <small class="text-muted">({{ __('strefa czasowa: :timezone', ['timezone' => config('app.timezone')]) }})</small></th>
                                <th style="width: {{ CMS::isMoreLocales() ? '105' : '85' }}px;">&nbsp;</th>
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
        <div class="modal fade" id="add-new" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
            <div class="modal-dialog">
                {{Form::open(['route' => 'sitemap.store', 'files' => true, 'method' => 'POST', 'class' => 'modal-content'])}}
                    {{ csrf_field() }}
                    <div class="modal-header">
                        {{ __('Dodaj rekord do mapy strony') }}
                    </div>
                    <div class="modal-body">
                        <div class="form-group{{ $errors->has('url') ? ' has-error' : '' }}">
                            <label>{{ __('URL') }}{{ $errors->has('name') ? ' - '.(__($errors->first('url'))) : '' }}</label>
                            <input type="text" id="url" name="url" class="form-control" value="{{ old('url')  }}" required autofocus />
                        </div>
                        <div class="form-group">
                            <label>{{ __('Typ') }}</label>
                            <?php $type = old('type') ?>
                            <select name="type" id="type" class="form-control">
                                <option value="page" {{ $type == 'page' ? ' selected' : '' }}>{{ __('Strona')  }}</option>
                                <option value="module" {{ $type == 'module' ? ' selected' : '' }}>{{ __('Moduł')  }}</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label>{{ __('Częstotliwość aktualizacji') }}</label>
                            <?php $update = old('update_frequency') ?>
                            <select name="update_frequency" id="update_frequency" class="form-control">
                                <option value="daily" {{ $update == 'daily' ? ' selected' : '' }}>{{ __('Codziennie')  }}</option>
                                <option value="weekly" {{ $update == 'weekly' ? ' selected' : '' }}>{{ __('Co tydzień')  }}</option>
                                <option value="monthly" {{ $update == 'monthly' ? ' selected' : '' }}>{{ __('Co miesiąc')  }}</option>
                                <option value="yearly" {{ $update == 'yearly' ? ' selected' : '' }}>{{ __('Co rok')  }}</option>
                            </select>
                        </div>
                        <div class="form-group{{ $errors->has('priorty') ? ' has-error' : '' }}">
                            <label>{{ __('Priorytet') }}{{ $errors->has('priorty') ? ' - '.(__($errors->first('priorty'))) : '' }}</label>
                            <input type="text" id="priorty" name="priorty" class="form-control" value="{{ old('priorty') }}" required />
                        </div>
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
                    {!! __('Po usunięciu strony zostanie przeniesiona do elementów usuniętych. Można będzie ją przywrócic przechodząc do zakładki "Usunięte elementy"') !!}
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
                    {!! __('Po zdezaktywowaniu strony będzie ona niedostępna na stronie.') !!}
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-success pull-left" data-dismiss="modal">{{ __('Anuluj') }}</button>
                    <a class="btn btn-danger pull-right btn-ok">{{ __('Zdezaktywuj') }}</a>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="confirm-scan" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    {{ __('Czy jesteś tego pewien?') }}
                </div>
                <div class="modal-body">
                    {!! __('Proces może chwilę potrwać, w tym czasie system może odpowiadać wolniej.') !!}
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-success pull-left" data-dismiss="modal">{{ __('Anuluj') }}</button>
                    <a class="btn btn-danger pull-right btn-ok">{{ __('Generuj') }}</a>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    @if(count($errors) > 0)
        <script>
            $('#create-new').trigger('click');
        </script>
    @endif
@endsection