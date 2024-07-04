@extends('layouts.app')

@section('header_title')
    {{ __('person.edit.page_title') }}
@endsection

@section('page_title')
    <h2 class="small display_table_cell_md">{{ __('person.edit.page_title') }}</h2>
@endsection

@section('controls')
    <div class="col-4 text-right" title="Edit Person" id="editSection">
        <div class="col-4 text-right" title="Edit Person" id="editSection">
            <button id="saveButton" class="btn btn-success btn-sm">
                <div style="display: inline-block"><h4><i class="fas fa-floppy-o"></i></h4></div>
                <div style="display: inline-block; width: 50px;"><span>{{ __('person.edit.save_button') }}</span></div>
            </button>
            <button id="cancelButton" class="btn btn-danger btn-sm">
                <div style="display: inline-block"><h4><i class="fas fa-ban"></i></h4></div>
                <div style="display: inline-block; width: 50px;"><span>{{ __('person.edit.cancel_button') }}</span></div>
            </button>
        </div>
    </div>
@endsection

@section('content')
    <form id="personForm" action="{{ url('/edit-person/' . $person->id) }}" method="post" enctype="multipart/form-data">
        @csrf
        <input type="hidden" name="personId" value="{{ $person->id }}">

    <div class="col-sm-10 col-md-10 col-lg-10">
        <div class="container">
            <div class="row">
                <!-- Person Display Name -->
                <div class="col-sm-3">
                    <div class="form-group" id="display_name">
                        <label for="display_name" class="control-label">
                            <span class="grey">{{ __('person.edit.display_name_label') }}</span>
                        </label>
                        <input type="text" class="form-control " name="display_name" id="display_name" placeholder="{{ __('person.edit.display_name_label') }}" value="{{ $person->display_name }}">
                    </div>
                </div>


                <!-- Person Full Name -->
                <div class="col-sm-3">
                    <div class="form-group" id="full_name">
                        <label for="full_name" class="control-label">
                            <span class="grey">{{ __('person.edit.full_name_label') }}</span>
                        </label>
                        <input type="text" class="form-control " name="full_name" id="fullname" placeholder="{{ __('person.edit.full_name_label') }}" value="{{ $person->full_name }}">
                    </div>
                </div>

                <!-- image upload -->
                <div class="col-sm-3">
                    <div class="form-group" id="names">
                        <label for="new_image" class="control-label">
                            <span class="grey">Add Image</span>
                        </label>
                        <input type="file" class="form-control " name="new_image" id="new_image" accept="image/*" placeholder="New Image" value="">
                    </div>
                </div>
            </div>

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
                                        @if ($language->language_id == $person->getPrimaryTranslation()->language_id) SELECTED @endif
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
                                        @if (count($person->getSecondaryTranslations()) > 0 &&
                                            $language->language_id == $person->getSecondaryTranslations()[0]->language_id) SELECTED @endif
                                >{{ $language->name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
            </div>

            <!-- description -->
            <div class="row">
                <!-- Original Language Desc -->
                <div class="col-sm-5">
                    <div class="form-group" id="original_lyrics">
                        <label for="original_description" class="control-label">
                            <span class="grey">{{ __('person.edit.original_description') }}</span>
                        </label>
                        <textarea rows="20" cols="100" name="original_description" id="original_description" class="form-control" placeholder="{{ __('person.edit.original_description') }}">{{ $person->getPrimaryTranslation()->description }}</textarea>
                    </div>
                </div>

                <!-- Spacer -->
                <div class="col-sm-1"></div>

                <!-- Secondary Language Description -->
                <div class="col-sm-5">
                    <div class="form-group" id="secondary_description">
                        <label for="secondary_description" class="control-label">
                            <span class="grey">{{ __('person.edit.secondary_description') }}</span>
                        </label>
                        <textarea rows="20" cols="100" name="secondary_description" id="secondary_description" class="form-control" placeholder="{{ __('person.edit.secondary_description') }}">
                            @if (count($person->getSecondaryTranslations()) > 0)
                                {{ $person->getSecondaryTranslations()[0]->description }}
                            @endif
                        </textarea>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-sm-12 text-center" data-animation="scaleAppear">
                    <table>
                        <tr>
                            <th>Image</th>
                            <th>Captions</th>
                            <th>Set Portrait</th>
                            <th>Check to Delete</th>
                        </tr>
                        @foreach ($person->personImages as $personImage)
                            @if (!empty($personImage) && !empty($personImage->image))
                            <tr>
                                <td><img src="{{ url($personImage->image->getSlug()) }}"></td>
                                <td>
                                    <label for="image_caption_{{ $personImage->id }}" class="control-label">
                                        <span class="grey">{{ __('person.edit.image_caption') }}</span>
                                    </label><br>
                                    <input type="text" name="image_caption_{{ $personImage->image->id }}" value="@if (!empty($personImage->image->getPrimaryTranslation())) {{ $personImage->image->getPrimaryTranslation()->caption }} @endif">
                                <br>
                                    <label for="secondary_image_caption_{{ $personImage->id }}" class="control-label">
                                        <span class="grey">{{ __('person.edit.secondary_image_caption') }}</span>
                                    </label><br>
                                    <input type="text" name="secondary_image_caption_{{ $personImage->image->id }}" value="@if (!empty($personImage->image->getSecondaryTranslations()[0])) {{ $personImage->image->getSecondaryTranslations()[0]->caption }} @endif">
                                </td>
                                <td>
                                    <label>
                                        <input type="radio" name="portrait" value="{{ $personImage->image->id }}" @if ($personImage->is_portrait == 1) checked @endif required>
                                        Set as portrait
                                    </label>
                                </td>
                                <td>
                                    <label>
                                        <input type="checkbox" name="delete_image_{{ $personImage->image->id }}" value="{{ $personImage->image->id }}">
                                        Delete image
                                    </label>
                                </td>
                            </tr>
                            @endif
                        @endforeach
                    </table>
                </div>
            </div>
        </div>
    </div>

    </form>
@endsection

@section('js')
    <script>
        $(document).ready(function() {
            $('#cancelButton').click(function() {
                window.location.href = '{{ url('person/' . $person->id . '/' . $person->display_name) }}';
            });

            $('#saveButton').click(function() {
                $('#personForm').submit();
            });
        });
    </script>
@endsection
