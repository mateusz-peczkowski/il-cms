@extends('cmsbackend.layout')

@section('content')
    @if(isset($redirects))
        <div class="row">
            <div class="col-xs-12">
                <div class="box">
                    <div class="box-body">
                        @can('add_dev', 'App\User')
                            <span class="btn btn-success" data-toggle="modal" data-target="#add-new">{{ __('Dodaj przekierowanie') }}</span>
                            @if(!$redirects->isEmpty())
                                <br /><br />
                            @endif
                        @else
                            <div class="alert alert-warning alert-dismissible">
                                {!! __('Posiadasz za małe uprawnienia aby móc edytować i dodawać przekierowania (wymagane przynajmniej: <strong>developer</strong>). Możesz jedynie przeglądać listę przekierowań') !!}
                            </div>
                        @endcan
                        @if(Session::has('status'))
                            @if($redirects->isEmpty())
                                <br /><br />
                            @endif
                            <div class="alert alert-{{ Session::get('status_type') }} alert-dismissible" data-autohide="true">
                                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                                <h4 class="mb-0"><i class="icon fa fa-check"></i> {{ Session::get('status') }}!</h4>
                            </div>
                        @endif
                        @if(!$redirects->isEmpty())
                        <table class="table table-bordered table-striped">
                            <thead>
                            <tr>
                                <th style="width: 35px;">{{ __('Lp.') }}</th>
                                <th>{{ __('Z adresu') }}</th>
                                <th>{{ __('Na adres') }}</th>
                                <th><strong>{{ __('Ostatnia edycja') }}</strong> <small class="text-muted">({{ __('strefa czasowa: :timezone', ['timezone' => config('app.timezone')]) }})</small></th>
                                @can('edit_dev', 'App\User')
                                    <th style="width: 70px;">&nbsp;</th>
                                @endcan
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($redirects as $num => $redirect)
                                <tr>
                                    <td style="text-align: center;">{!! $redirect->status == 2 ? '<s>' : '' !!}{{ $num+1 }}{!! $redirect->status == 2 ? '</s>' : '' !!}</td>
                                    <td>{!! $redirect->status == 2 ? '<s>' : '' !!}{{ $redirect->from }}{!! $redirect->status == 2 ? '</s>' : '' !!}</td>
                                    <td>{!! $redirect->status == 2 ? '<s>' : '' !!}{{ $redirect->to }}{!! $redirect->status == 2 ? '</s>' : '' !!}</td>
                                    @if($redirect->who_updated)
                                        <td><img src="{{ $redirect->updater->image ? : '/backend/img/blank.jpg' }}" class="user-circle-image" width="25" height="25" alt=""> {{ $redirect->updater->name }} <small class="text-muted">({{ $redirect->updated_at }})</small></td>
                                    @else
                                        <td>&nbsp;</td>
                                    @endif
                                    @can('edit_dev', 'App\User')
                                        <td class="text-center">
                                            <a href="{{ route('redirects.edit', $redirect->id) }}" class="text-light-blue" title="{{ __('Edytuj') }}"><i class="fa fa-edit"></i></a>
                                            @if($redirect->status == 1)
                                                <a href="#" data-href="{{ route('redirects.deactivate', $redirect->id) }}" class="text-yellow" data-toggle="modal" data-target="#confirm-deactivate" title="{{ __('Zdezaktywuj') }}"><i class="fa fa-close"></i></a>
                                            @else
                                                <a href="{{ route('redirects.activate', $redirect->id) }}" class="text-green" title="{{ __('Aktywuj') }}"><i class="fa fa-check"></i></a>
                                            @endif
                                            <a href="#" data-href="{{ route('redirects.delete', $redirect->id) }}" class="text-red" data-toggle="modal" data-target="#confirm-delete" title="{{ __('Usuń') }}"><i class="fa fa-trash"></i></a>
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
                            {{ $redirects->links() }}
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
            <form role="form" method="POST" action="{{ route('redirects') }}" class="modal-content">
                {{ csrf_field() }}
                <div class="modal-header">
                    {{ __('Dodaj przekierowanie') }}
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label>{{ __('Z adresu') }} <small class="text-muted">({{ __('np. /adres-do-przekierowania/test') }})</small></label>
                        <input type="text" id="redirect_from" name="redirect_from" class="form-control" value="{{ old('redirect_from') }}" required />
                    </div>
                    <div class="form-group">
                        <label>{{ __('Na adres') }} <small class="text-muted">({{ __('np. /adres lub http://adres.pl/adres jeżeli przekierowanie zewnętrzne') }})</small></label>
                        <input type="text" id="redirect_to" name="redirect_to" class="form-control" value="{{ old('redirect_to') }}" required />
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger pull-left" data-dismiss="modal">{{ __('Anuluj') }}</button>
                    <button type="submit" class="btn btn-success pull-right">{{ __('Zapisz') }}</button>
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
                    {!! __('Po usunięciu przekierowanie zostanie wyłączone i trafi do elementów usuniętych. Usunięte przekierowanie można przywrócić lub usunąć na stałe. W przypadku nie usunięcia go na stałe nie będzie można stworzyć innego z tego samego adresu.') !!}
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
                    {!! __('Po zdezaktywowaniu przekierowania będzie ono niedostępne.') !!}
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-success pull-left" data-dismiss="modal">{{ __('Anuluj') }}</button>
                    <a class="btn btn-danger pull-right btn-ok">{{ __('Zdezaktywuj') }}</a>
                </div>
            </div>
        </div>
    </div>
@endsection
