@extends('admin.layouts.app')

@section('header_title')
    Edit Musician Files
@endsection

@section('page_title')
    <h2 class="small display_table_cell_md">Edit Musician Files</h2>
@endsection

@section('content')
    <div class="col-sm-12">
        <div class="row">
            <form class="add_file" action="{{ url('/admin/edit-musician-files') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="form-group-sm">
                    <div class="form-group">
                        <label for="new_media" class="sr-only">Add Media</label>
                        <input type="file" class="form-control " name="new_file" id="new_file" placeholder="Choose File" value="">
                    </div>
                </div>
                <div class="form-group-sm">
                    <div class="feedback-form-button">
                        <input type="hidden" name="action" value="save">
                        <button type="submit" class="theme_button color4 margin_0">Add File</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
<div class="col-sm-12">
    <div class="row">
        <div class="col-sm-12 text-center" data-animation="scaleAppear">
            <table>
                <tr>
                    <th>Filename</th>
                    <th>Actions</th>
                </tr>
                @foreach ($files as $file)
                    <tr>
                        <td>{{ $file->mediaFile->filename }}</td>
                        <td>
                            <form action="{{ url('admin/edit-musician-files') }}" method="POST">
                                @csrf
                                <input type="hidden" name="action" value="delete">
                                <input type="hidden" name="file_id" value="{{ $file->id }}">
                                <button type="submit" name="submit_image_delete" class="theme_button color4 min_width_button margin_0">Delete</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </table>
        </div>
    </div>
</div>

@endsection
