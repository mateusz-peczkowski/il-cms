@extends('cmsbackend.layout')

@section('content')
    <div class="row">
        <div class="col-xs-12">
            <div class="box">
                <div class="box-body">
                    @if(Session::has('status'))
                        <div class="alert alert-{{ Session::get('status_type') }} alert-dismissible" data-autohide="true">
                            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                            <h4 class="mb-0"><i class="icon fa fa-check"></i> {{ Session::get('status') }}!</h4>
                        </div>
                    @endif
                    <form role="form" method="POST" action="{{ route('forms.definition.control.update', [$form->id, $control->id]) }}">
                        {{ csrf_field() }}
                        {{ method_field('PUT') }}
                        <input type="hidden" name="id" value="{{ $form->id }}">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group{{ $errors->has('label') ? ' has-error' : '' }}">
                                    <label>{{ __('Nazwa wyświetlana') }}{{ $errors->has('label') ? ' - '.(__($errors->first('label'))) : '' }}</label>
                                    <input type="text" id="label" name="label" class="form-control" value="{{ old('label') ? : $control->label }}" required autofocus />
                                </div>
                                <div class="form-group{{ $errors->has('type') ? ' has-error' : '' }}">
                                    <label>{{ __('Typ') }}{{ $errors->has('type') ? ' - '.(__($errors->first('type'))) : '' }}</label>
                                    <?php $type = old('type') ? : $control->type; ?>
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
                                <div class="form-group{{ $errors->has('values') ? ' has-error' : '' }}">
                                    <label>{{ __('Wartości - rozdzielone znakiem ";" (użyć w przypadku typów: select, checkbox [dla grup], radio)') }}{{ $errors->has('values') ? ' - '.(__($errors->first('values'))) : '' }}</label>
                                    <input type="text" id="values" name="values" class="form-control" value="{{ old('values') ? : $control->values }}" autofocus />
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
                                    <label>{{ __('Nazwa (pole name)') }}{{ $errors->has('name') ? ' - '.(__($errors->first('name'))) : '' }}</label>
                                    <input type="text" id="name" name="name" class="form-control" value="{{ old('name') ? : $control->name }}" required autofocus />
                                </div>
                                <div class="form-group{{ $errors->has('default') ? ' has-error' : '' }}">
                                    <label>{{ __('Wartość domyślna') }}{{ $errors->has('default') ? ' - '.(__($errors->first('default'))) : '' }}</label>
                                    <input type="text" id="default" name="default" class="form-control" value="{{ old('default') ? : $control->default }}" autofocus />
                                </div>
                            </div>
                            <div class="col-xs-12">
                                <div class="form-group">
                                    <?php $required = old('required') ? : $control->required; ?>
                                    <label><input type="checkbox" id="required" name="required" class="form-control"{{ $required ? ' checked' : '' }} /> {{ __('Pole wymagane') }}</label>
                                </div>
                            </div>
                            <div class="col-xs-12">
                                <div class="text-center mb-0">
                                    <button type="reset" class="btn btn-danger margin">{{ __('Wyczyść formularz') }}</button>
                                    <button type="submit" class="btn btn-success margin">{{ __('Zapisz') }}</button>

                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection