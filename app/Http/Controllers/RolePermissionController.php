<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Yajra\DataTables\Facades\DataTables;

class RolePermissionController extends Controller
{

    public function __construct()
    {
        $this->middleware('permission:role_permission-list|role_permission-create|role_permission-edit|role_permission-delete', ['only' => ['index', 'show']]);
        $this->middleware('permission:role_permission-create', ['only' => ['create', 'store']]);
        $this->middleware('permission:role_permission-edit', ['only' => ['edit', 'update']]);
        $this->middleware('permission:role_permission-delete', ['only' => ['destroy']]);
    }
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $_roles = Role::orderBy('id', 'DESC');
            if (!Auth::user()->hasRole('Admin')) {
                $_roles->where('name', '!=', 'Admin');
            }
            $roles = $_roles->get();

            return DataTables::of($roles)
                ->addIndexColumn()
                ->addColumn('action', function ($row) {
                    $getRole = Auth::user()->getRoleNames();
                    $currentUserRole = isset($getRole[0]) ? $getRole[0] : null;
                    if ($row->name !== "Admin" || $currentUserRole === "Admin") {
                        $btn = '<div class="button-group d-flex">';
                        $btn .= '<div class="dropdown">';
                        $btn .= '<button type="button" class="btn p-0 dropdown-toggle hide-arrow btn btn-primary p-2 " data-bs-toggle="dropdown"><i class="bx bx-dots-vertical-rounded"></i></button>';
                        $btn .= '<div class="dropdown-menu">';
                        $btn .= '<a href="' . route('role-permission.edit', ['id' => $row['id']]) . '" class="dropdown-item">';
                        $btn .= '<i class="bx bx-edit-alt me-1"></i> Edit';
                        $btn .= '</a>';
                        $btn .= '<form method="post" action="' . route('role-permission.delete', ['id' => $row->id]) . '">' . csrf_field() . ' ' . method_field("DELETE") . '</form>';
                        $btn .= '<a href="javascript:;" class="dropdown-item delete-cms">';
                        $btn .= '<i class="bx bx-trash-alt me-1"></i> Delete';
                        $btn .= '</a>';
                        $btn .= '</div></div>';
                        $btn .= '</div>';
                        return $btn;
                    }
                })
                ->rawColumns(['action'])
                ->make(true);
        }
        return view('admin.role-permission.index');
    }

    public function create()
    {
        return view('admin.role-permission.form');
    }
    public function store(Request $request)
    {

        // dd($request->all());
        $request->validate([
            'role' => 'required|unique:roles,name,' . $request->id,
            'user_managemant' => 'array',
            'cms' => 'array',
            'email_template' => 'array',
        ]);

        $roleData = ['name' => $request->input('role')];

        if ($request->filled('id')) {
            $role = Role::findOrFail($request->id);
            $role->update($roleData);
            $role->permissions()->detach();
        } else {
            $role = Role::create($roleData);
        }
        // dd($role,$request->input('user_managemant', []));
        // Assign permissions to the role
        $this->assignPermissions($role, $request->input('user_managemant', []), 'user_management');

        $this->assignPermissions($role, $request->input('product_permission', []), 'product_permission');
        $this->assignPermissions($role, $request->input('moderator_management', []), 'moderator_management');
        $this->assignPermissions($role, $request->input('role_permission', []), 'role_permission');


        $message = isset($request->id) ? 'Role & Permission Updated Successfully' : 'Role & Permission Created Successfully';

        return redirect()->route('role-permission.list')->with('message', $message);
    }
    protected function assignPermissions($role, $permissions, $prefix)
    {

        foreach ($permissions as $permission) {
            // Create the permission if it doesn't exist
            Permission::firstOrCreate(['name' => $permission]);

            // Assign the permission to the role
            $role->givePermissionTo($permission);
        }
    }

    public function delete($id)
    {
        Role::where('id', '=', $id)->delete();
        return redirect()->route('role-permission.list')->with('message', 'Role & Permission Deleted successfully');
    }

    public function edit($id)
    {
        $role = Role::find($id);
        $permissions = Permission::get();
        $rolePermissions = DB::table("role_has_permissions")
            ->join('permissions', 'role_has_permissions.permission_id', '=', 'permissions.id')
            ->where("role_has_permissions.role_id", $id)
            ->select('permissions.name', 'permissions.id')
            ->get();
        $permissionsArray = [];
        foreach ($rolePermissions as $rolePermission) {
            $permissionsArray['id'][] = $rolePermission->id;
            $permissionsArray['name'][] = $rolePermission->name;
        }

        // dd($permissionsArray);
        return view('admin.role-permission.form', ['role' => $role, 'permissions' => $permissions, 'rolePermissions' => $rolePermissions, 'permissionsArray' => $permissionsArray]);
    }
}
