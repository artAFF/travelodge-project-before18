<?php

namespace App\Http\Controllers;

use App\Models\Building;
use App\Models\Category;
use App\Models\Department;
use App\Models\Ehcm_guest;
use App\Models\Ehcm_net;
use App\Models\Ehcm_server;
use App\Models\Ehcm_switch;
use App\Models\GuestRoom;
use App\Models\NetSpeed;
use App\Models\ServerRoom;
use App\Models\SwitchRoom;
use App\Models\Tlcmn_guest;
use App\Models\Tlcmn_net;
use App\Models\Tlcmn_server;
use App\Models\Tlcmn_switch;
use Illuminate\Http\Request;
use App\Models\Travelodge;
use App\Models\Uncm_guest;
use App\Models\Uncm_net;
use App\Models\Uncm_server;
use App\Models\Uncm_switch;
use App\Models\User;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;

class UpdateController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function UpdateReportIssue($id)
    {
        $ReportIssues = Travelodge::findOrFail($id);
        $categories = Category::all();
        $departments = Department::all();
        $itSupportUsers = User::whereHas('department', function ($query) {
            $query->where('name', 'IT Support');
        })->get();

        return view('/reports/updateReport', compact('ReportIssues', 'categories', 'departments', 'itSupportUsers'));
    }

    public function UpdateIssue(Request $request, $id)
    {
        $request->validate([
            'category_id' => 'required|exists:categories,id',
            'department_id' => 'required|exists:departments,id',
            'detail' => 'required',
            'remarks' => 'nullable|string',
            'hotel' => 'required',
            'assignee' => 'nullable|exists:users,id',
            'status' => 'required|in:0,1',
        ]);

        $travelodge = Travelodge::findOrFail($id);

        $travelodge->update([
            'category_id' => $request->category_id,
            'department_id' => $request->department_id,
            'detail' => $request->detail,
            'remarks' => $request->remarks,
            'hotel' => $request->hotel,
            'status' => $request->status,
            'assignee_id' => $request->assignee ?: null,
        ]);

        // Handle file upload if a new file is provided
        if ($request->hasFile('file')) {
            // Delete old file if exists
            if ($travelodge->file_path) {
                Storage::disk('public')->delete($travelodge->file_path);
            }

            $file = $request->file('file');
            $filename = time() . '_' . $file->getClientOriginalName();
            $filePath = $file->storeAs('uploads', $filename, 'public');
            $travelodge->update(['file_path' => $filePath]);
        }

        $this->sendLineNotification($travelodge);

        return redirect($request->input('previous_url'));
    }

    private function sendLineNotification($travelodge)
    {
        $accessToken = 'e1GzyiuXMwk1u5gA8MgtsWo1JBxNEvPeU6DCeKMQsab';
        $messageUrl = 'https://notify-api.line.me/api/notify';

        $client = new \GuzzleHttp\Client();


        $message = "Update Issue Reported:\n";
        $message .= "  - ID Issue: " . $travelodge->id . "\n";
        $message .= "  - Issue Category: " . ($travelodge->category->name ?? 'N/A') . "\n";
        $message .= "  - Detail: " . $travelodge->detail . "\n";
        $message .= "  - Remarks: " . ($travelodge->remarks ?? "No remarks") . "\n";
        $message .= "  - Department: " . ($travelodge->department->name ?? 'N/A') . "\n";
        $message .= "  - Hotel: " . $travelodge->hotel . "\n";
        $message .= "  - Assignee: " . ($travelodge->assignee->name ?? 'Unassigned') . "\n";
        $message .= "  - Status: " . ($travelodge->status == 0 ? 'In-progress' : 'Done');

        try {
            $response = $client->post($messageUrl, [
                'headers' => [
                    'Authorization' => 'Bearer ' . $accessToken,
                    'Content-Type' => 'application/x-www-form-urlencoded',
                ],
                'form_params' => [
                    'message' => $message,
                ],
            ]);

            if ($response->getStatusCode() !== 200) {
                /* \Log::error('Line Notify error: ' . $response->getBody()); */
            }
        } catch (\Exception $e) {
            /* \Log::error('Line Notify error: ' . $e->getMessage()); */
        }
    }

    public function updateStatus(Request $request, $id)
    {
        try {
            $report = Travelodge::findOrFail($id);
            $oldStatus = $report->status;
            $newStatus = $request->status;
            $report->status = $newStatus;
            $report->save();

            $lineSent = $this->sendStatusUpdateNotification($report, $oldStatus, $newStatus);

            return response()->json([
                'success' => true,
                'db_updated' => true,
                'line_sent' => $lineSent
            ]);
        } catch (\Exception $e) {
            /* \Log::error('Status update error: ' . $e->getMessage()); */
            return response()->json([
                'success' => false,
                'error' => $e->getMessage()
            ], 500);
        }
    }

    private function sendStatusUpdateNotification($travelodge, $oldStatus, $newStatus)
    {
        $accessToken = 'e1GzyiuXMwk1u5gA8MgtsWo1JBxNEvPeU6DCeKMQsab';
        $messageUrl = 'https://notify-api.line.me/api/notify';

        $client = new Client();

        $message = "Status Update:\n";
        $message .= "  - ID: " . $travelodge->id . "\n";
        $message .= "  - Detail: " . $travelodge->detail . "\n";
        $message .= "  - Old Status: " . ($oldStatus == 0 ? 'In-process' : 'Done') . "\n";
        $message .= "  - New Status: " . ($newStatus == 0 ? 'In-process' : 'Done');

        try {
            $response = $client->post($messageUrl, [
                'headers' => [
                    'Authorization' => 'Bearer ' . $accessToken,
                    'Content-Type' => 'application/x-www-form-urlencoded',
                ],
                'form_params' => [
                    'message' => $message,
                ],
            ]);

            if ($response->getStatusCode() === 200) {
                return true;
            } else {
                /* \Log::error('Line Notify error: ' . $response->getBody());
                return false; */
            }
        } catch (RequestException $e) {
            /* \Log::error('Line Notify error: ' . $e->getMessage());
            return false; */
        }
    }

    public function updateAssignee(Request $request, $id)
    {
        $request->validate([
            'assignee_id' => 'nullable|exists:users,id',
        ]);

        $travelodge = Travelodge::findOrFail($id);
        $oldAssignee = $travelodge->assignee ? $travelodge->assignee->name : 'Not Assigned';

        $newAssigneeId = $request->assignee_id ?: null;
        $travelodge->update([
            'assignee_id' => $newAssigneeId,
        ]);

        $updatedTravelodge = Travelodge::findOrFail($id);
        $newAssignee = $updatedTravelodge->assignee ? $updatedTravelodge->assignee->name : 'Not Assigned';

        $this->sendAssigneeUpdateNotification($updatedTravelodge, $oldAssignee, $newAssignee);

        return response()->json([
            'success' => true,
            'oldAssignee' => $oldAssignee,
            'newAssignee' => $newAssignee
        ]);
    }

    private function sendAssigneeUpdateNotification($travelodge, $oldAssignee, $newAssignee)
    {
        $accessToken = 'e1GzyiuXMwk1u5gA8MgtsWo1JBxNEvPeU6DCeKMQsab';
        $messageUrl = 'https://notify-api.line.me/api/notify';

        $client = new \GuzzleHttp\Client();

        $message = "Assignee Update:\n";
        $message .= "  - ID: " . $travelodge->id . "\n";
        $message .= "  - Detail: " . $travelodge->detail . "\n";
        $message .= "  - Remarks: " . ($travelodge->remarks ?? "No remarks") . "\n";
        $message .= "  - Old Assignee: " . $oldAssignee . "\n";
        $message .= "  - New Assignee: " . $newAssignee;

        try {
            $response = $client->post($messageUrl, [
                'headers' => [
                    'Authorization' => 'Bearer ' . $accessToken,
                    'Content-Type' => 'application/x-www-form-urlencoded',
                ],
                'form_params' => [
                    'message' => $message,
                ],
            ]);

            if ($response->getStatusCode() !== 200) {
                /* \Log::error('Line Notify error: ' . $response->getBody()); */
            }
        } catch (\Exception $e) {
            /* \Log::error('Line Notify error: ' . $e->getMessage()); */
        }
    }

    function UpdateGuest($type, $id)
    {
        $model = $this->getModelFromType($type, 'guest');
        $ReportGuests = $model::where('id', $id)->first();
        $buildings = Building::select('name')->get();

        return view('/guest/updateGuest', compact('ReportGuests', 'buildings', 'type'));
    }

    function UpdateGuestProcess(Request $request, $type, $id)
    {
        $request->validate([
            'location' => 'required',
            'room_no' => 'required',
            'upload' => 'required',
            'download' => 'required',
            'ch_no' => 'required',
            'ch_name' => 'required'
        ]);

        $data = [
            'location' => $request->location,
            'room_no' => $request->room_no,
            'upload' => $request->upload,
            'download' => $request->download,
            'ch_no' => $request->ch_no,
            'ch_name' => $request->ch_name,
            'updated_at' => now()
        ];

        $model = $this->getModelFromType($type, 'guest');
        $model::where('id', $id)->update($data);
        return redirect("/daily/hotels/{$type}");
    }

    function UpdateSwitch($type, $id)
    {
        $model = $this->getModelFromType($type, 'switch');
        $ReportSwitchs = $model::where('id', $id)->first();
        $buildings = Building::select('name')->get();

        return view('/switchs/updateSwitch', compact('ReportSwitchs', 'buildings', 'type'));
    }

    function UpdateSwitchProcess(Request $request, $type, $id)
    {
        $request->validate([
            'location' => 'required',
            'ups_battery' => 'required',
            'ups_time' => 'required',
            'ups_temp' => 'required'
        ]);

        $data = [
            'location' => $request->location,
            'ups_battery' => $request->ups_battery,
            'ups_time' => $request->ups_time,
            'ups_temp' => $request->ups_temp,
            'updated_at' => now()
        ];

        $model = $this->getModelFromType($type, 'switch');
        $model::where('id', $id)->update($data);
        return redirect("/daily/hotels/{$type}");
    }

    function UpdateServer($type, $id)
    {
        $model = $this->getModelFromType($type, 'server');
        $ReportServers = $model::where('id', $id)->first();

        return view('/servers/updateServer', compact('ReportServers', 'type'));
    }

    function UpdateServerProcess(Request $request, $type, $id)
    {
        $request->validate([
            'server_temp' => 'required',
            'ups_temp' => 'required',
            'ups_battery' => 'required',
            'ups_time' => 'required'
        ]);

        $data = [
            'server_temp' => $request->server_temp,
            'ups_temp' => $request->ups_temp,
            'ups_battery' => $request->ups_battery,
            'ups_time' => $request->ups_time,
            'updated_at' => now()
        ];

        $model = $this->getModelFromType($type, 'server');
        $model::where('id', $id)->update($data);
        return redirect("/daily/hotels/{$type}");
    }

    function UpdateReportNetSpeed($type, $id)
    {
        $model = $this->getModelFromType($type, 'net');
        $ReportNetSpeeds = $model::where('id', $id)->first();
        $buildings = Building::select('name')->get();

        return view('/netspeed/updateNetSpeed', compact('ReportNetSpeeds', 'buildings', 'type'));
    }

    function UpdateReportNetSpeedProcess(Request $request, $type, $id)
    {
        $request->validate([
            'location' => 'required',
            'upload' => 'required',
            'download' => 'required'
        ]);

        $data = [
            'location' => $request->location,
            'upload' => $request->upload,
            'download' => $request->download,
            'updated_at' => now()
        ];

        $model = $this->getModelFromType($type, 'net');
        $model::where('id', $id)->update($data);
        return redirect("/daily/hotels/{$type}");
    }

    private function getModelFromType($type, $modelType)
    {
        switch ($type) {
            case 'tlcmn':
                return "App\\Models\\Tlcmn_{$modelType}";
            case 'ehcm':
                return "App\\Models\\Ehcm_{$modelType}";
            case 'uncm':
                return "App\\Models\\Uncm_{$modelType}";
            default:
                throw new \Exception("Invalid type");
        }
    }
}
