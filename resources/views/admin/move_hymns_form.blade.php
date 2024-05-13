@extends('admin.layouts.app')

@section('header_title')
    Move Hymns
@endsection

@section('page_title')
    <h2 class="small display_table_cell_md">Move Hymn Files</h2>
@endsection

@section('content')
    <div class="col-sm-12 text-center" data-animation="scaleAppear">
        <form method="POST" action="{{ url('admin/move-hymn-files') }}">
            @csrf
            <div class="row">
                <input type="text" name="person_id" value="" placeholder="Person ID">
                <input type="hidden" name="action" value="load">
                <div class="contact-form-submit topmargin_10">
                    <button type="submit" id="move_hymn" name="move_hymn" class="theme_button color4 min_width_button margin_0">Start</button>
                </div>
            </div>
        </form>
    </div>

@endsection
