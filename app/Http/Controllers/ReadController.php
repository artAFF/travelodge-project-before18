<?php

namespace App\Http\Controllers;

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
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;


class ReadController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function TableReportIssue(Request $request)
    {
        $query = $request->input('query');
        $sort_by = $request->input('sort_by', 'id');
        $sort_order = $request->input('sort_order', 'desc');
        $user = auth()->user();

        $ReportIssues = Travelodge::with(['category', 'department', 'assignee'])
            ->when($query, function ($q) use ($query) {
                $q->whereHas('category', function ($q) use ($query) {
                    $q->where('name', 'like', "%{$query}%");
                })->orWhereHas('department', function ($q) use ($query) {
                    $q->where('name', 'like', "%{$query}%");
                })->orWhere('detail', 'like', "%{$query}%")
                    ->orWhere('hotel', 'like', "%{$query}%");
            })
            ->when($user->role !== 'admin', function ($q) use ($user) {
                $q->where('department_id', $user->department_id);
            })
            ->orderBy($sort_by, $sort_order)
            ->paginate(10)
            ->appends(['query' => $query, 'sort_by' => $sort_by, 'sort_order' => $sort_order]);

        $itSupportUsers = User::whereHas('department', function ($query) {
            $query->where('name', 'IT Support');
        })->get();

        return view('/reports/reportIssue', compact('ReportIssues', 'query', 'sort_by', 'sort_order', 'itSupportUsers'));
    }

    public function InprocessIssue(Request $request)
    {
        $query = $request->input('query');
        $sort_by = $request->input('sort_by', 'id');
        $sort_order = $request->input('sort_order', 'desc');
        $user = auth()->user();

        $in_process = Travelodge::with(['category', 'department', 'assignee'])
            ->where('status', 0)
            ->when($query, function ($q) use ($query) {
                $q->whereHas('category', function ($q) use ($query) {
                    $q->where('name', 'like', "%{$query}%");
                })->orWhereHas('department', function ($q) use ($query) {
                    $q->where('name', 'like', "%{$query}%");
                })->orWhere('detail', 'like', "%{$query}%")
                    ->orWhere('hotel', 'like', "%{$query}%");
            })
            ->when($user->role !== 'admin', function ($q) use ($user) {
                $q->where('department_id', $user->department_id);
            })
            ->orderBy($sort_by, $sort_order)
            ->paginate(10)
            ->appends(['query' => $query, 'sort_by' => $sort_by, 'sort_order' => $sort_order]);

        $itSupportUsers = User::whereHas('department', function ($query) {
            $query->where('name', 'IT Support');
        })->get();

        return view('/reports/inprocess', compact('in_process', 'query', 'sort_by', 'sort_order', 'itSupportUsers'));
    }

    public function TableReportAll(Request $request, $type)
    {
        $prefix = $this->getPrefixFromType($type);
        $source = $type;

        $pageGuests = $request->input('pageGuests', 1);
        $pageSwitchs = $request->input('pageSwitchs', 1);
        $pageServers = $request->input('pageServers', 1);
        $pageNetSpeeds = $request->input('pageNetSpeeds', 1);

        $ReportGuests = DB::table("{$prefix}guests")->orderBy('id', 'desc')->paginate(10, ['*'], 'pageGuests', $pageGuests);
        $ReportSwitchs = DB::table("{$prefix}switches")->orderBy('id', 'desc')->paginate(10, ['*'], 'pageSwitchs', $pageSwitchs);
        $ReportServers = DB::table("{$prefix}servers")->orderBy('id', 'desc')->paginate(10, ['*'], 'pageServers', $pageServers);
        $ReportNetSpeeds = DB::table("{$prefix}nets")->orderBy('id', 'desc')->paginate(10, ['*'], 'pageNetSpeeds', $pageNetSpeeds);

        if ($request->ajax()) {
            return response()->json([
                'ReportGuests' => view('partials.report_guests', compact('ReportGuests', 'source'))->render(),
                'ReportSwitchs' => view('partials.report_switchs', compact('ReportSwitchs', 'source'))->render(),
                'ReportServers' => view('partials.report_servers', compact('ReportServers', 'source'))->render(),
                'ReportNetSpeeds' => view('partials.report_netspeeds', compact('ReportNetSpeeds', 'source'))->render(),
            ]);
        }

        return view("daily.hotels.{$source}", compact('ReportGuests', 'ReportSwitchs', 'ReportServers', 'ReportNetSpeeds', 'source'));
    }

    private function getPrefixFromType($type)
    {
        switch ($type) {
            case 'ehcm':
                return 'Ehcm_';
            case 'uncm':
                return 'Uncm_';
            default:
                return 'Tlcmn_';
        }
    }

    public function preview($id)
    {
        $report = Travelodge::findOrFail($id);
        return view('/reports/preview-issue', compact('report'));
    }

    public function inprocess(Request $request)
    {
        $query = $request->input('query');
        $sort_by = $request->input('sort_by', 'id');
        $sort_order = $request->input('sort_order', 'asc');
        $user = auth()->user();

        $in_process = Travelodge::with(['category', 'department', 'assignee'])
            ->where('status', 0)
            ->when($query, function ($q) use ($query) {
                $q->whereHas('category', function ($q) use ($query) {
                    $q->where('name', 'like', "%{$query}%");
                })->orWhereHas('department', function ($q) use ($query) {
                    $q->where('name', 'like', "%{$query}%");
                })->orWhere('detail', 'like', "%{$query}%")
                    ->orWhere('hotel', 'like', "%{$query}%");
            })
            ->when($user->role !== 'admin', function ($q) use ($user) {
                $q->where('department_id', $user->department_id);
            })
            ->orderBy($sort_by, $sort_order)
            ->paginate(10)
            ->appends(['query' => $query, 'sort_by' => $sort_by, 'sort_order' => $sort_order]);

        $itSupportUsers = User::whereHas('department', function ($query) {
            $query->where('name', 'IT Support');
        })->get();

        return view('/reports/inprocess', compact('in_process', 'query', 'sort_by', 'sort_order', 'itSupportUsers'));
    }

    public function filterDate(Request $request)
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
        $departments = [];
        $departmentLinks = [];

        $departmentRecords = Department::all();

        foreach ($departmentRecords as $dept) {
            $departments[$dept->name] = ['0' => 0, '1' => 0];
            $departmentLinks[$dept->name] = route('itsup_status', ['department' => $dept->name]);
        }

        $travelodges = Travelodge::all();
        foreach ($travelodges as $travelodge) {
            $department = $travelodge->department;
            $status = $travelodge->status;
            if (isset($departments[$department])) {
                if (isset($departments[$department][$status])) {
                    $departments[$department][$status]++;
                } else {
                    error_log("Invalid status '$status' for department '$department'");
                }
            } else {
                error_log("Invalid department '$department'");
            }
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

    public function itsup_status($department)
    {
        $user = auth()->user();

        if ($user->role !== 'admin' && $user->department->name !== $department) {
            abort(403, 'Unauthorized action.');
        }

        $itsup_statuses = Travelodge::where('department', $department)
            ->where('status', 0)
            ->paginate(15);

        return view('home.itsup_status', compact('itsup_statuses', 'department'));
    }
}
