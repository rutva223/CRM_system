<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;

class RoleController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        if (Auth::user()->can('manage roles')) {
            $roles = Role::where('created_by', '=', Auth::user()->creatorId())->get();
            return view('role.index')->with('roles', $roles);
        } else {
            return redirect()->back()->with('error', __('Permission denied.'));
        }
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        if (Auth::user()->can('create roles')) {
            $permissions = Permission::all()->pluck('name', 'id')->toArray();
            return view('role.create', compact('permissions'));
        } else {
            return redirect()->back()->with('error', __('Permission denied.'));
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        if (Auth::user()->can('create roles')) {
            $validator = Validator::make(
                $request->all(),
                [
                    'name' => 'required|max:100|unique:roles,name,NULL,id,created_by,' . creatorId(),
                    'permissions' => 'required',
                ]
            );

            if ($validator->fails()) {
                $messages = $validator->getMessageBag();
                return redirect()->back()->with('error', $messages->first());
            }

            $name             = $request['name'];
            $role             = new Role();
            $role->name       = $name;
            $role->created_by = creatorId();
            $permissions      = $request['permissions'];
            $role->save();

            foreach ($permissions as $permission) {
                $p = Permission::where('id', '=', $permission)->firstOrFail();
                $role->givePermissionTo($p);
            }

            return redirect()->back()->with('success', __('Role successfully created.'));
        } else {
            return redirect()->back()->with('error', __('Permission denied.'));
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Role $role)
    {
        if (Auth::user()->can('edit roles')) {
            $permissions = Permission::all()->pluck('name', 'id')->toArray();

            return view('role.edit', compact('role', 'permissions'));
        } else {
            return redirect()->back()->with('error', __('Permission denied.'));
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Role $role)
    {
        if(Auth::user()->can('edit roles'))
        {
            $validator = Validator::make(
                $request->all(),
                [
                    'name' => 'max:100|unique:roles,name,NULL,id,created_by,',
                    'permissions' => 'required',
                ]
            );
            if ($validator->fails()) {
                $messages = $validator->getMessageBag();

                return redirect()->back()->with('error', $messages->first());
            }

            $input       = $request->except(['permissions']);
            $permissions = $request['permissions'];
            $role->fill($input)->save();

            $p_all = Permission::all();

            foreach ($p_all as $p) {
                $role->revokePermissionTo($p);
            }

            foreach ($permissions as $permission) {
                $p = Permission::where('id', '=', $permission)->firstOrFail();
                $role->givePermissionTo($p);
            }

            return redirect()->back()->with('success', __('Role successfully updated.'));
        } else {
            return redirect()->back()->with('error', 'Permission denied.');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        if(Auth::user()->can('delete roles')) {
            Role::find($id)->delete();
            return redirect()->route('roles.index')
                ->with('success', 'User deleted successfully');
        } else {
            return redirect()->back()->with('error', 'Permission denied.');
        }
    }
}
