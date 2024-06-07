<?php

namespace App\Http\Controllers;

use App\Models\Building;
use App\Models\Department;
use App\Models\Travelodge;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;


class AdminController extends Controller
{
    /* function tablereport()
     {
        $reports = Travelodge::orderBy('id', 'desc')->paginate(10);
        return view('/report', compact('reports'));

        /* $reports = Travelodge::paginate(10);
        return view('/report', compact('reports')); 

    } */

    /* function addreports()
    {
        $buildings = Building::select('name')->get();
        $departments = Department::select('name')->get();
        return view('addreport', compact('buildings', 'departments'));
    } */

    /* function inserts(Request $request)
    {
        $request->validate([
            'issue' => 'required',
            'detail' => 'required'

        ]);
        $data = [
            'issue' => $request->issue,
            'detail' => $request->detail,
            'department' => $request->department,
            'location' => $request->location,
            'status' => $request->status,
            'created_at' => $request->created_at

        ];
        Travelodge::insert($data);
        return redirect('/report');
    } */

    /* function delete($id)
    {
        Travelodge::where('id', $id)->delete();
        return redirect('/report');
    } */

    /* function updatereports($id)
    {
        $report = Travelodge::where('id', $id)->first();
        $buildings = Building::select('name')->get();
        $departments = Department::select('name')->get();

        return view('updatereport', compact('report', 'buildings', 'departments'));
    } */

    /* function update(Request $request, $id)
    {
        $request->validate([
            'issue' => 'required',
            'detail' => 'required'

        ]);
        $data = [
            'issue' => $request->issue,
            'detail' => $request->detail,
            'department' => $request->department,
            'location' => $request->location,
            'status' => $request->status,
            'updated_at' => $request->updated_at

        ];
        Travelodge::where('id', $id)->update($data);
        return redirect('/report');
    } */

    /*  public function ncs()
    {
        $departments = [
            'Sales & Marketing' => ['0' => 0, '1' => 0],
            'Front Office' => ['0' => 0, '1' => 0],
            'IT' => ['0' => 0, '1' => 0],
        ];

        $travelodges = Travelodge::all();

        foreach ($travelodges as $travelodge) {
            $department = $travelodge->department;
            $status = $travelodge->status;

            $departments[$department][$status]++;
        }

        foreach ($departments as $department => $statuses) {
            $departments[$department]['total'] = array_sum($statuses);
        }

        return view('/home', ['departments' => $departments]);
    } */
}
