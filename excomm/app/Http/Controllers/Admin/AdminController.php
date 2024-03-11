<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Admin;
use App\Models\AdminsRole;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;

class AdminController extends Controller
{
    public function dashboard()
    {
        return view('admin.dashboard');
    }

    public function login(Request $request)
    {
        // dd($request);
        if ($request->isMethod('post')) {
            $data = $request->all();
            // Validation rules
            $rules = [
                'email' => 'required|email|max:255',
                'password' => 'required|max:30',
            ];
            // Custom error messages
            $customMessages = [
                'email.required' => 'Email is required',
                'email.email' => 'Valid Email is required',
                'password.required' => 'Password is required',
            ];
            // Validate the request data
            $validator = Validator::make($data, $rules, $customMessages);
            // If validation fails, redirect back with errors
            if ($validator->fails()) {
                return redirect()->back()->withErrors($validator)->withInput();
            }
            // Attempt to authenticate the user
            if (Auth::guard('admin')->attempt(['email' => $data['email'], 'password' => $data['password']])) {
                return redirect('admin/dashboard');
            } else {
                return redirect()->back()->with("error_message", "Invalid Username and Password");
            }
        }
        return view('admin.login');
    }

    public function logout()
    {
        Auth::guard('admin')->logout();
        return redirect('admin/login');
    }

    public function updatePassword()
    {
        return view('admin.update_password');
    }

    public function checkCurrentPassword(Request $request)
    {
        // Check if the user is authenticated
        if (Auth::guard('admin')->check()) {
            $data = $request->all();
            $currentPassword = $data['current_pwd'];

            if (Hash::check($currentPassword, Auth::guard('admin')->user()->password)) {
                return response()->json('true');
            } else {
                return response()->json('false');
            }
        } else {
            // User is not authenticated
            return response()->json('false');
        }
    }

    public function processUpdatePassword(Request $request)
    {
        $data = $request->all();
        // Validation rules
        $rules = [
            'current_pwd' => 'required',
            'new_pwd' => 'required|min:8|different:current_pwd',
            'confirm_pwd' => 'required|same:new_pwd',
        ];
        // Custom error messages
        $customMessages = [
            'current_pwd.required' => 'Current password is required.',
            'new_pwd.required' => 'New password is required.',
            'new_pwd.min' => 'New password must be at least 8 characters long.',
            'new_pwd.different' => 'New password must be different from the current password.',
            'confirm_pwd.required' => 'Confirm password is required.',
            'confirm_pwd.same' => 'Confirm password must match the new password.',
        ];
        // Validate the request data
        $validator = Validator::make($data, $rules, $customMessages);
        // If validation fails, redirect back with errors
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }
        // Update the password
        $auth = Auth::guard('admin')->user();
        $user =  Admin::find($auth->id);
        $user->password = Hash::make($data['new_pwd']);
        $user->save();
        // Logout the user after password update
        Auth::guard('admin')->logout();
        return redirect('admin/login')->with('success_message', 'Password updated successfully. Please login with your new password.');
    }

    public function updateAdminDetails()
    {
        return view('admin.update_admin_details');
    }

    public function processUpdateDetails(Request $request)
    {
        $data = $request->all();

        // Validation rules
        $rules = [
            'admin_name' => 'required|max:255',
            'mobile' => 'required|numeric',
            'image' => 'required|image|max:2048',
        ];

        // Custom error messages
        $customMessages = [
            'admin_name.required' => 'Name is required.',
            'mobile.required' => 'Mobile is required.',
            'mobile.numeric' => 'Mobile must be a number.',
            'image.required' => 'Image is required.',
            'image.image' => 'The file must be an image.',
        ];

        // Validate the request data
        $validator = Validator::make($data, $rules, $customMessages);

        // If validation fails, redirect back with errors
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        // Update the user details
        $auth = Auth::guard('admin')->user();
        $user =  Admin::find($auth->id);
        $user->name = $data['admin_name'];
        $user->mobile = $data['mobile'];

        // Handle image upload
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $imageName = time() . '_' . $image->getClientOriginalName();
            $image->storeAs('images', $imageName, 'public');
            $user->image = 'storage/images/' . $imageName;
        }

        $user->save();

        return redirect()->back()->with('success_message', 'Details updated successfully.');
    }

    public function sabAdmins()
    {
        // dd(Auth::guard('admin')->user()->type);
        Session::put('page', 'subadmins');
        $subadmins = Admin::get()->toArray();
        // dd($subadmins);
        $rolePermissionCount = AdminsRole::where([
            'subadmin_id' => Auth::guard('admin')->user()->id,
            'module' => 'admin_roles'
        ])->count();
        // dd($rolePermissionCount);
        $pagesModule = array();

        if (Auth::guard('admin')->user()->type == "admin") {
            $pagesModule['view_access'] = 1;
            $pagesModule['edit_access'] = 1;
            $pagesModule['full_access'] = 1;
        } elseif ($rolePermissionCount == 0) {
            $message = "This feature is restricted for you";
            return redirect('admin/dashboard')->with('error_message', $message);
        } else {
            $pagesModule = AdminsRole::where([
                'subadmin_id' => Auth::guard('admin')->user()->id,
                'module' => 'admin_roles'
            ])->first()->toArray();
        }

        return view('admin.subadmins.subadmins')->with(compact('subadmins', 'pagesModule'));
    }


    public function editSubAdmin(Request $request, $id = null)
    {
        // Use model binding to directly retrieve the SubAdmin instance
        $subadmin = $id ? Admin::findOrFail($id) : new Admin();

        $title = $id ? "Edit SubAdmin" : "Add SubAdmin";

        if ($request->isMethod('post')) {
            $data = $request->all();

            $rules = [
                'name' => 'required',
                'type' => 'required',
                'mobile' => 'required',
                'email' => 'required|email',
                'status' => 'required|in:0,1', // Assuming you want to validate that status is either 0 or 1
                // Update image validation if it's not required during update
                'image' => $id ? 'nullable|image|max:2048' : 'required|image|max:2048',
                // Add more validation rules as needed
            ];

            $customMessages = [
                'name.required' => 'SubAdmin Name is required',
                'type.required' => 'SubAdmin Type is required',
                'mobile.required' => 'SubAdmin Mobile is required',
                'email.required' => 'SubAdmin Email is required',
                'email.email' => 'Invalid email format',
                'status.required' => 'Status is required',
                'status.in' => 'Invalid status value', // Customize this message as needed
                'image.required' => 'Image is required.',
                'image.image' => 'The file must be an image.',
                // Add more custom messages as needed
            ];

            $this->validate($request, $rules, $customMessages);

            // Update SubAdmin attributes
            $subadmin->fill($data);

            // Handle image upload if it's present in the request
            if ($request->hasFile('image')) {
                $image = $request->file('image');
                $imageName = time() . '_' . $image->getClientOriginalName();
                $image->store('public/images'); // storeAs is not needed here
                $subadmin->image = 'storage/images/' . $imageName;
            }

            $subadmin->save();

            $message = $id ? 'SubAdmin updated successfully' : 'SubAdmin added successfully';

            return redirect('admin/subadmins')->with('success_message', $message);
        }

        return view('admin.subadmins.add_edit_subadmins', compact('title', 'subadmin'));
    }

    public function updateSubAdminStatus(Request $request, Admin $admin)
    {
        if ($request->ajax()) {
            $adminId = $request->input('admin_id');
            dd('admin_id');
            $status = $request->input('status');
            $admin = Admin::find($adminId);
            if (!$admin) {
                return response()->json(['error' => 'Admin not found'], 404);
            }
            $admin->status = ($status == 'Active') ? 0 : 1;
            $admin->save();
            return response()->json(['status' => $admin->status, 'admin_id' => $admin->id]);
        }
    }
    

    public function destroySubAdmin($id)
    {
        Admin::where('id', $id)->delete();
        return redirect()->back()->with('success_message', 'SubAdmin deleted successfully!');
    }
    public function updateRole($id, Request $request)
    {
        $title = "Update Subadmin Role/Permission";
        if ($request->isMethod('post')) {
            // dd($request->toArray());
            $data = $request->all();

            // Delete existing roles for the subadmin
            AdminsRole::where('subadmin_id', $id)->delete();

            foreach ($data['access'] as $key => $value) {
                if (isset($value['view'])) {
                    $view = $value['view'];
                } else {
                    $view = 0;
                }

                if (isset($value['edit'])) {
                    $edit = $value['edit'];
                } else {
                    $edit = 0;
                }

                if (isset($value['full'])) {
                    $full = $value['full'];
                } else {
                    $full = 0;
                }
                // Create a new role entry for each module
                $role = new AdminsRole;
                $role->subadmin_id = $id;
                $role->module = $key;
                $role->view_access = $view;
                $role->edit_access = $edit;
                $role->full_access = $full;
                $role->save();
            }

            $message = "Subadmin Roles updated successfully";
            return redirect()->back()->with('success_message', $message);
        }
        $subadminRoles = AdminsRole::where('subadmin_id', $id)->get();
        return view('admin.subadmins.update_roles')->with(compact('title', 'id', 'subadminRoles'));
    }
}
