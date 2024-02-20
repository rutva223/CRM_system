<?php

namespace App\Http\Controllers;

use App\Models\DealType;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class DealTypeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        if(Auth::user()->can('manage dealtype'))
        {
            $dealtypes = DealType::where('created_by', '=', creatorId())->get();
            return view('deal_type.index',compact('dealtypes'));
        }
        else
        {
            return redirect()->back()->with('error', __('Permission Denied.'));
        }
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        if(Auth::user()->can('create dealtype'))
        {
            return view('deal_type.create');
        }
        else
        {
            return response()->json(['error' => __('Permission Denied.')], 401);
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        if(Auth::user()->can('create dealtype'))
        {

            $validator = Validator::make(
                $request->all(), [
                    'name' => 'required|max:20',
                ]
            );

            if($validator->fails())
            {
                $messages = $validator->getMessageBag();

                return redirect()->route('dealtypes.index')->with('error', $messages->first());
            }

            $dealType             = new DealType();
            $dealType->name       = $request->name;
            $dealType->created_by = creatorId();
            $dealType->save();


            return redirect()->route('dealtypes.index')->with('success', __('Deal Type successfully created!'));
        }
        else
        {
            return redirect()->back()->with('error', __('Permission Denied.'));
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(DealType $dealType)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        if(Auth::user()->can('edit dealtype'))
        {
                $dealType = DealType::find($id);
                return view('deal_type.edit', compact('dealType'));

        }
        else
        {
            return response()->json(['error' => __('Permission Denied.')], 401);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request,$id)
    {
        if(Auth::user()->can('edit dealtype'))
        {
            $dealType = DealType::find($id);
            if($dealType->created_by == creatorId() )
            {

                $validator = Validator::make(
                    $request->all(), [
                        'name' => 'required|max:20',
                    ]
                );

                if($validator->fails())
                {
                    $messages = $validator->getMessageBag();

                    return redirect()->route('dealtypes.index')->with('error', $messages->first());
                }

                $dealType->name = $request->name;
                $dealType->save();


                return redirect()->route('dealtypes.index')->with('success', __('Deal Type successfully updated!'));
            }
            else
            {
                return redirect()->back()->with('error', __('Permission Denied.'));
            }
        }
        else
        {
            return redirect()->back()->with('error', __('Permission Denied.'));
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        if(Auth::user()->can('delete dealtype'))
        {
            $dealType = DealType::find($id);
            if($dealType->created_by == creatorId())
            {

                $dealType->delete();


                return redirect()->route('dealtypes.index')->with('success', __('Deal Type successfully deleted!'));
            }
            else
            {
                return redirect()->route('dealtypes.index')->with('error', __('There are some Stages and Deals on Pipeline, please remove it first!'));
            }

        }
        else
        {
            return redirect()->back()->with('error', __('Permission Denied.'));
        }
    }
}
