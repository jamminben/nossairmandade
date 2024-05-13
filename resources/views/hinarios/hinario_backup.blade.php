@extends('layouts.app')

@section('header_title')
    {{ $hinario->getName() }}
@endsection

@section('panzer')
    <!-- Panzer -->
    <link href="/panzer/panzer.css" rel="stylesheet" media="all" />
    <link href="/panzer/panzerlist.css" rel="stylesheet" media="all" />

    <!--<script src="/panzer/panzer.js" type="text/javascript"></script>-->
    <script src="/panzer/panzerlist.js" type="text/javascript"></script>
@endsection

@section('page_title')
    @if (strlen($hinario->getName($hinario->original_language_id)) > 25)
        <div class="hinario-header">
            <h2 class="small display_table_cell_md">
                {{ $hinario->getName($hinario->original_language_id) }}
            </h2>
        </div>
    @else
        <h2 class="small display_table_cell_md">
            {{ $hinario->getName($hinario->original_language_id) }}
    @endif

        <ol class="breadcrumb display_table_cell_md">
            @if ($hinario->getName($hinario->original_language_id) != $hinario->getName())
                <li>
                    {{ $hinario->getName() }}
                </li>
            @endif
            @if ($hinario->type_id == 1 && !empty($hinario->receivedBy))
                <li>
                    {{ __('hymns.header.received_by') }} <a href="{{ url($hinario->receivedBy->getSlug()) }}">{{ $hinario->receivedBy->display_name }}</a>
                </li>
            @endif
            <li>
                <a href="{{ url($hinario->getSlug() . '/pdf') }}" target="_blank">{{ __('hinarios.pdf.link_text') }}</a>
            </li>
        </ol>

    @if (strlen($hinario->getName($hinario->original_language_id)) > 25)
        </h2>
    @endif

@endsection

@section('content')
    <div class="col-sm-5 col-md-5 col-lg-5">
        @php
            $sectionName = ''
        @endphp
        @foreach ($hinario->hymnHinarios as $hymnHinario)
            @if ($displaySections && $hymnHinario->getSection()->getName() != $sectionName)
                <div class="row">
                    <div class="hinario-section-name">{{ $hymnHinario->getSection()->getName() }}</div>
                </div>
                @php
                    $sectionName = $hymnHinario->getSection()->getName()
                @endphp
            @endif
            <div class="hymn-list-name">
                <a href="{{ url($hymnHinario->hymn->getSlug()) }}">
                    {{ $hymnHinario->list_order }}. {{ mb_convert_case($hymnHinario->hymn->getName($hymnHinario->hymn->original_language_id), MB_CASE_TITLE, "UTF-8") }}
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
        @include ('hinarios.partials.audio_block_display_nav')
    </div>

    <!-- sidebar -->
    <div class="col-sm-3 col-md-3 col-lg-3">
        <div class="row">
            @include ('hinarios.partials.audio_block_display_tabs')
        </div>
        <div class="row">
            @include('layouts.partials.other_media', [ 'entity' => $hinario ])
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

