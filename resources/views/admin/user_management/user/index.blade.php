@extends('admin.layouts.app')

@section('header_title')
    Users
@endsection

@section('page_title')
    <h2 class="small display_table_cell_md">Users</h2>
@endsection
@section('css')
<link rel="stylesheet" href="{{ asset('css/datatables.min.css') }}">
<link rel="stylesheet" href="{{ asset('css/dataTables.jqueryui.min.css') }}">
@endsection
@section('content')
<div class="container">
    <table class="table" id="users-table">
        <thead>
            <tr>
                <th>Name</th>
                <th>Email</th>
                <th>created at</th>
                <th width="10%">Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($users as $user)
            <tr>
                <td>{{ $user->name }}</td>
                <td>{{ $user->email }}</td>
                <td>{{ $user->created_at }}</td>
                <td>
                    <form action="{{route('permission.assignHinarioPermissionsToUser')}}" method="post">
                        @csrf
                        <input type="hidden" value="{{$user->id}}" name="userId">
                        <button type="submit" class="btn btn-primary btn-sm">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-shield-lock-fill" viewBox="0 0 16 16">
                                <path fill-rule="evenodd" d="M8 0c-.69 0-1.843.265-2.928.56-1.11.3-2.229.655-2.887.87a1.54 1.54 0 0 0-1.044 1.262c-.596 4.477.787 7.795 2.465 9.99a11.8 11.8 0 0 0 2.517 2.453c.386.273.744.482 1.048.625.28.132.581.24.829.24s.548-.108.829-.24a7 7 0 0 0 1.048-.625 11.8 11.8 0 0 0 2.517-2.453c1.678-2.195 3.061-5.513 2.465-9.99a1.54 1.54 0 0 0-1.044-1.263 63 63 0 0 0-2.887-.87C9.843.266 8.69 0 8 0m0 5a1.5 1.5 0 0 1 .5 2.915l.385 1.99a.5.5 0 0 1-.491.595h-.788a.5.5 0 0 1-.49-.595l.384-1.99A1.5 1.5 0 0 1 8 5"/>
                            </svg>
                            Hinario
                        </button>
                    </form>
                    <form action="{{route('permission.assignPersonPermissionsToUser')}}" method="post">
                        @csrf
                        <input type="hidden" value="{{$user->id}}" name="userId">
                        <button type="submit" class="btn btn-primary btn-sm">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-shield-lock-fill" viewBox="0 0 16 16">
                                <path fill-rule="evenodd" d="M8 0c-.69 0-1.843.265-2.928.56-1.11.3-2.229.655-2.887.87a1.54 1.54 0 0 0-1.044 1.262c-.596 4.477.787 7.795 2.465 9.99a11.8 11.8 0 0 0 2.517 2.453c.386.273.744.482 1.048.625.28.132.581.24.829.24s.548-.108.829-.24a7 7 0 0 0 1.048-.625 11.8 11.8 0 0 0 2.517-2.453c1.678-2.195 3.061-5.513 2.465-9.99a1.54 1.54 0 0 0-1.044-1.263 63 63 0 0 0-2.887-.87C9.843.266 8.69 0 8 0m0 5a1.5 1.5 0 0 1 .5 2.915l.385 1.99a.5.5 0 0 1-.491.595h-.788a.5.5 0 0 1-.49-.595l.384-1.99A1.5 1.5 0 0 1 8 5"/>
                            </svg>
                            Person
                        </button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
@section('js')
<script src="{{ asset('js/datatables.min.js') }}"></script>

<script src="{{ asset('js/dataTables.jqueryui.min.js') }}"></script>
<script>
    new DataTable('#users-table');
</script>
@if(session('success'))
    <script>
        $.notify("{{ session('success') }}", "success");
    </script>
@endif
@if ($errors->any())
    @foreach ($errors->all() as $error)
        <script>
            $.notify("{{ $error }}", "error");
        </script>
    @endforeach
@endif
@endsection
