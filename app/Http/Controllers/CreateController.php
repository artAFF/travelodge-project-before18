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
    /*     public function __construct()
    {
        $this->middleware('auth');
    } */

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
        ]);

        $issues = $request->input('issues');

        foreach ($issues as $issueData) {
            $data = [
                'issue' => $issueData['issue'],
                'detail' => $issueData['detail'],
                'department' => $issueData['department'],
                'hotel' => $issueData['hotel'],
                'location' => $issueData['location'],
                'status' => $issueData['status'],
                'created_at' => now()
            ];

            Travelodge::insert($data);

            $accessToken = 'e1GzyiuXMwk1u5gA8MgtsWo1JBxNEvPeU6DCeKMQsab';
            $messageUrl = 'https://notify-api.line.me/api/notify';

            $client = new \GuzzleHttp\Client();

            $message = "New Issue Reported:\n";
            $message .= "  - Issue Category: " . $issueData['issue'] . "\n";
            $message .= "  - Detail: " . $issueData['detail'] . "\n";
            $message .= "  - Department: " . $issueData['department'] . "\n";
            $message .= "  - Hotel: " . $issueData['hotel'] . "\n";
            $message .= "  - Location: " . $issueData['location'] . "\n";
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


    function Tlcmn_AddGuest()
    {
        $buildings = Building::select('name')->get();
        return view('/guest/addGuest', compact('buildings'));
    }

    public function Tlcmn_InsertGuest(Request $request)
    {
        $request->validate([
            'room_no' => 'required',
            'upload' => 'required',
            'download' => 'required',
            'ch_no' => 'required',
            'ch_name' => 'required'
        ]);

        $hotel = $request->input('hotel');

        switch ($hotel) {
            case 'tlcmn':
                $request->validate([
                    'location1' => 'required'
                ]);
                $data = [
                    'location' => $request->input('location1'),
                    'room_no' => $request->room_no,
                    'upload' => $request->upload,
                    'download' => $request->download,
                    'ch_no' => $request->ch_no,
                    'ch_name' => $request->ch_name,
                    'created_at' => now()
                ];
                Tlcmn_guest::insert($data);
                return redirect('/tlcmn');
                break;
            case 'ehcm':
                $request->validate([
                    'location2' => 'required'
                ]);
                $data = [
                    'location' => $request->input('location2'),
                    'room_no' => $request->room_no,
                    'upload' => $request->upload,
                    'download' => $request->download,
                    'ch_no' => $request->ch_no,
                    'ch_name' => $request->ch_name,
                    'created_at' => now()
                ];
                Ehcm_guest::insert($data);
                return redirect('/ehcm');
                break;
            case 'uncm':
                $request->validate([
                    'location2' => 'required'
                ]);
                $data = [
                    'location' => $request->input('location2'),
                    'room_no' => $request->room_no,
                    'upload' => $request->upload,
                    'download' => $request->download,
                    'ch_no' => $request->ch_no,
                    'ch_name' => $request->ch_name,
                    'created_at' => now()
                ];
                Uncm_guest::insert($data);
                return redirect('/uncm');
                break;
            default:
                return redirect()->back()->withErrors(['hotel' => 'Invalid hotel selection.']);
        }
    }

    function Tlcmn_AddSwitch()
    {
        $buildings = Building::select('name')->get();
        return view('/switchs/addSwitch', compact('buildings'));
    }

    public function Tlcmn_InsertSwitch(Request $request)
{
    $request->validate([
        'ups_battery' => 'required',
        'ups_time' => 'required',
        'ups_temp' => 'required'
    ]);

    $hotel = $request->input('hotel');

    switch ($hotel) {
        case 'tlcmn':
            $request->validate([
                'location1' => 'required'
            ]);
            $data = [
                'location' => $request->input('location1'),
                'ups_battery' => $request->ups_battery,
                'ups_time' => $request->ups_time,
                'ups_temp' => $request->ups_temp,
                'created_at' => now()
            ];
            Tlcmn_switch::insert($data);
            return redirect('/tlcmn');
            break;
        case 'ehcm':
            $request->validate([
                'location2' => 'required'
            ]);
            $data = [
                'location' => $request->input('location2'),
                'ups_battery' => $request->ups_battery,
                'ups_time' => $request->ups_time,
                'ups_temp' => $request->ups_temp,
                'created_at' => now()
            ];
            Ehcm_switch::insert($data);
            return redirect('/ehcm');
            break;
        case 'uncm':
            $request->validate([
                'location2' => 'required'
            ]);
            $data = [
                'location' => $request->input('location2'),
                'ups_battery' => $request->ups_battery,
                'ups_time' => $request->ups_time,
                'ups_temp' => $request->ups_temp,
                'created_at' => now()
            ];
            Uncm_switch::insert($data);
            return redirect('/uncm');
            break;
        default:
            return redirect()->back()->withErrors(['hotel' => 'Invalid hotel selection.']);
    }
}

    function Tlcmn_AddServer()
    {
        return view('/servers/addServer');
    }

    public function Tlcmn_InsertServer(Request $request)
    {
        $request->validate([
            'server_temp' => 'required|numeric',
            'ups_temp' => 'required|numeric',
            'ups_battery' => 'required|numeric',
            'ups_time' => 'required|numeric'
        ]);

        $hotel = $request->input('hotel');

        switch ($hotel) {
            case 'tlcmn':
                $data = [
                    'server_temp' => $request->server_temp,
                    'ups_temp' => $request->ups_temp,
                    'ups_battery' => $request->ups_battery,
                    'ups_time' => $request->ups_time,
                    'created_at' => now()
                ];
                Tlcmn_server::insert($data);
                return redirect('/tlcmn');

            case 'ehcm':
                $data = [
                    'server_temp' => $request->server_temp,
                    'ups_temp' => $request->ups_temp,
                    'ups_battery' => $request->ups_battery,
                    'ups_time' => $request->ups_time,
                    'created_at' => now()
                ];
                Ehcm_server::insert($data);
                return redirect('/ehcm');

            case 'uncm':
                $data = [
                    'server_temp' => $request->server_temp,
                    'ups_temp' => $request->ups_temp,
                    'ups_battery' => $request->ups_battery,
                    'ups_time' => $request->ups_time,
                    'created_at' => now()
                ];
                Uncm_server::insert($data);
                return redirect('/uncm');

            default:
                return redirect()->back()->withErrors(['hotel' => 'Invalid hotel selection.']);
        }
    }


    function Tlcmn_AddNetSpeed()
    {
        $buildings = Building::select('name')->get();
        return view('/netspeed/addNetSpeed', compact('buildings'));
    }

    public function Tlcmn_InsertNetSpeed(Request $request)
{
    $request->validate([
        'upload' => 'required',
        'download' => 'required'
    ]);

    $hotel = $request->input('hotel');

    switch ($hotel) {
        case 'tlcmn':
            $request->validate([
                'location1' => 'required'
            ]);
            $data = [
                'location' => $request->input('location1'),
                'upload' => $request->upload,
                'download' => $request->download,
                'created_at' => now()
            ];
            Tlcmn_net::insert($data);
            return redirect('/tlcmn');
            break;
        case 'ehcm':
            $request->validate([
                'location2' => 'required'
            ]);
            $data = [
                'location' => $request->input('location2'),
                'upload' => $request->upload,
                'download' => $request->download,
                'created_at' => now()
            ];
            Ehcm_net::insert($data);
            return redirect('/ehcm');
            break;
        case 'uncm':
            $request->validate([
                'location2' => 'required'
            ]);
            $data = [
                'location' => $request->input('location2'),
                'upload' => $request->upload,
                'download' => $request->download,
                'created_at' => now()
            ];
            Uncm_net::insert($data);
            return redirect('/uncm');
            break;
        default:
            return redirect()->back()->withErrors(['hotel' => 'Invalid hotel selection.']);
    }
}
}
