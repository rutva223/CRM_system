<?php

namespace App\Http\Controllers;

use App\Models\Branch;
use App\Models\Department;
use App\Models\Designation;
use App\Models\Employee;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class BranchController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        if(Auth::user()->can('manage branch'))
        {
            $branches = Branch::where('created_by', '=', creatorId())->get();
            return view('branch.index',compact('branches'));
        }
        else
        {
            return redirect()->back()->with('error', __('Permission denied.'));
        }
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        if(Auth::user()->can('branch create'))
        {
            return view('branch.create');
        }
        else
        {
            return response()->json(['error' => __('Permission denied.')], 401);
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        if(Auth::user()->can('branch create'))
        {
            $validator = Validator::make(
                $request->all(), [
                                   'name' => 'required',
                                   'email' => 'required',
                                   'phone' => 'required',
                                   'address' => 'required',
                                   'status' => 'required',
                               ]
            );
            if($validator->fails())
            {
                $messages = $validator->getMessageBag();

                return redirect()->back()->with('error', $messages->first());
            }

            $branch                 = new Branch();
            $branch->name           = $request->name;
            $branch->email          = $request->email;
            $branch->phone          = $request->phone;
            $branch->address        = $request->address;
            $branch->status         = $request->status;
            $branch->created_by     = creatorId();
            $branch->save();


            return redirect()->route('branch.index')->with('success', __('Branch  successfully created.'));
        }
        else
        {
            return redirect()->back()->with('error', __('Permission denied.'));
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Branch $branch)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Branch $branch)
    {
        if(Auth::user()->can('branch edit'))
        {
            if($branch->created_by == creatorId() )
            {
                return view('branch.edit', compact('branch'));
            }
            else
            {
                return redirect()->back()->with('error', __('Permission denied.'));
            }
        }
        else
        {
            return response()->json(['error' => __('Permission denied.')], 401);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Branch $branch)
    {
        if(Auth::user()->can('branch edit'))
        {
            if($branch->created_by == creatorId() )
            {
                $validator = Validator::make(
                    $request->all(), [
                        'name' => 'required',
                        'email' => 'required',
                        'phone' => 'required',
                        'address' => 'required',
                        'status' => 'required',
                                   ]
                );
                if($validator->fails())
                {
                    $messages = $validator->getMessageBag();

                    return redirect()->back()->with('error', $messages->first());
                }

                $branch->name           = $request->name;
                $branch->email          = $request->email;
                $branch->phone          = $request->phone;
                $branch->address        = $request->address;
                $branch->status         = $request->status;
                $branch->save();


                return redirect()->route('branch.index')->with('success', __('Branch successfully updated.'));
            }
            else
            {
                return redirect()->back()->with('error', __('Permission denied.'));
            }
        }
        else
        {
            return redirect()->back()->with('error', __('Permission denied.'));
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Branch $branch)
    {
        if(Auth::user()->can('branch delete'))
        {
            if($branch->created_by == creatorId() )
            {
                $employee     = Employee::where('branch_id',$branch->id)->get();
                if(count($employee) == 0)
                {
                    Department::where('branch_id',$branch->id)->delete();
                    Designation::where('branch_id',$branch->id)->delete();


                    $branch->delete();
                }
                else
                {
                    return redirect()->route('branch.index')->with('error', __('This branch has employees. Please remove the employee from this branch.'));
                }

                return redirect()->route('branch.index')->with('success', __('Branch successfully deleted.'));
            }
            else
            {
                return redirect()->back()->with('error', __('Permission denied.'));
            }
        }
        else
        {
            return redirect()->back()->with('error', __('Permission denied.'));
        }
    }

    public function BranchNameEdit()
    {
        if(Auth::user()->can('branch name edit'))
        {
            return view('branch.branchnameedit');
        }
        else
        {
            return response()->json(['error' => __('Permission denied.')], 401);
        }
    }
    public function saveBranchName(Request $request)
    {
        if(Auth::user()->can('branch name edit'))
        {
            $validator = \Validator::make($request->all(),
            [
                'hrm_branch_name' => 'required',
            ]);

            if($validator->fails()){
                $messages = $validator->getMessageBag();
                return redirect()->back()->with('error', $messages->first());
            }
            else
            {
                $userContext = new Context(['user_id' => creatorId(),'workspace_id'=>getActiveWorkSpace()]);
                \Settings::context($userContext)->set('hrm_branch_name', $request->hrm_branch_name);

                return redirect()->route('branch.index')->with('success', __('Branch Name successfully updated.'));
            }
        }
        else
        {
            return redirect()->back()->with('error', __('Permission denied.'));
        }
    }
}
