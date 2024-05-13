@extends('admin.layouts.app')

@section('header_title')
    Choose Hymn
@endsection

@section('page_title')
    <h2 class="small display_table_cell_md">Choose Hymn to Edit</h2>
@endsection

@section('content')
    <div class="col-sm-12 text-center" data-animation="scaleAppear">
        <form method="POST" action="{{ url('admin/edit-hymn') }}">
            @csrf
            <div class="row">
                <div class="col-sm-6 col-sm-offset-3">
                    <div class="form-group" id="hymnId">
                        <label for="hymnId" class="control-label">
                            <span class="grey">Load Hymn</span>
                        </label>
                        <input type="text" class="form-control " name="hymnId" id="hymnId" placeholder="Hymn ID" value="">
                    </div>
                </div>
            </div>
            <div class="row">
                <input type="hidden" name="action" value="load">
                <div class="contact-form-submit topmargin_10">
                    <button type="submit" id="load_hymn_submit" name="load_hymn_submit" class="theme_button color4 min_width_button margin_0">Load Hymn</button>
                </div>
            </div>
        </form>
    </div>

@endsection
