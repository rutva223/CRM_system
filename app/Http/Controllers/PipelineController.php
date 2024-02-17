<?php

namespace App\Http\Controllers;

use App\Models\ActivityLog;
use App\Models\ClientDeal;
use App\Models\Deal;
use App\Models\DealDiscussion;
use App\Models\DealFile;
use App\Models\DealTask;
use App\Models\Pipeline;
use App\Models\UserDeal;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class PipelineController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        if(Auth::user()->can('manage pipeline'))
        {
            $pipelines = Pipeline::where('created_by', '=', creatorId())->get();
            return view('pipelines.index',compact('pipelines'));
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
        if(Auth::user()->can('create pipeline'))
        {
            return view('pipelines.create');
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
        if(Auth::user()->can('create pipeline'))
        {

            $validator = Validator::make(
                $request->all(), [
                    'name' => 'required|max:20',
                ]
            );

            if($validator->fails())
            {
                $messages = $validator->getMessageBag();

                return redirect()->route('pipelines.index')->with('error', $messages->first());
            }

            $pipeline             = new Pipeline();
            $pipeline->name       = $request->name;
            $pipeline->created_by = creatorId();
            $pipeline->save();


            return redirect()->route('pipelines.index')->with('success', __('Pipeline successfully created!'));
        }
        else
        {
            return redirect()->back()->with('error', __('Permission Denied.'));
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Pipeline $pipeline)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Pipeline $pipeline)
    {
        if(Auth::user()->can('edit pipeline'))
        {
            if($pipeline->created_by == creatorId())
            {
                return view('pipelines.edit', compact('pipeline'));
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
    public function update(Request $request, Pipeline $pipeline)
    {
        if(Auth::user()->can('edit pipeline'))
        {

            if($pipeline->created_by == creatorId() )
            {

                $validator = Validator::make(
                    $request->all(), [
                        'name' => 'required|max:20',
                    ]
                );

                if($validator->fails())
                {
                    $messages = $validator->getMessageBag();

                    return redirect()->route('pipelines.index')->with('error', $messages->first());
                }

                $pipeline->name = $request->name;
                $pipeline->save();


                return redirect()->route('pipelines.index')->with('success', __('Pipeline successfully updated!'));
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
    public function destroy(Pipeline $pipeline)
    {
        if(Auth::user()->can('delete pipeline'))
        {

            if(count($pipeline->dealStages) == 0)
            {
                foreach($pipeline->dealStages as $dealStage)
                {
                    $deals = Deal::where('pipeline_id', '=', $pipeline->id)->where('stage_id', '=', $dealStage->id)->get();
                    foreach($deals as $deal)
                    {
                        DealDiscussion::where('deal_id', '=', $deal->id)->delete();
                        DealFile::where('deal_id', '=', $deal->id)->delete();
                        ClientDeal::where('deal_id', '=', $deal->id)->delete();
                        UserDeal::where('deal_id', '=', $deal->id)->delete();
                        DealTask::where('deal_id', '=', $deal->id)->delete();

                        $deal->delete();
                    }

                    $dealStage->delete();
                }

                $pipeline->delete();


                return redirect()->route('pipelines.index')->with('success', __('Pipeline successfully deleted!'));
            }
            else
            {
                return redirect()->route('pipelines.index')->with('error', __('There are some Stages and Deals on Pipeline, please remove it first!'));
            }

        }
        else
        {
            return redirect()->back()->with('error', __('Permission Denied.'));
        }
    }
}
