@extends('cmsbackend.layout')

@section('content')
    @if(isset($forms))
    <div class="row">
        <div class="col-xs-12">
            <div class="box">
                <div class="box-body">
                    @can('add_dev', 'App\User')
                        <span class="btn btn-success" data-toggle="modal" data-target="#add-new" id="create-new">{{ __('Dodaj formularz') }}</span>
                        @if(CMS::isMoreLocales())
                        <div class="btn-group pull-right text-uppercase">
                            <a href="{{ route('forms.changelocale', CMS::getDefaultLocale()) }}" class="btn btn-{{ (Session::get('cms_locale_form') == CMS::getDefaultLocale() || !Session::has('cms_locale_form')) ? 'success' : 'default' }}">{{ CMS::getDefaultLocale() }}</a>
                            @foreach(CMS::getMoreDefaultLocales() as $lang)
                                <a href="{{ route('forms.changelocale', $lang->slug) }}" class="btn btn-{{ Session::get('cms_locale_form') == $lang->slug ? 'success' : 'default' }}">{{ $lang->slug }}</a>
                            @endforeach
                        </div>
                        @endif
                        @if(!$forms->isEmpty())
                            <br /><br />
                        @endif
                    @else
                        <div class="alert alert-warning alert-dismissible">
                            {!! __('Posiadasz za małe uprawnienia aby móc edytować i dodawać formularze (wymagane przynajmniej: <strong>developer</strong>). Możesz jedynie przeglądać listę formularzy') !!}
                        </div>
                    @endcan
                    @if(Session::has('status'))
                        @if($forms->isEmpty())
                            <br /><br />
                        @endif
                        <div class="alert alert-{{ Session::get('status_type')  }} alert-dismissible" data-autohide="true">
                            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                            <h4 class="mb-0"><i class="icon fa fa-check"></i> {{ Session::get('status') }}!</h4>
                        </div>
                    @endif
                    @if(!$forms->isEmpty())
                    <table class="table table-bordered table-striped with-images">
                        <thead>
                            <tr>
                                <th style="width: 35px;">{{ __('Lp.') }}</th>
                                <th>{{ __('Nazwa') }}</th>
                                <th>{{ __('Liczba przesłanych formularzy') }}</th>
                                <th>{{ __('Aktywne kontrolki / Liczba kontrolek') }}</th>
                                <th><strong>{{ __('Ostatnia edycja') }}</strong> <small class="text-muted">({{ __('strefa czasowa: :timezone', ['timezone' => config('app.timezone')]) }})</small></th>
                                @can('edit_dev', 'App\User')
                                    <th style="width: 85px;">&nbsp;</th>
                                @endcan
                            </tr>
                        </thead>
                        <tbody>
                        @foreach($forms as $num => $form)
                            <tr>
                                <td style="text-align: center;">{!! $form->status == 2 ? '<s>' : '' !!}{{ $num+1 }}{!! $form->status == 2 ? '</s>' : '' !!}</td>
                                <td>{!! $form->status == 2 ? '<s>' : '' !!}{{ $form->title }}{!! $form->status == 2 ? '</s>' : '' !!}</td>
                                <td>{!! $form->status == 2 ? '<s>' : '' !!}{{ count($form->submits) }}{!! $form->status == 2 ? '</s>' : '' !!}</td>
                                <td>{!! $form->status == 2 ? '<s>' : '' !!}{{ count($form->controls_active) }}/{{ count($form->controls) }}{!! $form->status == 2 ? '</s>' : '' !!}</td>
                                @if($form->who_updated)
                                    <td><img src="{{ $form->updater->image ? : '/backend/img/blank.jpg' }}" class="user-circle-image" width="25" height="25" alt=""> {{ $form->updater->name }} <small class="text-muted">({{ $form->updated_at }})</small></td>
                                @else
                                    <td>&nbsp;</td>
                                @endif
                                @can('edit_dev', 'App\User')
                                <td class="text-center">
                                    @if($form->role <= Auth::user()->role)
                                        <a href="{{ route('forms.definition.controls', $form->id) }}" class="text-purple" title="{{ __('Edycja kontrolek') }}"><i class="fa fa-list"></i></a>
                                        <a href="{{ route('forms.definition.edit', $form->id) }}" class="text-light-blue" title="{{ __('Edytuj') }}"><i class="fa fa-edit"></i></a>
                                        @if($form->status == 1)
                                            <a href="#" data-href="{{ route('forms.definition.deactivate', $form->id) }}" class="text-yellow" data-toggle="modal" data-target="#confirm-deactivate" title="{{ __('Zdezaktywuj') }}"><i class="fa fa-close"></i></a>
                                        @else
                                            <a href="{{ route('forms.definition.activate', $form->id) }}" class="text-green" title="{{ __('Aktywuj') }}"><i class="fa fa-check"></i></a>
                                        @endif
                                        <a href="#" data-href="{{ route('forms.definition.delete', $form->id) }}" class="text-red" data-toggle="modal" data-target="#confirm-delete" title="{{ __('Usuń') }}"><i class="fa fa-trash"></i></a>
                                    @endif
                                </td>
                                @endcan
                            </tr>
                        @endforeach
                        </tbody>
                        <tfoot>
                            <tr>
                                <th style="width: 35px;">{{ __('Lp.') }}</th>
                                <th>{{ __('Nazwa') }}</th>
                                <th>{{ __('Liczba przesłanych formularzy') }}</th>
                                <th>{{ __('Aktywne kontrolki / Liczba kontrolek') }}</th>
                                <th><strong>{{ __('Ostatnia edycja') }}</strong> <small class="text-muted">({{ __('strefa czasowa: :timezone', ['timezone' => config('app.timezone')]) }})</small></th>
                                @can('edit_dev', 'App\User')
                                    <th style="width: 85px;">&nbsp;</th>
                                @endcan
                            </tr>
                        </tfoot>
                    </table>
                    <div class="pull-right">
                        {{ $forms->links() }}
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
                <form role="form" method="POST" action="{{ route('forms.definition') }}" class="modal-content">
                    {{ csrf_field() }}
                    <div class="modal-header">
                        {{ __('Dodaj formularz') }}
                    </div>
                    <div class="modal-body">
                        <div class="form-group{{ $errors->has('title') ? ' has-error' : '' }}">
                            <label>{{ __('Nazwa') }}{{ $errors->has('title') ? ' - '.(__($errors->first('title'))) : '' }}</label>
                            <input type="text" id="title" name="title" class="form-control" value="{{ old('title') }}" required autofocus />
                        </div>
                        <div class="form-group">
                            <label>{{ __('Opis') }}</label>
                            <textarea name="description" id="description" class="form-control">{{ old('description') }}</textarea>
                        </div>
                        <div class="form-group{{ $errors->has('tag') ? ' has-error' : '' }}">
                            <label>{{ __('Tag') }}{{ $errors->has('tag') ? ' - '.(__($errors->first('tag'))) : '' }}</label>
                            <input type="text" id="tag" name="tag" class="form-control" value="{{ old('tag') }}" required autofocus />
                        </div>
                        <div class="form-group{{ $errors->has('type') ? ' has-error' : '' }}">
                            <label>{{ __('Typ') }}{{ $errors->has('type') ? ' - '.(__($errors->first('type'))) : '' }}</label>
                            <select name="type" id="type" class="form-control" required>
                                <option value="contact"{{ old('type') == 'contact' ? ' selected' : '' }}>{{ __('Formularz kontaktowy') }}</option>
                                <option value="newsletter"{{ old('type') == 'newsletter' ? ' selected' : '' }}>{{ __('Newsletter') }}</option>
                            </select>
                        </div>
                        <div class="row">
                            <div class="columns col-sm-6">
                                <div class="form-group{{ $errors->has('sender_name') ? ' has-error' : '' }}">
                                    <label>{{ __('Nazwa wysyłającego') }}{{ $errors->has('sender_name') ? ' - '.(__($errors->first('sender_name'))) : '' }}</label>
                                    <input type="text" id="sender_name" name="sender_name" class="form-control" value="{{ old('sender_name') }}" required autofocus />
                                </div>
                            </div>
                            <div class="columns col-sm-6">
                                <div class="form-group{{ $errors->has('sender_email') ? ' has-error' : '' }}">
                                    <label>{{ __('E-mail wysyłającego') }}{{ $errors->has('sender_email') ? ' - '.(__($errors->first('sender_email'))) : '' }}</label>
                                    <input type="email" id="sender_email" name="sender_email" class="form-control" value="{{ old('sender_email') }}" required autofocus />
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label><input type="checkbox" id="confirmation" name="confirmation" class="form-control"{{ old('confirmation') ? ' checked' : '' }} /> {{ __('Wysyłac potwierdzenie?') }}</label>
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
                    {!! __('Po usunięciu formularz zostanie przeniesiony do elementów usuniętych. Można będzie go przywrócic przechodząc do zakładki "Usunięte elementy"') !!}
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
                    {!! __('Po zdezaktywowaniu formularza będzie on niedostępny na stronie.') !!}
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