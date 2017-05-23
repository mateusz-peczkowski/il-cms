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
                    <form role="form" method="POST" action="{{ route('pages.options.value', $option->id) }}">
                        {{ csrf_field() }}
                        {{ method_field('PUT') }}
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>{{ __('Tytuł') }}</label>
                                    <input type="text" id="key" name="key" class="form-control" value="{{ $option->key }}" disabled />
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>{{ __('Typ') }}</label>
                                    <input type="text" id="type" name="type" class="form-control" value="{{ $option->type }}" disabled />
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>{{ __('Slug') }} {{ __('(służy do wywołania na stronie)') }}</label>
                                    <input type="text" id="type" name="type" class="form-control" value="{{ $option->slug }}" disabled />
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group ">
                                    <label>{{ __('Wartość') }}</label>
                                    @if($option->type == 'textarea')
                                        <?php $selected = old('value') ? : $option->value; ?>
                                        <textarea name="value" id="value" class="form-control">{{ $selected }}</textarea>
                                    @elseif($option->type == 'checkbox')
                                        <?php
                                            $num = 0;
                                            $selected = old('value') ? : $option->value;
                                            $selected = explode(',', $selected);
                                        ?>
                                        <div class="radcheck">
                                            <?php $num++; ?>
                                            @foreach(explode(';', $option->values) as $value)
                                                <div class="block">
                                                    <label for="value-{{ $num }}">
                                                        <input type="checkbox" id="value-{{ $num }}" name="value[]" class="form-control" value="{{ $value }}"{{ in_array($value, $selected) ? ' checked' : '' }} />
                                                        {{ $value }}
                                                    </label>
                                                </div>
                                                <?php $num++; ?>
                                            @endforeach
                                        </div>
                                    @elseif($option->type == 'select')
                                        <?php $selected = old('value') ? : $option->value; ?>
                                        <select name="value" id="value" class="form-control">
                                            <option value=""{{ !$selected ? ' selected' : '' }}>-</option>
                                            @foreach(explode(';', $option->values) as $value)
                                                <option value="{{ $value }}"{{ $selected == $value ? ' selected' : '' }}>{{ $value }}</option>
                                            @endforeach
                                        </select>
                                    @else
                                        <?php $selected = old('value') ? : $option->value; ?>
                                        <input type="text" id="value" name="value" class="form-control" value="{{ $selected }}" autofocus />
                                    @endif
                                </div>
                            </div>
                            <div class="col-xs-12">
                                <div class="text-center mb-0">
                                    @can('add_dev', 'App\User')
                                        <a href="{{ route('pages.options.edit', $option->id) }}" class="btn btn-info margin" title="{{ __('Edytuj strukturę') }}">{{ __('Edytuj strukturę') }}</a>
                                    @endcan
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