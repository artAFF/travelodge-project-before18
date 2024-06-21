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

class UpdateController extends Controller
{
    /*  public function __construct()
    {
        $this->middleware('auth');
    } */

    function UpdateReportIssue($id)
    {
        $ReportIssues = Travelodge::where('id', $id)->first();
        $buildings = Building::select('name')->get();
        $departments = Department::select('name')->get();
        $categories = Category::select('name')->get();

        return view('/reports/updateReport', compact('ReportIssues', 'buildings', 'departments', 'categories'));
    }

    function UpdateIssue(Request $request, $id)
    {
        $request->validate([
            'issue' => 'required',
            'detail' => 'required'

        ]);
        $data = [
            'issue' => $request->issue,
            'detail' => $request->detail,
            'department' => $request->department,
            'hotel' => $request->hotel,
            'location' => $request->location,
            'status' => $request->status,
            'updated_at' => $request->updated_at

        ];
        Travelodge::where('id', $id)->update($data);

        $accessToken = 'e1GzyiuXMwk1u5gA8MgtsWo1JBxNEvPeU6DCeKMQsab'; //token for test PAjBExb3IfM1VtcuNJVLhrj2mdN2ZNlAUTJXmbGRXAh e1GzyiuXMwk1u5gA8MgtsWo1JBxNEvPeU6DCeKMQsab
        $messageUrl = 'https://notify-api.line.me/api/notify';

        $client = new \GuzzleHttp\Client();

        $message = "Update Issue Reported:\n";
        $message .= "  - ID Issue: " . $request->id . "\n";
        $message .= "  - Issue Category: " . $request->issue . "\n";
        $message .= "  - Detail: " . $request->detail . "\n";
        /* $message .= "  - Department: " . $request->department . "\n";
        $message .= "  - Location: " . $request->location . "\n"; */
        $message .= "  - Hotel: " . $request->hotel . "\n";
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
        /* return redirect('/reports/reportIssue'); */
        return redirect($request->input('previous_url'));
    }

    function Tlcmn_UpdateGuest($id)
    {
        $ReportGuests = Tlcmn_guest::where('id', $id)->first();
        $buildings = Building::select('name')->get();

        return view('/guest/updateGuest', compact('ReportGuests', 'buildings'));
    }

    public function Tlcmn_UpdateGuestProcess(Request $request, $id)
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
                    'updated_at' => now()
                ];
                Tlcmn_guest::where('id', $id)->update($data);
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
                    'updated_at' => now()
                ];
                Ehcm_guest::where('id', $id)->update($data);
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
                    'updated_at' => now()
                ];
                Uncm_guest::where('id', $id)->update($data);
                return redirect('/uncm');
                break;
            default:
                return redirect()->back()->withErrors(['hotel' => 'Invalid hotel selection.']);
        }
    }

    function Tlcmn_UpdateSwitch($id)
    {
        $ReportSwitchs = Tlcmn_switch::where('id', $id)->first();
        $buildings = Building::select('name')->get();

        return view('/switchs/updateSwitch', compact('ReportSwitchs', 'buildings'));
    }

    public function Tlcmn_UpdateSwitchProcess(Request $request, $id)
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
                    'updated_at' => now()
                ];
                Tlcmn_switch::where('id', $id)->update($data);
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
                    'updated_at' => now()
                ];
                Ehcm_switch::where('id', $id)->update($data);
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
                    'updated_at' => now()
                ];
                Uncm_switch::where('id', $id)->update($data);
                return redirect('/uncm');
                break;
            default:
                return redirect()->back()->withErrors(['hotel' => 'Invalid hotel selection.']);
        }
    }

    function Tlcmn_UpdateServer($id)
    {
        $ReportServers = Tlcmn_server::where('id', $id)->first();

        return view('/servers/updateServer', compact('ReportServers'));
    }

    public function Tlcmn_UpdateServerProcess(Request $request, $id)
    {
        $request->validate([
            'server_temp' => 'required',
            'ups_temp' => 'required',
            'ups_battery' => 'required',
            'ups_time' => 'required'
        ]);

        $hotel = $request->input('hotel');

        switch ($hotel) {
            case 'tlcmn':
                $data = [
                    'server_temp' => $request->server_temp,
                    'ups_temp' => $request->ups_temp,
                    'ups_battery' => $request->ups_battery,
                    'ups_time' => $request->ups_time,
                    'updated_at' => now()
                ];
                Tlcmn_server::where('id', $id)->update($data);
                return redirect('/tlcmn');
                break;
            case 'ehcm':
                $data = [
                    'server_temp' => $request->server_temp,
                    'ups_temp' => $request->ups_temp,
                    'ups_battery' => $request->ups_battery,
                    'ups_time' => $request->ups_time,
                    'updated_at' => now()
                ];
                Ehcm_server::where('id', $id)->update($data);
                return redirect('/ehcm');
                break;
            case 'uncm':
                $data = [
                    'server_temp' => $request->server_temp,
                    'ups_temp' => $request->ups_temp,
                    'ups_battery' => $request->ups_battery,
                    'ups_time' => $request->ups_time,
                    'updated_at' => now()
                ];
                Uncm_server::where('id', $id)->update($data);
                return redirect('/uncm');
                break;
            default:
                return redirect()->back()->withErrors(['hotel' => 'Invalid hotel selection.']);
        }
    }

    function Tlcmn_UpdateReportNetSpeed($id)
    {
        $ReportNetSpeeds = Tlcmn_net::where('id', $id)->first();
        $buildings = Building::select('name')->get();

        return view('/netspeed/updateNetSpeed', compact('ReportNetSpeeds', 'buildings'));
    }

    public function Tlcmn_UpdateReportNetSpeedProcess(Request $request, $id)
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
                    'updated_at' => now()
                ];
                Tlcmn_net::where('id', $id)->update($data);
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
                    'updated_at' => now()
                ];
                Ehcm_net::where('id', $id)->update($data);
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
                    'updated_at' => now()
                ];
                Uncm_net::where('id', $id)->update($data);
                return redirect('/uncm');
                break;
            default:
                return redirect()->back()->withErrors(['hotel' => 'Invalid hotel selection.']);
        }
    }
}
