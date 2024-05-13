@extends('admin.layouts.app')

@section('header_title')
    User Management - Roles
@endsection

@section('page_title')
    <h2 class="small display_table_cell_md">Permission</h2>
@endsection
@section('css')
<link rel="stylesheet" href="{{ asset('css/datatables.min.css') }}">
<link rel="stylesheet" href="{{ asset('css/dataTables.jqueryui.min.css') }}">
@endsection
@section('content')
<div class="container">
    <div class="text-right mb-3">
        <!-- Button trigger modal -->
        <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#addPermissionModel">
            Add Permission
        </button>
    </div>
    <table class="table" id="roles-table">
        <thead>
            <tr>
                <th width="30%">Name</th>
                <th width="30%">Page Name</th>
                <th width="30%">Group</th>
                <th width="30%">created at</th>
                <th width="10%">Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($permissions as $permission)
            <tr>
                <td>{{ $permission->name }}</td>
                <td>{{ $permission->pages }}</td>
                <td>{{ $permission->group }}</td>
                <td>{{ $permission->created_at }}</td>
                <td>
                    <button class="btn btn-info btn-sm btn-edit" data-id="{{ $permission->id }}" data-page="{{$permission->pages}}" data-name="{{ $permission->name }}" data-toggle="modal" data-target="#editPermissionModel">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-pencil" viewBox="0 0 16 16">
                            <path d="M12.146.146a.5.5 0 0 1 .708 0l3 3a.5.5 0 0 1 0 .708l-10 10a.5.5 0 0 1-.168.11l-5 2a.5.5 0 0 1-.65-.65l2-5a.5.5 0 0 1 .11-.168zM11.207 2.5 13.5 4.793 14.793 3.5 12.5 1.207zm1.586 3L10.5 3.207 4 9.707V10h.5a.5.5 0 0 1 .5.5v.5h.5a.5.5 0 0 1 .5.5v.5h.293zm-9.761 5.175-.106.106-1.528 3.821 3.821-1.528.106-.106A.5.5 0 0 1 5 12.5V12h-.5a.5.5 0 0 1-.5-.5V11h-.5a.5.5 0 0 1-.468-.325"/>
                        </svg>
                    </button>
                    <button class="btn btn-danger btn-sm btn-delete" data-id="{{ $permission->id }}" data-toggle="modal" data-target="#deletePermissionModel">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-trash3" viewBox="0 0 16 16">
                            <path d="M6.5 1h3a.5.5 0 0 1 .5.5v1H6v-1a.5.5 0 0 1 .5-.5M11 2.5v-1A1.5 1.5 0 0 0 9.5 0h-3A1.5 1.5 0 0 0 5 1.5v1H1.5a.5.5 0 0 0 0 1h.538l.853 10.66A2 2 0 0 0 4.885 16h6.23a2 2 0 0 0 1.994-1.84l.853-10.66h.538a.5.5 0 0 0 0-1zm1.958 1-.846 10.58a1 1 0 0 1-.997.92h-6.23a1 1 0 0 1-.997-.92L3.042 3.5zm-7.487 1a.5.5 0 0 1 .528.47l.5 8.5a.5.5 0 0 1-.998.06L5 5.03a.5.5 0 0 1 .47-.53Zm5.058 0a.5.5 0 0 1 .47.53l-.5 8.5a.5.5 0 1 1-.998-.06l.5-8.5a.5.5 0 0 1 .528-.47M8 4.5a.5.5 0 0 1 .5.5v8.5a.5.5 0 0 1-1 0V5a.5.5 0 0 1 .5-.5"/>
                        </svg>
                    </button>
                </td>                
            </tr>
            @endforeach
        </tbody>
    </table>
</div>

<!-- Add Permision Modal -->
<div class="modal fade" id="addPermissionModel" tabindex="-1" role="dialog" aria-labelledby="addPermissionModelLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="addPermissionModelLabel">Add New Permission</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form action="{{route('permissions.store')}}" method="post">
        @csrf
        <div class="modal-body">
            <div class="form-group">
                <label for="PermissionInput">Permission Name</label>
                <input type="text" class="form-control" name="name" id="PermissionInput" aria-describedby="permissionHelp" placeholder="Enter Permission Name">
                <small id="permissionHelp" class="form-text text-muted">Enter new Permission name</small>
            </div>
            <div class="form-group">
                <label for="page">Select or Enter Page:</label>
                <input type="text" id="page" name="page" class="form-control" list="pageOptions" placeholder="Type or select a page">
                <datalist id="pageOptions" class="dropdown-menu">
                    @foreach($pages as $page)
                        <option value="{{ $page }}">{{ $page }}</option>
                    @endforeach
                </datalist>
            </div>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            <button type="submit" class="btn btn-primary">Add Permission</button>
        </div>
    </form>
    </div>
  </div>
</div>

<!-- edit Permission Modal -->
<div class="modal fade" id="editPermissionModel" tabindex="-1" role="dialog" aria-labelledby="editPermissionModelLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="editPermissionModelLabel">Edit Permission</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form action="{{route('permissions.update')}}" method="post">
        @csrf
        <div class="modal-body">
            <input type="hidden"  name="id" id="editPermissionId">
            <input type="hidden" name="page" id="editPageName">
            <div class="form-group">
                <label for="editPermissionInput">Permission Name</label>
                <input type="text" class="form-control" name="name" id="editPermissionInput" aria-describedby="editpermissionHelp" placeholder="Edit Permission Name">
                <small id="editpermissionHelp" class="form-text text-muted">Enter Permission name to update</small>
            </div>
            <div class="form-group">
                <label for="editPage">Select or Enter Page:</label>
                <input type="text" id="editPage" name="page" class="form-control" list="pageOptions" placeholder="Type or select a page">
                <datalist id="pageOptions" class="dropdown-menu">
                    @foreach($pages as $page)
                        <option value="{{ $page }}">{{ $page }}</option>
                    @endforeach
                </datalist>
            </div>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            <button type="submit" class="btn btn-primary">Update</button>
        </div>
    </form>
    </div>
  </div>
</div>

<!-- delete Permission Modal -->
<div class="modal fade" id="deletePermissionModel" tabindex="-1" role="dialog" aria-labelledby="deletePermissionModelLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="deletePermissionModelLabel">Delete Permission</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form action="{{route('permission.delete')}}" method="post">
        @csrf
        <div class="modal-body">
            <input type="hidden" name="id" id="deletePermissionId">
            <div class="form-group">
                <strong>Are you sure you want to delete this permission? This action cannot be undone</strong>
            </div>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            <button type="submit" class="btn btn-primary">Delete</button>
        </div>
    </form>
    </div>
  </div>
</div>
@endsection
@section('js')
<script src="{{ asset('js/datatables.min.js') }}"></script>
<script src="{{ asset('js/dataTables.jqueryui.min.js') }}"></script>
<script>
    new DataTable('#roles-table');
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

<script>
    $(document).ready(function () {
        $('.btn-edit').click(function () {
            var permissionId = $(this).data('id');
            var permissionName = $(this).data('name');
            var permissionPage = $(this).data('page');
            $('#editPage').val(permissionPage);
            $('#editPermissionId').val(permissionId);
            $('#editPermissionInput').val(permissionName);
        });
        $('.btn-delete').click(function () {
            var permissionId = $(this).data('id');
            $('#deletePermissionId').val(permissionId);
        });
    });
</script>

@endsection