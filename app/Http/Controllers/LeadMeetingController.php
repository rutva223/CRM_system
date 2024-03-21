<?php

namespace App\Http\Controllers;

use App\Models\Lead;
use App\Models\LeadActivityLog;
use App\Models\LeadMeeting;
use App\Models\UserLead;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class LeadMeetingController extends Controller
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
        if (Auth::user()->can('create lead meeting')) {
            $lead = Lead::find($id);
            $status = LeadMeeting::$status;
            if ($lead->created_by == creatorId()) {
                $users = UserLead::where('lead_id', '=', $lead->id)->get();

                return view('lead.meeting', compact('lead', 'users','status'));
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
    public function store($id, Request $request)
    {
        $usr = Auth::user();

        if ($usr->can('create lead meeting')) {
            $lead = Lead::find($id);
            if ($lead->created_by == creatorId()) {
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

                LeadMeeting::create(
                    [
                        'lead_id' => $lead->id,
                        'subject' => $request->subject,
                        'duration' => $request->duration,
                        'user_id' => $request->user_id,
                        'description' => $request->description,
                        'status' => $request->call_result,
                    ]
                );

                LeadActivityLog::create(
                    [
                        'user_id' => $usr->id,
                        'lead_id' => $lead->id,
                        'log_type' => 'Create Meeting',
                        'remark' => json_encode(['title' => 'Create new lead Meeting']),
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

    /**
     * Display the specified resource.
     */
    public function show(LeadMeeting $leadMeeting)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id, $meeting_id)
    {
        if (Auth::user()->can('edit lead meeting')) {
            $lead = Lead::find($id);
            if ($lead->created_by == creatorId()) {
                $meeting  = LeadMeeting::find($meeting_id);
                $users = UserLead::where('lead_id', '=', $lead->id)->get();
                $status = LeadMeeting::$status;
                return view('lead.meeting', compact('meeting', 'lead', 'users','status  '));
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
    public function update($id, $meeting_id, Request $request)
    {
        if (Auth::user()->can('edit lead meeting')) {
            $lead = Lead::find($id);
            if ($lead->created_by == creatorId()) {
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

                $meeting = LeadMeeting::find($meeting_id);

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

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id, $meeting_id)
    {
        if (Auth::user()->can('delete lead meeting')) {
            $lead = Lead::find($id);
            if ($lead->created_by == creatorId()) {
                $task = LeadMeeting::find($meeting_id);
                $task->delete();


                return redirect()->back()->with('success', __('Meeting successfully deleted!'))->with('status', 'meeting');
            } else {
                return redirect()->back()->with('error', __('Permission Denied.'))->with('status', 'meeting');
            }
        } else {
            return redirect()->back()->with('error', __('Permission Denied.'))->with('status', 'meeting');
        }
    }

}
