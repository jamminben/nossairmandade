@extends('layouts.app')

@section('header_title')
    {{ mb_convert_case($hymn->getName(), MB_CASE_TITLE, 'UTF-8') }}
@endsection

@section('panzer')
    <!-- Panzer -->
    <link href="/panzer/panzer.css" rel="stylesheet" media="all" />

    <script src="/panzer/panzer.js" type="text/javascript"></script>
@endsection

@section('extra_styles')
    <link rel="stylesheet" href="/css/hymns.css">
    <link rel="stylesheet" href="/css/hinarios.css">
@endsection

@section('page_title')
    <h2 class="small display_table_cell_md">{{ mb_convert_case($hymn->getName($hymn->original_language_id), MB_CASE_TITLE, 'UTF-8') }}</h2>
    @if (\Illuminate\Support\Facades\Auth::check())
        <div class="hymn-title-add-form">
            <ul class="nav navbar-nav navbar-right add-hymn">
                <li class="dropdown">
                    @include('layouts.partials.add_hymn_form')
                </li>
            </ul>
        </div>
    @endif
    @if (!empty($hymn->received_by))
        <ol class="breadcrumb display_table_cell_md">
            @if (!empty($hymn->receivedBy))
            <li>
                <a href="{{ url($hymn->receivedBy->getSlug()) }}">{{ $hymn->receivedBy->display_name }}</a>
            </li>
            @endif
            @if (!empty($hymn->receivedHinario))
            <li>
                <a href="{{ url($hymn->receivedHinario->getSlug()) }}">{{ $hymn->receivedHinario->getName($hymn->receivedHinario->original_language_id) }}</a> #{{ $hymn->received_order }}
            </li>
            @endif
            @if (!empty($hymn->offeredTo))
                <li>{{ __('hymns.header.offered_to') }} <a href="{{ url($hymn->offeredTo->getSlug()) }}">{{ $hymn->offeredTo->display_name }}</a></li>
            @endif
        </ol>
    @endif
@endsection

@section('content')

    <div class="col-sm-8 col-md-8">
        <div class="container">
            <div class="row">
                <!-- hinario breadcrumbs -->
                <div class="col-sm-12 col-md-12">
                    @foreach ($hymn->getHinarios() as $hinario)
                        @if ($loop->index == 1)
                            <div class="hinario-breadcrumb-also">{{ __('hymns.breadcrumbs.also_in') }}:</div>
                        @endif
                        <div class="@if ($loop->first) hinario-breadcrumb-bold @else hinario-breadcrumb @endif">
                            @if ($loop->first)
                                @php
                                    $previousHymn = $hinario->getPreviousHymn($hymn->id);
                                @endphp
                                @if (!empty($previousHymn))
                                    <a href="{{ url($previousHymn->getSlug()) }}" title="{{ mb_convert_case($previousHymn->getName($previousHymn->original_language_id), MB_CASE_TITLE, 'UTF-8') }}"><i class="far fa-arrow-alt-circle-left"></i> {{ __('hymns.breadcrumbs.previous') }} :: </a>
                                @endif
                            @endif
                            <span class="hinario-breadcrumb-hinario">
                                <a href="{{ url($hinario->getSlug()) }}">{{ $hinario->getName($hinario->original_language_id) }} #{{ $hymn->getNumber($hinario->id) }}</a>
                            </span>
                            @if ($loop->first)
                                @php
                                    $nextHymn = $hinario->getNextHymn($hymn->id);
                                @endphp
                                @if (!empty($nextHymn))
                                    <a href="{{ url($nextHymn->getSlug()) }}" title="{{ mb_convert_case($nextHymn->getName($nextHymn->original_language_id), MB_CASE_TITLE, 'UTF-8') }}">:: {{ __('hymns.breadcrumbs.next') }} <i class="far fa-arrow-alt-circle-right"></i></a>
                                @endif
                            @endif
                        </div>
                    @endforeach
                </div>
            </div>
            <div class="row">
                <!-- music players -->
                @include('hymns.partials.audio_block_display', ['hymn' => $hymn])
            </div>

            <!-- Language selector -->
            @if (count($hymn->getSecondaryTranslations()) >1)
            <div class="row">
                <div class="col-sm-12 col-md-12 text-right flag-image">
                    <ul class="nav-unstyled darklinks flag-image" role="tablist">
                        @foreach ($hymn->getSecondaryTranslations() as $translation)
                            <li @if ($loop->first) class="active" @endif>
                                <a href="#tab-unstyled-{{ $loop->index }}" role="tab" data-toggle="tab">
                                    @if (!empty($translation->language->getImageSlug()))
                                        @include('layouts.partials.flag_image', [ 'language' => $translation->language ])
                                    @else
                                        {{ $translation->language->getField('name') }}
                                    @endif
                                </a>
                            </li>
                        @endforeach
                    </ul>
                </div>
            </div>
            @endif
            <!-- hymn lyrics -->
            <div class="row">
                <!-- Primary Translation -->
                <div class="col-sm-6 col-md-6">
                    <div class="tab-content tab-unstyled">
                        <div class="tab-pane fade in active notranslate" id="tab-unstyled-1000">
                            @if (view()->exists('hymns.patterns.' . $hymn->pattern_id))
                                @include('hymns.patterns.' . $hymn->pattern_id, [ 'language' => $hymn->original_language_id ])
                            @else
                                @include('hymns.patterns.0', [ 'language' => $hymn->original_language_id ])
                            @endif
                            @include('hymns.partials.sun_moon_stars')
                        </div>
                    </div>
                </div>

                @if (count($hymn->getSecondaryTranslations()) > 1)

                    <!-- Other Translations if there are more than one -->
                    <div class="col-sm-6 col-md-6">
                        <!-- Tab panes -->
                        <div class="tab-content tab-unstyled">
                            @foreach ($hymn->getSecondaryTranslations() as $translation)
                                <div class="tab-pane fade @if ($loop->first) in active @endif" id="tab-unstyled-{{ $loop->index }}">
                                    @if (view()->exists('hymns.patterns.' . $hymn->pattern_id))
                                        @include('hymns.patterns.' . $hymn->pattern_id, [ 'language' => $translation->language_id ])
                                    @else
                                        @include('hymns.patterns.0', [ 'language' => $translation->language_id ])
                                    @endif
                                </div>
                            @endforeach
                            @include('hymns.partials.sun_moon_stars')
                        </div>
                    </div>

                @else

                    <!-- Other Translations if there is only one -->
                    @foreach ($hymn->getSecondaryTranslations() as $translation)
                        <div class="col-sm-6 col-md-6">
                            <div class="tab-content tab-unstyled">
                                <div class="tab-pane fade in active" id="tab-unstyled-1000">
                                    @if (view()->exists('hymns.patterns.' . $translation->hymn->pattern_id))
                                        @include('hymns.patterns.' . $translation->hymn->pattern_id, [ 'language' => $translation->language_id ])
                                    @else
                                        @include('hymns.patterns.0', [ 'language' => $translation->language_id ])
                                    @endif
                                </div>
                                @include('hymns.partials.sun_moon_stars')
                            </div>
                        </div>
                    @endforeach

                @endif
            </div> <!-- end lyrics -->
            @if ((!empty($hymn->received_date) && $hymn->received_date != '0000-00-00') || !empty($hymn->received_location))
                <div class="row">
                    @if ((!empty($hymn->received_date) && $hymn->received_date != '0000-00-00') ||
                         !empty($hymn->received_location))
                        <p>
                            {{ __('hymns.received') }}
                            @if ((!empty($hymn->received_date) && $hymn->received_date != '0000-00-00'))
                                {{ $hymn->received_date }}
                            @endif

                            @if ((!empty($hymn->received_date) && $hymn->received_date != '0000-00-00') &&
                                 !empty($hymn->received_location))
                                -
                            @endif

                            @if (!empty($hymn->received_location))
                                {{ $hymn->received_location }}
                            @endif
                        </p>
                    @endif
                </div>
            @endif
        </div>
    </div>

<!-- sidebar -->
<aside class="col-sm-2 col-md-2 col-lg-2">
<div class="row">
<div class="vertical-item content-absolute ds rounded overflow_hidden">
<div class="item-media">
@if(file_exists(public_path($hymn->receivedBy->getPortrait())))
    <img src="{{ asset($hymn->receivedBy->getPortrait()) }}">
@endif
</div>
</div>
<br>
@include('layouts.partials.other_media', [ 'entity' => $hymn ])

@include('layouts.partials.feedback_form', [ 'entityType' => 'hymn', 'entityId' => $hymn->id ])
</div>
<div class="row">
<div class="col-sm-8 col-md-12 col-lg-12 padding-top-20 text-center">
<!-- feedback form -->
@if (\Illuminate\Support\Facades\Auth::check() && \Illuminate\Support\Facades\Auth::user()->hasRole('superadmin'))
@include('admin.layouts.partials.add_media_form', [ 'entityType' => 'hymn', 'entityId' => $hymn->id ])
@endif
</div>
</div>
</aside>
<!-- eof aside sidebar -->
<script>
$(document).ready(function(){
$('[data-toggle="tooltip"]').tooltip();
});
</script>
@endsection

