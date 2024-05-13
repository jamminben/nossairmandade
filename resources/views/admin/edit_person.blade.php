@extends('admin.layouts.app')

@section('header_title')
    Edit Person
@endsection

@section('page_title')
    <h2 class="small display_table_cell_md">Edit Person</h2>
@endsection

@section('content')
    <div class="col-sm-1">
        <div class="row">
            <form action="{{ url('/admin/edit-person') }}" method="POST">
                @csrf
                <div class="form-group">
                    <label for="personId" class="control-label">
                        <span class="grey">Person:</span>
                    </label>
                    <select class="form-control" name="personId" id="person_selector">
                        <option value=""></option>
                        @foreach($persons as $person)
                            <option value="{{ $person->id }}">{{ $person->display_name }}</option>
                        @endforeach
                    </select>
                    <div class="contact-form-submit topmargin_10">
                        <input type="hidden" name="action" value="load">
                        <button type="submit" id="save_hymn_submit" name="save_hymn_submit" class="theme_button color4 margin_0">Load</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
    @if (!empty($personId) && $personId > 0)
        <div class="col-sm-1"></div>
        <form action="{{ url('/admin/edit-person') }}" method="POST" enctype="multipart/form-data" >
            <div class="col-sm-8">
                <div class="row">
                    <h4>Editing #{{ $personId }} - {{ $displayName }}</h4>
                    @csrf
                    <div class="row">
                        <!-- Name -->
                        <div class="col-sm-4">
                            <div class="form-group" id="names">
                                <label for="display_name" class="control-label">
                                    <span class="grey">Display Name</span>
                                </label>
                                <input type="text" class="form-control " name="display_name" id="display_name" placeholder="{{ $displayName }}" value="{{ $displayName }}">
                            </div>
                        </div>
                        <div class="col-sm-4">
                            <div class="form-group" id="names">
                                <label for="full_name" class="control-label">
                                    <span class="grey">Full Name</span>
                                </label>
                                <input type="text" class="form-control " name="full_name" id="full_name" placeholder="{{ $fullName }}" value="{{ $fullName }}">
                            </div>
                        </div>
                        <div class="col-sm-4">
                            <div class="form-group" id="names">
                                <label for="full_name" class="control-label">
                                    <span class="grey">Add Image</span>
                                </label>
                                <input type="file" class="form-control " name="new_image" id="new_image" placeholder="New Image" value="">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-6">English Description</div>
                        <div class="col-sm-6">Portuguese Description</div>
                    </div>
                    <div class="row">
                        <div class="col-sm-6">
                            <textarea rows="10" cols="100" name="english_description" id="english_description" class="form-control" placeholder="English Description">{{ $englishDescription }}</textarea>
                        </div>
                        <div class="col-sm-6">
                            <textarea rows="10" cols="100" name="portuguese_description" id="portuguese_description" class="form-control" placeholder="Portuguese Description">{{ $portugueseDescription }}</textarea>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-10 text-center">
                            <input type="hidden" name="personId" value="{{ $personId }}">
                            <div class="contact-form-submit topmargin_10">
                                <button type="submit" id="save_person_submit" name="save_person_submit" class="theme_button color4 min_width_button margin_0">Save Person</button>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
            <div class="col-sm-2">
                <div class="row">

                </div>
            </div>
        </form>
        <div class="col-sm-12">
            <div class="row">
                <div class="col-sm-12 text-center" data-animation="scaleAppear">
                    <table>
                        <tr>
                            <th>Image</th>
                            <th>Is Portrait?</th>
                            <th>Actions</th>
                        </tr>
                        @foreach ($personImages as $personImage)
                            <tr>
                                <td><img src="{{ url($personImage->image->getSlug()) }}" alt="{{ $fullName }}"></td>
                                <td>{{ $personImage->is_portrait }}</td>
                                <td>
                                    <form action="{{ url('admin/edit-person') }}" method="POST">
                                        @csrf
                                        <input type="hidden" name="action" value="delete_image">
                                        <input type="hidden" name="image_id" value="{{ $personImage->image->id }}">
                                        <input type="hidden" name="personId" value="{{ $personId }}">
                                        <button type="submit" name="submit_image_delete" class="theme_button color4 min_width_button margin_0">Delete</button>
                                    </form>
                                    <form action="{{ url('admin/edit-person') }}" method="POST">
                                        @csrf
                                        <input type="hidden" name="action" value="set_portrait">
                                        <input type="hidden" name="image_id" value="{{ $personImage->image->id }}">
                                        <input type="hidden" name="personId" value="{{ $personId }}">
                                        <button type="submit" name="submit_set_portrait" class="theme_button color4 min_width_button margin_0">Set as Portrait</button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </table>
                </div>
            </div>
        </div>
    @endif


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


@endsection
