@extends('cmsbackend.layout')

@section('content')
    @if(isset($languages))
        <div class="row">
            <div class="col-xs-12">
                <div class="box">
                    <div class="box-body">
                        @can('add_dev', 'App\User')
                            <span class="btn btn-success" data-toggle="modal" data-target="#add-new">{{ __('Dodaj język') }}</span>
                            @if(!$languages->isEmpty())
                                <br /><br />
                            @endif
                        @else
                            <div class="alert alert-warning alert-dismissible">
                                {!! __('Posiadasz za małe uprawnienia aby móc edytować i dodawać języki (wymagane przynajmniej: <strong>developer</strong>). Możesz jedynie przeglądać listę języków') !!}
                            </div>
                        @endcan
                        @if(Session::has('status'))
                            @if($languages->isEmpty())
                                <br /><br />
                            @endif
                            <div class="alert alert-{{ Session::get('status_type') }} alert-dismissible" data-autohide="true">
                                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                                <h4 class="mb-0"><i class="icon fa fa-check"></i> {{ Session::get('status') }}!</h4>
                            </div>
                        @endif
                        @if(!$languages->isEmpty())
                        <table class="table table-bordered table-striped">
                            <thead>
                            <tr>
                                <th style="width: 35px;">{{ __('Lp.') }}</th>
                                <th>{{ __('Tytuł') }}</th>
                                <th>{{ __('Slug') }}</th>
                                <th>{{ __('Język domyślny') }}</th>
                                <th><strong>{{ __('Ostatnia edycja') }}</strong> <small class="text-muted">({{ __('strefa czasowa: :timezone', ['timezone' => config('app.timezone')]) }})</small></th>
                                @can('edit_dev', 'App\User')
                                    <th style="width: 70px;">&nbsp;</th>
                                @endcan
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($languages as $num => $language)
                                <tr>
                                    <td style="text-align: center;">{!! $language->status == 2 ? '<s>' : '' !!}{{ $num+1 }}{!! $language->status == 2 ? '</s>' : '' !!}</td>
                                    <td>{!! $language->status == 2 ? '<s>' : '' !!}{{ $language->title }}{!! $language->status == 2 ? '</s>' : '' !!}</td>
                                    <td>{!! $language->status == 2 ? '<s>' : '' !!}{{ $language->slug }}{!! $language->status == 2 ? '</s>' : '' !!}</td>
                                    <td>{{ $language->is_default ? __('Tak') : __('Nie') }}</td>
                                    @if($language->who_updated)
                                        <td><img src="{{ $language->updater->image ? : '/backend/img/blank.jpg' }}" class="user-circle-image" width="25" height="25" alt=""> {{ $language->updater->name }} <small class="text-muted">({{ $language->updated_at }})</small></td>
                                    @else
                                        <td>&nbsp;</td>
                                    @endif
                                    @can('edit_dev', 'App\User')
                                        <td class="text-center">
                                            <a href="{{ route('languages.edit', $language->id) }}" class="text-light-blue" title="{{ __('Edytuj') }}"><i class="fa fa-edit"></i></a>
                                            @if(!$language->is_default)
                                                @if($language->status == 1)
                                                    <a href="#" data-href="{{ route('languages.deactivate', $language->id) }}" class="text-yellow" data-toggle="modal" data-target="#confirm-deactivate" title="{{ __('Zdezaktywuj') }}"><i class="fa fa-close"></i></a>
                                                @else
                                                    <a href="{{ route('languages.activate', $language->id) }}" class="text-green" title="{{ __('Aktywuj') }}"><i class="fa fa-check"></i></a>
                                                @endif
                                                <a href="#" data-href="{{ route('languages.delete', $language->id) }}" class="text-red" data-toggle="modal" data-target="#confirm-delete" title="{{ __('Usuń') }}"><i class="fa fa-trash"></i></a>
                                            @endif
                                        </td>
                                    @endcan
                                </tr>
                            @endforeach
                            </tbody>
                            <tfoot>
                            <tr>
                                <th style="width: 35px;">{{ __('Lp.') }}</th>
                                <th>{{ __('Tytuł') }}</th>
                                <th>{{ __('Slug') }}</th>
                                <th>{{ __('Język domyślny') }}</th>
                                <th><strong>{{ __('Ostatnia edycja') }}</strong> <small class="text-muted">({{ __('strefa czasowa: :timezone', ['timezone' => config('app.timezone')]) }})</small></th>
                                @can('edit_dev', 'App\User')
                                    <th style="width: 70px;">&nbsp;</th>
                                @endcan
                            </tr>
                            </tfoot>
                        </table>
                        <div class="pull-right">
                            {{ $languages->links() }}
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
            <form role="form" method="POST" action="{{ route('languages') }}" class="modal-content">
                {{ csrf_field() }}
                <div class="modal-header">
                    {{ __('Dodaj tłumaczenie') }}
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label>{{ __('Tytuł') }}</label>
                        <input type="text" id="language_title" name="language_title" class="form-control" value="{{ old('language_title') }}" required />
                    </div>
                    <div class="form-group">
                        <label>{{ __('Slug') }} <small>({{ __('np. pl') }})</small></label>
                        <input type="text" id="language_slug" name="language_slug" class="form-control" value="{{ old('language_slug') }}" required />
                    </div>
                    <div class="form-group">
                        <div class="checkbox icheck">
                            <label>
                                <input type="checkbox" name="language_is_default"{{ old('language_is_default') ? ' checked' : '' }}> {{ __('Domyślny język') }} <small>({{ __('Przełączenie spowoduje zmianę domyślnego języka strony oraz systemu') }})</small>
                            </label>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger pull-left" data-dismiss="modal">{{ __('Anuluj') }}</button>
                    <button type="submit" class="btn btn-success margin">{{ __('Zapisz') }}</button>
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
                    {!! __('Po usunięciu język trafi do elementów usuniętych. Usunięty język można przywrócić lub usunąć na stałe.') !!}
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
                    {!! __('Po zdezaktywowaniu język będzie niedostępny.') !!}
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-success pull-left" data-dismiss="modal">{{ __('Anuluj') }}</button>
                    <a class="btn btn-danger pull-right btn-ok">{{ __('Zdezaktywuj') }}</a>
                </div>
            </div>
        </div>
    </div>
@endsection
