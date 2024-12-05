@php
    $mode = isset($role->id) ? 'Edit' : 'Add';
    $breadcrumb = '<h4 class="py-3 mb-4">
        <a href="'.route('role-permission.list').'"><span class="text-muted fw-light">Roles & Permission</span></a><span class="text-muted fw-light">/</span>'.$mode.'
        </h4>';
        $route = route('role-permission.save');
        // if(isset($role->id)){
        //     $route = route('role-permission.update');
        // }else{
        // }
@endphp
@extends('layouts/contentNavbarLayout')

@section('title', ' Role & Permission - ' . $mode)
@section('breadcrumb')
    {!! $breadcrumb !!}
@endsection
@section('content')
    @if (count($errors) > 0)
    <div class="alert alert-danger">
      <strong>Whoops!</strong> There were some problems with your input.
    </div>
  @endif
    <!-- Basic Layout -->
    <div class="row">
        <div class="col-xl">
            <div class="card mb-4">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">Role & Permission</h5> <small class="text-muted float-end">Role & Permission</small>
                </div>
                <div class="card-body">
                <form id="addRoleForm" class="row g-3" method="post" action="{{ $route }}">
                    @csrf
                    <input type="hidden" name="id" value="@if(isset($role->id)){{ $role->id }}@endif">
                    <div class="col-12 mb-4">
                        <label class="form-label" for="role">Role Name</label>
                        <input type="text" id="role" name="role" class="form-control"
                            placeholder="Enter a role name" tabindex="-1" value="@if(isset($role->name)){{ $role->name }}@endif" />
                            @error('role')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                    </div>
                    <div class="col-12">
                        <h4>Role Permissions</h4>
                        <!-- Permission table -->
                        <div class="table-responsive">
                            <table class="table table-flush-spacing">
                                <caption>Permissions</caption>
                                <tbody>
                                    <tr>
                                        <td class="text-nowrap fw-medium">Administrator Access <i
                                                class="bx bx-info-circle bx-xs" data-bs-toggle="tooltip"
                                                data-bs-placement="top" title="Allows a full access to the system"></i>
                                        </td>
                                        <td>
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" id="selectAll" />
                                                <label class="form-check-label" for="selectAll">
                                                    Select All
                                                </label>
                                            </div>
                                        </td>
                                    </tr>
                                    
                                    <tr>
                                        <td class="text-nowrap fw-medium">User Management</td>
                                        <td>
                                            <div class="d-flex">
                                                <div class="form-check me-3 me-lg-5">
                                                    <input class="form-check-input" type="checkbox"
                                                        id="userManagementRead" name="user_managemant[]"
                                                        value="user_management-list" @if(!empty($permissionsArray) && isset($permissionsArray) && in_array('user_management-list',$permissionsArray['name']))checked @endif/>
                                                    <label class="form-check-label" for="userManagementRead">
                                                        List
                                                    </label>
                                                </div>
                                                <div class="form-check me-3 me-lg-5">
                                                    <input class="form-check-input" type="checkbox"
                                                        id="userManagementWrite" name="user_managemant[]"
                                                        value="user_management-create" @if(!empty($permissionsArray) && isset($permissionsArray) && in_array('user_management-create',$permissionsArray['name']))checked @endif/>
                                                    <label class="form-check-label" for="userManagementWrite">
                                                        Create
                                                    </label>
                                                </div>
                                                <div class="form-check me-3 me-lg-5">
                                                    <input class="form-check-input" type="checkbox"
                                                        id="userManagementCreate" name="user_managemant[]"
                                                        value="user_management-edit" @if(!empty($permissionsArray) && isset($permissionsArray) && in_array('user_management-edit',$permissionsArray['name']))checked @endif/>
                                                    <label class="form-check-label" for="userManagementCreate">
                                                        Edit
                                                    </label>
                                                </div>
                                                <div class="form-check">
                                                    <input class="form-check-input" type="checkbox"
                                                        id="userManagementDelete" name="user_managemant[]"
                                                        value="user_management-delete" @if(!empty($permissionsArray) && isset($permissionsArray) && in_array('user_management-delete',$permissionsArray['name']))checked @endif/>
                                                    <label class="form-check-label" for="userManagementDelete">
                                                        Delete
                                                    </label>
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                    
                                    
                                    
                                    
                                    <tr>
                                        <td class="text-nowrap fw-medium">Role & Permission</td>
                                        <td>
                                            <div class="d-flex">
                                                <div class="form-check me-3 me-lg-5">
                                                    <input class="form-check-input" type="checkbox"
                                                        id="rolePermissionRead" name="role_permission[]"
                                                        value="role_permission-list" @if(!empty($permissionsArray) && isset($permissionsArray) && in_array('role_permission-list',$permissionsArray['name']))checked @endif/>
                                                    <label class="form-check-label" for="rolePermissionRead">
                                                        List
                                                    </label>
                                                </div>
                                                <div class="form-check me-3 me-lg-5">
                                                    <input class="form-check-input" type="checkbox"
                                                        id="rolePermissionWrite" name="role_permission[]"
                                                        value="role_permission-create" @if(!empty($permissionsArray) && isset($permissionsArray) && in_array('role_permission-create',$permissionsArray['name']))checked @endif/>
                                                    <label class="form-check-label" for="rolePermissionWrite">
                                                        Create
                                                    </label>
                                                </div>
                                                <div class="form-check me-3 me-lg-5">
                                                    <input class="form-check-input" type="checkbox"
                                                        id="rolePermissionCreate" name="role_permission[]"
                                                        value="role_permission-edit" @if(!empty($permissionsArray) && isset($permissionsArray) && in_array('role_permission-edit',$permissionsArray['name']))checked @endif/>
                                                    <label class="form-check-label" for="rolePermissionCreate">
                                                        Edit
                                                    </label>
                                                </div>
                                                <div class="form-check">
                                                    <input class="form-check-input" type="checkbox"
                                                        id="rolePermissionDelete" name="role_permission[]"
                                                        value="role_permission-delete" @if(!empty($permissionsArray) && isset($permissionsArray) && in_array('role_permission-delete',$permissionsArray['name']))checked @endif/>
                                                    <label class="form-check-label" for="rolePermissionDelete">
                                                        Delete
                                                    </label>
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="text-nowrap fw-medium">Moderator Management</td>
                                        <td>
                                            <div class="d-flex">
                                                <div class="form-check me-3 me-lg-5">
                                                    <input class="form-check-input" type="checkbox"
                                                        id="moderatorPermissionRead" name="moderator_management[]"
                                                        value="moderator_management-list" @if(!empty($permissionsArray) && isset($permissionsArray) && in_array('moderator_management-list',$permissionsArray['name']))checked @endif/>
                                                    <label class="form-check-label" for="moderatorPermissionRead">
                                                        List
                                                    </label>
                                                </div>
                                                <div class="form-check me-3 me-lg-5">
                                                    <input class="form-check-input" type="checkbox"
                                                        id="moderatorPermissionWrite" name="moderator_management[]"
                                                        value="moderator_management-create" @if(!empty($permissionsArray) && isset($permissionsArray) && in_array('moderator_management-create',$permissionsArray['name']))checked @endif/>
                                                    <label class="form-check-label" for="moderatorPermissionWrite">
                                                        Create
                                                    </label>
                                                </div>
                                                <div class="form-check me-3 me-lg-5">
                                                    <input class="form-check-input" type="checkbox"
                                                        id="moderatorPermissionCreate" name="moderator_management[]"
                                                        value="moderator_management-edit" @if(!empty($permissionsArray) && isset($permissionsArray) && in_array('moderator_management-edit',$permissionsArray['name']))checked @endif/>
                                                    <label class="form-check-label" for="moderatorPermissionCreate">
                                                        Edit
                                                    </label>
                                                </div>
                                                <div class="form-check">
                                                    <input class="form-check-input" type="checkbox"
                                                        id="moderatorPermissionDelete" name="moderator_management[]"
                                                        value="moderator_management-delete" @if(!empty($permissionsArray) && isset($permissionsArray) && in_array('moderator_management-delete',$permissionsArray['name']))checked @endif/>
                                                    <label class="form-check-label" for="moderatorPermissionDelete">
                                                        Delete
                                                    </label>
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="text-nowrap fw-medium">Product</td>
                                        <td>
                                            <div class="d-flex">
                                                <div class="form-check me-3 me-lg-5">
                                                    <input class="form-check-input" type="checkbox"
                                                        id="productPermissionRead" name="product_permission[]"
                                                        value="product-list" @if(!empty($permissionsArray) && isset($permissionsArray) && in_array('product-list',$permissionsArray['name']))checked @endif/>
                                                    <label class="form-check-label" for="productPermissionRead">
                                                        List
                                                    </label>
                                                </div>
                                                <div class="form-check me-3 me-lg-5">
                                                    <input class="form-check-input" type="checkbox"
                                                        id="productPermissionWrite" name="product_permission[]"
                                                        value="product-create" @if(!empty($permissionsArray) && isset($permissionsArray) && in_array('product-create',$permissionsArray['name']))checked @endif/>
                                                    <label class="form-check-label" for="productPermissionWrite">
                                                        Create
                                                    </label>
                                                </div>
                                                <div class="form-check me-3 me-lg-5">
                                                    <input class="form-check-input" type="checkbox"
                                                        id="productPermissionEdit" name="product_permission[]"
                                                        value="product-edit" @if(!empty($permissionsArray) && isset($permissionsArray) && in_array('product-edit',$permissionsArray['name']))checked @endif/>
                                                    <label class="form-check-label" for="productPermissionEdit">
                                                        Edit
                                                    </label>
                                                </div>
                                                <div class="form-check">
                                                    <input class="form-check-input" type="checkbox"
                                                        id="productPermissionDelete" name="product_permission[]"
                                                        value="product-delete" @if(!empty($permissionsArray) && isset($permissionsArray) && in_array('product-delete',$permissionsArray['name']))checked @endif/>
                                                    <label class="form-check-label" for="productPermissionDelete">
                                                        Delete
                                                    </label>
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                    
                                </tbody>
                            </table>
                        </div>
                        <!-- Permission table -->
                    </div>
                    <div class="col-12 text-right">
                        <button type="submit" class="btn btn-primary me-sm-3 me-1">Submit</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<script>
    $(document).ready(function () {
        $('#selectAll').change(function () {
            $('.form-check-input').prop('checked', $(this).prop('checked'));
        });

        $('.form-check-input').change(function () {
            if ($('.form-check-input:checked').length === $('.form-check-input').length) {
                $('#selectAll').prop('checked', true);
            } else {
                $('#selectAll').prop('checked', false);
            }
        });
    });
</script>
@endsection