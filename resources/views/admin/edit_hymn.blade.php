@extends('admin.layouts.app')

@section('header_title')
    Edit Hymn
@endsection

@section('page_title')
    <h2 class="small display_table_cell_md">Edit Hymn</h2>
@endsection

@section('content')
    <div class="col-sm-10 text-center" data-animation="scaleAppear">
        <div class="row">
            <form method="POST" action="{{ url('admin/enter-hymn') }}">
                @csrf
                <div class="row">
                    <!-- Received By Selector -->
                    <div class="col-sm-3">
                        <div class="form-group">
                            <label for="received_by" class="control-label">
                                <span class="grey">Received by:</span>
                            </label>
                            <select class="form-control" name="received_by" id="received_by">
                                <option value="">Select a person</option>
                                @foreach($persons as $person)
                                    <option value="{{ $person->id }}"
                                        @if ($person->id == $receivedById) SELECTED @endif
                                    >{{ $person->display_name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <!-- New Person for Received By -->
                    <div class="col-sm-3">
                        <div class="form-group" id="new_received_by">
                            <label for="new_received_by" class="control-label">
                                <span class="grey">Received by new person</span>
                            </label>
                            <input type="text" class="form-control " name="new_received_by" id="new_received_by" placeholder="Add New Person" value="">
                        </div>
                    </div>

                    <!-- Received Number -->
                    <div class="col-sm-2">
                        <div class="form-group" id="received_number">
                            <label for="received_number" class="control-label">
                                <span class="grey">Rec. #</span>
                            </label>
                            <input type="text" class="form-control " name="received_number" id="received_number" placeholder="Received Number" value="{{ $receivedNumber }}">
                        </div>
                    </div>

                    <!-- Hinario Selector -->
                    <div class="col-sm-3">
                        <div class="form-group">
                            <label for="hinario" class="control-label">
                                <span class="grey">Hinario</span>
                            </label>
                            <select class="form-control" name="hinario" id="hinario">
                                <option value="">Select an Hinario</option>
                                @foreach($hinarios as $hinario)
                                    <option value="{{ $hinario->id }}"
                                            @if ($hinario->id == $hinarioId) SELECTED @endif
                                    >{{ $hinario->getName() }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <!-- Hinario Section Number -->
                    <div class="col-sm-1">
                        <div class="form-group" id="section_number">
                            <label for="section_number" class="control-label">
                                <span class="grey">Sec. #</span>
                            </label>
                            <input type="text" class="form-control " name="section_number" id="section_number" placeholder="Section Number" value="{{ $sectionNumber }}">
                        </div>
                    </div>
                </div>
                <div class="row">
                    <!-- Offered To Selector -->
                    <div class="col-sm-3">
                        <div class="form-group">
                            <label for="offered_to" class="control-label">
                                <span class="grey">Offered to</span>
                            </label>
                            <select class="form-control" name="offered_to" id="offered_to">
                                <option value="">Select a person</option>
                                @foreach($persons as $person)
                                    <option value="{{ $person->id }}"
                                            @if ($person->id == $offeredTo) SELECTED @endif
                                    >{{ $person->display_name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <!-- New Person for Offered To -->
                    <div class="col-sm-4">
                        <div class="form-group" id="new_offered_to">
                            <label for="new_offered_to" class="control-label">
                                <span class="grey">New person for Offered to</span>
                            </label>
                            <input type="text" class="form-control " name="new_offered_to" id="new_offered_to" placeholder="Add New Person" value="">
                        </div>
                    </div>

                    <!-- Notations Selector -->
                    <div class="col-sm-3">
                        <div class="form-group">
                            <label for="notation_id" class="control-label">
                                <span class="grey">Notation</span>
                            </label>
                            <select class="form-control" name="notation_id" id="notation_id">
                                <option value="">None</option>
                                @foreach($notations as $notation)
                                    <option value="{{ $notation->hymn_notation_id }}"
                                            @if ($notation->hymn_notation_id == $notationId) SELECTED @endif
                                    >{{ $notation->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <!-- Pattern Selector -->
                    <div class="col-sm-2">
                        <div class="form-group" id="pattern_id">
                            <label for="pattern_id" class="control-label">
                                <span class="grey">Pattern</span>
                            </label>
                            <select class="form-control" name="pattern_id" id="pattern_id">
                                <option value="0">None</option>
                                @foreach($patterns as $pattern)
                                    <option value="{{ $pattern->pattern_id }}"
                                            @if ($pattern->pattern_id == $patternId) SELECTED @endif
                                    >{{ $pattern->pattern_id }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>
                <div class="row">

                    <!-- Received Date -->
                    <div class="col-sm-3">
                        <div class="form-group" id="received_date">
                            <label for="received_date" class="control-label">
                                <span class="grey">Received Date</span>
                            </label>
                            <input type="text" class="form-control " name="received_date" id="received_date" placeholder="Received on" value="{{ $receivedDate }}">
                        </div>
                    </div>

                    <!-- Received Location -->
                    <div class="col-sm-3">
                        <div class="form-group" id="received_location">
                            <label for="received_location" class="control-label">
                                <span class="grey">Received Location</span>
                            </label>
                            <input type="text" class="form-control " name="received_location" id="received_location" placeholder="Received at" value="{{ $receivedLocation }}">
                        </div>
                    </div>

                </div>
                <div class="row">

                    <!-- Original Language Selector -->
                    <div class="col-sm-3">
                        <div class="form-group" id="original_language_id">
                            <label for="original_language_id" class="control-label">
                                <span class="grey">Original Language</span>
                            </label>
                            <select class="form-control" name="original_language_id" id="original_language_id">
                                @foreach($languages as $language)
                                    <option value="{{ $language->language_id }}"
                                        @if ($language->language_id == $originalLanguageId) SELECTED @endif
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
                                <span class="grey">Secondary Language</span>
                            </label>
                            <select class="form-control" name="secondary_language_id" id="secondary_language_id">
                                <option value="0"></option>
                                @foreach($languages as $language)
                                    <option value="{{ $language->language_id }}"
                                            @if ($language->language_id == $secondaryLanguageId) SELECTED @endif
                                    >{{ $language->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <!-- Original Hymn Name -->
                    <div class="col-sm-5">
                        <div class="form-group" id="original_name">
                            <label for="original_name" class="control-label">
                                <span class="grey">Original Hymn Name</span>
                            </label>
                            <input type="text" class="form-control " name="original_name" id="original_name" placeholder="Hymn Name" value="{{ $originalName }}">
                        </div>
                    </div>

                    <!-- Spacer -->
                    <div class="col-sm-1"></div>

                    <!-- Secondary Hymn Name -->
                    <div class="col-sm-5">
                        <div class="form-group" id="secondary_name">
                            <label for="secondary_name" class="control-label">
                                <span class="grey">Secondary Hymn Name</span>
                            </label>
                            <input type="text" class="form-control " name="secondary_name" id="secondary_name" placeholder="Secondary Name" value="{{ $secondaryName }}">
                        </div>
                    </div>
                </div>
                <div class="row">
                    <!-- Original Language Lyrics -->
                    <div class="col-sm-5">
                        <div class="form-group" id="original_lyrics">
                            <label for="original_lyrics" class="control-label">
                                <span class="grey">Original Lyrics</span>
                            </label>
                            <textarea rows="20" cols="100" name="original_lyrics" id="original_lyrics" class="form-control" placeholder="Original Lyrics">{{ $originalLyrics }}</textarea>
                        </div>
                    </div>

                    <!-- Spacer -->
                    <div class="col-sm-1"></div>

                    <!-- Secondary Language Lyrics -->
                    <div class="col-sm-5">
                        <div class="form-group" id="secondary_lyrics">
                            <label for="secondary_lyrics" class="control-label">
                                <span class="grey">Secondary Lyrics</span>
                            </label>
                            <textarea rows="20" cols="100" name="secondary_lyrics" id="secondary_lyrics" class="form-control" placeholder="Secondary Lyrics">{{ $secondaryLyrics }}</textarea>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <input type="hidden" name="hymnId" value="{{ $hymnId }}">
                    <div class="contact-form-submit topmargin_10">
                        <button type="submit" id="save_hymn_submit" name="save_hymn_submit" class="theme_button color4 min_width_button margin_0">Save Hymn</button>
                    </div>
                </div>
            </form>
        </div>
        @if (count($feedback) > 0)
            <div class="row">
                <div class="col-sm-12 text-center" data-animation="scaleAppear">
                    <table>
                        <tr>
                            <th>Message</th>
                            <th>Date Submitted</th>
                            <th>Action</th>
                        </tr>
                        @foreach ($feedback as $feedback)
                            <tr>
                                <td>{{ $feedback->message }}</td>
                                <td>{{ date('Y-m-d H:i:s', strtotime($feedback->created_at)) }}</td>
                                <td>
                                    @if ($feedback->resolved != 0)
                                        Resolved
                                    @else
                                        <form action="{{ url('admin/enter-hymn?hymn_id=' . $hymnId) }}" method="POST">
                                            @csrf
                                            <input type="hidden" name="action" value="feedback">
                                            <input type="hidden" name="feedback_id" value="{{ $feedback->id }}">
                                            <input type="hidden" name="hymnId" value="{{ $hymnId }}">
                                            <button type="submit" name="submit_feedback" class="theme_button color4 min_width_button margin_0">Resolve</button>
                                        </form>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    </table>
                </div>
            </div>
        @endif
    </div>


@endsection
