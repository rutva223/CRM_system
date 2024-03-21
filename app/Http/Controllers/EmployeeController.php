<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class EmployeeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        if (!in_array(Auth::user()->type, Auth::user()->not_emp_type) )
        {
            $employees = User::leftjoin('employees', 'users.id', '=', 'employees.user_id')
                        ->where('users.created_by', creatorId())->emp()
                        ->where('users.id', Auth::user()->id)
                        ->get();
            return view('hrm::employee.index', compact('employees'));
        }
        elseif(Auth::user()->can('employee manage'))
        {
            $employees = User::leftjoin('employees', 'users.id', '=', 'employees.user_id')
                        ->where('users.created_by', creatorId())->emp()
                        ->select('users.*','users.id as ID','employees.*', 'users.name as name', 'users.email as email', 'users.id as id')
                        ->get();
            return view('hrm::employee.index', compact('employees'));
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
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Employee $employee)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Employee $employee)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Employee $employee)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Employee $employee)
    {
        //
    }
}
