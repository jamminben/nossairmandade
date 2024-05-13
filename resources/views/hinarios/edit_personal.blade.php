@extends('layouts.app')

@section('header_title')
    {{ __('pagetitles.hinarios.personal.edit_header_title') }} {{ $hinario->name }}
@endsection

@section('page_title')
    <h2 class="small display_table_cell_md">{{ __('pagetitles.hinarios.personal.edit_page_title') }} {{ $hinario->name }}</h2>
    <ol class="breadcrumb display_table_cell_md">
        <li>
            <a href="{{ url($hinario->getSlug()) }}" target="_blank">{{ __('pagetitles.hinarios.personal.view') }}</a>
        </li>
    </ol>
@endsection

@section('content')
    <div class="col-sm-7 col-md-7 col-lg-7">
        @foreach ($hinario->hymnHinarios as $hymnHinario)
            <div class="hymn-list-name">
                <a href="{{ url($hymnHinario->hymn->getSlug()) }}" style="padding-right: 60px;">
                    {{ $hymnHinario->list_order }}. {{ mb_convert_case($hymnHinario->hymn->getName($hymnHinario->hymn->original_language_id), MB_CASE_TITLE, "UTF-8") }}
                </a>
                <div class="personal-hymn-actions">
                    <form action="{{ url('/edit-personal-hinario/' . $hymnHinario->hinario_id ) }}" method="POST" id="delete_hymn_form_{{ $hymnHinario->hymn_id }}" style="display: inline-block;">
                        @csrf
                        <a href="#" id="delete_hymn_link_{{ $hymnHinario->hymn_id }}"><i class="fas fa-trash-alt"></i></a>
                        <input type="hidden" name="hymn_id" value="{{ $hymnHinario->hymn_id }}">
                        <input type="hidden" name="action" value="delete_hymn">
                    </form>
                    @if (!$loop->first)
                        <form action="{{ url('/edit-personal-hinario/' . $hymnHinario->hinario_id ) }}" method="POST" id="move_hymn_up_form_{{ $hymnHinario->hymn_id }}" style="display: inline-block;">
                            @csrf
                            <a href="#" id="move_hymn_up_link_{{ $hymnHinario->hymn_id }}"><i class="fas fa-arrow-up"></i></a>
                            <input type="hidden" name="hymn_id" value="{{ $hymnHinario->hymn_id }}">
                            <input type="hidden" name="action" value="move_up">
                        </form>
                    @endif
                    @if (!$loop->last)
                        <form action="{{ url('/edit-personal-hinario/' . $hymnHinario->hinario_id ) }}" method="POST" id="move_hymn_down_form_{{ $hymnHinario->hymn_id }}" style="display: inline-block;">
                            @csrf
                            <a href="#" id="move_hymn_down_link_{{ $hymnHinario->hymn_id }}"><i class="fas fa-arrow-down"></i></a>
                            <input type="hidden" name="hymn_id" value="{{ $hymnHinario->hymn_id }}">
                            <input type="hidden" name="action" value="move_down">
                        </form>
                    @endif
                </div>

                <script>
                    var form_delete_hymn_{{ $hymnHinario->hymn_id }} = document.getElementById("delete_hymn_form_{{ $hymnHinario->hymn_id }}");

                    document.getElementById("delete_hymn_link_{{ $hymnHinario->hymn_id }}").addEventListener("click", function () {
                        form_delete_hymn_{{ $hymnHinario->hymn_id }}.submit();
                    });

                    @if (!$loop->first)
                        var move_hymn_up_form_{{ $hymnHinario->hymn_id }} = document.getElementById("move_hymn_up_form_{{ $hymnHinario->hymn_id }}");

                        document.getElementById("move_hymn_up_link_{{ $hymnHinario->hymn_id }}").addEventListener("click", function () {
                            move_hymn_up_form_{{ $hymnHinario->hymn_id }}.submit();
                        });
                    @endif

                    @if (!$loop->last)
                        var move_hymn_down_form_{{ $hymnHinario->hymn_id }} = document.getElementById("move_hymn_down_form_{{ $hymnHinario->hymn_id }}");

                        document.getElementById("move_hymn_down_link_{{ $hymnHinario->hymn_id }}").addEventListener("click", function () {
                            move_hymn_down_form_{{ $hymnHinario->hymn_id }}.submit();
                        });
                    @endif
                </script>

                <br>
                {{ $hymnHinario->hymn->receivedBy->display_name }} #{{ $hymnHinario->hymn->received_order }}
            </div>
        @endforeach
    </div>
    <div class="col-sm-3 col-md-3 col-lg-3">
        <div class="row">
            @if ($hinario->image_path != '')
                <img src="{{ url($hinario->image_path) }}">
                <h4>{{ __('hinarios.edit_personal.change_image_header') }}</h4>
            @else
                <h4>{{ __('hinarios.edit_personal.add_image_header') }}</h4>
            @endif

            <form action="{{ url('/edit-personal-hinario/' . $hinario->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="form-group">
                    <input type="hidden" name="action" value="new_image">
                    <input type="file" name="new_image" class="form-control " value="">
                </div>
                <div class="form-group">
                    <button type="submit" class="theme_button color4 margin_0">{{ __('hinarios.edit_personal.submit_image') }}</button>
                </div>
            </form>
            <hr>
        </div>
        <div class="row">
            <h4>{{ __('hinarios.edit_personal.new_name_header') }}</h4>
            <form action="{{ url('/edit-personal-hinario/' . $hinario->id) }}" method="POST">
                @csrf
                <div class="form-group">
                    <input type="hidden" name="action" value="rename_hinario">
                    <input type="text" name="new_name" value="" placeholder="{{ __('hinarios.edit_personal.new_name_placeholder') }}">
                </div>
                <div class="form-group">
                    <button type="submit" class="theme_button color4 margin_0">{{ __('hinarios.edit_personal.submit_rename') }}</button>
                </div>
            </form>
        </div>
    </div>
@endsection
