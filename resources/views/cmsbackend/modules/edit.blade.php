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
                    <form role="form" method="POST" action="{{ route('edit-modules', $module->id) }}">
                        {{ csrf_field() }}
                        {{ method_field('PUT') }}
                        <input type="hidden" name="id" value="{{ $module->id }}">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>{{ __('Tytuł') }}</label>
                                    <input type="text" id="title" name="title" class="form-control" value="{{ old('title') ? : $module->title }}" required />
                                </div>
                                <div class="form-group">
                                    <label>{{ __('Slug') }} <small class="text-muted">({{ __('służy do wywołania na stronie') }})</small></label>
                                    <input type="text" id="slug" name="slug" class="form-control" value="{{ $module->slug }}" disabled />
                                </div>
                                <div class="form-group">
                                    <?php
                                        $checkbox = old('has_details') ? : $module->has_details;
                                    ?>
                                    <label><input type="checkbox" id="has_details" name="has_details" class="form-control"{{ $checkbox ? ' checked' : '' }} /> {{ __('Czy elementy modułu będą miały swoją podstronę ze szczegółami?') }}</label>
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <?php
                                                $sort = old('order_records') ? : $module->order_records;
                                            ?>
                                            <label>{{ __('Sortuj według') }}</label>
                                            <select name="order_records" id="order_records" class="form-control">
                                                <option value="title"{{ $sort == 'title' ? ' selected' : '' }}>{{ __('Tytuł') }}</option>
                                                <option value="order"{{ $sort == 'order' ? ' selected' : '' }}>{{ __('Kolejność własna') }}</option>
                                                <option value="created_at"{{ $sort == 'created_at' ? ' selected' : '' }}>{{ __('Data stworzenia') }}</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <?php
                                                $order = old('order_records_type') ? : $module->order_records_type;
                                            ?>
                                            <label>{{ __('Sposób sortowania') }}</label>
                                            <select name="order_records_type" id="order_records_type" class="form-control">
                                                <option value="desc"{{ $order == 'desc' ? ' selected' : '' }}>{{ __('Malejący') }}</option>
                                                <option value="asc"{{ $order == 'asc' ? ' selected' : '' }}>{{ __('Rosnący') }}</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>{{ __('Struktura') }}</label>
                                    <div class="button-group">
                                        <span class="btn btn-success btn-xs" data-toggle="modal" data-target="#add-new"><i class="fa fa-plus"></i></span>
                                        <br /><br />
                                    </div>
                                    <table class="table table-bordered table-striped">
                                        <thead>
                                            <tr>
                                                <th>{{ __('Klucz') }}</th>
                                                <th>{{ __('Slug') }}</th>
                                                <th>{{ __('Typ') }}</th>
                                                <th>{{ __('Pole wymagane') }}</th>
                                                <th style="width: 55px;"></th>
                                            </tr>
                                        </thead>
                                        <tbody id="table-body">
                                        </tbody>
                                        <tfoot>
                                            <tr>
                                                <th>{{ __('Klucz') }}</th>
                                                <th>{{ __('Slug') }}</th>
                                                <th>{{ __('Typ') }}</th>
                                                <th>{{ __('Pole wymagane') }}</th>
                                                <th style="width: 55px;"></th>
                                            </tr>
                                        </tfoot>
                                    </table>
                                    <input type="hidden" name="structure" id="structure" value="{{ old('structure') ? : $module->structure }}">
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

@section('modals')
    <div class="modal fade" id="add-new" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <form role="form" method="POST" action="" class="modal-content" id="module_add_structure">
                {{ csrf_field() }}
                <div class="modal-header">
                    {{ __('Dodaj element struktury') }}
                </div>
                <div class="modal-body">
                    <div class="alert alert-error alert-dismissible">
                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                        <h4 class="mb-0"><i class="icon fa fa-check"></i> {{ __('Element już istnieje. Podaj inny') }}!</h4>
                    </div>
                    <div class="form-group">
                        <label>{{ __('Tytuł') }}</label>
                        <input type="text" id="str_title" name="str_title" class="form-control" value="{{ old('str_title') }}" required />
                    </div>
                    <div class="form-group">
                        <label>{{ __('Typ') }}</label>
                        <select name="str_type" id="str_type" class="form-control" required>
                            <option value="text">{{ __('Text') }}</option>
                            <option value="textarea">{{ __('Textarea') }}</option>
                            <option value="date">{{ __('Date') }}</option>
                            <option value="file">{{ __('File') }}</option>
                            <option value="checkbox">{{ __('Checkbox') }}</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label><input type="checkbox" id="str_required" name="str_required" class="form-control"{{ old('str_required') ? ' checked' : '' }} /> {{ __('Czy elementy jest wymagany?') }}</label>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger pull-left" data-dismiss="modal">{{ __('Anuluj') }}</button>
                    <button type="submit" class="btn btn-success margin">{{ __('Dodaj') }}</button>
                </div>
            </form>
        </div>
    </div>
@endsection


@section('scripts')
    <script>
        var moduleData = {};

        $('#module_add_structure .alert').slideUp();

        var create_slug = function(str) {
            str = str.replace(/^\s+|\s+$/g, '');
            str = str.toLowerCase();
            var from = "ãàáäâẽèéëêìíïîõòóöôùúüûñç·/_,:;";
            var to   = "aaaaaeeeeeiiiiooooouuuunc------";
            for (var i=0, l=from.length ; i<l ; i++) {
                str = str.replace(new RegExp(from.charAt(i), 'g'), to.charAt(i));
            }
            str = str.replace(/[^a-z0-9 -]/g, '')
                .replace(/\s+/g, '-')
                .replace(/-+/g, '-');
            return str;
        };

        var setTable = function() {

            $('#structure').val(JSON.stringify(moduleData));

            var string = '';
            $.each(moduleData, function(index, elem) {
                string += '<tr>';
                string += '<td>'+elem.title+'</td>';
                string += '<td>'+elem.slug+'</td>';
                string += '<td>'+elem.type+'</td>';
                var required = elem.required ? "{{ __('Tak') }}" : "{{ __('Nie') }}";
                string += '<td>'+required+'</td>';
                string += '<td class="text-center"><button class="text-red remove-btn" style="padding: 0; background: transparent; border: 0; margin: 0 5px;" data-slug="'+ elem.slug +'"><i class="fa fa-trash"></i></button></td>';
                string += '</tr>';
            });

            $('#table-body').empty().html(string);

            btnActions();
        };

        var btnActions = function() {
            $('.remove-btn').unbind('click').click(function(e) {
                e.preventDefault();
                delete moduleData[$(this).data('slug')];
                setTable();
            });
        };

        $('#module_add_structure').on('submit', function(e) {
           e.preventDefault();

            var title = $('#str_title').val();
            var type = $('#str_type').val();
            var required = $('#str_required').prop('checked');

            var slug = create_slug(title);

            if(moduleData[slug]) {
                $('#module_add_structure .alert').slideDown(function() {
                   setTimeout(function() {
                       $('#module_add_structure .alert').slideUp();
                   }, 2000);
                });
                return false;
            }

            moduleData[slug] = {};
            moduleData[slug]['title'] = title;
            moduleData[slug]['slug'] = slug;
            moduleData[slug]['type'] = type;
            moduleData[slug]['required'] = required;

            setTable();

            $('#module_add_structure input').val('');
            $('#module_add_structure select').val($('#module_add_structure select option').eq(0).val());
            $('#module_add_structure input[type="checkbox"]').iCheck('uncheck');

            $('#add-new').modal('hide');

        });

        if($('#structure').val()) {
            moduleData = JSON.parse($('#structure').val());
            setTable();
        }
    </script>
@endsection