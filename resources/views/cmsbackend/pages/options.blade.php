@extends('cmsbackend.layout')

@section('content')
    <div class="row">
        <div class="col-xs-12">
            <div class="box">
                <div class="box-body">
                    <div class="btn-group">
                        <a href="{{ route('pages.edit', $page->id) }}" class="btn btn-success">{{ __('Ogólne') }}</a>
                        <a href="{{ route('pages.gallery', $page->id) }}" class="btn btn-success">{{ __('Zdjęcia') }}</a>
                        <a href="{{ route('pages.sections', $page->id) }}" class="btn btn-success">{{ __('Sekcje') }}</a>
                        <a href="{{ route('pages.options', $page->id) }}" class="btn btn-default disabled">{{ __('Opcje') }}</a>
                        @can('edit_dev', 'App\User')
                            <a href="{{ route('pages.advanced', $page->id) }}" class="btn btn-success">{{ __('Zaawansowane') }}</a>
                        @endcan
                    </div>
                    <hr>
                    @can('add_dev', 'App\User')
                        <span class="btn btn-success" data-toggle="modal" data-target="#add-new" id="create-new">{{ __('Dodaj opcje') }}</span>
                    @endcan
                    @if(isset($options))
                        @foreach($options as $option)
                            {{ $option->key }}
                        @endforeach
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
                <form role="form" method="POST" action="{{ route('pages.options', $page->id) }}" class="modal-content">
                    {{ csrf_field() }}
                    <div class="modal-header">
                        {{ __('Dodaj opcje') }}
                    </div>
                    <div class="modal-body">
                        <div class="form-group">
                            <label>{{ __('Tytuł') }}</label>
                            <input type="text" id="key" name="key" class="form-control" value="{{ old('key') }}" required autofocus />
                        </div>
                        <div class="form-group">
                            <label>{{ __('Typ') }}</label>
                            <?php $type = old('type') ?>
                            <select name="type" id="type" class="form-control" required>
                                <option value="text"{{ $type == 'text' ? ' selected' : '' }}>{{ __('Text') }}</option>
                                <option value="textarea"{{ $type == 'textarea' ? ' selected' : '' }}>{{ __('Textarea') }}</option>
                                <option value="select"{{ $type == 'select' ? ' selected' : '' }}>{{ __('Select') }}</option>
                                <option value="checkbox"{{ $type == 'checkbox' ? ' selected' : '' }}>{{ __('Checkbox') }}</option>
                            </select>
                        </div>
                        <div class="form-group" id="show-type">
                            <label>{{ __('Wartości typu - rozdzielone znakiem ";". Np. "Test;Test2"') }}</label>
                            <input type="text" id="values" name="values" class="form-control" value="{{ old('values') }}" autofocus />
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
@endsection

@section('scripts')
    <script>
        $('#show-type').slideUp();
        $('#type').on('change', function() {
            var allowArray = ['select', 'checkbox'];
            if($.inArray($(this).val(), allowArray) > -1) {
                $('#show-type').slideDown();
            } else {
                $('#show-type').slideUp();
            }
        });
    </script>
@endsection