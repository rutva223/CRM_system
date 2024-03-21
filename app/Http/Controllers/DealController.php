<?php

namespace App\Http\Controllers;

use App\Models\Deal;
use App\Models\DealStage;
use App\Models\EntitiesUser;
use App\Models\Pipeline;
use App\Models\ClientDeal;
use App\Models\DealActivityLog;
use App\Models\DealCall;
use App\Models\DealEmail;
use App\Models\DealFile;
use App\Models\DealMeeting;
use App\Models\DealType;
use App\Models\Label;
use App\Models\Source;
use App\Models\User;
use App\Models\UserDeal;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;

class DealController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    { {
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
            $users = User::where('created_by', $id)->get()->pluck('name', 'id');
            $deal_stage = DealStage::where('created_by', $id)->get()->pluck('name', 'id');
            $pipeline = Pipeline::where('created_by', $id)->get()->pluck('name', 'id');
            $dealtype = DealType::where('created_by', $id)->get()->pluck('name', 'id');
            $priority = Deal::$priority;
            $select_stage = $request->stage;
            $user =  User::where('id', $id)->first();
            $select_pipeline = $user->default_pipeline;
            return view('deal.create', compact('users', 'deal_stage', 'select_stage', 'pipeline', 'select_pipeline', 'dealtype', 'priority'));
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
                    'pipeline_id' => 'required',
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
            if ($pipeline) {

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
                $deal->pipeline_id = $request->pipeline_id ?? $pipeline->id;
                $deal->stage_id    = $request->stage_id ?? $stage->id;
                $deal->close_date    = $request->close_date;
                $deal->priority     = $request->priority ?? 'Medium';
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
    { {
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
        if (Auth::user()->can('edit deal')) {
            if ($deal->created_by == creatorId()) {
                $pipelines = Pipeline::where('created_by', '=', creatorId())->get()->pluck('name', 'id');
                $pipelines->prepend(__('Select Pipeline'), '');
                $sources = Source::where('created_by', '=', creatorId())->get()->pluck('name', 'id');
                $sources->prepend(__('Select Sources'), '');
                $products = ['Select Products'];
                $priority = Deal::$priority;

                // if (module_is_active('ProductService')) {
                //     $products = ProductService::where('created_by', '=', creatorId())->get()->pluck('name', 'id');
                //     $products->prepend(__('Select Products'), '');
                // }
                $deal->sources  = explode(',', $deal->sources);
                $deal->products = explode(',', $deal->products);

                return view('deal.edit', compact('deal', 'pipelines', 'sources', 'products', 'priority'));
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
        if (Auth::user()->can('edit deal')) {
            if ($deal->created_by == creatorId()) {
                $validator = Validator::make(
                    $request->all(),
                    [
                        'name' => 'required',
                        'pipeline_id' => 'required',
                        'amount' => 'min:0',
                        'stage_id' => 'required',
                        'priority' => 'required',
                    ]
                );

                if ($validator->fails()) {
                    $messages = $validator->getMessageBag();

                    return redirect()->back()->with('error', $messages->first());
                }

                $deal->name = $request->name;
                if (empty($request->amount)) {
                    $deal->amount = 0;
                } else {
                    $deal->amount = $request->amount;
                }
                $deal->pipeline_id = $request->pipeline_id;
                $deal->stage_id    = $request->stage_id;
                $deal->priority    = $request->priority;
                // $deal->phone       = $request->phone;
                // $deal->sources     = implode(",", array_filter($request->sources));
                // $deal->products    = implode(",", array_filter($request->products));
                $deal->notes       = $request->notes;
                $deal->save();


                return redirect()->back()->with('success', __('Deal successfully updated!'));
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
    public function destroy(Deal $deal)
    {
    }

    public function order(Request $request)
    {
        $usr = Auth::user();
        if ($usr->can('move deal')) {
            $post       = $request->all();
            $deal       = Deal::find($post['deal_id']);
            $clients    = ClientDeal::select('client_id')->where('deal_id', '=', $deal->id)->get()->pluck('client_id')->toArray();
            $deal_users = $deal->users->pluck('id')->toArray();
            $usrs       = User::whereIN('id', array_merge($deal_users, $clients))->get()->pluck('email', 'id')->toArray();
            if ($deal->stage_id != $post['stage_id']) {
                $newStage = DealStage::find($post['stage_id']);
                DealActivityLog::create(
                    [
                        'user_id' => $usr->id,
                        'deal_id' => $deal->id,
                        'log_type' => 'Move',
                        'remark' => json_encode(
                            [
                                'title' => $deal->name,
                                'old_status' => $deal->stage->name,
                                'new_status' => $newStage->name,
                            ]
                        ),
                    ]
                );
            }
            foreach ($post['order'] as $key => $item) {
                if($key){

                    $deal           = Deal::find($item);
                    $deal->order    = $key;
                    $deal->stage_id = $post['stage_id'];
                    $deal->save();
                }
            }
        } else {
            return response()->json(['error' => __('Permission Denied.')], 401);
        }
    }

    public function ContactAssign($id)
    {
        if (Auth::user()->can('edit deal')) {
            $deal = Deal::find($id);

            if ($deal->created_by == creatorId()) {
                $clients = User::where('created_by', '=', creatorId())->where('type', '=', 'client')->whereNOTIn(
                    'id',
                    function ($q) use ($deal) {
                        $q->select('client_id')->from('client_deals')->where('deal_id', '=', $deal->id);
                    }
                )->get()->pluck('name', 'id');
                return view('deal.clients', compact('deal', 'clients'));
            } else {
                return response()->json(['error' => __('Permission Denied.')], 401);
            }
            $deal = Deal::find($id);
            return view('deal.contact_assign');
        } else {
            return response()->json(['error' => __('Permission Denied.')], 401);
        }
    }

    public function DealContactUpdate($id, Request $request)
    {
        if (Auth::user()->can('edit deal')) {
            $deal = Deal::find($id);
            if ($deal->created_by == creatorId()) {
                if (!empty($request->clients)) {
                    // $clients = array_filter($request->clients);
                    // foreach ($clients as $client) {
                    ClientDeal::create(
                        [
                            'deal_id' => $deal->id,
                            'client_id' => $request->clients,
                        ]
                    );
                    // }
                }


                if (!empty($request->clients)) {
                    return redirect()->back()->with('success', __('Clients successfully updated!'))->with('status', 'clients');
                } else {
                    return redirect()->back()->with('error', __('Please Select Valid Clients!'))->with('status', 'clients');
                }
            } else {
                return redirect()->back()->with('error', __('Permission Denied.'))->with('status', 'clients');
            }
        } else {
            return redirect()->back()->with('error', __('Permission Denied.'))->with('status', 'clients');
        }
    }
    public function noteStore($id, Request $request)
    {
        if (Auth::user()->can('edit deal')) {
            $deal = Deal::find($id);
            if ($deal->created_by == creatorId()) {
                $deal->name = $request->name;
                $deal->notes = $request->notes;
                $deal->save();

                return redirect()->back()->with('success', __('Note successfully saved!'));
            } else {
                return redirect()->back()->with('error', __('Permission Denied'));
            }
        } else {
            return redirect()->back()->with('error', __('Permission Denied'));
        }
    }

    // Deal Calls
    public function callCreate($id)
    {
        if (Auth::user()->can('create deal call')) {
            $deal = Deal::find($id);
            if ($deal->created_by == creatorId()) {
                $users = UserDeal::where('deal_id', '=', $deal->id)->get();

                return view('deal.calls', compact('deal', 'users'));
            } else {
                return response()->json(
                    [
                        'is_success' => false,
                        'error' => __('Permission Denied.'),
                    ],
                    401
                );
            }
        } else {
            return response()->json(
                [
                    'is_success' => false,
                    'error' => __('Permission Denied.'),
                ],
                401
            );
        }
    }

    public function callStore($id, Request $request)
    {
        $usr = Auth::user();

        if ($usr->can('create deal call')) {
            $deal = Deal::find($id);
            if ($deal->created_by == creatorId()) {
                $validator = Validator::make(
                    $request->all(),
                    [
                        'subject' => 'required',
                        'call_type' => 'required',
                        'user_id' => 'required',
                        'duration' => 'required',
                    ]
                );

                if ($validator->fails()) {
                    $messages = $validator->getMessageBag();

                    return redirect()->back()->with('error', $messages->first());
                }

                DealCall::create(
                    [
                        'deal_id' => $deal->id,
                        'subject' => $request->subject,
                        'call_type' => $request->call_type,
                        'duration' => $request->duration,
                        'user_id' => $request->user_id,
                        'description' => $request->description,
                        'call_result' => $request->call_result,
                    ]
                );

                DealActivityLog::create(
                    [
                        'user_id' => $usr->id,
                        'deal_id' => $deal->id,
                        'log_type' => 'Create Deal Call',
                        'remark' => json_encode(['title' => 'Create new Deal Call']),
                    ]
                );

                $dealArr = [
                    'deal_id' => $deal->id,
                    'name' => $deal->name,
                    'updated_by' => $usr->id,
                ];


                return redirect()->back()->with('success', __('Call successfully created!'))->with('status', 'calls');
            } else {
                return redirect()->back()->with('error', __('Permission Denied.'))->with('status', 'calls');
            }
        } else {
            return redirect()->back()->with('error', __('Permission Denied.'))->with('status', 'calls');
        }
    }

    public function callEdit($id, $call_id)
    {
        if (Auth::user()->can('edit deal call')) {
            $deal = Deal::find($id);
            if ($deal->created_by == creatorId()) {
                $call  = DealCall::find($call_id);
                $users = UserDeal::where('deal_id', '=', $deal->id)->get();

                return view('deal.calls', compact('call', 'deal', 'users'));
            } else {
                return response()->json(
                    [
                        'is_success' => false,
                        'error' => __('Permission Denied.'),
                    ],
                    401
                );
            }
        } else {
            return response()->json(
                [
                    'is_success' => false,
                    'error' => __('Permission Denied.'),
                ],
                401
            );
        }
    }

    public function callUpdate($id, $call_id, Request $request)
    {
        if (Auth::user()->can('edit deal call')) {
            $deal = Deal::find($id);
            if ($deal->created_by == creatorId()) {
                $validator = Validator::make(
                    $request->all(),
                    [
                        'subject' => 'required',
                        'call_type' => 'required',
                        'user_id' => 'required',
                    ]
                );

                if ($validator->fails()) {
                    $messages = $validator->getMessageBag();

                    return redirect()->back()->with('error', $messages->first());
                }

                $call = DealCall::find($call_id);

                $call->update(
                    [
                        'subject' => $request->subject,
                        'call_type' => $request->call_type,
                        'duration' => $request->duration,
                        'user_id' => $request->user_id,
                        'description' => $request->description,
                        'call_result' => $request->call_result,
                    ]
                );


                return redirect()->back()->with('success', __('Call successfully updated!'))->with('status', 'calls');
            } else {
                return redirect()->back()->with('error', __('Permission Denied.'))->with('status', 'calls');
            }
        } else {
            return redirect()->back()->with('error', __('Permission Denied.'))->with('status', 'tasks');
        }
    }
    public function callDestroy($id, $call_id)
    {
        if (Auth::user()->can('delete deal call')) {
            $deal = Deal::find($id);
            if ($deal->created_by == creatorId()) {
                $task = DealCall::find($call_id);
                $task->delete();


                return redirect()->back()->with('success', __('Call successfully deleted!'))->with('status', 'calls');
            } else {
                return redirect()->back()->with('error', __('Permission Denied.'))->with('status', 'calls');
            }
        } else {
            return redirect()->back()->with('error', __('Permission Denied.'))->with('status', 'calls');
        }
    }
    // Deal meeting
    public function meetingCreate($id)
    {
        if (Auth::user()->can('create deal meeting')) {
            $deal = Deal::find($id);
            $status = DealMeeting::$status;
            if ($deal->created_by == creatorId()) {
                $users = UserDeal::where('deal_id', '=', $deal->id)->get();

                return view('deal.meeting', compact('deal', 'users','status'));
            } else {
                return response()->json(
                    [
                        'is_success' => false,
                        'error' => __('Permission Denied.'),
                    ],
                    401
                );
            }
        } else {
            return response()->json(
                [
                    'is_success' => false,
                    'error' => __('Permission Denied.'),
                ],
                401
            );
        }
    }

    public function meetingStore($id, Request $request)
    {
        $usr = Auth::user();

        if ($usr->can('create deal meeting')) {
            $deal = Deal::find($id);
            if ($deal->created_by == creatorId()) {
                $validator = Validator::make(
                    $request->all(),
                    [
                        'subject' => 'required',
                        'user_id' => 'required',
                        'duration' => 'required',
                    ]
                );

                if ($validator->fails()) {
                    $messages = $validator->getMessageBag();

                    return redirect()->back()->with('error', $messages->first());
                }

                DealMeeting::create(
                    [
                        'deal_id' => $deal->id,
                        'subject' => $request->subject,
                        'duration' => $request->duration,
                        'user_id' => $request->user_id,
                        'description' => $request->description,
                        'status' => $request->call_result,
                    ]
                );

                DealActivityLog::create(
                    [
                        'user_id' => $usr->id,
                        'deal_id' => $deal->id,
                        'log_type' => 'Create Meeting',
                        'remark' => json_encode(['title' => 'Create new Deal Meeting']),
                    ]
                );

                return redirect()->back()->with('success', __('Meeting successfully created!'))->with('status', 'meeting');
            } else {
                return redirect()->back()->with('error', __('Permission Denied.'))->with('status', 'meeting');
            }
        } else {
            return redirect()->back()->with('error', __('Permission Denied.'))->with('status', 'meeting');
        }
    }

    public function meetingEdit($id, $meeting_id)
    {
        if (Auth::user()->can('edit deal meeting')) {
            $deal = Deal::find($id);
            if ($deal->created_by == creatorId()) {
                $meeting  = DealMeeting::find($meeting_id);
                $users = UserDeal::where('deal_id', '=', $deal->id)->get();
                $status = DealMeeting::$status;
                return view('deal.meeting', compact('meeting', 'deal', 'users','status  '));
            } else {
                return response()->json(
                    [
                        'is_success' => false,
                        'error' => __('Permission Denied.'),
                    ],
                    401
                );
            }
        } else {
            return response()->json(
                [
                    'is_success' => false,
                    'error' => __('Permission Denied.'),
                ],
                401
            );
        }
    }

    public function meetingUpdate($id, $meeting_id, Request $request)
    {
        if (Auth::user()->can('edit deal meeting')) {
            $deal = Deal::find($id);
            if ($deal->created_by == creatorId()) {
                $validator = Validator::make(
                    $request->all(),
                    [
                        'subject' => 'required',
                        'user_id' => 'required',
                    ]
                );

                if ($validator->fails()) {
                    $messages = $validator->getMessageBag();

                    return redirect()->back()->with('error', $messages->first());
                }

                $meeting = DealMeeting::find($meeting_id);

                $meeting->update(
                    [
                        'subject' => $request->subject,
                        'status' => $request->status,
                        'duration' => $request->duration,
                        'user_id' => $request->user_id,
                        'description' => $request->description,
                    ]
                );


                return redirect()->back()->with('success', __('meeting successfully updated!'))->with('status', 'meeting');
            } else {
                return redirect()->back()->with('error', __('Permission Denied.'))->with('status', 'meeting');
            }
        } else {
            return redirect()->back()->with('error', __('Permission Denied.'))->with('status', 'tasks');
        }
    }

    public function meetingDestroy($id, $meeting_id)
    {
        if (Auth::user()->can('delete deal meeting')) {
            $deal = Deal::find($id);
            if ($deal->created_by == creatorId()) {
                $task = DealMeeting::find($meeting_id);
                $task->delete();


                return redirect()->back()->with('success', __('Meeting successfully deleted!'))->with('status', 'meeting');
            } else {
                return redirect()->back()->with('error', __('Permission Denied.'))->with('status', 'meeting');
            }
        } else {
            return redirect()->back()->with('error', __('Permission Denied.'))->with('status', 'meeting');
        }
    }

    // Deal email
    public function emailCreate($id)
    {
        if (Auth::user()->can('deal email create')) {
            $deal = Deal::find($id);
            if ($deal->created_by == creatorId()) {
                return view('deal.emails', compact('deal'));
            } else {
                return response()->json(
                    [
                        'is_success' => false,
                        'error' => __('Permission Denied.'),
                    ],
                    401
                );
            }
        } else {
            return response()->json(
                [
                    'is_success' => false,
                    'error' => __('Permission Denied.'),
                ],
                401
            );
        }
    }

    public function emailStore($id, Request $request)
    {
        if (Auth::user()->can('deal email create')) {
            $deal = Deal::find($id);
            if ($deal->created_by == creatorId()) {
                $validator = Validator::make(
                    $request->all(),
                    [
                        'to' => 'required|email',
                        'subject' => 'required',
                    ]
                );

                if ($validator->fails()) {
                    $messages = $validator->getMessageBag();

                    return redirect()->back()->with('error', $messages->first());
                }

                $dealEmail = DealEmail::create(
                    [
                        'deal_id' => $deal->id,
                        'to' => $request->to,
                        'subject' => $request->subject,
                        'description' => $request->description,
                    ]
                );

                DealActivityLog::create(
                    [
                        'user_id' => Auth::user()->id,
                        'deal_id' => $deal->id,
                        'log_type' => 'Create Deal Email',
                        'remark' => json_encode(['title' => 'Create new Deal Email']),
                    ]
                );


                return redirect()->back()->with('success', __('Email successfully created!'))->with('status', 'emails');
            } else {
                return redirect()->back()->with('error', __('Permission Denied.'))->with('status', 'emails');
            }
        } else {
            return redirect()->back()->with('error', __('Permission Denied.'))->with('status', 'emails');
        }
    }

    public function fileUpload($id, Request $request)
    {
        if (Auth::user()->can('edit deal')) {
            $deal = Deal::find($id);
            if ($deal->created_by == creatorId()) {

                $file_name = $request->file->getClientOriginalName();
                $file_path = $request->deal_id . "_" . md5(time()) . "_" . $request->file->getClientOriginalName();

                $url = upload_file($request, 'file', $file_name, 'deals', []);
                if (isset($url['flag']) && $url['flag'] == 1) {

                    $file                 = DealFile::create(
                        [
                            'deal_id' => $request->deal_id,
                            'file_name' => $file_name,
                            'file_path' => $url['url'],
                        ]
                    );
                    $return               = [];
                    $return['is_success'] = true;
                    $return['download']   = get_file($url['url']);

                    $return['delete']     = route(
                        'fileDelete',
                        [
                            $deal->id,
                            $file->id,
                        ]
                    );

                    DealActivityLog::create(
                        [
                            'user_id' => Auth::user()->id,
                            'deal_id' => $deal->id,
                            'log_type' => 'Upload File',
                            'remark' => json_encode(['file_name' => $file_name]),
                        ]
                    );


                    return response()->json($return);
                } else {
                    return response()->json(
                        [
                            'is_success' => false,
                            'error' => $url['msg'],
                        ],
                        401
                    );
                }
            } else {
                return response()->json(
                    [
                        'is_success' => false,
                        'error' => __('Permission Denied.'),
                    ],
                    401
                );
            }
        } else {
            return response()->json(
                [
                    'is_success' => false,
                    'error' => __('Permission Denied.'),
                ],
                401
            );
        }
    }

    public function fileDelete($id, $file_id)
    {
        if (Auth::user()->can('edit deal')) {
            $deal = Deal::find($id);
            if ($deal->created_by == creatorId()) {
                $file = DealFile::find($file_id);
                if ($file) {
                    delete_file($file->file_path);
                    $file->delete();


                    return response()->json(['is_success' => true], 200);
                } else {
                    return response()->json(
                        [
                            'is_success' => false,
                            'error' => __('File is not exist.'),
                        ],
                        200
                    );
                }
            } else {
                return response()->json(
                    [
                        'is_success' => false,
                        'error' => __('Permission Denied.'),
                    ],
                    401
                );
            }
        } else {
            return response()->json(
                [
                    'is_success' => false,
                    'error' => __('Permission Denied.'),
                ],
                401
            );
        }
    }


    // Deal Lable
    public function labels($id)
    {
        if (Auth::user()->can('edit deal')) {
            $deal = Deal::find($id);
            if ($deal->created_by == creatorId()) {
                $labels   = Label::where('pipeline_id', '=', $deal->pipeline_id)->get();
                $selected = $deal->labels();
                if ($selected) {
                    $selected = $selected->pluck('name', 'id')->toArray();
                } else {
                    $selected = [];
                }

                return view('deal.labels', compact('deal', 'labels', 'selected'));
            } else {
                return response()->json(['error' => __('Permission Denied.')], 401);
            }
        } else {
            return response()->json(['error' => __('Permission Denied.')], 401);
        }
    }

    public function labelStore($id, Request $request)
    {
        if (Auth::user()->can('edit deal')) {
            $deal = Deal::find($id);
            if ($deal->created_by == creatorId()) {
                if ($request->labels) {
                    $deal->labels = implode(',', $request->labels);
                } else {
                    $deal->labels = $request->labels;
                }
                $deal->save();

                return redirect()->back()->with('success', __('Labels successfully updated!'));
            } else {
                return redirect()->back()->with('error', __('Permission Denied.'));
            }
        } else {
            return redirect()->back()->with('error', __('Permission Denied.'));
        }
    }
}
