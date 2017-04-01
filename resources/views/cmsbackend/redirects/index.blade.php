@extends('cmsbackend.layout')

@section('content')
    @if(isset($redirects))
        <div class="row">
            <div class="col-xs-12">
                <div class="box">
                    <div class="box-body">
                        @can('add_dev', 'App\User')
                            <a href="{{ route('redirects.create') }}" class="btn btn-success">{{ __('Dodaj przekierowanie') }}</a>
                            <br /><br />
                        @else
                            <div class="alert alert-warning alert-dismissible">
                                {!! __('Posiadasz za małe uprawnienia aby móc edytować i dodawać przekierowania (wymagane przynajmniej: <strong>developer</strong>). Możesz jedynie przeglądać przekierowania') !!}
                            </div>
                        @endcan
                        @if(Session::has('status'))
                            <div class="alert alert-{{ Session::get('status_type') }} alert-dismissible" data-autohide="true">
                                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                                <h4 class="mb-0"><i class="icon fa fa-check"></i> {{ Session::get('status') }}!</h4>
                            </div>
                        @endif
                        <table class="table table-bordered table-striped">
                            <thead>
                            <tr>
                                <th style="width: 35px;">{{ __('Lp.') }}</th>
                                <th>{{ __('Z adresu') }}</th>
                                <th>{{ __('Na adres') }}</th>
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
                                    @can('edit_dev', 'App\User')
                                        <td class="text-right">
                                            <a href="{{ route('redirects.edit', $redirect->id) }}" class="text-light-blue"><i class="fa fa-edit"></i></a>
                                            @if($redirect->status == 1)
                                                <a href="#" data-href="{{ route('redirects.deactivate', $redirect->id) }}" class="text-yellow" data-toggle="modal" data-target="#confirm-deactivate"><i class="fa fa-close"></i></a>
                                            @else
                                                <a href="{{ route('redirects.activate', $redirect->id) }}" class="text-green"><i class="fa fa-check"></i></a>
                                            @endif
                                            <a href="#" data-href="{{ route('redirects.delete', $redirect->id) }}" class="text-red" data-toggle="modal" data-target="#confirm-delete"><i class="fa fa-trash"></i></a>
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
                                @can('edit_dev', 'App\User')
                                    <th style="width: 70px;">&nbsp;</th>
                                @endcan
                            </tr>
                            </tfoot>
                        </table>
                        <div class="pull-right">
                            {{ $redirects->links() }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endif
@endsection

@section('modals')
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
                    <a class="btn btn-danger pull-right btn-ok">{{ __('Usuń przekierowanie') }}</a>
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
                    <a class="btn btn-danger pull-right btn-ok">{{ __('Zdezaktywuj przekierowanie') }}</a>
                </div>
            </div>
        </div>
    </div>
@endsection
