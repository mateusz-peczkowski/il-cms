@extends('cmsbackend.layout')

@section('content')
    @if(isset($navigations))
        <div class="row">
            <div class="col-xs-12">
                <div class="box">
                    <div class="box-body">
                        @can('add_dev', 'App\User')
                            <span class="btn btn-success" data-toggle="modal" data-target="#add-new">{{ __('Dodaj nawigacje') }}</span>
                            @if(!$navigations->isEmpty())
                                <br /><br />
                            @endif
                        @else
                            <div class="alert alert-warning alert-dismissible">
                                {!! __('Posiadasz za małe uprawnienia aby móc edytować i dodawać nawigacje (wymagane przynajmniej: <strong>developer</strong>). Możesz jedynie przeglądać listę nawigacji') !!}
                            </div>
                        @endcan
                        @if(Session::has('status'))
                            @if($navigations->isEmpty())
                                <br /><br />
                            @endif
                            <div class="alert alert-{{ Session::get('status_type') }} alert-dismissible" data-autohide="true">
                                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                                <h4 class="mb-0"><i class="icon fa fa-check"></i> {{ Session::get('status') }}!</h4>
                            </div>
                        @endif
                        @if(!$navigations->isEmpty())
                        <table class="table table-bordered table-striped">
                            <thead>
                            <tr>
                                <th style="width: 35px;">{{ __('Lp.') }}</th>
                                <th>{{ __('Tytuł') }}</th>
                                <th>{{ __('Tag') }}</th>
                                <th><strong>{{ __('Ostatnia edycja') }}</strong> <small class="text-muted">({{ __('strefa czasowa: :timezone', ['timezone' => config('app.timezone')]) }})</small></th>
                                @can('edit_dev', 'App\User')
                                    <th style="width: 70px;">&nbsp;</th>
                                @endcan
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($navigations as $num => $navigation)
                                <tr>
                                    <td style="text-align: center;">{!! $navigation->status == 2 ? '<s>' : '' !!}{{ $num+1 }}{!! $navigation->status == 2 ? '</s>' : '' !!}</td>
                                    <td>{!! $navigation->status == 2 ? '<s>' : '' !!}{{ $navigation->title }}{!! $navigation->status == 2 ? '</s>' : '' !!}</td>
                                    <td>{!! $navigation->status == 2 ? '<s>' : '' !!}{{ $navigation->tag }}{!! $navigation->status == 2 ? '</s>' : '' !!}</td>
                                    @if($navigation->who_updated)
                                        <td><img src="{{ $navigation->updater->image ? : '/backend/img/blank.jpg' }}" class="user-circle-image" width="25" height="25" alt=""> {{ $navigation->updater->name }} <small class="text-muted">({{ $navigation->updated_at }})</small></td>
                                    @else
                                        <td>&nbsp;</td>
                                    @endif
                                    @can('edit_dev', 'App\User')
                                        <td class="text-center">
                                            <a href="{{ route('edit-navigations', $navigation->id) }}" class="text-light-blue" title="{{ __('Edytuj') }}"><i class="fa fa-edit"></i></a>
                                            @if($navigation->status == 1)
                                                <a href="#" data-href="{{ route('deactivate-navigations', $navigation->id) }}" class="text-yellow" data-toggle="modal" data-target="#confirm-deactivate" title="{{ __('Zdezaktywuj') }}"><i class="fa fa-close"></i></a>
                                            @else
                                                <a href="{{ route('activate-navigations', $navigation->id) }}" class="text-green" title="{{ __('Aktywuj') }}"><i class="fa fa-check"></i></a>
                                            @endif
                                            <a href="#" data-href="{{ route('delete-navigations', $navigation->id) }}" class="text-red" data-toggle="modal" data-target="#confirm-delete" title="{{ __('Usuń') }}"><i class="fa fa-trash"></i></a>
                                        </td>
                                    @endcan
                                </tr>
                            @endforeach
                            </tbody>
                            <tfoot>
                            <tr>
                                <th style="width: 35px;">{{ __('Lp.') }}</th>
                                <th>{{ __('Tytuł') }}</th>
                                <th>{{ __('Tag') }}</th>
                                <th><strong>{{ __('Ostatnia edycja') }}</strong> <small class="text-muted">({{ __('strefa czasowa: :timezone', ['timezone' => config('app.timezone')]) }})</small></th>
                                @can('edit_dev', 'App\User')
                                    <th style="width: 70px;">&nbsp;</th>
                                @endcan
                            </tr>
                            </tfoot>
                        </table>
                        <div class="pull-right">
                            {{ $navigations->links() }}
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
            <form role="form" method="POST" action="{{ route('index-navigations') }}" class="modal-content">
                {{ csrf_field() }}
                <div class="modal-header">
                    {{ __('Dodaj nawigację') }}
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label>{{ __('Tytuł') }}</label>
                        <input type="text" id="title" name="title" class="form-control" value="{{ old('title') }}" required />
                    </div>
                    <div class="form-group">
                        <label>{{ __('Tag') }}</label>
                        <input type="text" id="tag" name="tag" class="form-control" value="{{ old('tag') }}" required />
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
                    {!! __('Po usunięciu nawigacja zostanie wyłączona i trafi do elementów usuniętych. Usuniętą nawigację można przywrócić lub usunąć na stałe w elementach usuniętych') !!}
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
                    {!! __('Po zdezaktywowaniu nawigacji będzie ona niedostępna na stronie.') !!}
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-success pull-left" data-dismiss="modal">{{ __('Anuluj') }}</button>
                    <a class="btn btn-danger pull-right btn-ok">{{ __('Zdezaktywuj') }}</a>
                </div>
            </div>
        </div>
    </div>
@endsection
