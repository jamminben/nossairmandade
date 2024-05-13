@extends('admin.layouts.app')

@section('header_title')
    Move Hymns
@endsection

@section('page_title')
    <h2 class="small display_table_cell_md">Move Hymn Files</h2>
@endsection

@section('content')
    <form method="POST" action="{{ url('admin/import-people-audio-files') }}">
    <div class="col-sm-3 text-center" data-animation="scaleAppear">
        @csrf
        <div class="row">
            <div class="contact-form-submit topmargin_10">
                <button type="submit" id="move_hymn" name="move_hymn" class="theme_button color4 min_width_button margin_0">Start</button>
            </div>
        </div>
        <div class="row">
            @foreach ($done as $donePerson)
                {{ $donePerson->id }}. {{ $donePerson->display_name }}<br>
            @endforeach
        </div>
    </div>
    <div class="col-sm-8">
        <div class="row">
            <table>
                <tr>
                    <th>Name</th>
                    <th>Import?</th>
                </tr>
                @foreach ($people as $person)
                    <tr>
                        <td>{{ $person->id }}. {{ $person->display_name }}</td>
                        <td><input type="checkbox" name="imports[]" value="{{ $person->id }}"></td>
                    </tr>
                @endforeach
            </table>
        </div>
    </div>
    </form>

@endsection
