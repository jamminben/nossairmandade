@extends('admin.layouts.app')

@section('header_title')
    Users
@endsection

@section('page_title')
    <h2 class="small display_table_cell_md">Edit Permissions</h2>
@endsection
@section('css')
<link rel="stylesheet" href="{{ asset('css/datatables.min.css') }}">
<link rel="stylesheet" href="{{ asset('css/dataTables.jqueryui.min.css') }}">
<style>
   .flex-container {
        display: flex;
        flex-wrap: wrap;
    }
    .column {
        flex-basis: 50% !important;
        flex: 1;
        padding: 10px;
        border : outset 2px;
    }
    fieldset {
        border: 1px solid #ccc;
        padding: 10px;
    }
    legend {
        font-weight: bold;
    }
    .checkboxes {
        display: flex;
    }
    .checkboxes label {
        margin-right: 10px;
    }
</style>
@endsection
@section('content')
@php
    use App\Constants\Constants;
@endphp
<!-- <div class="container">
    <form action="{{route('permission.assignPermissions')}}" method="post">
        @csrf
        <div class="row">
            <div class="container mt-5">
                <div class="card">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="user">Username</label>
                                    <p id="user">{{$user->name}}</p>
                                    <input type="hidden" name="userId" value="{{$user->id}}">
                                </div>
                                <div class="form-group">
                                    <label for="email">Email Address</label>
                                    <p id="email">{{$user->email}}</p>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="text-right">
                                    <button type="submit" class="btn btn-primary mr-2">Save</button>
                                    <a href="cancel_page.html" class="btn btn-warning">Cancel</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col">
                <div class="flex-container">
                    @foreach($permissions as $group => $permissionData)
                    <div class="column">
                        <fieldset>
                            <legend>{{$group}}</legend>
                            <div class="checkboxes">
                                @foreach($permissionData as $permission)
                                <?php
                                    $string = $permission->name;
                                    $parts = explode('_', $string);
                                    $output = $parts[0];
                                ?>
                                <label><input type="checkbox" name="permissions[]" value="{{$permission->name}}" {{ $user->hasPermissionTo($permission->name) ? 'checked' : '' }}> {{$output}}</label>
                                @endforeach
                            </div>
                        </fieldset>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
    </form>
</div> -->
<div class="container">
    <div class="row">
        <div class="col">
            <div class="container mt-5">
                <div class="card">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="user" class="d-inline-block"><b>Username : </b></label>
                                    <p id="user" class="d-inline-block" style="display:inline">{{$user->name}}</p>
                                    <!-- <input type="hidden" name="userId" value="{{$user->id}}"> -->
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="email" class="d-inline-block"><b>Email Address:</b></label>
                                    <p id="email" class="d-inline-block" style="display:inline">{{$user->email}}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div clas="row">
        <div class="col">
            <table class="table" id="hinario-permissions">
                <thead>
                    <tr>
                        <th width="75%">Hinario</th>
                        <th width="25%">Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($permissions as $group => $permissionData)
                    <tr>
                        <td>{{$group}}</td>
                        <td>
                            <form action="{{route('permission.assignPermissions')}}" method="post">
                                <input type="hidden" name="userId" value="{{$user->id}}">
                                @csrf
                                <div class="checkboxes">
                                    @foreach($permissionData as $permission)
                                    <?php
                                        $string = $permission->name;
                                        $parts = explode('_', $string);
                                        $output = $parts[0];
                                    ?>
                                    <input type="hidden" name="permissions[{{$permission->name}}]" value="{{ Constants::HINARIO_CHECKBOX_INACTIVE_STATE }}">
                                    <label><input type="checkbox" name="permissions[{{$permission->name}}]" value="{{ Constants::HINARIO_CHECKBOX_ACTIVE_STATE }}" {{ $user->hasPermissionTo($permission->name) ? 'checked' : '' }} > {{$output}}</label>
                                    @endforeach
                                    <button type="submit" class="btn btn-primary btn-sm mr-2">Update</button>
                                </div>
                            </form>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>

@endsection
@section('js')
<script src="{{ asset('js/datatables.min.js') }}"></script>
<script src="{{ asset('js/dataTables.jqueryui.min.js') }}"></script>
<script>
    new DataTable('#hinario-permissions');
</script>

@endsection
