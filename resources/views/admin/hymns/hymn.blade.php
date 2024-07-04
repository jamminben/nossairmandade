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
    <link href="/css/DynamicSelect.css" rel="stylesheet" type="text/css">
@endsection

@section('page_title')
    <h3>{{ __('hymns.edit.page_title') }}</h3>
@endsection
@section('controls')
    <div class="col-4 text-right" title="Edit Hinario" id="editSection">
        <div class="col-4 text-right" title="Edit Hinario" id="editSection">
            <button id="saveButton" class="btn btn-success btn-sm">
                <div style="display: inline-block"><h4><i class="fas fa-floppy-o"></i></h4></div>
                <div style="display: inline-block; width: 50px;"><span>{{ __('hymns.edit.save_button') }}</span></div>
            </button>
            <button id="cancelButton" class="btn btn-danger btn-sm">
                <div style="display: inline-block"><h4><i class="fas fa-ban"></i></h4></div>
                <div style="display: inline-block; width: 50px;"><span>{{ __('hymns.edit.cancel_button') }}</span></div>
            </button>
        </div>
    </div>
@endsection

@section('content')
    <script src="/js/DynamicSelect.js"></script>

    <form id="hymnForm" action="{{ url('/edit-hymn/' . $hymn->id) }}" method="post" autocomplete="off" enctype="multipart/form-data">
        @csrf
        <input type="hidden" name="hymnId" value="{{ $hymn->id }}">
    <div class="col-sm-12 col-md-12">
        <div class="container">

            <!-- music fies -->
            @include('admin.hymns.partials.audio_block_display', ['hymn' => $hymn])

            <hr style="border-top: 2px solid #4e6891;">
            <div class="row">
                <!-- autofill received by -->
                <div class="col-sm-3">
                    <div class="form-group" id="received_by_group">
                        <label for="received_by" class="control-label">
                            <span class="grey">{{ __('hymns.edit.received_by') }}</span>
                        </label>
                        <input type="text" class="form-control " name="received_by" id="received_by" placeholder="{{ __('hymns.edit.received_by') }}" value="@if (!is_null($hymn->receivedBy)){{ $hymn->receivedBy->display_name }}@endif" list="persons-list">
                        <datalist id="persons-list">
                            @foreach ($persons as $person)
                                <option value="{{ $person->display_name }}"></option>
                            @endforeach
                        </datalist>
                    </div>
                </div>

                <div class="col-sm-3">
                    <div class="form-group" id="received_date">
                        <label for="received_date" class="control-label">
                            <span class="grey">{{ __('hymns.edit.received_date') }}</span>
                        </label>
                        <input type="date" name="received_date" value="{{ $hymn->received_date == '0000-00-00' ? '' : $hymn->received_date }}">
                    </div>
                </div>

                <div class="col-sm-3">
                    <div class="form-group" id="received_location">
                        <label for="received_location" class="control-label">
                            <span class="grey">{{ __('hymns.edit.received_location') }}</span>
                        </label>
                        <input type="text" name="received_location" value="{{ $hymn->received_location }}">
                    </div>
                </div>
            </div>

            <div class="row">

                <div class="col-sm-3">
                    <div class="form-group" id="offered_to_group">
                        <label for="received_by" class="control-label">
                            <span class="grey">{{ __('hymns.edit.offered_to') }}</span>
                        </label>
                        <input type="text" class="form-control " name="offered_to" id="offered_to" placeholder="" value="@if (!is_null($hymn->offeredTo)){{ $hymn->offeredTo->display_name }}@endif" list="persons-list">
                    </div>
                </div>
            </div>
            <hr style="border-top: 2px solid #4e6891;">

            <!-- patterns and notations -->
            <div class="row">
                <div class="col-sm-5">
                    <label for="pattern_id">{{ __('hymns.edit.pattern') }}</label>
                    <select id="pattern_id" name="pattern_id"></select>
                </div>

                <div class="col-sm-3">
                    <div class="form-group" id="notation">
                        <label for="notation" class="control-label">
                            <span class="grey">{{ __('hymns.edit.notation') }}</span>
                        </label>
                        <select class="form-control" name="notation_id" id="notation_id">
                            <option value="">({{ __('hymns.edit.no_notation') }})</option>
                            @foreach($notations as $notation)
                                <option value="{{ $notation->notation_id }}"
                                        @if (!is_null($hymn->notation) && $notation->notation_id == $hymn->notation) SELECTED @endif
                                >{{ $notation->getName(\App\Services\GlobalFunctions::getCurrentLanguage()) }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
            </div>
            <input type="hidden" name="old_pattern_id" value="{{ $hymn->pattern_id }}">
            <hr style="border-top: 2px solid #4e6891;">

            <!-- language selectors -->
            <div class="row">

                <!-- Original Language Selector -->
                <div class="col-sm-3">
                    <div class="form-group" id="original_language_id">
                        <label for="original_language_id" class="control-label">
                            <span class="grey">{{ __('hymns.edit.original_language') }}</span>
                        </label>
                        <select class="form-control" name="original_language_id" id="original_language_id">
                            @foreach($languages as $language)
                                <option value="{{ $language->language_id }}"
                                        @if ($language->language_id == $hymn->original_language_id) SELECTED @endif
                                >{{ $language->name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <!-- Spacer -->
                <div class="col-sm-3"></div>

                <!-- Secondary Language Selector -->
                <div class="col-sm-3">
                    <div class="form-group" id="original_language_id">
                        <label for="secondary_language_id" class="control-label">
                            <span class="grey">{{ __('hymns.edit.secondary_language') }}</span>
                        </label>
                        <select class="form-control" name="secondary_language_id" id="secondary_language_id">
                            <option value="0"></option>
                            @foreach($languages as $language)
                                <option value="{{ $language->language_id }}"
                                        @if (count($hymn->getSecondaryTranslations()) > 0 &&
                                            $language->language_id == $hymn->getSecondaryTranslations()[0]->language_id) SELECTED @endif
                                >{{ $language->name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
            </div>
            <!-- hymn name -->
            <div class="row">
                <!-- Original Hymn Name -->
                <div class="col-sm-5">
                    <div class="form-group" id="original_name">
                        <label for="original_name" class="control-label">
                            <span class="grey">{{ __('hymns.edit.original_name') }}</span>
                        </label>
                        <input type="text" class="form-control " name="original_name" id="original_name" placeholder="{{ __('hymns.edit.hymn_name') }}" value="@if (!is_null($hymn->getPrimaryTranslation())){{ $hymn->getPrimaryTranslation()->name }}@endif">
                    </div>
                </div>

                <!-- Spacer -->
                <div class="col-sm-1"></div>

                <!-- Secondary Hymn Name -->
                <div class="col-sm-5">
                    <div class="form-group" id="secondary_name">
                        <label for="secondary_name" class="control-label">
                            <span class="grey">{{ __('hymns.edit.secondary_name') }}</span>
                        </label>
                        <input type="text" class="form-control " name="secondary_name" id="secondary_name" placeholder="{{ __('hymns.edit.hymn_name') }}" value="@if (count($hymn->getSecondaryTranslations()) > 0){{ $hymn->getSecondaryTranslations()[0]->name }}@endif">
                    </div>
                </div>
            </div>
            <!-- hymn lyrics -->
            <div class="row">
                <!-- Original Language Lyrics -->
                <div class="col-sm-5">
                    <div class="form-group" id="original_lyrics">
                        <label for="original_lyrics" class="control-label">
                            <span class="grey">{{ __('hymns.edit.original_lyrics') }}</span>
                        </label>
                        <textarea rows="20" cols="100" name="original_lyrics" id="original_lyrics" class="form-control" placeholder="{{ __('hymns.edit.original_lyrics') }}">@if (!is_null($hymn->getPrimaryTranslation())){{ $hymn->getPrimaryTranslation()->lyrics }}@endif</textarea>
                    </div>
                </div>

                <!-- Spacer -->
                <div class="col-sm-1"></div>

                <!-- Secondary Language Lyrics -->
                <div class="col-sm-5">
                    <div class="form-group" id="secondary_lyrics">
                        <label for="secondary_lyrics" class="control-label">
                            <span class="grey">{{ __('hymns.edit.secondary_lyrics') }}</span>
                        </label>
                        <textarea rows="20" cols="100" name="secondary_lyrics" id="secondary_lyrics" class="form-control" placeholder="{{ __('hymns.edit.secondary_lyrics') }}">
                            @if (count($hymn->getSecondaryTranslations()) > 0)
                                {{ $hymn->getSecondaryTranslations()[0]->lyrics }}
                            @endif
                        </textarea>
                    </div>
                </div>
            </div>
        </div>
    </div>
    </form>

    <script>
        $(document).ready(function(){
            $('[data-toggle="tooltip"]').tooltip();
        });
    </script>
    <script>
        $(document).ready(function() {
            $('#cancelButton').click(function() {
                window.location.href = '{{ url('hymn/' . $hymn->id) }}';
            });

            $('#saveButton').click(function() {
                $('#hymnForm').submit();
            });
        });
    </script>
    <script>
        new DynamicSelect('#pattern_id', {
            columns: 5,
            height: '160px',
            width: '300px',
            dropdownWidth: '600px',
            placeholder: '{{ __('hymns.edit.select_pattern_label') }}',
            data: [
                @if (!in_array($hymn->pattern_id, $patternIds))
                {
                    value: '{{ $hymn->pattern_id }}',
                    text: 'Keep existing pattern (not shown)',
                    imgWidth: '100px',
                    imgHeight: '150px',
                    selected: true
                },
                @endif
                @foreach ($patternIds as $patternId)
                {
                    value: '{{ $patternId }}',
                    img: '/images/hymn_patterns/{{ \App\Services\GlobalFunctions::getCurrentLanguage() }}/{{ $patternId }}.jpg',
                    imgWidth: '100px',
                    imgHeight: '150px' @if ($patternId == $hymn->pattern_id) , selected: true @endif
                } @if (!$loop->last) , @endif
                @endforeach
            ],
        });
    </script>
@endsection

