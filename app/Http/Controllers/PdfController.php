<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Travelodge;
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
}
