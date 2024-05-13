@extends('admin.layouts.app')

@section('header_title')
    Generate Hinario Zips
@endsection

@section('page_title')
    <h2 class="small display_table_cell_md">Generate Hinario Zips</h2>
@endsection

@section('content')
    <form method="POST" action="{{ url('admin/generate-hinario-zip-files') }}">
        <div class="col-sm-3 text-center" data-animation="scaleAppear">
            @csrf
            <div class="row">
                <div class="contact-form-submit topmargin_10">
                    <button type="submit" id="move_hymn" name="move_hymn" class="theme_button color4 min_width_button margin_0">Start</button>
                </div>
            </div>
            <div class="row">
                @foreach ($done as $doneHinario)
                    {{ $doneHinario->id }}. {{ $doneHinario->getName() }}<br>
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
                    @foreach ($hinarios as $hinario)
                        <tr>
                            <td>{{ $hinario->id }}. {{ $hinario->getName() }}</td>
                            <td><input type="checkbox" name="hinarios[]" value="{{ $hinario->id }}"></td>
                        </tr>
                    @endforeach
                </table>
            </div>
        </div>
    </form>

@endsection
