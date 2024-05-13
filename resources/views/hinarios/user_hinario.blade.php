@extends('layouts.app')

@section('header_title')
    {{ $hinario->getName() }}
@endsection

@section('panzer')
    <!-- Panzer -->
    <link href="/panzer/panzer.css" rel="stylesheet" media="all" />
    <link href="/panzer/panzerlist.css" rel="stylesheet" media="all" />

    <script src="/panzer/panzer.js" type="text/javascript"></script>
    <script src="/panzer/panzerlist.js" type="text/javascript"></script>
@endsection

@section('extra_styles')
    <link rel="stylesheet" href="/css/hymns.css">
    <link rel="stylesheet" href="/css/hinarios.css">
@endsection

@section('page_title')
    <h2 class="small display_table_cell_md">
        {{ $hinario->getName($hinario->original_language_id) }}
            <ol class="breadcrumb display_table_cell">
                @if (\Illuminate\Support\Facades\Auth::user()->getAuthIdentifier() == $hinario->user_id)
                <li>
                    <a href="{{ url('/edit-personal-hinario/' .$hinario->id) }}"><i class="fas fa-edit"></i></a>
                </li>
                @endif
                <li>
                    <a href="{{ url($hinario->getSlug() . '/pdf') }}" target="_blank">{{ __('hinarios.pdf.link_text') }}</a>
                </li>
            </ol>
    </h2>
@endsection

@section('content')
    <div class="col-sm-5 col-md-5 col-lg-5">
        @foreach ($hinario->hymnHinarios as $hymnHinario)
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
        @if ($hinario->image_path != '')
            <div class="row">
                <img src="{{ url($hinario->image_path) }}">
            </div>
        @endif
    </div>
    <!-- eof aside sidebar -->
@endsection
