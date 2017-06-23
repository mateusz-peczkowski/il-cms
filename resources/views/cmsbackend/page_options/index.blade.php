@extends('cmsbackend.layout')

@section('content')
    <div class="row">
        <div class="col-xs-12">
            <div class="box">
                <div class="box-body">
                    @include('cmsbackend.parts.top_nav.pages', ['active' => 'options', 'model' => $page])
                    <hr>
                    @can('add_dev', 'App\User')
                        <span class="btn btn-success" data-toggle="modal" data-target="#add-new" id="create-new">{{ __('Dodaj opcje') }}</span>
                        @if(!$options->isEmpty())
                            <br /><br />
                        @endif
                    @else
                        <div class="alert alert-warning alert-dismissible">
                            {!! __('Posiadasz za małe uprawnienia aby móc dodawać opcje (wymagane przynajmniej: <strong>developer</strong>). Możesz jedynie przeglądać listę opcji i edytowa ich wartość') !!}
                        </div>
                    @endcan
                    @if(Session::has('status'))
                        @if($options->isEmpty())
                            <br /><br />
                        @endif
                        <div class="alert alert-{{ Session::get('status_type') }} alert-dismissible" data-autohide="true">
                            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                            <h4 class="mb-0"><i class="icon fa fa-check"></i> {{ Session::get('status') }}!</h4>
                        </div>
                    @endif
                    @if(!$options->isEmpty())
                        <table class="table table-bordered table-striped">
                            <thead>
                            <tr>
                                <th style="width: 35px;">{{ __('Lp.') }}</th>
                                <th>{{ __('Tytuł') }}</th>
                                <th>{{ __('Slug') }}</th>
                                <th>{{ __('Typ') }}</th>
                                <th>{{ __('Wartość') }}</th>
                                <th><strong>{{ __('Ostatnia edycja') }}</strong> <small class="text-muted">({{ __('strefa czasowa: :timezone', ['timezone' => config('app.timezone')]) }})</small></th>
                                <th style="width: 90px;">&nbsp;</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($options as $num => $option)
                                <tr>
                                    <td style="text-align: center;">{{ $num+1 }}</td>
                                    <td>{{ $option->key }}</td>
                                    <td>{{ $option->slug }}</td>
                                    <td>{{ $option->type }}</td>
                                    <td>{{ $option->value }}</td>
                                    @if($option->who_updated)
                                        <td><img src="{{ $option->updater->image ? : '/backend/img/blank.jpg' }}" class="user-circle-image" width="25" height="25" alt=""> {{ $option->updater->name }} <small class="text-muted">({{ $option->updated_at }})</small></td>
                                    @else
                                        <td>&nbsp;</td>
                                    @endif
                                    <td class="text-center">
                                        <a href="{{ route('pages.options.value', $option->id) }}" class="text-green" title="{{ __('Dodaj wartość') }}"><i class="fa fa-plus"></i></a>
                                        @can('edit_dev', 'App\User')
                                        <a href="{{ route('pages.options.edit', $option->id) }}" class="text-light-blue" title="{{ __('Edytuj') }}"><i class="fa fa-edit"></i></a>
                                        <a href="#" data-href="{{ route('pages.options.delete', $option->id) }}" class="text-red" data-toggle="modal" data-target="#confirm-delete" title="{{ __('Usuń') }}"><i class="fa fa-trash"></i></a>
                                        @endcan
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                            <tfoot>
                            <tr>
                                <th style="width: 35px;">{{ __('Lp.') }}</th>
                                <th>{{ __('Tytuł') }}</th>
                                <th>{{ __('Slug') }}</th>
                                <th>{{ __('Typ') }}</th>
                                <th>{{ __('Wartość') }}</th>
                                <th><strong>{{ __('Ostatnia edycja') }}</strong> <small class="text-muted">({{ __('strefa czasowa: :timezone', ['timezone' => config('app.timezone')]) }})</small></th>
                                <th style="width: 90px;">&nbsp;</th>
                            </tr>
                            </tfoot>
                        </table>
                        <div class="pull-right">
                            {{ $options->links() }}
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
                    {!! __('Po usunięciu opcja zostanie wymazana z systemu.') !!}
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-success pull-left" data-dismiss="modal">{{ __('Anuluj') }}</button>
                    <a class="btn btn-danger pull-right btn-ok">{{ __('Usuń') }}</a>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script>
        $('#show-type').slideUp();
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