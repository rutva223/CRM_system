<?php

namespace App\Http\Controllers;

use App\Models\Deal;
use App\Models\DealStage;
use App\Models\Pipeline;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class DealStageController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        if (Auth::user()->can('manage dealstages')) {
            $stages    = DealStage::select('deal_stages.*', 'pipelines.name as pipeline')
                ->join('pipelines', 'pipelines.id', '=', 'deal_stages.pipeline_id')
                ->where('pipelines.created_by', '=', creatorId())
                ->where('deal_stages.created_by', '=', creatorId())
                ->orderBy('deal_stages.pipeline_id')
                ->orderBy('deal_stages.order')
                ->get();
            $pipelines = [];

            foreach ($stages as $stage) {
                if (!array_key_exists($stage->pipeline_id, $pipelines)) {
                    $pipelines[$stage->pipeline_id]           = [];
                    $pipelines[$stage->pipeline_id]['name']   = $stage['pipeline'];
                    $pipelines[$stage->pipeline_id]['stages'] = [];
                }
                $pipelines[$stage->pipeline_id]['stages'][] = $stage;
            }

            return view('deal_stages.index')->with('pipelines', $pipelines);
        } else {
            return redirect()->back()->with('error', __('Permission Denied.'));
        }
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        if (Auth::user()->can('create dealstages')) {
            $pipelines = Pipeline::where('created_by', '=', creatorId())->get()->pluck('name', 'id');

            return view('deal_stages.create')->with('pipelines', $pipelines);
        } else {
            return response()->json(['error' => __('Permission Denied.')], 401);
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        if (Auth::user()->can('dealstages create')) {
            $validator = Validator::make(
                $request->all(),
                [
                    'name' => 'required|max:20',
                    'pipeline_id' => 'required',
                ]
            );

            if ($validator->fails()) {
                $messages = $validator->getMessageBag();

                return redirect()->route('stages.index')->with('error', $messages->first());
            }
            $stage              = new DealStage();
            $stage->name        = $request->name;
            $stage->pipeline_id = $request->pipeline_id;
            $stage->created_by  = creatorId();
            $stage->save();


            return redirect()->route('deal-stages.index')->with('success', __('Deal Stage successfully created!'));
        } else {
            return redirect()->back()->with('error', __('Permission Denied.'));
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(DealStage $dealStage)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(DealStage $dealStage)
    {
        if (Auth::user()->can('edit dealstages')) {
            if ($dealStage->created_by == creatorId() ) {
                $pipelines = Pipeline::where('created_by', '=', creatorId())->get()->pluck('name', 'id');

                return view('deal_stages.edit', compact('dealStage', 'pipelines'));
            } else {
                return response()->json(['error' => __('Permission Denied.')], 401);
            }
        } else {
            return response()->json(['error' => __('Permission Denied.')], 401);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, DealStage $dealStage)
    {
        if (Auth::user()->can('edit dealstages')) {

            if ($dealStage->created_by == creatorId() ) {

                $validator = Validator::make(
                    $request->all(),
                    [
                        'name' => 'required|max:20',
                        'pipeline_id' => 'required',
                    ]
                );

                if ($validator->fails()) {
                    $messages = $validator->getMessageBag();

                    return redirect()->route('deal-stages.index')->with('error', $messages->first());
                }

                $dealStage->name        = $request->name;
                $dealStage->pipeline_id = $request->pipeline_id;
                $dealStage->save();


                return redirect()->route('deal-stages.index')->with('success', __('Deal Stage successfully updated!'));
            } else {
                return redirect()->back()->with('error', __('Permission Denied.'));
            }
        } else {
            return redirect()->back()->with('error', __('Permission Denied.'));
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(DealStage $dealStage)
    {
        if (Auth::user()->can('dealstages delete')) {
            if ($dealStage->created_by == creatorId()) {
                $deals = Deal::where('stage_id', '=', $dealStage->id)->where('created_by', '=', $dealStage->created_by)->count();

                if ($deals == 0) {
                    $dealStage->delete();

                    return redirect()->route('deal-stages.index')->with('success', __('Deal Stage successfully deleted!'));
                } else {
                    return redirect()->route('deal-stages.index')->with('error', __('There are some deals on stage, please remove it first!'));
                }
            } else {
                return redirect()->back()->with('error', __('Permission Denied.'));
            }
        } else {
            return redirect()->back()->with('error', __('Permission Denied.'));
        }
    }

    public function order(Request $request)
    {
        $post = $request->all();
        foreach ($post['order'] as $key => $item) {
            $stage        = DealStage::where('id', '=', $item)->first();
            $stage->order = $key;
            $stage->save();


        }
    }

    public function json(Request $request)
    {
        $stage = new DealStage();
        if ($request->pipeline_id) {
            $stage = $stage->where('pipeline_id', '=', $request->pipeline_id);
            $stage = $stage->get()->pluck('name', 'id');
        } else {
            $stage = [];
        }

        return response()->json($stage);
    }
}
