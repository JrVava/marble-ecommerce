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
                                        <td class="text-nowrap fw-medium">SMTP</td>
                                        <td>
                                            <div class="d-flex">
                                                <div class="form-check me-3 me-lg-5">
                                                    <input class="form-check-input" type="checkbox"
                                                        id="SMTPRead" name="smtp[]"
                                                        value="smtp-list" @if(!empty($permissionsArray) && isset($permissionsArray) && in_array('smtp-list',$permissionsArray['name']))checked @endif/>
                                                    <label class="form-check-label" for="SMTPRead">
                                                        List
                                                    </label>
                                                </div>
                                                <div class="form-check me-3 me-lg-5">
                                                    <input class="form-check-input" type="checkbox"
                                                        id="smtpCreatOREdite" name="smtp[]"
                                                        value="smpt-create-edit" @if(!empty($permissionsArray) && isset($permissionsArray) && in_array('smpt-create-edit',$permissionsArray['name']))checked @endif/>
                                                    <label class="form-check-label" for="smtpCreateOREdit">
                                                        Create Or Edit
                                                    </label>
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="text-nowrap fw-medium">Contacts</td>
                                        <td>
                                            <div class="d-flex">
                                                <div class="form-check me-3 me-lg-5">
                                                    <input class="form-check-input" type="checkbox"
                                                        id="contactsRead" name="contact[]"
                                                        value="contact-list" @if(!empty($permissionsArray) && isset($permissionsArray) && in_array('contact-list',$permissionsArray['name']))checked @endif/>
                                                    <label class="form-check-label" for="contactsRead">
                                                        List
                                                    </label>
                                                </div>
                                                {{-- <div class="form-check me-3 me-lg-5">
                                                    <input class="form-check-input" type="checkbox"
                                                        id="contactsWrite" name="contact[]"
                                                        value="contact-create" @if(!empty($permissionsArray) && isset($permissionsArray) && in_array('contact-create',$permissionsArray['name']))checked @endif/>
                                                    <label class="form-check-label" for="contactsWrite">
                                                        Create
                                                    </label>
                                                </div>
                                                <div class="form-check me-3 me-lg-5">
                                                    <input class="form-check-input" type="checkbox"
                                                        id="moderatorManagementCreate" name="contact[]"
                                                        value="contact-edit" @if(!empty($permissionsArray) && isset($permissionsArray) && in_array('contact-edit',$permissionsArray['name']))checked @endif/>
                                                    <label class="form-check-label" for="moderatorManagementCreate">
                                                        Edit
                                                    </label>
                                                </div> --}}
                                                <div class="form-check">
                                                    <input class="form-check-input" type="checkbox"
                                                        id="moderatorManagementDelete" name="contact[]"
                                                        value="contact-delete" @if(!empty($permissionsArray) && isset($permissionsArray) && in_array('contact-delete',$permissionsArray['name']))checked @endif/>
                                                    <label class="form-check-label" for="moderatorManagementDelete">
                                                        Delete
                                                    </label>
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="text-nowrap fw-medium">Settings</td>
                                        <td>
                                            <div class="d-flex">
                                                <div class="form-check me-3 me-lg-5">
                                                    <input class="form-check-input" type="checkbox"
                                                        id="settingsRead" name="settings[]"
                                                        value="settings-list" @if(!empty($permissionsArray) && isset($permissionsArray) && in_array('settings-list',$permissionsArray['name']))checked @endif/>
                                                    <label class="form-check-label" for="settingsRead">
                                                        List
                                                    </label>
                                                </div>
                                                <div class="form-check me-3 me-lg-5">
                                                    <input class="form-check-input" type="checkbox"
                                                        id="settingtCreatOREdite" name="settings[]"
                                                        value="settings-create-edit" @if(!empty($permissionsArray) && isset($permissionsArray) && in_array('settings-create-edit',$permissionsArray['name']))checked @endif/>
                                                    <label class="form-check-label" for="settingCreateOREdit">
                                                        Create Or Edit
                                                    </label>
                                                </div>
                                                <div class="form-check">
                                                    <input class="form-check-input" type="checkbox"
                                                        id="SettingsDelete" name="settings[]"
                                                        value="settings-delete" @if(!empty($permissionsArray) && isset($permissionsArray) && in_array('settings-delete',$permissionsArray['name']))checked @endif/>
                                                    <label class="form-check-label" for="SettingsDelete">
                                                        Delete
                                                    </label>
                                                </div>
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
                                        <td class="text-nowrap fw-medium">CMS</td>
                                        <td>
                                            <div class="d-flex">
                                                <div class="form-check me-3 me-lg-5">
                                                    <input class="form-check-input" type="checkbox"
                                                        id="cmsRead" name="cms[]"
                                                        value="cms-list"  @if(!empty($permissionsArray) && isset($permissionsArray) && in_array('cms-list',$permissionsArray['name']))checked @endif/>
                                                    <label class="form-check-label" for="cmsRead">
                                                        List
                                                    </label>
                                                </div>
                                                <div class="form-check me-3 me-lg-5">
                                                    <input class="form-check-input" type="checkbox"
                                                        id="cmsWrite" name="cms[]"
                                                        value="cms-create" @if(!empty($permissionsArray) && isset($permissionsArray) && in_array('cms-create',$permissionsArray['name']))checked @endif/>
                                                    <label class="form-check-label" for="cmsWrite">
                                                        Create
                                                    </label>
                                                </div>
                                                <div class="form-check me-3 me-lg-5">
                                                    <input class="form-check-input" type="checkbox"
                                                        id="cmsCreate" name="cms[]"
                                                        value="cms-edit" @if(!empty($permissionsArray) && isset($permissionsArray) && in_array('cms-edit',$permissionsArray['name']))checked @endif/>
                                                    <label class="form-check-label" for="cmsCreate">
                                                        Edit
                                                    </label>
                                                </div>
                                                <div class="form-check">
                                                    <input class="form-check-input" type="checkbox"
                                                        id="cmsDelete" name="cms[]"
                                                        value="cms-delete" @if(!empty($permissionsArray) && isset($permissionsArray) && in_array('cms-delete',$permissionsArray['name']))checked @endif/>
                                                    <label class="form-check-label" for="cmsDelete">
                                                        Delete
                                                    </label>
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="text-nowrap fw-medium">Email Template</td>
                                        <td>
                                            <div class="d-flex">
                                                <div class="form-check me-3 me-lg-5">
                                                    <input class="form-check-input" type="checkbox"
                                                        id="emailTemplateRead" name="email_template[]"
                                                        value="email_template-list" @if(!empty($permissionsArray) && isset($permissionsArray) && in_array('email_template-list',$permissionsArray['name']))checked @endif/>
                                                    <label class="form-check-label" for="emailTemplateRead">
                                                        List
                                                    </label>
                                                </div>
                                                <div class="form-check me-3 me-lg-5">
                                                    <input class="form-check-input" type="checkbox"
                                                        id="emailTemplateWrite" name="email_template[]"
                                                        value="email_template-create" @if(!empty($permissionsArray) && isset($permissionsArray) && in_array('email_template-create',$permissionsArray['name']))checked @endif/>
                                                    <label class="form-check-label" for="emailTemplateWrite">
                                                        Create
                                                    </label>
                                                </div>
                                                <div class="form-check me-3 me-lg-5">
                                                    <input class="form-check-input" type="checkbox"
                                                        id="emalTemplateCreate" name="email_template[]"
                                                        value="email_template-edit" @if(!empty($permissionsArray) && isset($permissionsArray) && in_array('email_template-edit',$permissionsArray['name']))checked @endif/>
                                                    <label class="form-check-label" for="emalTemplateCreate">
                                                        Edit
                                                    </label>
                                                </div>
                                                <div class="form-check">
                                                    <input class="form-check-input" type="checkbox"
                                                        id="emailTemplateDelete" name="email_template[]"
                                                        value="email_template-delete" @if(!empty($permissionsArray) && isset($permissionsArray) && in_array('email_template-delete',$permissionsArray['name']))checked @endif/>
                                                    <label class="form-check-label" for="emailTemplateDelete">
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
                                                        id="moderatorManagementRead" name="moderator_management[]"
                                                        value="moderator_management-list" @if(!empty($permissionsArray) && isset($permissionsArray) && in_array('moderator_management-list',$permissionsArray['name']))checked @endif/>
                                                    <label class="form-check-label" for="moderatorManagementRead">
                                                        List
                                                    </label>
                                                </div>
                                                <div class="form-check me-3 me-lg-5">
                                                    <input class="form-check-input" type="checkbox"
                                                        id="moderatorManagementWrite" name="moderator_management[]"
                                                        value="moderator_management-create" @if(!empty($permissionsArray) && isset($permissionsArray) && in_array('moderator_management-create',$permissionsArray['name']))checked @endif/>
                                                    <label class="form-check-label" for="moderatorManagementWrite">
                                                        Create
                                                    </label>
                                                </div>
                                                <div class="form-check me-3 me-lg-5">
                                                    <input class="form-check-input" type="checkbox"
                                                        id="moderatorManagementCreate" name="moderator_management[]"
                                                        value="moderator_management-edit" @if(!empty($permissionsArray) && isset($permissionsArray) && in_array('moderator_management-edit',$permissionsArray['name']))checked @endif/>
                                                    <label class="form-check-label" for="moderatorManagementCreate">
                                                        Edit
                                                    </label>
                                                </div>
                                                <div class="form-check">
                                                    <input class="form-check-input" type="checkbox"
                                                        id="moderatorManagementDelete" name="moderator_management[]"
                                                        value="moderator_management-delete" @if(!empty($permissionsArray) && isset($permissionsArray) && in_array('moderator_management-delete',$permissionsArray['name']))checked @endif/>
                                                    <label class="form-check-label" for="moderatorManagementDelete">
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