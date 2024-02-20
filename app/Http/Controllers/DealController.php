<?php

namespace App\Http\Controllers;

use App\Models\Deal;
use App\Models\DealStage;
use App\Models\EntitiesUser;
use App\Models\Pipeline;
use App\Models\ClientDeal;
use App\Models\DealType;
use App\Models\Source;
use App\Models\User;
use App\Models\UserDeal;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;

class DealController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        {
            $usr = Auth::user();
            $user = User::find($usr->id);
            if ($usr->can('manage deal')) {
                if ($usr->default_pipeline) {
                    $pipeline = Pipeline::where('created_by', '=', creatorId())->where('id', '=', $usr->default_pipeline)->first();
                    if (!$pipeline) {
                        $pipeline = Pipeline::where('created_by', '=', creatorId())->first();
                    }
                } else {
                    $pipeline = Pipeline::where('created_by', '=', creatorId())->first();
                }

                $pipelines = Pipeline::where('created_by', '=', creatorId())->get()->pluck('name', 'id');
                if (Auth::user()->type == 'client') {
                    $id_deals = $user->clientDeals->pluck('id');
                } else {
                    $id_deals = $user->deals->pluck('id');
                }
                if (!empty($pipeline)) {
                    $deals       = Deal::whereIn('id', $id_deals)->where('pipeline_id', '=', $pipeline->id)->get();
                    $curr_month  = Deal::whereIn('id', $id_deals)->where('pipeline_id', '=', $pipeline->id)->whereMonth('created_at', '=', date('m'))->get();
                    $curr_week   = Deal::whereIn('id', $id_deals)->where('pipeline_id', '=', $pipeline->id)->whereBetween(
                        'created_at',
                        [
                            \Carbon\Carbon::now()->startOfWeek(),
                            \Carbon\Carbon::now()->endOfWeek(),
                        ]
                    )->get();
                    $last_30days = Deal::whereIn('id', $id_deals)->where('pipeline_id', '=', $pipeline->id)->whereDate('created_at', '>', \Carbon\Carbon::now()->subDays(30))->get();
                } else {
                    return redirect()->back()->with('error', __('Please Create Pipeline'));
                }
                // Deal Summary
                $cnt_deal                = [];
                $cnt_deal['total']       = Deal::getDealSummary($deals);
                $cnt_deal['this_month']  = Deal::getDealSummary($curr_month);
                $cnt_deal['this_week']   = Deal::getDealSummary($curr_week);
                $cnt_deal['last_30days'] = Deal::getDealSummary($last_30days);

                return view('deal.index', compact('pipelines', 'pipeline', 'cnt_deal'));
            } else {
                return redirect()->back()->with('error', __('Permission Denied.'));
            }
        }

    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request)
    {

        if (Auth::user()->can('create deal')) {
            $id = Session::get('user_id') ?? Auth::user()->id;
            $users = User::where('created_by',$id)->get()->pluck('name','id');
            $deal_stage= DealStage::where('created_by',$id)->get()->pluck('name','id');
            $pipeline= Pipeline::where('created_by',$id)->get()->pluck('name','id');
            $dealtype= DealType::where('created_by',$id)->get()->pluck('name','id');
            $priority= Deal::$priority;
            $select_stage = $request->stage;
            $user =  User::where('id',$id)->first();
            $select_pipeline =$user->default_pipeline;
            return view('deal.create',compact('users','deal_stage','select_stage','pipeline','select_pipeline','dealtype','priority'));
        } else {
            return response()->json(['error' => __('Permission denied.')], 401);
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $usr = Auth::user();
        if ($usr->can('create deal')) {
            $validator = Validator::make(
                $request->all(),
                [
                    'name' => 'required',
                    'user' => 'required',
                    'pipeline' => 'required',
                    'stage_id' => 'required',
                ]
            );

            if ($validator->fails()) {
                $messages = $validator->getMessageBag();

                return redirect()->back()->with('error', $messages->first());
            }

            // Default Field Value
            if ($usr->default_pipeline) {
                $pipeline = Pipeline::where('created_by', '=', creatorId())->where('id', '=', $usr->default_pipeline)->first();
                if (!$pipeline) {
                    $pipeline = Pipeline::where('created_by', '=', creatorId())->first();
                }
            } else {
                $pipeline = Pipeline::where('created_by', '=', creatorId())->first();

            }
            if($pipeline){

                $stage = DealStage::where('pipeline_id', '=', $pipeline->id)->first();

            }
            // End Default Field Value

            // Check if stage are available or not in pipeline.

            if (empty($stage)) {
                return redirect()->back()->with('error', __('Please Create Stage for This Pipeline.'));
            } else {
                $deal       = new Deal();
                $deal->name = $request->name;
                if (empty($request->amount)) {
                    $deal->amount = 0;
                } else {
                    $deal->amount = $request->amount;
                }
                $deal->pipeline_id = $request->pipeline ?? $pipeline->id;
                $deal->stage_id    = $request->stage_id ?? $stage->id;
                $deal->close_date    = $request->close_date ;
                $deal->priority     = $request->priority ?? 'Medium' ;
                $deal->status      = 'Active';
                $deal->created_by  = creatorId();
                $deal->save();

                // $clients = User::whereIN('id', array_filter($request->clients))->get()->pluck('email', 'id')->toArray();
                $clients = User::where('id', $request->user)->first();

                // foreach (array_keys($clients) as $client) {
                    ClientDeal::create(
                        [
                            'deal_id' => $deal->id,
                            'client_id' => $clients->id,
                        ]
                    );
                // }
                UserDeal::create(
                    [
                        'user_id' => creatorId(),
                        'deal_id' => $deal->id,
                    ]
                );

                $resp = null;
                $resp['is_success'] = true;
                return redirect()->back()->with('success', __('Deal successfully created!') . (($resp['is_success'] == false && !empty($resp['error'])) ? '<br> <span class="text-danger">' . $resp['error'] . '</span>' : ''));
            }
        } else {
            return redirect()->back()->with('error', __('Permission Denied.'));
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Deal $deal)
    {
        {
            if ($deal->is_active) {
                $transdate = date('Y-m-d', time());
                $calenderTasks = [];
                if (Auth::user()->can('show deal task')) {
                    foreach ($deal->tasks as $task) {
                        $calenderTasks[] = [
                            'title' => $task->name,
                            'start' => $task->date,
                            'url' => route(
                                'deals.tasks.show',
                                [
                                    $deal->id,
                                    $task->id,
                                ]
                            ),
                            'className' => ($task->status) ? 'event-success border-success' : 'event-warning border-warning',
                        ];
                    }
                }
                $permission = [];
                if (Auth::user()->type == 'client') {
                    if ($permission) {
                        $permission = explode(',', $permission->permissions);
                    } else {
                        $permission = [];
                    }
                }
                return view('deal.show', compact('deal', 'transdate', 'calenderTasks', 'permission'));
            } else {
                return redirect()->back()->with('error', __('Permission Denied.'));
            }
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Deal $deal)
    {
        if (Auth::user()->can('deal edit')) {
            if ($deal->created_by == creatorId()) {
                $pipelines = Pipeline::where('created_by', '=', creatorId())->get()->pluck('name', 'id');
                $pipelines->prepend(__('Select Pipeline'), '');
                $sources = Source::where('created_by', '=', creatorId())->get()->pluck('name', 'id');
                $sources->prepend(__('Select Sources'), '');
                $products = ['Select Products'];
                // if (module_is_active('ProductService')) {
                //     $products = ProductService::where('created_by', '=', creatorId())->get()->pluck('name', 'id');
                //     $products->prepend(__('Select Products'), '');
                // }
                $deal->sources  = explode(',', $deal->sources);
                $deal->products = explode(',', $deal->products);

                return view('deal.edit', compact('deal', 'pipelines', 'sources', 'products', 'customFields'));
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
    public function update(Request $request, Deal $deal)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Deal $deal)
    {
        //
    }
}
