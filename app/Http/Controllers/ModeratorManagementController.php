<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Hash;
use Yajra\DataTables\Facades\DataTables;

class ModeratorManagementController extends Controller
{
    public  function __construct()
    {
         $this->middleware('permission:moderator_management-list|moderator_management-create|moderator_management-edit|moderator_management-delete', ['only' => ['index','show']]);
         $this->middleware('permission:moderator_management-create', ['only' => ['create','store']]);
         $this->middleware('permission:moderator_management-edit', ['only' => ['edit','update']]);
         $this->middleware('permission:moderator_management-delete', ['only' => ['delete']]);
    }
    public function index(Request $request){

        if ($request->ajax()) {
            $roles = Role::get();
            $roleArray = [];
            foreach ($roles as $role) {
                $roleArray[] = $role->name;
            }
            $data =User::role($roleArray)->get();

            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('role', function ($row) {
                    return $row->getRoleNames()[0];
                })
                ->addColumn('action', function ($row) {

                    $status = $row['status'] == 1 ? 'checked' : "";
                    $btn = '<div class="button-group d-flex">';
                    if (!empty($row->getRoleNames()) && $row->getRoleNames()[0] != 'Admin') {
                        if (auth()->user()->can('moderator_management-edit')) {
                            $btn .= '<div class="form-check form-switch">';
                            $btn .= '<input class="form-check-input status" data-id="' . $row['id'] . '" type="checkbox" role="switch" id="status" ' . $status . '>';
                            $btn .= '</div>';
                        }
                        $btn .= '<div class="dropdown">';
                        $btn .= '<button type="button" class="btn p-0 dropdown-toggle hide-arrow" data-bs-toggle="dropdown"><i class="bx bx-dots-vertical-rounded"></i></button>';
                        $btn .= '<div class="dropdown-menu">';
                        if (auth()->user()->can('moderator_management-edit')) {
                            $btn .= '<a href="' . route('moderator-management.edit', ['id' => $row['id']]) . '" class="dropdown-item">';
                            $btn .= '<i class="bx bx-edit-alt me-1"></i> Edit';
                            $btn .= '</a>';
                        }
                        if (auth()->user()->can('moderator_management-delete')) {
                            $btn .= '<form method="post" action="' . route('moderator-management.delete', ['id' => $row->id]) . '">' . csrf_field() . ' ' . method_field("DELETE") . '</form>';
                            $btn .= '<a href="javascript:;" class="dropdown-item delete-cms">';
                            $btn .= '<i class="bx bx-trash-alt me-1"></i> Delete';
                            $btn .= '</a>';
                        }
                        $btn .= '</div></div>';
                    }
                    $btn .= '</div>';
                    return $btn;
                })
                ->addColumn('status', function ($row) {
                    $statusLable = $row['status'] == 1 ? 'Active' : "Inactive";
                    $statusClass = $row['status'] == 1 ? 'primary' : "danger";
                    $btn = '';
                    if (!empty($row->getRoleNames()) && $row->getRoleNames()[0] != 'Admin') {
                        $btn .= "<span class='badge bg-label-$statusClass me-1'>$statusLable</span>";
                    }
                    return $btn;
                })
                ->rawColumns(['action', 'status'])
                ->make(true);
        }
        return view('admin.moderator-management.index');
    }

    public function create(){
        $roles = Role::where('name','!=','Admin')->get();
        return view('admin.moderator-management.form',compact('roles'));
    }
    public function edit($id)
    {
        $user = User::where('id', '=', $id)->first();
        $roles = Role::where('name','!=','Admin')->get();
        $userRole = $user->roles->pluck('name','name')->first();
        return view('admin.moderator-management.form', ['user' => $user,'roles'=>$roles,'userRole' => $userRole]);
    }
    public function store(Request $request) {
        $rules = [
            'name' => 'required',
            'email' => 'required|email|unique:users,email,' . $request->id,
            'password' => 'required|same:confirm_password',
            'role' => 'required',
            'phone_number' => ['nullable', 'regex:/^[0-9]{10}$/']
        ];
        // Validate the request first
        
        
        $request->validate($rules);
        // Hash the password after validation
        $request['password'] = Hash::make($request->password);
        
        // dd($request->all());
            $user = User::create($request->all());
            
            $user->assignRole($request->role);
        
        return redirect()->route('moderator-management')->with('message', 'User Created Successfully');
    }
    
    public function update(Request $request){
        $rules = [
            'name' => 'required',
            'email' => 'required|email|unique:users,email,' . $request->id,
            'role' => 'required',
            'phone_number' => ['nullable', 'regex:/^[0-9]{10}$/']
        ];

        $request->validate($rules);
        $user = User::find($request->id);
        $user->update($request->all());
        DB::table('model_has_roles')->where('model_id', $request->id)->delete();
        $user->assignRole($request->role);
        return redirect()->route('moderator-management')->with('message', 'User Updated Successfully');
    }

    public function delete($id){
        User::find($id)->delete();
        return redirect()->route('moderator-management')->with('message', 'User Deleted successfully');
    }
}
