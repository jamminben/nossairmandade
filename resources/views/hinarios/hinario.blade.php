@extends('layouts.app')

@section('header_title')
    {{ $hinario->name }}
@endsection

@section('panzer')
    <!-- Panzer -->
    <link href="/panzer/panzerlist.css" rel="stylesheet" media="all" />

    <script src="/panzer/panzerlist.js" type="text/javascript"></script>
@endsection

@section('extra_styles')
    <link rel="stylesheet" href="/css/hymns.css">
    <link rel="stylesheet" href="/css/hinarios.css">
@endsection
@section('css')
<style>
    .d-none {
        display : none !important;
    }
</style>
@endsection
@section('page_title')
    @if (strlen($hinario->name) > 25)
        <div class="hinario-header">
            <h2 class="small display_table_cell_md">
                {{ $hinario->name }}
            </h2>
        </div>
    @else
        <h2 class="small display_table_cell_md">
            {{ $hinario->name }}
    @endif

        <ol class="breadcrumb display_table_cell_md">
            @if ($hinario->name != $hinarioModel->getName())
                <li>
                    {{ $hinarioModel->getName() }}
                </li>
            @endif
            @if ($hinario->type_id == 1 && !empty($hinario->receivedBy))
                <li>
                    {{ __('hymns.header.received_by') }} <a href="{{ url($hinario->receivedBy->slug) }}">{{ $hinario->receivedBy->display_name }}</a>
                </li>
            @endif
            <li>
                <a href="{{ url($hinario->slug . '/pdf') }}" target="_blank" style="color: #fac400;">{{ __('hinarios.pdf.link_text') }}</a>
            </li>
        </ol>

    @if (strlen($hinario->name) > 25)
        </h2>
    @endif

@endsection
@section('controls')
@can('edit_hinario_' . $hinario->id)
<!-- <div class="col-4 text-right" title="Edit Hinario">
    <svg xmlns="http://www.w3.org/2000/svg" width="30" height="30" fill="currentColor" class="bi bi-pencil-square" viewBox="0 0 16 16">
        <path d="M15.502 1.94a.5.5 0 0 1 0 .706L14.459 3.69l-2-2L13.502.646a.5.5 0 0 1 .707 0l1.293 1.293zm-1.75 2.456-2-2L4.939 9.21a.5.5 0 0 0-.121.196l-.805 2.414a.25.25 0 0 0 .316.316l2.414-.805a.5.5 0 0 0 .196-.12l6.813-6.814z"/>
        <path fill-rule="evenodd" d="M1 13.5A1.5 1.5 0 0 0 2.5 15h11a1.5 1.5 0 0 0 1.5-1.5v-6a.5.5 0 0 0-1 0v6a.5.5 0 0 1-.5.5h-11a.5.5 0 0 1-.5-.5v-11a.5.5 0 0 1 .5-.5H9a.5.5 0 0 0 0-1H2.5A1.5 1.5 0 0 0 1 2.5z"/>
    </svg>
</div> -->
<div class="col-4 text-right" title="Edit Hinario" id="editSection">
    <div class="col-4 text-right" title="Edit Hinario" id="editSection">
        <button id="editButton" class="btn btn-primary btn-sm">
            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-pencil-square" viewBox="0 0 16 16">
                <path d="M15.502 1.94a.5.5 0 0 1 0 .706L14.459 3.69l-2-2L13.502.646a.5.5 0 0 1 .707 0l1.293 1.293zm-1.75 2.456-2-2L4.939 9.21a.5.5 0 0 0-.121.196l-.805 2.414a.25.25 0 0 0 .316.316l2.414-.805a.5.5 0 0 0 .196-.12l6.813-6.814z"/>
                <path fill-rule="evenodd" d="M1 13.5A1.5 1.5 0 0 0 2.5 15h11a1.5 1.5 0 0 0 1.5-1.5v-6a.5.5 0 0 0-1 0v6a.5.5 0 0 1-.5.5h-11a.5.5 0 0 1-.5-.5v-11a.5.5 0 0 1 .5-.5H9a.5.5 0 0 0 0-1H2.5A1.5 1.5 0 0 0 1 2.5z"/>
            </svg>
            <span>Edit</span>
        </button>
        <button id="saveButton" class="btn btn-success d-none btn-sm">
            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-save" viewBox="0 0 16 16">
                <path d="M9.286 2.447a.5.5 0 0 1 .701-.116l5 3.5a.5.5 0 0 1 0 .826l-5 3.5a.5.5 0 0 1-.701-.447V6.447a.5.5 0 0 0-.5-.5H1a.5.5 0 0 1-.5-.5v-1a.5.5 0 0 1 .5-.5h7.286a.5.5 0 0 0 .5-.5V2.447zM7 2h1v3H7V2z"/>
                <path d="M2 1.5A1.5 1.5 0 0 1 3.5 0h9A1.5 1.5 0 0 1 14 1.5v3a.5.5 0 0 1-1 0V1.5a.5.5 0 0 0-.5-.5h-9a.5.5 0 0 0-.5.5v11a.5.5 0 0 0 .5.5h9a.5.5 0 0 0 .5-.5v-3a.5.5 0 0 1 1 0v3A1.5 1.5 0 0 1 12.5 16h-9A1.5 1.5 0 0 1 2 14.5v-11z"/>
            </svg>
            <span>Save</span>
        </button>
        <button id="cancelButton" class="btn btn-danger d-none btn-sm">
            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-x-square" viewBox="0 0 16 16">
                <path fill-rule="evenodd" d="M10.354 4.646a.5.5 0 0 1 0 .708l-3.5 3.5a.5.5 0 0 1-.708 0l-3.5-3.5a.5.5 0 0 1 .708-.708L6 7.293l3.646-3.647a.5.5 0 0 1 .708 0z"/>
                <path fill-rule="evenodd" d="M7.646 4.646a.5.5 0 0 1 0-.708l3.5-3.5a.5.5 0 0 1 .708 0l3.5 3.5a.5.5 0 0 1-.708.708L9 2.707l-3.646 3.647a.5.5 0 0 1-.708 0z"/>
            </svg>
            <span>Cancel</span>
        </button>
    </div>
</div>
@endcan
@endsection
@section('content')
    <div class="col-sm-5 col-md-5 col-lg-5">
        <div class="mobile-active" style="padding-bottom: 20px;"><a href="#players">{{ __('hinarios.jump') }}</a></div>
        @php
            $sectionName = ''
        @endphp
        @foreach ($hinario->hymnHinarios as $hymnHinario)
            @if ($hinario->displaySections && $hymnHinario->section != $sectionName)
                <div class="row">
                    <div class="col">
                        <div class="hinario-section-name" style="margin-left:14px;">{{ $hymnHinario->section }}</div>
                    </div>
                </div>
                @php
                    $sectionName = $hymnHinario->section
                @endphp
            @endif
            <div class="hymn-list-name">
                <a href="{{ url($hymnHinario->hymn->slug) }}" class="ml-sm-5">
                    {{ $hymnHinario->list_order }}.
                    @if (strlen($hymnHinario->hymn->name) > 30)
                        @php
                            $closestSpace = strpos($hymnHinario->hymn->name, ' ', 23);
                        @endphp
                        {!! mb_convert_case(substr_replace($hymnHinario->hymn->name, '<br>', $closestSpace, 0), MB_CASE_TITLE, "UTF-8") !!}
                    @else
                        {{ mb_convert_case($hymnHinario->hymn->name, MB_CASE_TITLE, "UTF-8") }}
                    @endif
                </a>
                @if (\Illuminate\Support\Facades\Auth::check())
                    <ul class="nav navbar-nav navbar-right add-hymn">
                        <li class="dropdown">
                            @include('layouts.partials.add_hymn_form', [ 'hymn' => $hymnHinario->hymn ])
                        </li>
                    </ul>
                @endif
            </div>
        @endforeach
    </div>
    <!--eof .col-sm-8 (main content)-->
    <!-- tabs -->
    <div class="col-sm-2 col-md-2 col-lg-2">
        <a name="players" class="name-anchor-mobile"></a>
        @include ('hinarios.partials.audio_block_display_nav')
    </div>

    <!-- sidebar -->
    <div class="col-sm-3 col-md-3 col-lg-3">
        <div class="row">
            @include ('hinarios.partials.audio_block_display_tabs')
        </div>
        <div class="row">
            @include('layouts.partials.other_media_hinario')
        </div>
        <div class="row">
            <div class="col-sm-12 col-md-12 col-lg-12 padding-top-20">
                <!-- feedback form -->
                @if (\Illuminate\Support\Facades\Auth::check())
                    @include('layouts.partials.feedback_form', [ 'entityType' => 'hinario', 'entityId' => $hinario->id ])
                @endif
            </div>
        </div>
        <div class="row">
            <div class="col-sm-12 col-md-12 col-lg-12 padding-top-20">
                <!-- add media form -->
                @if (\Illuminate\Support\Facades\Auth::check() && \Illuminate\Support\Facades\Auth::user()->hasRole('superadmin'))
                    @include('admin.layouts.partials.add_media_form', [ 'entityType' => 'hinario', 'entityId' => $hinario->id ])
                @endif
            </div>
        </div>
    </div>
    <!-- eof aside sidebar -->
@endsection
@section('js')
<script>
    $(document).ready(function() {
        $('#editButton').click(function() {
            $(this).addClass('d-none');
            $('#saveButton').removeClass('d-none');
            $('#cancelButton').removeClass('d-none');
        });

        $('#cancelButton').click(function() {
            $('#editButton').removeClass('d-none');
            $('#saveButton').addClass('d-none');
            $(this).addClass('d-none');
        });

        $('#saveButton').click(function() {
            // Implement your save functionality here
            alert('Save button clicked');
        });
    });
</script>
@endsection

