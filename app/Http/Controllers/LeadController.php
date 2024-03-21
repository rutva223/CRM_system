<?php

namespace App\Http\Controllers;

use App\Models\ClientLead;
use App\Models\Label;
use App\Models\lead;
use App\Models\leadType;
use App\Models\LeadActivityLog;
use App\Models\LeadCall;
use App\Models\LeadEmail;
use App\Models\LeadFile;
use App\Models\LeadMeeting;
use App\Models\LeadStage;
use App\Models\Pipeline;
use App\Models\Source;
use App\Models\User;
use App\Models\UserLead;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;

class LeadController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        if('manage leads'){

            $leads = Lead::leftjoin('users', 'users.id', '=', 'leads.user_id')
                ->select('leads.*', 'users.name')
                ->orderBy('id', 'desc')
                ->get();

            return view('lead.index',compact('leads'));
        } else {
            return redirect()->back()->with('error', __('Permission denied.'));
        }
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request)
    {
        if (Auth::user()->can('create leads')) {
            $id = Session::get('user_id') ?? Auth::user()->id;
            $users = User::where('created_by', $id)->get()->pluck('name', 'id');
            $lead_stage = LeadStage::where('created_by', $id)->get()->pluck('name', 'id');
            $pipeline = Pipeline::where('created_by', $id)->get()->pluck('name', 'id');
            $leadtype = leadType::where('created_by', $id)->get()->pluck('name', 'id');
            $priority = Lead::$priority;
            $select_stage = $request->stage;
            $user =  User::where('id', $id)->first();
            $select_pipeline = $user->default_pipeline;
            return view('lead.create', compact('users','lead_stage','select_stage', 'pipeline', 'select_pipeline', 'leadtype', 'priority'));
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
        if ($usr->can('create leads')) {
            $validator = Validator::make(
                $request->all(),
                [
                    'subject' => 'required',
                    'name' => 'required',
                    'email' => 'required|unique:leads,email',
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
            if (!empty($pipeline)) {
                $stage = LeadStage::where('pipeline_id', '=', $pipeline->id)->first();
                // End Default Field Value
            } else {
                return redirect()->back()->with('error', __('Please Create Pipeline.'));
            }
            if (empty($stage)) {
                return redirect()->back()->with('error', __('Please Create Stage for This Pipeline.'));
            } else {
                $lead               = new Lead();
                $lead->name         = $request->name;
                $lead->email        = $request->email;
                $lead->subject      = $request->subject;
                $lead->user_id      = $request->user;
                $lead->pipeline_id = $request->pipeline_id ?? $pipeline->id;
                $lead->stage_id     = $stage->id;
                $lead->description     = $request->description;
                $lead->created_by   = creatorId();
                $lead->date         = date('Y-m-d');
                $lead->save();


                if (Auth::user()->hasRole('company')) {
                    $usrLeads = [
                        $usr->id,
                        $request->user,
                    ];
                } else {
                    $usrLeads = [
                        creatorId(),
                        $request->user,
                    ];
                }

                foreach ($usrLeads as $usrLead) {
                    UserLead::create(
                        [
                            'user_id' => $usrLead,
                            'lead_id' => $lead->id,
                        ]
                    );
                }

                $resp = null;
                $resp['is_success'] = true;
                return redirect()->back()->with('success', __('Lead successfully created!') . (($resp['is_success'] == false && !empty($resp['error'])) ? '<br> <span class="text-danger">' . $resp['error'] . '</span>' : ''));
            }
        } else {
            return redirect()->back()->with('error', __('Permission Denied.'));
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Lead $lead)
    {
        if ($lead->is_active) {

            $calenderTasks = [];
            // $lead          = Lead::where('id', '=', $lead->is_converted)->first();
            $stageCnt      = LeadStage::where('pipeline_id', '=', $lead->pipeline_id)->where('created_by', '=', $lead->created_by)->get();
            $i             = 0;
            foreach ($stageCnt as $stage) {
                $i++;
                if ($stage->id == $lead->stage_id) {
                    break;
                }
            }
            $precentage = number_format(($i * 100) / count($stageCnt));

            return view('lead.show', compact('lead', 'calenderTasks', 'lead', 'precentage'));
        } else {
            return redirect()->back()->with('error', __('Permission Denied.'));
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Lead $lead)
    {
        if (Auth::user()->can('edit leads')) {
            if ($lead->created_by == creatorId()) {
                $pipelines = Pipeline::where('created_by', '=', creatorId())->get()->pluck('name', 'id');
                $pipelines->prepend(__('Select Pipeline'), '');
                $sources = Source::where('created_by', '=', creatorId())->get()->pluck('name', 'id');
                $sources->prepend(__('Select Sources'), '');
                $products = ['Select Products'];
                $users = User::where('created_by', '=', creatorId())->where('type', '!=', 'client')->get()->pluck('name', 'id');
                $users->prepend(__('Select User'), '');

                $lead->sources  = explode(',', $lead->sources);
                $lead->products = explode(',', $lead->products);

                return view('lead.edit', compact('lead', 'pipelines', 'sources', 'products', 'users', 'customFields'));
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
    public function update(Request $request, Lead $lead)
    {
        if (Auth::user()->can('edit leads')) {
            if ($lead->created_by == creatorId()) {
                $validator = Validator::make(
                    $request->all(),
                    [
                        'subject' => 'required',
                        'name' => 'required',
                        'email' => 'required|email|unique:leads,email,' . $lead->id,
                        'pipeline_id' => 'required',
                        'user_id' => 'required',
                        'stage_id' => 'required',
                        'sources' => 'required',
                        'products' => 'required',
                    ]
                );

                if ($validator->fails()) {
                    $messages = $validator->getMessageBag();

                    return redirect()->back()->with('error', $messages->first());
                }

                $lead->name        = $request->name;
                $lead->email       = $request->email;
                $lead->subject     = $request->subject;
                $lead->user_id     = $request->user_id;
                $lead->pipeline_id = $request->pipeline_id;
                $lead->stage_id    = $request->stage_id;
                $lead->sources     = implode(",", array_filter($request->sources));
                $lead->products    = implode(",", array_filter($request->products));
                $lead->notes       = $request->notes;
                $lead->save();




                return redirect()->back()->with('success', __('Lead successfully updated!'));
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
    public function destroy(Lead $lead)
    {
        if (Auth::user()->can('delete leads')) {

            UserLead::where('lead_id', '=', $lead->id)->delete();
            $leadfiles = LeadFile::where('lead_id', '=', $lead->id)->get();
            foreach ($leadfiles as $leadfile) {

                delete_file($leadfile->file_path);
                $leadfile->delete();
            }
            LeadActivityLog::where('lead_id', '=', $lead->id)->delete();

            $lead->delete();

            return redirect()->back()->with('success', __('Lead successfully deleted!'));
        } else {
            return redirect()->back()->with('error', __('Permission Denied.'));
        }
    }

    public function GridView() {
        $leads = Lead::leftjoin('users', 'users.id', '=', 'leads.user_id')
                ->select('leads.*', 'users.name')
                ->orderBy('id', 'desc')
                ->get();

            return view('lead.grid',compact('leads'));
    }

    public function leadnoteStore($id, Request $request)
    {
        if (Auth::user()->can('edit leads')) {
            $lead = Lead::find($id);
            if ($lead->created_by == creatorId()) {
                $lead->name = $request->name;
                $lead->notes = $request->notes;
                $lead->save();

                return redirect()->back()->with('success', __('Note successfully saved!'));
            } else {
                return redirect()->back()->with('error', __('Permission Denied'));
            }
        } else {
            return redirect()->back()->with('error', __('Permission Denied'));
        }
    }

    // Lead Calls
    public function leadcallCreate($id)
    {
        if (Auth::user()->can('create lead call')) {
            $lead = Lead::find($id);
            if ($lead->created_by == creatorId()) {
                $users = UserLead::where('lead_id', '=', $lead->id)->get();

                return view('lead.calls', compact('lead', 'users'));
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

    public function leadcallStore($id, Request $request)
    {
        $usr = Auth::user();

        if ($usr->can('create lead call')) {
            $lead = Lead::find($id);
            if ($lead->created_by == creatorId()) {
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

                LeadCall::create(
                    [
                        'lead_id' => $lead->id,
                        'subject' => $request->subject,
                        'call_type' => $request->call_type,
                        'duration' => $request->duration,
                        'user_id' => $request->user_id,
                        'description' => $request->description,
                        'call_result' => $request->call_result,
                    ]
                );

                LeadActivityLog::create(
                    [
                        'user_id' => $usr->id,
                        'lead_id' => $lead->id,
                        'log_type' => 'Create Lead Call',
                        'remark' => json_encode(['title' => 'Create new Lead Call']),
                    ]
                );

                $leadArr = [
                    'lead_id' => $lead->id,
                    'name' => $lead->name,
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

    public function leadcallEdit($id, $call_id)
    {
        if (Auth::user()->can('edit lead call')) {
            $lead = Lead::find($id);
            if ($lead->created_by == creatorId()) {
                $call  = LeadCall::find($call_id);
                $users = UserLead::where('lead_id', '=', $lead->id)->get();

                return view('lead.calls', compact('call', 'lead', 'users'));
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

    public function leadcallUpdate($id, $call_id, Request $request)
    {
        if (Auth::user()->can('edit lead call')) {
            $lead = Lead::find($id);
            if ($lead->created_by == creatorId()) {
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

                $call = leadCall::find($call_id);

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

    public function leadcallDestroy($id, $call_id)
    {
        if (Auth::user()->can('delete lead call')) {
            $lead = Lead::find($id);
            if ($lead->created_by == creatorId()) {
                $task = leadCall::find($call_id);
                $task->delete();


                return redirect()->back()->with('success', __('Call successfully deleted!'))->with('status', 'calls');
            } else {
                return redirect()->back()->with('error', __('Permission Denied.'))->with('status', 'calls');
            }
        } else {
            return redirect()->back()->with('error', __('Permission Denied.'))->with('status', 'calls');
        }
    }

    // lead Lable
    public function labels($id)
    {
        if (Auth::user()->can('edit leads')) {
            $lead = Lead::find($id);
            if ($lead->created_by == creatorId()) {
                $labels   = Label::where('pipeline_id', '=', $lead->pipeline_id)->get();
                $selected = $lead->labels();
                if ($selected) {
                    $selected = $selected->pluck('name', 'id')->toArray();
                } else {
                    $selected = [];
                }

                return view('lead.labels', compact('lead', 'labels', 'selected'));
            } else {
                return response()->json(['error' => __('Permission Denied.')], 401);
            }
        } else {
            return response()->json(['error' => __('Permission Denied.')], 401);
        }
    }

    public function labelStore($id, Request $request)
    {
        if (Auth::user()->can('edit leads')) {
            $lead = Lead::find($id);
            if ($lead->created_by == creatorId()) {
                if ($request->labels) {
                    $lead->labels = implode(',', $request->labels);
                } else {
                    $lead->labels = $request->labels;
                }
                $lead->save();

                return redirect()->back()->with('success', __('Labels successfully updated!'));
            } else {
                return redirect()->back()->with('error', __('Permission Denied.'));
            }
        } else {
            return redirect()->back()->with('error', __('Permission Denied.'));
        }
    }
    public function leadContactAssign($id)
    {
        if (Auth::user()->can('edit leads')) {
            $lead = Lead::find($id);

            if ($lead->created_by == creatorId()) {
                $clients = User::where('created_by', '=', creatorId())->where('type', '=', 'client')->whereNOTIn(
                    'id',
                    function ($q) use ($lead) {
                        $q->select('client_id')->from('client_leads')->where('lead_id', '=', $lead->id);
                    }
                )->get()->pluck('name', 'id');
                return view('lead.clients', compact('lead', 'clients'));
            } else {
                return response()->json(['error' => __('Permission Denied.')], 401);
            }
            $lead = Lead::find($id);
            return view('lead.contact_assign');
        } else {
            return response()->json(['error' => __('Permission Denied.')], 401);
        }
    }

    public function LeadContactUpdate($id, Request $request)
    {
        if (Auth::user()->can('edit leads')) {
            $lead = Lead::find($id);
            if ($lead->created_by == creatorId()) {
                if (!empty($request->clients)) {
                    // $clients = array_filter($request->clients);
                    // foreach ($clients as $client) {
                    ClientLead::create(
                        [
                            'lead_id' => $lead->id,
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

}
