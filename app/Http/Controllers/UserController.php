<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        if (Auth::user()->can('user manage')) {

            if(Session::has('user_type') == 'super admin')
            {
                $users_data = User::where('type','company')->get();
            }
            elseif(Session::has('user_type') == 'company'){
                $id =  Session()->get('user_id');
                $users_data = User::orderBy('id', 'desc')->where('created_by',$id)->get();

            }else{
                return redirect()->back()->with('error', __('Permission denied.'));
            }
            return view('user.index', compact('users_data'));

        } else  {
            return redirect()->back()->with('error', __('Permission denied.'));

        }
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        if (Auth::user()->can('user manage'))
        {
            $roles = Role::pluck('name','name');
            return view('user.create',compact('roles'));

        }else{
            return response()->json(['error' => __('Permission denied.')], 401);
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        if(Auth::user()->can('user create'))
        {
            $validatorArray = [
                'name' => 'required|max:120',
                'email' => 'required|em ail|max:100|unique:users,email',
                'password' => 'required|min:6',
            ];
            $validator = Validator::make(
                $request->all(), $validatorArray
            );
            if($validator->fails())
            {
                return redirect()->back()->with('error', $validator->errors()->first());
            }
            if(Session::has('user_type') == 'super admin')
            {
                $roles = Role::findByName('company');
            }
            else
            {
                $roles = Role::find($request->input('roles'));
            }
            $userpassword       = $request->input('password');
            $user['name']       = $request->input('name');
            $user['email']      = $request->input('email');
            $user['password']   = !empty($userpassword) ? Hash::make($userpassword) : null;
            $user['lang']       =  'en';
            $user['type']       = $roles->name;
            $user['created_by'] = creatorId();
            $user = User::create($user);
            $user->assignRole($roles);

            return redirect()->route('users.index')->with('success','User created successfully');
        }else{
            return redirect()->back()->with('error', __('Permission denied.'));

        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        return redirect()->route('users.index');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        if(Auth::user()->can('user edit'))
        {
            $user = User::find($id);
            $roles = Role::pluck('name','name')->all();
            $userRole = $user->roles->pluck('name','name')->all();

            return view('user.edit',compact('user','roles','userRole'));
        }
        else
        {
            return response()->json(['error' => __('Permission denied.')], 401);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        if(Auth::user()->can('user edit'))
        {
            $validator = Validator::make(
                $request->all(), [
                                'name' => 'required',
                                'email' => 'required|email|unique:users,email,' . $id,
                            ]
            );
            if($validator->fails())
            {
                $messages = $validator->getMessageBag();

                return redirect()->back()->with('error', $messages->first());
            }

            $user          = User::find($id);
            if(!empty($user))
            {
                if(Session::has('user_type') == 'super admin')
                {
                    $role = Role::findByName('company');
                }
                else
                {
                    $role = Role::find($request->input('roles'));
                }
                $user->name = $request->name;
                $user->email = $request->email;
                $user->type = $role->name;
                $user->save();
                if(Session::has('user_type') != 'super admin')
                {
                    $roles[] = $request->roles;
                    $user->roles()->sync($roles);
                }
                return redirect()->route('users.index')->with('success','User updated successfully');
            }
            return redirect()->back()->with('error', __('Something is wrong.'));

        }
        else {
            return redirect()->back()->with('error', __('Permission denied.'));
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        if(Auth::user()->can('user delete'))
        {
            $user = User::findOrFail($id);
            try
            {
                // get all table
                $tables_in_db = \DB::select('SHOW TABLES');
                $db = "Tables_in_".env('DB_DATABASE');
                foreach($tables_in_db as $table)
                {
                    if (Schema::hasColumn($table->{$db}, 'created_by'))
                    {
                        \DB::table($table->{$db})->where('created_by', $user->id)->delete();
                    }
                }
                $user->delete();
            }
            catch (\Exception $e)
            {
                return redirect()->back()->with('error', __($e->getMessage()));
            }

            return redirect()->route('users.index')
                            ->with('success','User deleted successfully');
        }
    }
}
