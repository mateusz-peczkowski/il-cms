@extends('cmsbackend.layout')

@section('content')
    <div class="row">
        <div class="col-xs-12">
            <div class="box">
                <div class="box-body">
                    @can('add_dev', 'App\User')
                    <span class="btn btn-success" data-toggle="modal" data-target="#add-new" id="create-new">{{ __('Dodaj kontrolkę') }}</span>
                        @if(!$controls->isEmpty())
                            <br /><br />
                        @endif
                    @else
                        <div class="alert alert-warning alert-dismissible">
                            {!! __('Posiadasz za małe uprawnienia aby móc edytować i dodawać zawartość formularzy (wymagane przynajmniej: <strong>developer</strong>). Możesz jedynie przeglądać listę kontrolek') !!}
                        </div>
                    @endcan
                    @if(Session::has('status'))
                        @if($controls->isEmpty())
                            <br /><br />
                        @endif
                        <div class="alert alert-{{ Session::get('status_type')  }} alert-dismissible" data-autohide="true">
                            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                            <h4 class="mb-0"><i class="icon fa fa-check"></i> {{ Session::get('status') }}!</h4>
                        </div>
                    @endif
                    @if(!$controls->isEmpty())
                    <table class="table table-bordered table-striped with-images">
                        <thead>
                            <tr>
                                <th style="width: 35px;">{{ __('Lp.') }}</th>
                                <th>{{ __('Nazwa wyświetlana') }}</th>
                                <th>{{ __('Typ') }}</th>
                                <th>{{ __('Wymagalność') }}</th>
                                <th><strong>{{ __('Ostatnia edycja') }}</strong> <small class="text-muted">({{ __('strefa czasowa: :timezone', ['timezone' => config('app.timezone')]) }})</small></th>
                                @can('edit_dev', 'App\User')
                                    <th style="width: 85px;">&nbsp;</th>
                                @endcan
                            </tr>
                        </thead>
                        <tbody>
                        @foreach($controls as $num => $control)
                            <tr>
                                <td style="text-align: center;">{!! $control->status == 2 ? '<s>' : '' !!}{{ $num+1 }}{!! $control->status == 2 ? '</s>' : '' !!}</td>
                                <td>{!! $control->status == 2 ? '<s>' : '' !!}{{ $control->label }}{!! $control->status == 2 ? '</s>' : '' !!}</td>
                                <td>{!! $control->status == 2 ? '<s>' : '' !!}{{ $control->type }}{!! $control->status == 2 ? '</s>' : '' !!}</td>
                                <td>{!! $control->status == 2 ? '<s>' : '' !!}{{ $control->required ? __('Tak') : __('Nie') }}{!! $control->status == 2 ? '</s>' : '' !!}</td>
                                @if($control->who_updated)
                                    <td><img src="{{ $control->updater->image ? : '/backend/img/blank.jpg' }}" class="user-circle-image" width="25" height="25" alt=""> {{ $control->updater->name }} <small class="text-muted">({{ $control->updated_at }})</small></td>
                                @else
                                    <td>&nbsp;</td>
                                @endif
                                @can('edit_dev', 'App\User')
                                <td class="text-center">
                                    @if($control->role <= Auth::user()->role)
                                        <a href="{{ route('forms.definition.control.edit', [$form->id, $control->id]) }}" class="text-light-blue" title="{{ __('Edytuj') }}"><i class="fa fa-edit"></i></a>
                                        @if($control->status == 1)
                                            <a href="#" data-href="{{ route('forms.definition.control.deactivate', $control->id) }}" class="text-yellow" data-toggle="modal" data-target="#confirm-deactivate" title="{{ __('Zdezaktywuj') }}"><i class="fa fa-close"></i></a>
                                        @else
                                            <a href="{{ route('forms.definition.control.activate', $control->id) }}" class="text-green" title="{{ __('Aktywuj') }}"><i class="fa fa-check"></i></a>
                                        @endif
                                        <a href="#" data-href="{{ route('forms.definition.control.destroy', $control->id) }}" class="text-red" data-toggle="modal" data-target="#confirm-delete" title="{{ __('Usuń') }}"><i class="fa fa-trash"></i></a>
                                    @endif
                                </td>
                                @endcan
                            </tr>
                        @endforeach
                        </tbody>
                        <tfoot>
                            <tr>
                                <th style="width: 35px;">{{ __('Lp.') }}</th>
                                <th>{{ __('Nazwa wyświetlana') }}</th>
                                <th>{{ __('Typ') }}</th>
                                <th>{{ __('Wymagalność') }}</th>
                                <th><strong>{{ __('Ostatnia edycja') }}</strong> <small class="text-muted">({{ __('strefa czasowa: :timezone', ['timezone' => config('app.timezone')]) }})</small></th>
                                @can('edit_dev', 'App\User')
                                    <th style="width: 85px;">&nbsp;</th>
                                @endcan
                            </tr>
                        </tfoot>
                    </table>
                    <div class="pull-right">
                        {{ $controls->links() }}
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection

@section('modals')
    @can('add_dev', 'App\User')
        <div class="modal fade" id="add-new" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
            <div class="modal-dialog">
                <form role="form" method="POST" action="{{ route('forms.definition.controls', $form->id) }}" class="modal-content">
                    {{ csrf_field() }}
                    <div class="modal-header">
                        {{ __('Dodaj kontrolkę do formularza') }}
                    </div>
                    <div class="modal-body">
                        <div class="form-group{{ $errors->has('label') ? ' has-error' : '' }}">
                            <label>{{ __('Nazwa wyświetlana') }}{{ $errors->has('label') ? ' - '.(__($errors->first('label'))) : '' }}</label>
                            <input type="text" id="label" name="label" class="form-control" value="{{ old('label') }}" required autofocus />
                        </div>
                        <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
                            <label>{{ __('Nazwa (pole name)') }}{{ $errors->has('name') ? ' - '.(__($errors->first('name'))) : '' }}</label>
                            <input type="text" id="name" name="name" class="form-control" value="{{ old('name') }}" required autofocus />
                        </div>
                        <div class="form-group{{ $errors->has('type') ? ' has-error' : '' }}">
                            <label>{{ __('Typ') }}{{ $errors->has('type') ? ' - '.(__($errors->first('type'))) : '' }}</label>
                            <?php $type = old('type') ?>
                            <select name="type" id="type" class="form-control" required>
                                <option value="text"{{ $type == 'text' ? ' selected' : '' }}>{{ __('Text') }}</option>
                                <option value="textarea"{{ $type == 'textarea' ? ' selected' : '' }}>{{ __('Textarea') }}</option>
                                <option value="select"{{ $type == 'select' ? ' selected' : '' }}>{{ __('Select') }}</option>
                                <option value="checkbox"{{ $type == 'checkbox' ? ' selected' : '' }}>{{ __('Checkbox') }}</option>
                                <option value="date"{{ $type == 'date' ? ' selected' : '' }}>{{ __('Date') }}</option>
                                <option value="email"{{ $type == 'email' ? ' selected' : '' }}>{{ __('Email') }}</option>
                                <option value="file"{{ $type == 'file' ? ' selected' : '' }}>{{ __('File') }}</option>
                                <option value="hidden"{{ $type == 'hidden' ? ' selected' : '' }}>{{ __('Hidden') }}</option>
                                <option value="image"{{ $type == 'image' ? ' selected' : '' }}>{{ __('Image') }}</option>
                                <option value="number"{{ $type == 'number' ? ' selected' : '' }}>{{ __('Number') }}</option>
                                <option value="password"{{ $type == 'password' ? ' selected' : '' }}>{{ __('Password') }}</option>
                                <option value="radio"{{ $type == 'radio' ? ' selected' : '' }}>{{ __('Radio') }}</option>
                                <option value="tel"{{ $type == 'tel' ? ' selected' : '' }}>{{ __('Tel') }}</option>
                                <option value="url"{{ $type == 'url' ? ' selected' : '' }}>{{ __('URL') }}</option>
                            </select>
                        </div>
                        <div class="form-group{{ $errors->has('default') ? ' has-error' : '' }}">
                            <label>{{ __('Wartość domyślna') }}{{ $errors->has('default') ? ' - '.(__($errors->first('default'))) : '' }}</label>
                            <input type="text" id="default" name="default" class="form-control" value="{{ old('default') }}" autofocus />
                        </div>
                        <div class="form-group{{ $errors->has('values') ? ' has-error' : '' }}">
                            <label>{{ __('Wartości - rozdzielone znakiem ";" (użyć w przypadku typów: select, checkbox [dla grup], radio)') }}{{ $errors->has('values') ? ' - '.(__($errors->first('values'))) : '' }}</label>
                            <input type="text" id="values" name="values" class="form-control" value="{{ old('values') }}" autofocus />
                        </div>
                        <div class="form-group">
                            <label><input type="checkbox" id="required" name="required" class="form-control"{{ old('required') ? ' checked' : '' }} /> {{ __('Pole wymagane') }}</label>
                        </div>
                        <input type="hidden" name="form_id" value="{{ $form->id }}">
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
                    {!! __('Po usunięciu kontrolka zostanie usunięta na stałe i nie będzie dało się jej przywrócić.') !!}
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
                    {!! __('Po zdezaktywowaniu kontrolki będzie ona niedostępna w formularzu.') !!}
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