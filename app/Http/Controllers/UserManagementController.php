<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\User;
use DB;
use Hash;
use Illuminate\Http\Request;

use Yajra\DataTables\Facades\DataTables;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Mail;

class UserManagementController extends Controller
{
    public  function __construct()
    {
        $this->middleware('permission:user_management-list|user_management-create|user_management-edit|user_management-delete', ['only' => ['index', 'show']]);
        $this->middleware('permission:user_management-create', ['only' => ['create', 'store']]);
        $this->middleware('permission:user_management-edit', ['only' => ['edit', 'update', 'status']]);
        $this->middleware('permission:user_management-delete', ['only' => ['delete']]);
    }
    public function index(Request $request)
    {

        if ($request->ajax()) {
            $roles = Role::get();
            $roleArray = [];
            foreach ($roles as $role) {
                $roleArray[] = $role->name;
            }
            $nonRoles = User::withoutRole($roleArray)->get();

            return DataTables::of($nonRoles)
                ->addIndexColumn()
                ->addColumn('action', function ($row) {

                    $status = $row['status'] == 1 ? 'checked' : "";
                    $btn = '<div class="button-group d-flex">';
                    if (auth()->user()->can('user_management-edit')) {
                        $btn .= '<div class="form-check form-switch">';
                        $btn .= '<input class="form-check-input status" data-id="' . $row['id'] . '" type="checkbox" role="switch" id="status" ' . $status . '>';
                        $btn .= '</div>';

                        $btn .= '<a href="' . route('user-management.edit', ['id' => $row['id']]) . '" title="EDIT">';
                        $btn .= '<i class="bx bx-edit-alt me-1"></i>';
                        $btn .= '</a>';
                    }
                    if (auth()->user()->can('user_management-delete')) {
                        $btn .= '<form method="post" action="' . route('password.update') . '">' . csrf_field() . '<input type="hidden" name="id" value="' . $row['id'] . '" ></form>';
                        $btn .= '<a href="javascript:;" title="RESET PASSWORD" class="reset-password">';
                        $btn .= '<i class="bx bx-reset"></i>';
                        $btn .= '</a>';
                    }
                    $btn .= '<a href="' . route('user-management.profile', ['id' => $row['id']]) . '" title="PREVIEW PROFILE">';
                    $btn .= '<i class="bx bxs-bullseye"></i>';
                    $btn .= '</a>';

                    $btn .= '</div>';
                    return $btn;
                })
                ->addColumn('status', function ($row) {
                    $statusLable = $row['status'] == 1 ? 'Active' : "Inactive";
                    $statusClass = $row['status'] == 1 ? 'primary' : "danger";
                    $btn = '';
                    $btn .= "<span class='badge bg-label-$statusClass me-1'>$statusLable</span>";
                    return $btn;
                })
                ->rawColumns(['action', 'status'])
                ->make(true);
        }
        return view('admin.user-management.index');
    }

    public function edit($id)
    {
        $user = User::where('id', '=', $id)->first();
        return view('admin.user-management.form', ['user' => $user]);
    }
    public function create()
    {
        // dd("hello");
        return view('admin.user-management.form');
    }
    public function store(Request $request)
    {
        $rules = [
            'name' => 'required',
            'email' => 'required|email|unique:users,email,' . $request->id,
            'dob' => 'required',
            'password' => 'required|same:confirm_password',
            'phone_number' => ['nullable', 'regex:/^[0-9]{10}$/']
        ];

        $request->validate($rules);
        $user = new User();
        $user->fill($request->all());
        $user->save();
        

        return redirect()->route('user-management')->with('message', "User Created successfully.");
    }
    public function update(Request $request)
    {
        $rules = [
            'name' => 'required',
            'email' => 'required|email|unique:users,email,' . $request->id,
            'dob' => 'required',
            'phone_number' => ['nullable', 'regex:/^[0-9]{10}$/']
        ];
        $request->validate($rules);
        $data = [
            'name' => $request->name,
            'gender' => $request->gender,
            'dob' => $request->dob,
            'phone_number' => $request->phone_number,
            'address' => $request->address,
            'status' => $request->status,
        ];
        User::where('id', '=', $request->id)->update($data);
        return redirect()->route('user-management')->with('message', 'User Updated successfully.');
    }
    public function status(Request $request)
    {
        $data = json_decode($request->getContent(), true);
        $status = $data['status'];

        User::where('id', '=', $request->id)->update(['status' => $status]);
        return response()->json(['message' => 'Status updated successfully', 'status' => 200], 200);
    }

    public function profile($id)
    {
        $user = User::where('id', '=', $id)->first();
        return view('admin.user-management.profile', ['user' => $user]);
    }
}
