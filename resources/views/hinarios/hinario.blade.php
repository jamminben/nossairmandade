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
            @if (($hinario->type_id == 1 || $hinario->type_id == 2) && !empty($hinario->receivedBy))
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
<div class="col-4 text-right" title="Edit Hinario" id="editSection">
    <div class="col-4 text-right" title="Edit Hinario" id="editSection">
        <button id="editButton" class="btn btn-warning btn-sm">
            <div style="display: inline-block"><h4><i class="fas fa-pencil-square-o"></i></h4></div>
            <div style="display: inline-block; width: 50px;"><span>{{ __('hinarios.edit_button') }}</span></div>
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
                    <div class="hinario-section-name" style="margin-left:14px;">{{ $hymnHinario->section }}</div>
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
        @cannot('edit_hinario_' . $hinario->id)
        <div class="row">
            <div class="col-sm-12 col-md-12 col-lg-12 padding-top-20">
                <!-- feedback form -->
                @if (\Illuminate\Support\Facades\Auth::check())
                    @include('layouts.partials.feedback_form', [ 'entityType' => 'hinario', 'entityId' => $hinario->id ])
                @endif
            </div>
        </div>
        @endcannot
    </div>
    <!-- eof aside sidebar -->
@endsection
@section('js')
<script>
    $(document).ready(function() {
        $('#editButton').click(function() {
            window.location.href = '{{ url('edit-hinario/' . $hinario->id) }}';
        });
    });
</script>
@endsection

