@extends('cmsbackend.layout')

@section('content')
    @if(isset($navigation))
        <div class="row">
            <div class="col-xs-12">
                <div class="box">
                    <div class="box-body">
                        <span class="btn btn-success" data-toggle="modal" data-target="#add-new">{{ __('Dodaj element') }}</span>
                        @if(CMS::isMoreLocales())
                            <div class="btn-group pull-right text-uppercase">
                                <a href="{{ route('nodes.changelocale', [$navigation->id, CMS::getDefaultLocale()]) }}" class="btn btn-{{ (Session::get('cms_locale_module_'.$navigation->slug) == CMS::getDefaultLocale() || !Session::has('cms_locale_module_'.$navigation->slug)) ? 'success' : 'default' }}">{{ CMS::getDefaultLocale() }}</a>
                                @foreach(CMS::getMoreDefaultLocales() as $lang)
                                    <a href="{{ route('nodes.changelocale', [$navigation->id, $lang->slug]) }}" class="btn btn-{{ Session::get('cms_locale_module_'.$navigation->slug) == $lang->slug ? 'success' : 'default' }}">{{ $lang->slug }}</a>
                                @endforeach
                            </div>
                        @endif
                        <br />
                        <br />
                        @if(Session::has('status'))
                            <div class="alert alert-{{ Session::get('status_type') }} alert-dismissible" data-autohide="true">
                                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                                <h4 class="mb-0"><i class="icon fa fa-check"></i> {{ Session::get('status') }}!</h4>
                            </div>
                        @endif
                        @if(isset($tree) AND $tree)
                            <div id="form-messages"></div>
                            <?php
                                function render_subnodes($node, $navigation)
                                {
                                    $ret = '';
                                    if (count($node->subnodes))
                                    {
                                        $ret .= '<ol class="dd-list">';
                                        foreach ($node->subnodes as $subnode)
                                        {
                                            $ret .= '<li class="dd-item" data-id="' . $subnode->id . '">';
                                            $ret .= item($subnode, $navigation);
                                            $ret .= render_subnodes($subnode, $navigation);
                                            $ret .= '</li>';
                                        }
                                        $ret .= '</ol>';
                                    }
                                    return $ret;
                                }

                            function item($node, $navigation)
                            {
                                $item = '<div class="dd-handle dd3-handle">Drag</div>
                                            <div class="dd3-content">' .
                                                $node->title;
                                $item .= '<span class="button-group">';
                                $item .= '<a href="#" data-id="'.$node->id.'" data-title="'.$node->title.'" class="text-red" data-toggle="modal" data-target="#change-name" title="'. __('Zmień nazwę') .'"><i class="fa fa-cog"></i></a>';
                                $item .= '<a href="'.route('pages.edit', $node->page_id).'" class="text-light-blue" title="'.__('Edytuj').'"><i class="fa fa-edit"></i></a>';
                                $item .= '<a href="#" data-href="'.route('nodes.destroy', [$navigation->id, $node->id]).'" class="text-red" data-toggle="modal" data-target="#confirm-delete" title="'. __('Usuń') .'"><i class="fa fa-trash"></i></a>';
                                $item .= '</span></div>';
                                return $item;
                            }
                            ?>
                            @if ($navigation)
                                <div id="nestable1" class="dd">
                                    <ol class="dd-list">
                                        @foreach ($navigation->nodes as $node)
                                            <li class="dd-item" data-id="{{ $node->id }}">
                                                {!! item($node, $navigation) !!}
                                                {!! render_subnodes($node, $navigation) !!}
                                            </li>
                                        @endforeach
                                    </ol>
                                </div>
                            @endif
                            <div class="hide" id="nestable1-output"></div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    @endif
@endsection

@section('modals')
    @can('add_dev', 'App\User')
        <div class="modal fade" id="add-new" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                {{Form::open(['route' => ['nodes', $navigation->id], 'files' => true, 'method' => 'POST', 'class' => 'modal-content'])}}
                    {{ csrf_field() }}
                    <div class="modal-header">
                        {{ __('Dodaj element') }}
                    </div>
                    <div class="modal-body">
                        <div class="form-group">
                            <label>{{ __('Tytuł elementu nawigacyjnego') }}</label>
                            <input type="text" id="title" name="title" class="form-control" value="{{ old('title') }}" />
                        </div>
                        <div class="form-group">
                            <label>{{ __('Strona (wybierz lub stwórz nową na podstawie tytułu powyżej)') }}</label>
                            <select name="page_id" id="page_id" class="form-control select2" style="width: 100%;">
                                <option value="new"{{ old('page_id') == 'new' ? ' selected' : '' }}>{{ __('Nowa strona') }}</option>
                                @if(isset($pages) AND $pages)
                                    @foreach($pages as $page)
                                        <option value="{{ $page->id }}"{{ old('page_id') == $page->id ? ' selected' : '' }}>{{ $page->name }}</option>
                                    @endforeach
                                @endif
                            </select>
                        </div>
                        <div class="form-group">
                            <label>{{ __('Element nadrzędny (opcjonalne)') }}</label>
                            <select name="parent_id" id="parent_id" class="form-control select2" style="width: 100%;">
                                <option value=""{{ old('parent_id') == 'null' ? ' selected' : '' }}>{{ __('To jest element nadrzędny') }}</option>
                                @if(isset($nodes) AND $nodes)
                                    @foreach($nodes as $node)
                                        <option value="{{ $node->id }}"{{ old('parent_id') == $node->id ? ' selected' : '' }}>{{ $node->title }}</option>
                                    @endforeach
                                @endif
                            </select>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger pull-left" data-dismiss="modal">{{ __('Anuluj') }}</button>
                        <button type="submit" class="btn btn-success pull-right">{{ __('Zapisz') }}</button>
                    </div>
                {{Form::close()}}
            </div>
        </div>
        <div class="modal fade" id="change-name" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                {{Form::open(['route' => ['nodes.edit', $navigation->id], 'files' => false, 'method' => 'POST', 'class' => 'modal-content'])}}
                    {{ csrf_field() }}
                    <div class="modal-header">
                        {{ __('Zmień nazwę w nawigacji') }}
                    </div>
                    <div class="modal-body">
                        <div class="form-group">
                            <label>{{ __('Tytuł') }}</label>
                            <input type="text" id="change_title" name="change_title" class="form-control" value="{{ old('change_title') }}" required />
                        </div>
                        <input type="hidden" id="change_id" name="change_id" value="{{ old('change_id') }}" />
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger pull-left" data-dismiss="modal">{{ __('Anuluj') }}</button>
                        <button type="submit" class="btn btn-success pull-right">{{ __('Zapisz') }}</button>
                    </div>
                {{Form::close()}}
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
                    {!! __('Po usunięciu element zostanie usunięty z nawigacji. Operacji tej nie da się odwrócić.') !!}
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
        $('#change-name').on('show.bs.modal', function (event) {
            var button = $(event.relatedTarget);
            var id = button.data('id');
            var title = button.data('title');
            var modal = $(this);
            modal.find('#change_id').val(id);
            modal.find('#change_title').val(title);
        })
    </script>

    <script>
        var CompNestable = function() {
            var updateOutput = function(e, init) {
                var list   = e.length ? e : $(e.target),
                    output = list.data('output');
                if (window.JSON) {
                    output.html(window.JSON.stringify(list.nestable('serialize')));
                    if (!init)
                    {
                        var $_token = "{{ csrf_token() }}";
                        SendAjax('{{ route('nodes.refreshtree', array($navigation->id)) }}', 'POST', { tree_structure: window.JSON.stringify(list.nestable('serialize')), _token: $_token })
                    }
                } else {
                    output.html('JSON browser support required!');
                }
            };
            return {
                init: function() {
                    var nestList1 = $('#nestable1');
                    nestList1
                        .nestable({
                            group: 1
                        })
                        .on('change', updateOutput);
                    updateOutput(nestList1.data('output', $('#nestable1-output')), 1);
                }
            };
        }();
    </script>
    <script>$(function(){ CompNestable.init(); });</script>
@endsection
