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
                    <form role="form" method="POST" action="{{ route('forms.definition.update', $form->id) }}">
                        {{ csrf_field() }}
                        {{ method_field('PUT') }}
                        <input type="hidden" name="id" value="{{ $form->id }}">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group{{ $errors->has('title') ? ' has-error' : '' }}">
                                    <label>{{ __('Nazwa') }}{{ $errors->has('title') ? ' - '.(__($errors->first('title'))) : '' }}</label>
                                    <input type="text" id="title" name="title" class="form-control" value="{{ old('title') ? : $form->title }}" required autofocus />
                                </div>
                                <div class="form-group{{ $errors->has('tag') ? ' has-error' : '' }}">
                                    <label>{{ __('Tag') }}{{ $errors->has('tag') ? ' - '.(__($errors->first('tag'))) : '' }}</label>
                                    <input type="text" id="tag" name="tag" class="form-control" value="{{ old('tag') ? : $form->tag }}" required autofocus />
                                </div>
                                <div class="form-group{{ $errors->has('sender_name') ? ' has-error' : '' }}">
                                    <label>{{ __('Nazwa wysyłającego') }}{{ $errors->has('sender_name') ? ' - '.(__($errors->first('sender_name'))) : '' }}</label>
                                    <input type="text" id="sender_name" name="sender_name" class="form-control" value="{{ old('sender_name') ? : $form->sender_name }}" required autofocus />
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>{{ __('Opis') }}</label>
                                    <textarea name="description" id="description" class="form-control">{{ old('description') ? : $form->description }}</textarea>
                                </div>
                                <div class="form-group{{ $errors->has('type') ? ' has-error' : '' }}">
                                    <label>{{ __('Typ') }}{{ $errors->has('type') ? ' - '.(__($errors->first('type'))) : '' }}</label>
                                    <?php
                                    $type = old('type') ? : $form->type;
                                    ?>
                                    <select name="type" id="type" class="form-control" required>
                                        <option value="contact"{{ $type == 'contact' ? ' selected' : '' }}>{{ __('Formularz kontaktowy') }}</option>
                                        <option value="newsletter"{{ $type == 'newsletter' ? ' selected' : '' }}>{{ __('Newsletter') }}</option>
                                    </select>
                                </div>
                                <div class="form-group{{ $errors->has('sender_email') ? ' has-error' : '' }}">
                                    <label>{{ __('E-mail wysyłającego') }}{{ $errors->has('sender_email') ? ' - '.(__($errors->first('sender_email'))) : '' }}</label>
                                    <input type="email" id="sender_email" name="sender_email" class="form-control" value="{{ old('sender_email') ? : $form->sender_email }}" required autofocus />
                                </div>
                            </div>
                            <div class="col-xs-12">
                                <div class="form-group">
                                    <?php
                                        $confirmation = old('confirmation') ? : $form->confirmation;
                                    ?>
                                    <label><input type="checkbox" id="confirmation" name="confirmation" class="form-control"{{ $confirmation ? ' checked' : '' }} /> {{ __('Wysyłac potwierdzenie?') }}</label>
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