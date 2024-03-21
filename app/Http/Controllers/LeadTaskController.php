<?php

namespace App\Http\Controllers;

use App\Models\ClientLead;
use App\Models\Lead;
use App\Models\LeadActivityLog;
use App\Models\LeadTask;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class LeadTaskController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create($id)
    {
        if (Auth::user()->can('create lead task')) {
            $lead = Lead::find($id);
            if ($lead->created_by == creatorId() ) {
                $priorities = LeadTask::$priorities;
                $status     = LeadTask::$status;
                return view('lead.tasks', compact('lead', 'priorities', 'status'));
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

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request,$id)
    {

        $usr = Auth::user();
        if ($usr->can('create lead task')) {
            $lead       = Lead::find($id);
            $clients    = ClientLead::select('client_id')->where('lead_id', '=', $id)->get()->pluck('client_id')->toArray();
            $lead_users = $lead->users->pluck('id')->toArray();
            $usrs       = User::whereIN('id', array_merge($lead_users, $clients))->get()->pluck('email', 'id')->toArray();

            if ($lead->created_by == creatorId() ) {
                $validator = Validator::make(
                    $request->all(),
                    [
                        'name' => 'required',
                        'date' => 'required',
                        'time' => 'required',
                        'priority' => 'required',
                        'status' => 'required',
                    ]
                );
                if ($validator->fails()) {
                    $messages = $validator->getMessageBag();

                    return redirect()->back()->with('error', $messages->first());
                }

                $LeadTask = LeadTask::create(
                    [
                        'lead_id' => $lead->id,
                        'name' => $request->name,
                        'date' => $request->date,
                        'time' => date('H:i:s', strtotime($request->date . ' ' . $request->time)),
                        'priority' => $request->priority,
                        'status' => $request->status,
                        'created_by' => creatorId(),

                    ]
                );

                LeadActivityLog::create(
                    [
                        'user_id' => $usr->id,
                        'lead_id' => $lead->id,
                        'log_type' => 'Create Task',
                        'remark' => json_encode(['title' => $LeadTask->name]),
                    ]
                );

                $taskArr = [
                    'lead_id' => $lead->id,
                    'name' => $lead->name,
                    'updated_by' => $usr->id,
                ];

                return redirect()->back()->with('success', __('Task successfully created!') . ((!empty($resp) && $resp['is_success'] == false && !empty($resp['error'])) ? '<br> <span class="text-danger">' . $resp['error'] . '</span>' : ''));
            } else {
                return redirect()->back()->with('error', __('Permission Denied.'))->with('status', 'tasks');
            }
        } else {
            return redirect()->back()->with('error', __('Permission Denied.'))->with('status', 'tasks');
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(LeadTask $leadTask,$id,$task_id)
    {
        if (Auth::user()->can('show lead task')) {
            $lead = Lead::find($id);
            if ($lead->created_by == creatorId() ) {
                $task = LeadTask::find($task_id);

                return view('lead.tasksShow', compact('task', 'lead'));
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

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(LeadTask $leadTask,$id,$task_id)
    {
        if (Auth::user()->can('edit lead task')) {
            $lead = Lead::find($id);
            if ($lead->created_by == creatorId() ) {
                $priorities = LeadTask::$priorities;
                $status     = LeadTask::$status;
                $task       = LeadTask::find($task_id);

                return view('lead.tasks', compact('task', 'lead', 'priorities', 'status'));
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

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, LeadTask $leadTask,$id,$task_id)
    {
        if (Auth::user()->can('edit lead task')) {
            $lead = Lead::find($id);
            if ($lead->created_by == creatorId() ) {

                $validator = Validator::make(
                    $request->all(),
                    [
                        'name' => 'required',
                        'date' => 'required',
                        'time' => 'required',
                        'priority' => 'required',
                        'status' => 'required',
                    ]
                );

                if ($validator->fails()) {
                    $messages = $validator->getMessageBag();

                    return redirect()->back()->with('error', $messages->first());
                }

                $task = LeadTask::find($task_id);

                $task->update(
                    [
                        'name' => $request->name,
                        'date' => $request->date,
                        'time' => date('H:i:s', strtotime($request->date . ' ' . $request->time)),
                        'priority' => $request->priority,
                        'status' => $request->status,
                    ]
                );


                return redirect()->back()->with('success', __('Task successfully updated!'))->with('status', 'tasks');
            } else {
                return redirect()->back()->with('error', __('Permission Denied.'))->with('status', 'tasks');
            }
        } else {
            return redirect()->back()->with('error', __('Permission Denied.'))->with('status', 'tasks');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(LeadTask $leadTask,$id,$task_id)
    {
        if (Auth::user()->can('delete lead task')) {
            $lead = Lead::find($id);
            if ($lead->created_by == creatorId() ) {
                $task = LeadTask::find($task_id);
                $task->delete();


                return redirect()->back()->with('success', __('Task successfully deleted!'))->with('status', 'tasks');
            } else {
                return redirect()->back()->with('error', __('Permission Denied.'))->with('status', 'tasks');
            }
        } else {
            return redirect()->back()->with('error', __('Permission Denied.'))->with('status', 'tasks');
        }
    }

    public function taskUpdateStatus($id, $task_id, Request $request)
    {
        if (Auth::user()->can('edit lead task')) {
            $lead = Lead::find($id);
            if ($lead->created_by == creatorId() ) {

                $validator = Validator::make(
                    $request->all(),
                    [
                        'status' => 'required',
                    ]
                );

                if ($validator->fails()) {
                    $messages = $validator->getMessageBag();

                    return response()->json(
                        [
                            'is_success' => false,
                            'error' => $messages->first(),
                        ],
                        401
                    );
                }

                $task = LeadTask::find($task_id);
                if ($request->status) {
                    $task->status = 0;
                } else {
                    $task->status = 1;
                }
                $task->save();


                return response()->json(
                    [
                        'is_success' => true,
                        'success' => __('Task successfully updated!'),
                        'status' => $task->status,
                        'status_label' => __(LeadTask::$status[$task->status]),
                    ],
                    200
                );
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
}
