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
                    <form role="form" method="POST" action="{{ route('pages.options.edit', $option->id) }}">
                        {{ csrf_field() }}
                        {{ method_field('PUT') }}
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>{{ __('Tytuł') }}</label>
                                    <input type="text" id="key" name="key" class="form-control" value="{{ old('key') ? : $option->key }}" required autofocus />
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>{{ __('Typ') }}</label>
                                    <?php $type = old('type') ? : $option->type ?>
                                    <select name="type" id="type" class="form-control" required>
                                        <option value="text"{{ $type == 'text' ? ' selected' : '' }}>{{ __('Text') }}</option>
                                        <option value="textarea"{{ $type == 'textarea' ? ' selected' : '' }}>{{ __('Textarea') }}</option>
                                        <option value="select"{{ $type == 'select' ? ' selected' : '' }}>{{ __('Select') }}</option>
                                        <option value="checkbox"{{ $type == 'checkbox' ? ' selected' : '' }}>{{ __('Checkbox') }}</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6" id="show-type" data-donthide="{{ ($type == 'select' || $type == 'checkbox') ? 'true' : 'false' }}">
                                <div class="form-group">
                                    <label>{{ __('Wartości typu - rozdzielone znakiem ";". Np. "Test;Test2"') }}</label>
                                    <input type="text" id="values" name="values" class="form-control" value="{{ old('values') ? : $option->values }}" autofocus{{ ($type == 'select' || $type == 'checkbox') ? ' required' : '' }} />
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

@section('scripts')
    <script>
        $('#show-type[data-donthide="false"]').slideUp();
        $('#type').on('change', function() {
            var allowArray = ['select', 'checkbox'];
            if($.inArray($(this).val(), allowArray) > -1) {
                $('#show-type').slideDown();
                $('#show-type #values').attr('required', 'required');
            } else {
                $('#show-type').slideUp();
                $('#show-type #values').removeAttr('required');
            }
        });
    </script>
@endsection