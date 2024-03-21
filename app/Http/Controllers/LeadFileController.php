<?php

namespace App\Http\Controllers;

use App\Models\Lead;
use App\Models\LeadActivityLog;
use App\Models\LeadFile;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LeadFileController extends Controller
{
    public function fileUpload($id, Request $request)
    {
        if (Auth::user()->can('edit leads')) {
            $lead = Lead::find($id);
            if ($lead->created_by == creatorId()) {

                $file_name = $request->file->getClientOriginalName();
                $file_path = $request->lead_id . "_" . md5(time()) . "_" . $request->file->getClientOriginalName();

                $url = upload_file($request, 'file', $file_name, 'leads', []);
                if (isset($url['flag']) && $url['flag'] == 1) {

                    $file                 = leadFile::create(
                        [
                            'lead_id' => $request->lead_id,
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
                            $lead->id,
                            $file->id,
                        ]
                    );

                    LeadActivityLog::create(
                        [
                            'user_id' => Auth::user()->id,
                            'lead_id' => $lead->id,
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
        if (Auth::user()->can('edit leads')) {
            $lead = Lead::find($id);
            if ($lead->created_by == creatorId()) {
                $file = leadFile::find($file_id);
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
}
