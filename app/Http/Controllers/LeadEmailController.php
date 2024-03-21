<?php

namespace App\Http\Controllers;

use App\Models\Lead;
use App\Models\LeadActivityLog;
use App\Models\LeadEmail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class LeadEmailController extends Controller
{
    public function emailCreate($id)
    {
        if (Auth::user()->can('lead email create')) {
            $lead = Lead::find($id);
            if ($lead->created_by == creatorId()) {
                return view('lead.emails', compact('lead'));
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
        if (Auth::user()->can('lead email create')) {
            $lead = Lead::find($id);
            if ($lead->created_by == creatorId()) {
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

                $leadEmail = LeadEmail::create(
                    [
                        'lead_id' => $lead->id,
                        'to' => $request->to,
                        'subject' => $request->subject,
                        'description' => $request->description,
                    ]
                );

                LeadActivityLog::create(
                    [
                        'user_id' => Auth::user()->id,
                        'lead_id' => $lead->id,
                        'log_type' => 'Create lead Email',
                        'remark' => json_encode(['title' => 'Create new lead Email']),
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
}
