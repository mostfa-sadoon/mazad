<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Http\Requests\AdminRequest;
use App\Models\Admin;
use App\Models\Role;
use Illuminate\Http\Request;
use App\Http\Requests;
use App\Models\User;
use Hash;
use Auth;
use App\Image;

class AdminController extends Controller
{

    /**
     * render and paginate the users page.
     *
     * @return string
     */
    public function index()
    {
        $users = Admin::latest()->where('id', '<>', auth('admin')->id())->get(); //use pagination here
        //    return $users;
        return view('dashboard.admins.index', compact('users'));
    }

    public function create()
    {
        $roles = Role::get();
        return view('dashboard.admins.create', compact('roles'));
    }


    public function store(AdminRequest $request)
    {
        $user = new Admin();
        $user->name = $request->name;
        $user->email = $request->email;
        $user->password = bcrypt($request->password);   // the best place on model
        $user->role_id = $request->role_id;

        // save the new user data
        if ($user->save())
            return redirect()->back()->with(['success' => __('admin/forms.added_successfully')]);
        else
            return redirect()->back()->with(['error' => __('admin/forms.wrong')]);
    }


    public function edit($id)
    {
        $admin = Admin::findOrFail($id);
        if (!$admin)
            return redirect()->route('admin.admins.index')->with(['error' => 'هذا المستخم غير موجود']);

        $roles = Role::get();

        return view('dashboard.admins.edit', compact(['admin', 'roles']));
    }

    public function update($id, AdminRequest $request)
    {
        try {
            $admin = Admin::findOrFail($id);
            if (!$admin)
                return redirect()->route('admin.admins.index')->with(['error' => 'هذا المستخم غير موجود']);

            $admin->name = $request->name;
            $admin->email = $request->email;
            $admin->password = bcrypt($request->password);   // the best place on model
            $admin->role_id = $request->role_id;
            $admin->save();
            
            return redirect()->back()->with(['success' => __('admin/forms.updated_successfully')]);

        } catch (\Exception $ex) {
            // return message for unhandled exception
            return redirect()->back()->with(['error' => __('admin/forms.wrong')]);
        }
    }


    public function delete($id)
    {
        try {
            $admin = Admin::findOrFail($id);
            if (!$admin)
                return redirect()->route('admin.admins.index')->with(['error' => 'هذا المستخم غير موجود']);

            $admin->delete();

            return redirect()->back()->with(['success' => __('admin/forms.deleted_successfully')]);
        } catch (\Exception $ex) {
            return redirect()->back()->with(['error' => __('admin/forms.wrong')]);
        }
    }
}
