@extends('cmsbackend.layout')

@section('content')
    @if(isset($pages))
    <div class="row">
        <div class="col-xs-12">
            <div class="box">
                <div class="box-body">
                    @can('add_dev', 'App\User')
                        <a class="btn btn-success" href="{{ route('pages.create') }}">{{ __('Dodaj stronę') }}</a>
                        @if(CMS::isMoreLocales())
                        <div class="btn-group pull-right text-uppercase">
                            <a href="{{ route('pages.changelocale', CMS::getDefaultLocale()) }}" class="btn btn-{{ (Session::get('cms_locale_page') == CMS::getDefaultLocale() || !Session::has('cms_locale_page')) ? 'success' : 'default' }}">{{ CMS::getDefaultLocale() }}</a>
                            @foreach(CMS::getMoreDefaultLocales() as $lang)
                                <a href="{{ route('pages.changelocale', $lang->slug) }}" class="btn btn-{{ Session::get('cms_locale_page') == $lang->slug ? 'success' : 'default' }}">{{ $lang->slug }}</a>
                            @endforeach
                        </div>
                        @endif
                        @if(!$pages->isEmpty())
                            <br /><br />
                        @endif
                    @else
                        <div class="alert alert-warning alert-dismissible">
                            {!! __('Posiadasz za małe uprawnienia aby móc dodawać strony (wymagane przynajmniej: <strong>developer</strong>). Możesz jedynie przeglądać listę stron oraz je edytować') !!}
                        </div>
                    @endcan
                    @if(Session::has('status'))
                        @if($pages->isEmpty())
                            <br /><br />
                        @endif
                        <div class="alert alert-{{ Session::get('status_type')  }} alert-dismissible" data-autohide="true">
                            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                            <h4 class="mb-0"><i class="icon fa fa-check"></i> {{ Session::get('status') }}!</h4>
                        </div>
                    @endif
                    @if(!$pages->isEmpty())
                    <table class="table table-bordered table-striped with-images">
                        <thead>
                            <tr>
                                <th style="width: 35px;">{{ __('Lp.') }}</th>
                                <th>{{ __('Tytuł') }}</th>
                                <th>{{ __('URL') }}</th>
                                <th>{{ __('Data stworzenia') }} <small class="text-muted">({{ __('strefa czasowa: :timezone', ['timezone' => config('app.timezone')]) }})</small></th>
                                <th><strong>{{ __('Ostatnia edycja') }}</strong> <small class="text-muted">({{ __('strefa czasowa: :timezone', ['timezone' => config('app.timezone')]) }})</small></th>
                                <th style="width: {{ CMS::isMoreLocales() ? '105' : '85' }}px;">&nbsp;</th>
                            </tr>
                        </thead>
                        <tbody>
                        @foreach($pages as $num => $page)
                            <tr>
                                <td style="text-align: center;">{!! $page->status == 2 ? '<s>' : '' !!}{{ $num+1 }}{!! $page->status == 2 ? '</s>' : '' !!}</td>
                                <td>{!! $page->status == 2 ? '<s>' : '' !!}{{ $page->name }}{!! $page->status == 2 ? '</s>' : '' !!}</td>
                                <td>{!! $page->status == 2 ? '<s>' : '' !!}{{ $page->url }}{!! $page->status == 2 ? '</s>' : '' !!}</td>
                                <td>{!! $page->status == 2 ? '<s>' : '' !!}{{ $page->created_at }}/{{ count($page->controls) }}{!! $page->status == 2 ? '</s>' : '' !!}</td>
                                @if($page->who_updated)
                                    <td><img src="{{ $page->updater->image ? : '/backend/img/blank.jpg' }}" class="user-circle-image" width="25" height="25" alt=""> {{ $page->updater->name }} <small class="text-muted">({{ $page->updated_at }})</small></td>
                                @else
                                    <td>&nbsp;</td>
                                @endif
                                <td class="text-center">
                                    <a href="{{ route('pages.edit', $page->id) }}" class="text-light-blue" title="{{ __('Edytuj') }}"><i class="fa fa-edit"></i></a>
                                    @if($page->status == 1)
                                        <a href="#" data-href="{{ route('pages.deactivate', $page->id) }}" class="text-yellow" data-toggle="modal" data-target="#confirm-deactivate" title="{{ __('Zdezaktywuj') }}"><i class="fa fa-close"></i></a>
                                    @else
                                        <a href="{{ route('pages.activate', $page->id) }}" class="text-green" title="{{ __('Aktywuj') }}"><i class="fa fa-check"></i></a>
                                    @endif
                                    <a href="#" data-href="{{ route('pages.delete', $page->id) }}" class="text-red" data-toggle="modal" data-target="#confirm-delete" title="{{ __('Usuń') }}"><i class="fa fa-trash"></i></a>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                        <tfoot>
                            <tr>
                                <th style="width: 35px;">{{ __('Lp.') }}</th>
                                <th>{{ __('Tytuł') }}</th>
                                <th>{{ __('URL') }}</th>
                                <th>{{ __('Data stworzenia') }} <small class="text-muted">({{ __('strefa czasowa: :timezone', ['timezone' => config('app.timezone')]) }})</small></th>
                                <th><strong>{{ __('Ostatnia edycja') }}</strong> <small class="text-muted">({{ __('strefa czasowa: :timezone', ['timezone' => config('app.timezone')]) }})</small></th>
                                <th style="width: {{ CMS::isMoreLocales() ? '105' : '85' }}px;">&nbsp;</th>
                            </tr>
                        </tfoot>
                    </table>
                    <div class="pull-right">
                        {{ $pages->links() }}
                    </div>
                    @endif
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
@endsection

@section('scripts')
    @if(count($errors) > 0)
        <script>
            $('#create-new').trigger('click');
        </script>
    @endif
@endsection