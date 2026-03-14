<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Department;
use App\Models\User;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use File;

class UserController extends Controller
{
    public function __construct($sub_menu = null)
    {
        session()->flash('menu', 'User Management');
        session()->flash('sub-menu', $sub_menu);
    }

    protected function index(Request $request)
    {
        function check_user_roles($role)
        {
            return isset($role[0]) ? $role[0] : '';
        }

        if ($request->ajax()) {

            $data = User::where('id', '!=', 1)->get();


            return Datatables::of($data)
                ->addIndexColumn()
                ->addColumn('role', function ($data) {
                    return check_user_roles($data->roles->pluck('name'));
                })
                ->addColumn('action', function ($data) {
                    $btn = "<a class='edit_btn btn btn-sm btn-info hover-scale' 
                    style='cursor: pointer;' record_id='" . $data->id . "' name='" . $data->name . "' email='"
                        . $data->email . "' role='" . check_user_roles($data->roles->pluck('id')) . "' department_id='"
                        . $data->department_id . "'>Edit</a>";
                    return $btn;
                })
                ->rawColumns(['role'])
                ->rawColumns(['action'])
                ->make(true);
        }

        return view('auth.users.index');
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'email' => 'required|email|unique:users',
            'password' => 'required|confirmed|min:6',
            // 'department_id' => 'required',
        ], [
            'name.required' => 'نام ضروری میباشد',
            'email.required' => 'ایمیل ضروری میباشد',
            'email.email' => 'ایمیل ادرس باید به شکل ایمیل باشد.',
            'password.required' => 'کود ضروری میباشد',
            'password.confirmed' => 'کود هم خوانی ندارد',
            'password.min' => 'کود باید حد اقل ۶ خانه باشد',
            // 'department_id.required' => 'دیپارتمنت ضروری دی.',
        ]);

        if ($validator->fails()) {
            return json_encode($validator->errors()->toArray());
        }

        DB::beginTransaction();

        try {
            $user = new User();

            $user->name = $request->name;
            $user->email = $request->email;
            $user->password = Hash::make($request->password);
            // $user->department_id = $request->department_id;

            // if ($request->file('photo')) {
            //     $photo = Storage::disk('users')->put('/', new File($request->file('photo')));
            //     $user->photo = $photo;
            // }

            if ($request->hasFile('photo')) {

                $photo     = $request->photo;
                $ext           = $photo->getClientOriginalExtension();
                $photoName = 'user_' . uniqid() . '.' . $ext;
                $photo->move(public_path('uploads/users'), $photoName);
                $user->photo = "uploads/users/" . $photoName;
            }

            $user->save();

            $user->assignRole($request->role);

            DB::commit();
            // all good
        } catch (\Exception $e) {

            DB::rollback();
            // something went wrong

            session()->flash('warning', 'Something where wrong please contact Database Adminstrator.');
            return redirect()->back();
        }

        return true;
    }

    public function update(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'email' => 'required|email',
            'password' => $request->password != '' ? 'required|confirmed|min:6' : '',
        ], [
            'name.required' => 'نام ضروری میباشد',
            'email.required' => 'ایمیل ضروری میباشد',
            'email.email' => 'ایمیل ادرس باید به شکل ایمیل باشد.',
            'password.required' => 'کود ضروری میباشد',
            'password.confirmed' => 'کود هم خوانی ندارد',
            'password.min' => 'کود باید حد اقل ۶ خانه باشد',
        ]);

        if ($validator->fails()) {
            return json_encode($validator->errors()->toArray());
        }

        DB::beginTransaction();

        try {
            $user_duplicate = User::where('email', $request->email)->where('id', '!=', $request->id)->first();

            if (isset($user_duplicate)) {

                return 'duplicate_entry';
            }

            $user = User::findOrFail($request->id);

            $user->name = $request->name;
            $user->email = $request->email;
            $user->department_id = $request->department_id;
            if ($request->password != '') {
                $user->password = Hash::make($request->password);
            }

            if ($request->file('photo')) {

                if (File::exists(public_path($user->photo))) {
                    File::delete(public_path($user->photo));
                }

                $photo          = $request->photo;
                $ext           = $photo->getClientOriginalExtension();
                $photoName      = 'user_' . uniqid() . '.' . $ext;
                $photo->move(public_path('uploads/users'), $photoName);

                $user->photo = "uploads/users/" . $photoName;
            }

            // if ($request->file('photo')) {
            //     $photo = Storage::disk('users')->put('/', new File($request->file('photo')));
            //     $user->photo = $photo;
            // }
            $user->update();

            foreach ($user->roles as $key => $value) {
                $user->removeRole($value->name);
            }

            $user->assignRole($request->role);

            DB::commit();
            // all good
        } catch (\Exception $e) {
            DB::rollback();
            // something went wrong

            session()->flash('warning', 'Something where wrong please contact Database Adminstrator.');
            return false;
        }

        return true;
    }

    public function destroy($email, Request $request)
    {
        $this->__construct('All Users');
        DB::beginTransaction();

        try {
            $auth_user = Auth::user();

            $user = User::when($auth_user->type != null, function ($query) use ($auth_user) {
                return $query->where('users.type', $auth_user->type);
            })
                ->when($auth_user->type != null, function ($query) use ($auth_user) {
                    return $query->where('users.subject_id', $auth_user->subject_id);
                })
                ->where('id', $request->id)
                ->first();
            $user->delete();

            $user->roles()->detach();
            $user->accessDomains()->detach();

            DB::commit();
            // all good
        } catch (\Exception $e) {
            DB::rollback();
            // something went wrong

            session()->flash('warning', 'Something where wrong please contact Database Adminstrator.');
            return redirect()->back();
        }

        $locale = App::getLocale();
        switch ($locale) {
            case 'en':
                session()->flash('success', 'Deleted Successfuly.');
                break;

            case 'fa':
                session()->flash('success', 'موفقانه حذف گردید.');
                break;

            case 'pa':
                session()->flash('success', 'په بریالی توگه پاک شو.');
                break;

            default:
                break;
        }
        return redirect()->back();
    }

    public function profile()
    {
        $user = User::where('users.id', Auth::user()->id)->first();
        $dep = Department::where('id', $user->department_id)->first();

        return view('auth.users.profile', compact('user', 'dep'));
    }

    public function update_profile(Request $request)
    {
        $user = Auth::user();

        DB::beginTransaction();

        try {
            $directory = 'assets/images/user_images';
            if ($photo = $request->file('photo')) {
                $name = $photo->getClientOriginalName();
                $filename = pathinfo($name, PATHINFO_FILENAME);
                $extension = pathinfo($name, PATHINFO_EXTENSION);
                $new_name = $filename . '-' . time() . '.' . $extension;
                $photo->move($directory, $new_name);
                $user->photo = $directory . '/' . $new_name;
            }

            $user->information = $request->information;
            $user->update();

            DB::commit();
            // all good
        } catch (\Exception $e) {
            DB::rollback();
            // something went wrong

            session()->flash('warning', 'Something where wrong please contact Database Adminstrator.');
            return redirect()->back();
        }
        session()->flash('success', 'Updated Successfuly');

        return redirect()->back();
    }

    public function change_password(Request $request)
    {

        $validate = Validator::make(
            $request->all(),
            [
                'password' => 'confirmed'
            ],
            [
                'password.confirmed' => '<span class="text-danger" style="font-weight:bold">رمز جدید مطابقت ندارد</span>'
            ]
        );

        if ($validate->fails()) {
            return response()->json(['status' => false, 'data' => $validate->errors()]);
            // return json_encode($validate->errors()->toArray());
        }


        if (Hash::check($request->old_password, Auth::user()->password)) {
            DB::beginTransaction();

            try {
                $request->user()->fill([
                    'password' => Hash::make($request->password),
                ])->save();

                DB::commit();
                // all good
            } catch (\Exception $e) {
                DB::rollback();
                // something went wrong
                return response()->json(['status' => false, 'data' => 'رمز گذشته اشباه است']);
            }

            return response()->json(['status' => true, 'data' => 'پسورد موفقانه تبدیل گردید']);
        } else {
            return response()->json(['status' => false, 'data' => $validate->errors()]);
        }
    }

    public function roles(Request $request)
    {
        if ($request->ajax()) {
            $sql = Role::get();
            return Datatables::of($sql)
                ->addIndexColumn()
                ->addColumn('action', function ($sql) {
                    $btn = "<a class='edit_btn btn btn-sm btn-info hover-scale' style='cursor: pointer;' action='" . route('role.edit') . "' record_id='" . $sql->id . "' name='" . $sql->name . "'>Edit</a>";
                    return $btn;
                })
                ->rawColumns(['action'])
                ->make(true);
        }

        $permission = Permission::get();
        return view('auth.roles.index', compact('permission'));
    }

    public function role_store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|unique:roles',
        ], [
            'name.required' => 'نام ضروری میباشد',
            'name.unique' => 'نام قبلا گرفته شده',
        ]);

        if ($validator->fails()) {
            return json_encode($validator->errors()->toArray());
        }

        $role = Role::create(['name' => $request->name]);
        $role->syncPermissions($request->permissions);

        return true;
    }

    public function role_edit(Request $request)
    {
        $role = Role::where('id', $request->id)->first();
        $permission = Permission::get();

        return view('auth.roles.data', compact('role', 'permission'));
    }

    public function role_update(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
        ], [
            'name.required' => 'نام ضروری میباشد',
        ]);

        if ($validator->fails()) {
            return json_encode($validator->errors()->toArray());
        }

        DB::beginTransaction();

        try {

            $role = Role::find($request->id);
            $role->name = $request->name;
            $role->update();
            $role->revokePermissionTo($role->permissions);
            $role->syncPermissions($request->permissions);

            DB::commit();
            // all good
        } catch (\Exception $e) {
            DB::rollback();
            // something went wrong

            session()->flash('warning', 'Something where wrong please contact Database Adminstrator.');
            return redirect()->back();
        }

        return true;
    }
}
