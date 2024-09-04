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
use Illuminate\Support\Facades\DB;

class CreateController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    function AddReportIssue()
    {
        $buildings = Building::select('name')->get();
        $departments = Department::select('name')->get();
        $categories = Category::select('name')->get();
        return view('/reports/addIssue', compact('buildings', 'departments', 'categories'));
    }

    function InsertReportIssue(Request $request)
    {
        $request->validate([
            'issues.*.issue' => 'required',
            'issues.*.detail' => 'required',
            'issues.*.file' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:2048',
        ]);

        $issues = $request->input('issues');

        foreach ($issues as $index => $issueData) {
            $data = [
                'issue' => $issueData['issue'],
                'detail' => $issueData['detail'],
                'department' => $issueData['department'],
                'hotel' => $issueData['hotel'],
                'location' => $issueData['location'],
                'status' => $issueData['status'],
                'created_at' => now()
            ];

            if ($request->hasFile("issues.{$index}.file")) {
                $file = $request->file("issues.{$index}.file");
                $filename = time() . '_' . $file->getClientOriginalName();
                $filePath = $file->storeAs('uploads', $filename, 'public');
                $data['file_path'] = $filePath;
            }

            $hasAttachment = false;
            if ($request->hasFile("issues.{$index}.file")) {
                $file = $request->file("issues.{$index}.file");
                $filename = time() . '_' . $file->getClientOriginalName();
                $filePath = $file->storeAs('uploads', $filename, 'public');
                $data['file_path'] = $filePath;
                $hasAttachment = true;
            }

            Travelodge::insert($data);

            $accessToken = 'e1GzyiuXMwk1u5gA8MgtsWo1JBxNEvPeU6DCeKMQsab';
            $messageUrl = 'https://notify-api.line.me/api/notify';

            $client = new \GuzzleHttp\Client();

            $message = "New Issue Reported:\n";
            $message .= "  - Issue Category: " . $issueData['issue'] . "\n";
            $message .= "  - Detail: " . $issueData['detail'] . "\n";
            $message .= "  - Remarks: " . (!empty($issueData['remarks']) ? $issueData['remarks'] : "No remarks") . "\n";
            $message .= "  - Department: " . $issueData['department'] . "\n";
            $message .= "  - Hotel: " . $issueData['hotel'] . "\n";
            $message .= "  - Location: " . $issueData['location'] . "\n";
            $message .= "  - Attachment: " . ($hasAttachment ? 'Yes' : 'No') . "\n";
            $message .= "  - Status: " . ($issueData['status'] == 0 ? 'In-progress' : 'Done');


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
        }

        return redirect('/reports/reportIssue');
    }

    function AddGuest($type)
    {
        $buildings = Building::select('name')->get();
        return view('/guest/addGuest', compact('buildings', 'type'));
    }

    public function InsertGuest(Request $request)
    {
        $request->validate([
            'room_no' => 'required',
            'upload' => 'required',
            'download' => 'required',
            'ch_no' => 'required',
            'ch_name' => 'required',
            'location' => 'required'
        ]);

        $hotel = $request->input('hotel');
        $model = $this->getModelFromType($hotel, 'guest');

        $data = [
            'location' => $request->location,
            'room_no' => $request->room_no,
            'upload' => $request->upload,
            'download' => $request->download,
            'ch_no' => $request->ch_no,
            'ch_name' => $request->ch_name,
            'created_at' => now()
        ];

        $model::insert($data);
        return redirect("/daily/hotels/{$hotel}");
    }

    function AddSwitch($type)
    {
        $buildings = Building::select('name')->get();
        return view('/switchs/addSwitch', compact('buildings', 'type'));
    }

    public function InsertSwitch(Request $request)
    {
        $request->validate([
            'ups_battery' => 'required',
            'ups_time' => 'required',
            'ups_temp' => 'required',
            'location' => 'required'
        ]);

        $hotel = $request->input('hotel');
        $model = $this->getModelFromType($hotel, 'switch');

        $data = [
            'location' => $request->location,
            'ups_battery' => $request->ups_battery,
            'ups_time' => $request->ups_time,
            'ups_temp' => $request->ups_temp,
            'created_at' => now()
        ];

        $model::insert($data);
        return redirect("/daily/hotels/{$hotel}");
    }

    function AddServer($type)
    {
        return view('/servers/addServer', compact('type'));
    }

    public function InsertServer(Request $request)
    {
        $request->validate([
            'server_temp' => 'required|numeric',
            'ups_temp' => 'required|numeric',
            'ups_battery' => 'required|numeric',
            'ups_time' => 'required|numeric'
        ]);

        $hotel = $request->input('hotel');
        $model = $this->getModelFromType($hotel, 'server');

        $data = [
            'server_temp' => $request->server_temp,
            'ups_temp' => $request->ups_temp,
            'ups_battery' => $request->ups_battery,
            'ups_time' => $request->ups_time,
            'created_at' => now()
        ];

        $model::insert($data);
        return redirect("/daily/hotels/{$hotel}");
    }

    function AddNetSpeed($type)
    {
        $buildings = Building::select('name')->get();
        return view('/netspeed/addNetSpeed', compact('buildings', 'type'));
    }

    public function InsertNetSpeed(Request $request)
    {
        $request->validate([
            'upload' => 'required',
            'download' => 'required',
            'location' => 'required'
        ]);

        $hotel = $request->input('hotel');
        $model = $this->getModelFromType($hotel, 'net');

        $data = [
            'location' => $request->location,
            'upload' => $request->upload,
            'download' => $request->download,
            'created_at' => now()
        ];

        $model::insert($data);
        return redirect("/daily/hotels/{$hotel}");
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
