@extends('layouts.app')

@section('header_title')
    {{ $hinario->getName($hinario->original_language_id) }}
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

@endsection
@section('page_title')
    <h3>{{ __('hinarios.edit_hinario.page_header') }}</h3>


@endsection
@section('controls')
    <div class="col-4 text-right" title="Edit Hinario" id="editSection">
        <div class="col-5 text-right" title="Edit Hinario" id="editSection">
            <button id="saveButton" class="btn btn-success btn-sm">
                <div style="display: inline-block"><h4><i class="fas fa-floppy-o"></i></h4></div>
                <div style="display: inline-block; width: 50px;"><span>{{ __('hinarios.edit_hinario.save_button') }}</span></div>
            </button>
            <button id="cancelButton" class="btn btn-danger btn-sm">
                <div style="display: inline-block"><h4><i class="fas fa-ban"></i></h4></div>
                <div style="display: inline-block; width: 50px;"><span>{{ __('hinarios.edit_hinario.cancel_button') }}</span></div>
            </button>
        </div>
    </div>
@endsection
@section('content')
    <form id="hinarioForm" action="{{ url('/edit-hinario/' . $hinario->id) }}" method="post">
        @csrf
        <input type="hidden" name="hinarioId" value="{{ $hinario->id }}">
    <div class="col-sm-10 col-md-10 col-lg-10">
        <div class="row">
            <div class="col-sm-7">
                <div class="row">
                    <!-- Original Hinario Name -->
                    <div class="col-sm-5">
                        <div class="form-group" id="name">
                            <label for="name" class="control-label">
                                <span class="grey">{{ __('hinarios.edit_hinario.original_name') }}</span>
                            </label>
                            <input type="text" class="form-control " name="name" id="name" placeholder="{{ __('hinarios.edit_hinario.original_name') }}" value="{{ $hinario->getName($hinario->original_language_id) }}">
                        </div>
                    </div>

                    <!-- Spacer -->
                    <div class="col-sm-1"></div>

                    <!-- Original Language Selector -->
                    <div class="col-sm-4">
                        <div class="form-group" id="original_language_id">
                            <label for="original_language_id" class="control-label">
                                <span class="grey">{{ __('hinarios.edit_hinario.original_language') }}</span>
                            </label>
                            <select class="form-control" name="original_language_id" id="original_language_id">
                                @foreach($languages as $language)
                                    <option value="{{ $language->language_id }}"
                                            @if ($language->language_id == $hinario->original_language_id) SELECTED @endif
                                    >{{ $language->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <!-- Secondary Hinario Name -->
                    <div class="col-sm-5">
                        <div class="form-group" id="secondary_name">
                            <label for="secondary_name" class="control-label">
                                <span class="grey">{{ __('hinarios.edit_hinario.secondary_name') }}</span>
                            </label>
                            <input type="text" class="form-control " name="secondary_name" id="secondary_name" placeholder="{{ __('hinarios.edit_hinario.secondary_name') }}" value="@if (count($hinario->getSecondaryTranslations()) > 0){{ $hinario->getSecondaryTranslations()[0]->name }}@endif">
                        </div>
                    </div>

                    <!-- Spacer -->
                    <div class="col-sm-1"></div>

                    <!-- Secondary Language Selector -->
                    <div class="col-sm-5">
                        <div class="form-group" id="original_language_id">
                            <label for="secondary_language_id" class="control-label">
                                <span class="grey">{{ __('hinarios.edit_hinario.secondary_language') }}</span>
                            </label>
                            <select class="form-control" name="secondary_language_id" id="secondary_language_id">
                                <option value="0"></option>
                                @foreach($languages as $language)
                                    <option value="{{ $language->language_id }}"
                                            @if (count($hinario->getSecondaryTranslations()) > 0 &&
                                                $language->language_id == $hinario->getSecondaryTranslations()[0]->language_id) SELECTED @endif
                                    >{{ $language->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Spacer -->
            <div class="col-sm-1"></div>

            <div class="col-sm-3 col-md-3 col-lg-3">
                <div class="row">
                    @include('admin.layouts.partials.other_media', ['entity' => $hinario])
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
        </div>

        @php
            $sectionName = ''
        @endphp
        @foreach ($hinario->hymnHinarios as $hymnHinario)
            @if ($displaySections && $hymnHinario->getSection()->getName($hinario->original_language_id) != $sectionName)
                <div class="row">
                    <hr style="border-top: 2px solid #4e6891;">
                        <div class="hinario-section-name" style="margin-left:14px;">
                            {{ __('hinarios.edit_hinario.section_name', ['number' => $hymnHinario->section_number]) }}
                            <input type="text" name="section_{{ $hymnHinario->getSection()->id }}" value="{{ $hymnHinario->getSection()->getName($hinario->original_language_id) }}">
                            <input type="text" name="section_secondary_{{ $hymnHinario->getSection()->id }}" value="@if (count($hinario->getSection->getSecondaryTranslations()) > 0){{ $hymnHinario->getSection()->getSecondaryTranslations()[0]->name }}@endif">
                        </div>

                </div>
                @php
                    $sectionName = $hymnHinario->getSection()->getName($hinario->original_language_id)
                @endphp
            @endif
            <div class="hymn-list-name">

                <a class="ml-sm-5">
                    {{ $hymnHinario->list_order }}.
                    @if (strlen($hymnHinario->hymn->getName()) > 30)
                        @php
                            $closestSpace = strpos($hymnHinario->hymn->getName(), ' ', 23);
                        @endphp
                        {!! mb_convert_case(substr_replace($hymnHinario->hymn->getName(), '<br>', $closestSpace, 0), MB_CASE_TITLE, "UTF-8") !!}
                    @else
                        {{ mb_convert_case($hymnHinario->hymn->getName(), MB_CASE_TITLE, "UTF-8") }}
                    @endif
                </a>
                <div style="display: inline; padding-left: 20px;"><input type="checkbox" name="delete_hymn_{{ $hymnHinario->id }}"> {{ __('hinarios.edit_hinario.remove_hymn', ['hymn' => strtoupper($hymnHinario->hymn->getName())]) }} <i class="fas fa-trash"></i></div>
                <br>
                <hr>
                <input type="checkbox" name="add_hymn_{{ $hymnHinario->id }}"> {{ __('hinarios.edit_hinario.insert_new_hymn') }}
                <hr>

            </div>
        @endforeach

        <div class="row">
            <hr style="border-top: 2px solid #4e6891;">
            <div class="col">
                <div class="hinario-section-name" style="margin-left:14px;">
                    <input type="checkbox" name="add_section"> {{ __('hinarios.edit_hinario.add_new_section') }}
                    <input type="text" name="add_section_name" value="" placeholder="{{ __('hinarios.edit_hinario.new_section_name_placeholder') }}">
                    <input type="text" name="add_section_name_secondary_language" value="" placeholder="{{ __('hinarios.edit_hinario.new_section_name_placeholder_secondary_language') }}">
                </div>
            </div>
        </div>

    </div>

    <!--eof .col-sm-8 (main content)-->
    <!-- tabs -->
    <div class="col-sm-2 col-md-2 col-lg-2">
        <a name="players" class="name-anchor-mobile"></a>
        @include ('admin.hinarios.partials.audio_block_display_nav')
    </div>


    <!-- eof aside sidebar -->
    </form>
@endsection
@section('js')
<script>
    $(document).ready(function() {
        $('#cancelButton').click(function() {
            window.location.href = '{{ url('hinario/' . $hinario->id) }}';
        });

        $('#saveButton').click(function() {
            $('#hinarioForm').submit();
        });
    });
</script>
@endsection

