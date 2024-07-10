<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Travelodge;
use App\Models\Category;
use App\Models\Department;
use Barryvdh\DomPDF\Facade\Pdf as FacadePdf;
use Illuminate\Support\Facades\DB;
use PDF;

class PdfController extends Controller
{
    public function pdfissue($id)
    {
        $ReportIssues = Travelodge::find($id);

        $data = [
            'issue' => $ReportIssues->issue,
            'detail' => $ReportIssues->detail,
            'department' => $ReportIssues->department,
            'hotel' => $ReportIssues->hotel,
            'location' => $ReportIssues->location,
            'status' => $ReportIssues->status,
            'created_at' => $ReportIssues->created_at,
            'updated_at' => $ReportIssues->updated_at
        ];

        $pdf =  FacadePdf::loadView('/reports/pdf-issue', $data);

        return $pdf->download('report_issue.pdf');
    }

    public function printAllIssues()
    {
        $reportIssues = Travelodge::all();  // Travelodge::where('hotel', 'TLCMN')->where('status', 1)->get();

        $data = [];

        foreach ($reportIssues as $issue) {
            $data[] = [
                'id' =>  $issue->id,
                'issue' => $issue->issue,
                'detail' => $issue->detail,
                'department' => $issue->department,
                'hotel' => $issue->hotel,
                'location' => $issue->location,
                'status' => $issue->status,
                'created_at' => $issue->created_at,
                'updated_at' => $issue->updated_at
            ];
        }

        $issues = $reportIssues->chunk(2);

        $pdf = FacadePdf::loadView('/reports/pdf-issue-all', ['issues' => $issues]);

        return $pdf->download('report_issue_all.pdf');
    }

    public function showFilterForm()
    {
        $categories = Category::all();
        $departments = Department::all();
        $hotels = ['TLCMN', 'EHCM', 'UNCM'];

        return view('/filter/filter-form', compact('categories', 'departments', 'hotels'));
    }

    public function filterData(Request $request)
    {
        $query = Travelodge::query();

        if ($request->issue && $request->issue != 'All') {
            $query->where('issue', $request->issue);
        }

        if ($request->department && $request->department != 'All') {
            $query->where('department', $request->department);
        }

        if ($request->hotel && $request->hotel != 'All') {
            $query->where('hotel', $request->hotel);
        }

        if ($request->status !== null && $request->status != 'All') {
            $query->where('status', $request->status);
        }

        if ($request->start_date && $request->end_date) {
            $query->whereBetween('created_at', [$request->start_date, $request->end_date]);
        }

        $issues = $query->get();

        return view('/filter/filtered-data', compact('issues'));
    }

    public function downloadPDF(Request $request)
    {
     $issues = json_decode($request->issues, true);

        $pdf = FacadePdf::loadView('/filter/pdf-report', compact('issues'));

        return $pdf->download('report.pdf');
    }
}
