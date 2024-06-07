<?php

namespace App\Http\Controllers;

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


class ReadController extends Controller
{
    /*  public function __construct()
    {
        $this->middleware('auth');
    } */

    function TableReportIssue(Request $request)
    {
        $query = $request->input('query');
        $sort_by = $request->input('sort_by', 'id');
        $sort_order = $request->input('sort_order', 'desc');

        $ReportIssues = Travelodge::query()
            ->when($query, function ($q) use ($query) {
                $q->where('issue', 'like', "%{$query}%")
                    ->orWhere('detail', 'like', "%{$query}%")
                    ->orWhere('department', 'like', "%{$query}%")
                    ->orWhere('hotel', 'like', "%{$query}%")
                    ->orWhere('location', 'like', "%{$query}%");
            })
            ->orderBy($sort_by, $sort_order)
            ->paginate(10);

        return view('/reports/reportIssue', compact('ReportIssues', 'query', 'sort_by', 'sort_order'));
    }
    /*
    function TableReportIssue()
    {
        $ReportIssues = Travelodge::orderBy('id', 'desc')->paginate(10);
        return view('/reportIssue', compact('ReportIssues'));
    }
        $reports = Travelodge::paginate(10);
        return view('/report', compact('reports')); */

    /*  function TableReportGuest()
    {
        $ReportGuests = GuestRoom::orderBy('id', 'desc')->paginate(10);
        return view('/guest/reportGuest', compact('ReportGuests'));
    }

    function TableReportSwitch()
    {
        $ReportSwitchs = SwitchRoom::orderBy('id', 'desc')->paginate(10);
        return view('/switchs/reportSwitch', compact('ReportSwitchs'));
    }

    function TableReportServer()
    {
        $ReportServers = ServerRoom::orderBy('id', 'desc')->paginate(10);
        return view('/server/reportServer', compact('ReportServers'));
    }

    function TableReportNetSpeed()
    {
        $ReportNetSpeeds = NetSpeed::orderBy('id', 'desc')->paginate(10);
        return view('/netspeed/reportNet', compact('ReportNetSpeeds'));
    } */

    function TableReportAll(Request $request)
    {
        $pageGuests = $request->input('pageGuests', 1);
        $pageSwitchs = $request->input('pageSwitchs', 1);
        $pageServers = $request->input('pageServers', 1);
        $pageNetSpeeds = $request->input('pageNetSpeeds', 1);

        $ReportGuests = Tlcmn_guest::orderBy('id', 'desc')->paginate(10, ['*'], 'pageGuests', $pageGuests);
        $ReportSwitchs = Tlcmn_switch::orderBy('id', 'desc')->paginate(10, ['*'], 'pageSwitchs', $pageSwitchs);
        $ReportServers = Tlcmn_server::orderBy('id', 'desc')->paginate(10, ['*'], 'pageServers', $pageServers);
        $ReportNetSpeeds = Tlcmn_net::orderBy('id', 'desc')->paginate(10, ['*'], 'pageNetSpeeds', $pageNetSpeeds);

        return view('tlcmn', compact('ReportGuests', 'ReportSwitchs', 'ReportServers', 'ReportNetSpeeds'));
    }


    public function inprocess(Request $request)
    {
        $query = $request->input('query');
        $sort_by = $request->input('sort_by', 'id'); // Default sorting column
        $sort_order = $request->input('sort_order', 'asc'); // Default sorting order

        $in_process = Travelodge::where('status', 0)
            ->when($query, function ($queryBuilder) use ($query) {
                return $queryBuilder->where(function ($q) use ($query) {
                    $q->where('issue', 'like', "%{$query}%")
                        ->orWhere('detail', 'like', "%{$query}%")
                        ->orWhere('department', 'like', "%{$query}%")
                        ->orWhere('hotel', 'like', "%{$query}%")
                        ->orWhere('location', 'like', "%{$query}%");
                });
            })
            ->orderBy($sort_by, $sort_order)
            ->paginate(15);

        return view('/reports/inprocess', compact('in_process', 'query', 'sort_by', 'sort_order'));
    }

    public function filter(Request $request)
    {
        $start_date = $request->start_date;
        $end_date = $request->end_date;

        $in_process = Travelodge::whereDate('created_at', '>=', $start_date)
            ->whereDate('updated_at', '<=', $end_date)
            ->paginate(15);

        return view('/reports/inprocess', compact('in_process'));
    }

    function NumberOfCurrentStatus()
    {
        $departments = [
            'IT Support' => ['0' => 0, '1' => 0],
            'Admin and General' => ['0' => 0, '1' => 0],
            'Front Office' => ['0' => 0, '1' => 0],
            'Food and Beverage' => ['0' => 0, '1' => 0],
            'Housekeeping' => ['0' => 0, '1' => 0],
            'Engineering' => ['0' => 0, '1' => 0],
            'Finance and Accounting' => ['0' => 0, '1' => 0],
            'Human Resources' => ['0' => 0, '1' => 0],
            'Sale and Catering' => ['0' => 0, '1' => 0],
            'Kitchen' => ['0' => 0, '1' => 0],
            'Reservation' => ['0' => 0, '1' => 0],
            'Security' => ['0' => 0, '1' => 0]
        ];

        $departmentLinks = [
            'IT Support' => "/home/itsup_status",
            'Admin and General' => '/home/admin_status',
            'Front Office' => '#',
            'Food and Beverage' => '#',
            'Housekeeping' => '#',
            'Engineering' => '#',
            'Finance and Accounting' => '#',
            'Human Resources' => '#',
            'Sale and Catering' => '#',
            'Kitchen' => '#',
            'Reservation' => '#',
            'Security' => '#'
        ];

        $travelodges = Travelodge::all();

        foreach ($travelodges as $travelodge) {
            $department = $travelodge->department;
            $status = $travelodge->status;

            $departments[$department][$status]++;
        }

        $allTotals = ['0' => 0, '1' => 0, 'total' => 0];

        foreach ($departments as $department => $statuses) {
            $departments[$department]['total'] = array_sum($statuses);
            $allTotals['0'] += $statuses['0'];
            $allTotals['1'] += $statuses['1'];
            $allTotals['total'] += $departments[$department]['total'];
        }

        return view('/home/main', ['departments' => $departments, 'departmentLinks' => $departmentLinks, 'allTotals' => $allTotals]);
    }

    public function itsup_status()
    {

        $itsup_statuses = Travelodge::where('department', 'IT Support')
            ->where('status', 0)
            ->paginate(15);

        return view('/home/itsup_status', compact('itsup_statuses'));
    }

    public function admin_status()
    {

        $admin_statuses = Travelodge::where('department', 'Admin and General')
            ->where('status', 0)
            ->paginate(15);

        return view('/home/admin_status', compact('admin_statuses'));
    }
}
