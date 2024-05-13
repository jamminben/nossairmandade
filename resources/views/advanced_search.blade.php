@extends('layouts.app')

@section('header_title')
    {{ __('pagetitles.search.header_title') }}
@endsection

@section('page_title')
    <h2 class="small display_table_cell_md">{{ __('pagetitles.search.page_title') }}</h2>
@endsection

@section('content')
    <div class="col-xs-4">
        <form class="shop-register" role="form">
            <div class="col-sm-10">
                <div class="form-group" id="hymn_contains">
                    <label for="hymn_contains" class="control-label">
                        <span class="grey">{{ __('search.form.hymnContainsLabel') }}:</span>
                    </label>
                    <input type="text" class="form-control " name="hymn_contains" id="hymn_contains" placeholder="{{ __('search.form.hymnContains') }}" value="{{ $contains }}">
                </div>
            </div>
            <div class="col-sm-10">
                <div class="form-group">
                    <label for="received_by" class="control-label">
                        <span class="grey">{{ __('search.form.receivedByLabel') }}</span>
                    </label>
                    <select class="form-control" name="received_by" id="received_by">
                        <option value=""
                                @if (empty($receivedBy)) SELECTED @endif
                        >Select a person</option>
                        @foreach($people as $person)
                            <option value="{{ $person->id }}"
                                @if ($receivedBy == $person->id) SELECTED @endif
                            >{{ $person->display_name }} ({{ $person->hymns_count }})</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="col-sm-10">
                <div class="form-group">
                    <label for="offered_to" class="control-label">
                        <span class="grey">{{ __('search.form.offeredToLabel') }}</span>
                    </label>
                    <select class="form-control" name="offered_to" id="offered_to">
                        <option value=""
                                @if (empty($offeredTo)) SELECTED @endif
                        >Select a person</option>
                        @foreach($people as $person)
                            <option value="{{ $person->id }}"
                                    @if ($offeredTo == $person->id) SELECTED @endif
                            >{{ $person->display_name }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="col-sm-10 center">
                <button type="submit" class="theme_button wide_button color1 topmargin_40">{{ __('search.form.submit') }}</button>
            </div>
        </form>
    </div>
    <div class="col-xs-6">
        @if (count($hymnTranslations) > 0)
            <h3>{{ __('search.results') }}:</h3>
        @endif

            @foreach ($hymnTranslations as $hymnTranslation)
                <div class="row">
                    <div class="hymn-list-number">{{ $loop->iteration }}</div>
                    <div class="inline-block bottompadding_20">
                        <div class="hymn-list-name">
                            <a href="{{ url($hymnTranslation->hymn->getSlug()) }}">{{ mb_convert_case($hymnTranslation->name, MB_CASE_TITLE, "UTF-8") }}</a>
                        </div>
                        <p>
                            {{ $hymnTranslation->hymn->receivedBy->display_name }}
                            @if (!empty($hymnTranslation->hymn->receivedHinario))
                                - {{ $hymnTranslation->hymn->receivedHinario->getName() }} #{{ $hymnTranslation->hymn->received_order }}
                            @endif
                        </p>
                    </div>
                </div>
            @endforeach
    </div>
@endsection
