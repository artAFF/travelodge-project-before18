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
        $reportIssues = Travelodge::all();

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

    public function search(Request $request)
    {
        $query = $request->input('query', '');
        $start_date = $request->input('start_date');
        $end_date = $request->input('end_date');
        $hotel = $request->input('hotel', 'tlcmn');
        $category = $request->input('category', 'all');

        $prefix = $this->getPrefixFromHotel($hotel);

        $guests = ($category == 'all' || $category == 'guest') ? $this->getGuests($prefix, $start_date, $end_date, $query, true) : collect();
        $netSpeeds = ($category == 'all' || $category == 'internet') ? $this->getNetSpeeds($prefix, $start_date, $end_date, $query, true) : collect();
        $servers = ($category == 'all' || $category == 'server') ? $this->getServers($prefix, $start_date, $end_date, $query, true) : collect();
        $switches = ($category == 'all' || $category == 'switch') ? $this->getSwitches($prefix, $start_date, $end_date, $query, true) : collect();

        $searchResults = [
            'guests' => $guests,
            'netSpeeds' => $netSpeeds,
            'servers' => $servers,
            'switches' => $switches,
            'category' => $category,
            'query' => $query,
            'start_date' => $start_date,
            'end_date' => $end_date,
            'hotel' => $hotel
        ];

        $request->session()->put('searchResults', $searchResults);

        return view('/daily/search', $searchResults);
    }

    public function downloadPdfDaily(Request $request)
    {
        $searchParams = $request->session()->get('searchResults');

        if (!$searchParams) {
            return redirect()->route('search')->with('error', 'No search results found. Please perform a search first.');
        }

        $prefix = $this->getPrefixFromHotel($searchParams['hotel']);
        $category = $searchParams['category'] ?? 'all';
        $start_date = $searchParams['start_date'];
        $end_date = $searchParams['end_date'];
        $query = $searchParams['query'];

        $guests = ($category == 'all' || $category == 'guest') ? $this->getGuests($prefix, $start_date, $end_date, $query, false) : collect();
        $netSpeeds = ($category == 'all' || $category == 'internet') ? $this->getNetSpeeds($prefix, $start_date, $end_date, $query, false) : collect();
        $servers = ($category == 'all' || $category == 'server') ? $this->getServers($prefix, $start_date, $end_date, $query, false) : collect();
        $switches = ($category == 'all' || $category == 'switch') ? $this->getSwitches($prefix, $start_date, $end_date, $query, false) : collect();

        $pdfData = [
            'guests' => $guests,
            'netSpeeds' => $netSpeeds,
            'servers' => $servers,
            'switches' => $switches,
            'category' => $category,
            'start_date' => $start_date,
            'end_date' => $end_date,
            'hotel' => $searchParams['hotel']
        ];

        $pdf = FacadePdf::loadView('/daily/pdf-daily', $pdfData);

        return $pdf->download('daily_report.pdf');
    }

    private function getGuests($prefix, $start_date, $end_date, $query, $paginate = true)
    {
        $query = DB::table("{$prefix}guests")
            ->when($start_date && $end_date, function ($q) use ($start_date, $end_date) {
                return $q->whereBetween('created_at', [$start_date, $end_date]);
            })
            ->when($query, function ($q) use ($query) {
                return $q->where('room_no', 'like', "%{$query}%")
                    ->orWhere('location', 'like', "%{$query}%")
                    ->orWhere('ch_name', 'like', "%{$query}%");
            });

        return $paginate ? $query->paginate(10, ['*'], 'guests_page') : $query->get();
    }

    function getNetSpeeds($prefix, $start_date, $end_date, $query, $paginate = true)
    {
        $query = DB::table("{$prefix}nets")
            ->when($start_date && $end_date, function ($q) use ($start_date, $end_date) {
                return $q->whereBetween('created_at', [$start_date, $end_date]);
            })
            ->when($query, function ($q) use ($query) {
                return $q->where('location', 'like', "%{$query}%");
            });

        return $paginate ? $query->paginate(10, ['*'], 'netSpeeds_page') : $query->get();
    }

    private function getServers($prefix, $start_date, $end_date, $query, $paginate = true)
    {
        $query = DB::table("{$prefix}servers")
            ->when($start_date && $end_date, function ($q) use ($start_date, $end_date) {
                return $q->whereBetween('created_at', [$start_date, $end_date]);
            })
            ->when($query, function ($q) use ($query) {
                return $q->where('server_temp', 'like', "%{$query}%");
            });

        return $paginate ? $query->paginate(10, ['*'], 'servers_page') : $query->get();
    }

    private function getSwitches($prefix, $start_date, $end_date, $query, $paginate = true)
    {
        $query = DB::table("{$prefix}switches")
            ->when($start_date && $end_date, function ($q) use ($start_date, $end_date) {
                return $q->whereBetween('created_at', [$start_date, $end_date]);
            })
            ->when($query, function ($q) use ($query) {
                return $q->where('location', 'like', "%{$query}%");
            });

        return $paginate ? $query->paginate(10, ['*'], 'switches_page') : $query->get();
    }

    private function getPrefixFromHotel($hotel)
    {
        switch ($hotel) {
            case 'tlcmn':
                return 'tlcmn_';
            case 'ehcm':
                return 'ehcm_';
            case 'uncm':
                return 'uncm_';
            default:
                return '';
        }
    }
}
