@extends('admin.layouts.app')

@section('header_title')
    User Management - Roles
@endsection

@section('page_title')
    <h2 class="small display_table_cell_md">Roles</h2>
@endsection
@section('css')
<link rel="stylesheet" href="{{ asset('css/datatables.min.css') }}">
<link rel="stylesheet" href="{{ asset('css/dataTables.jqueryui.min.css') }}">
@endsection
@section('content')
<div class="container">
    <div class="text-right mb-3">
        <!-- Button trigger modal -->
        <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#addRoleModel">
            Add Role
        </button>
    </div>
    <table class="table" id="roles-table">
        <thead>
            <tr>
                <th width="40%">Name</th>
                <th width="40%">created at</th>
                <th width="10%">Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($roles as $role)
            <tr>
                <td>{{ $role->name }}</td>
                <td>{{ $role->created_at }}</td>
                <td>
                    <button class="btn btn-info btn-sm btn-edit" data-id="{{ $role->id }}" data-name="{{ $role->name }}" data-toggle="modal" data-target="#editRoleModel">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-pencil" viewBox="0 0 16 16">
                            <path d="M12.146.146a.5.5 0 0 1 .708 0l3 3a.5.5 0 0 1 0 .708l-10 10a.5.5 0 0 1-.168.11l-5 2a.5.5 0 0 1-.65-.65l2-5a.5.5 0 0 1 .11-.168zM11.207 2.5 13.5 4.793 14.793 3.5 12.5 1.207zm1.586 3L10.5 3.207 4 9.707V10h.5a.5.5 0 0 1 .5.5v.5h.5a.5.5 0 0 1 .5.5v.5h.293zm-9.761 5.175-.106.106-1.528 3.821 3.821-1.528.106-.106A.5.5 0 0 1 5 12.5V12h-.5a.5.5 0 0 1-.5-.5V11h-.5a.5.5 0 0 1-.468-.325"/>
                        </svg>
                    </button>
                    <button class="btn btn-danger btn-sm btn-delete" data-id="{{ $role->id }}" data-toggle="modal" data-target="#deleteRoleModel">
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

<!-- Add Role Modal -->
<div class="modal fade" id="addRoleModel" tabindex="-1" role="dialog" aria-labelledby="addRoleModelLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="addRoleModelLabel">Add New Role</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form action="{{route('roles.store')}}" method="post">
        @csrf
        <div class="modal-body">
            <div class="form-group">
                <label for="RoleInput">Role Name</label>
                <input type="text" class="form-control" name="name" id="RoleInput" aria-describedby="roleHelp" placeholder="Enter Role Name">
                <small id="roleHelp" class="form-text text-muted">Enter new Role name</small>
            </div>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            <button type="submit" class="btn btn-primary">Add Role</button>
        </div>
    </form>
    </div>
  </div>
</div>

<!-- edit Role Modal -->
<div class="modal fade" id="editRoleModel" tabindex="-1" role="dialog" aria-labelledby="editRoleModelLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="editRoleModelLabel">Edit Role</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form action="{{route('roles.update')}}" method="post">
        @csrf
        <div class="modal-body">
            <input type="hidden"  name="id" id="editRoleId">
            <div class="form-group">
                <label for="editRoleInput">Role Name</label>
                <input type="text" class="form-control" name="name" id="editRoleInput" aria-describedby="editRoleHelp" placeholder="Edit Role Name">
                <small id="editRoleHelp" class="form-text text-muted">Enter role name to update</small>
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

<!-- delete Role Modal -->
<div class="modal fade" id="deleteRoleModel" tabindex="-1" role="dialog" aria-labelledby="deleteRoleModelLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="deleteRoleModelLabel">Delete Role</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form action="{{route('role.delete')}}" method="post">
        @csrf
        <div class="modal-body">
            <input type="hidden" name="id" id="deleteRoleId">
            <div class="form-group">
                <strong>Are you sure you want to delete this role? This action cannot be undone</strong>
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
            var roleId = $(this).data('id');
            var roleName = $(this).data('name');
            $('#editRoleId').val(roleId);
            $('#editRoleInput').val(roleName);
        });
        $('.btn-delete').click(function () {
            var roleId = $(this).data('id');
            $('#deleteRoleId').val(roleId);
        });
    });
</script>

@endsection