<?php

namespace App\Http\Controllers;

use App\Models\Building;
use App\Models\Category;
use App\Models\Department;
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
            'issue' => 'required',
            'detail' => 'required',
        ]);

        $data = [
            'issue' => $request->issue,
            'detail' => $request->detail,
            'department' => $request->department,
            'hotel' => $request->hotel,
            'location' => $request->location,
            'status' => $request->status,
            'created_at' => $request->created_at
        ];

        Travelodge::insert($data);

        $accessToken = 'e1GzyiuXMwk1u5gA8MgtsWo1JBxNEvPeU6DCeKMQsab'; //token for test PAjBExb3IfM1VtcuNJVLhrj2mdN2ZNlAUTJXmbGRXAh // real -> e1GzyiuXMwk1u5gA8MgtsWo1JBxNEvPeU6DCeKMQsab
        $messageUrl = 'https://notify-api.line.me/api/notify';

        $client = new \GuzzleHttp\Client();

        $message = "New Issue Reported:\n";
        $message .= "  - Issue Category: " . $request->issue . "\n";
        $message .= "  - Detail: " . $request->detail . "\n";
        $message .= "  - Department: " . $request->department . "\n";
        $message .= "  - Hotel: " . $request->hotel . "\n";
        $message .= "  - Location: " . $request->location . "\n";
        $message .= "  - Status: " . ($request->status == 0 ? 'In-progress' : 'Done');

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
            // Success
        } else {
            // Error handling (log or display message)
            /* \Log::error('Line Notify error: ' . $response->getBody()); */
        }

        return redirect('/reports/reportIssue');
    }

    function Tlcmn_AddGuest()
    {
        $buildings = Building::select('name')->get();
        return view('/guest/addGuest', compact('buildings'));
    }

    function Tlcmn_InsertGuest(Request $request)
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
            'created_at' => $request->created_at

        ];
        Tlcmn_guest::insert($data);
        return redirect('/tlcmn');
    }

    function Tlcmn_AddSwitch()
    {
        $buildings = Building::select('name')->get();
        return view('/switchs/addSwitch', compact('buildings'));
    }

    function Tlcmn_InsertSwitch(Request $request)
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
            'created_at' => $request->created_at

        ];
        Tlcmn_switch::insert($data);
        return redirect('/tlcmn');
    }

    function Tlcmn_AddServer()
    {
        return view('/servers/addServer');
    }

    function Tlcmn_InsertServer(Request $request)
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
            'created_at' => $request->created_at

        ];
        Tlcmn_server::insert($data);
        return redirect('/tlcmn');
    }

    function Tlcmn_AddNetSpeed()
    {
        $buildings = Building::select('name')->get();
        return view('/netspeed/addNetSpeed', compact('buildings'));
    }

    function Tlcmn_InsertNetSpeed(Request $request)
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
            'created_at' => $request->created_at

        ];
        Tlcmn_net::insert($data);
        return redirect('/tlcmn');
    }
}
