<?php

namespace App\Http\Controllers;

use App\Models\Deal;
use App\Models\Label;
use App\Models\Lead;
use App\Models\Pipeline;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class LabelController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        if(Auth::user()->can('manage labels'))
        {
            $labels    = Label::select('labels.*', 'pipelines.name as pipeline')
            ->join('pipelines', 'pipelines.id', '=', 'labels.pipeline_id')
            ->where('pipelines.created_by', '=', creatorId())
            ->where('labels.created_by', '=', creatorId())
            ->orderBy('labels.pipeline_id')->get();
            $pipelines = [];

            foreach($labels as $label)
            {
                if(!array_key_exists($label->pipeline_id, $pipelines))
                {
                    $pipelines[$label->pipeline_id]           = [];
                    $pipelines[$label->pipeline_id]['name']   = $label['pipeline'];
                    $pipelines[$label->pipeline_id]['labels'] = [];
                }
                $pipelines[$label->pipeline_id]['labels'][] = $label;
            }

            return view('labels.index')->with('pipelines', $pipelines);
        }
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        if(Auth::user()->can('create labels'))
        {
            $pipelines = Pipeline::where('created_by', '=', creatorId())->get()->pluck('name', 'id');
            $colors = Label::$colors;

            return view('labels.create')->with('pipelines', $pipelines)->with('colors', $colors);
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
        if(Auth::user()->can('create labels'))
        {

            $validator = Validator::make(
                $request->all(), [
                    'name' => 'required|max:20',
                    'pipeline_id' => 'required',
                    'color' => 'required',
                ]
            );

            if($validator->fails())
            {
                $messages = $validator->getMessageBag();

                return redirect()->route('labels.index')->with('error', $messages->first());
            }

            $label              = new Label();
            $label->name        = $request->name;
            $label->color       = $request->color;
            $label->pipeline_id = $request->pipeline_id;
            $label->created_by  = creatorId();
            $label->save();


            return redirect()->route('labels.index')->with('success', __('Label successfully created!'));
        }
        else
        {
            return redirect()->back()->with('error', __('Permission Denied.'));
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Label $label)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Label $label)
    {
        if(Auth::user()->can('edit labels'))
        {
            if($label->created_by == creatorId() )
            {
                $pipelines = Pipeline::where('created_by', '=', creatorId())->get()->pluck('name', 'id');
                $colors    = Label::$colors;

                return view('labels.edit', compact('label', 'pipelines', 'colors'));
            }
            else
            {
                return response()->json(['error' => __('Permission Denied.')], 401);
            }
        }
        else
        {
            return response()->json(['error' => __('Permission Denied.')], 401);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Label $label)
    {
        if(Auth::user()->can('edit labels'))
        {
            if($label->created_by == creatorId())
            {

                $validator = Validator::make(
                    $request->all(), [
                        'name' => 'required|max:20',
                        'pipeline_id' => 'required',
                        'color' => 'required',
                    ]
                );

                if($validator->fails())
                {
                    $messages = $validator->getMessageBag();

                    return redirect()->route('users')->with('error', $messages->first());
                }

                $label->name        = $request->name;
                $label->color       = $request->color;
                $label->pipeline_id = $request->pipeline_id;
                $label->save();


                return redirect()->route('labels.index')->with('success', __('Label successfully updated!'));
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
    public function destroy(Label $label)
    {
        if(Auth::user()->can('delete labels'))
        {
            if($label->created_by == creatorId())
            {
                // $lead = Lead::where('labels', '=', $label->id)->where('created_by',$label->created_by)->count();
                $lead = 0;
                $deal = Deal    ::where('labels', '=', $label->id)->where('created_by',$label->created_by)->count();
                if($lead == 0 && $deal == 0){

                    $label->delete();

                    return redirect()->route('labels.index')->with('success', __('Label successfully deleted!'));
                }
                else{
                    return redirect()->back()->with('error', __('There are some Lead and Deal on Label, please remove it first!'));
                }
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
}
