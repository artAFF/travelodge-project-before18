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
    public function __construct()
    {
        $this->middleware('auth');
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

        if ($request->category_id && $request->category_id != 'All') {
            $query->where('category_id', $request->category_id);
        }

        if ($request->department_id && $request->department_id != 'All') {
            $query->where('department_id', $request->department_id);
        }

        if ($request->hotel && $request->hotel != 'All') {
            $query->where('hotel', $request->hotel);
        }

        if ($request->status !== null && $request->status != 'All') {
            $query->where('status', $request->status);
        }

        if ($request->start_date) {
            if ($request->end_date) {
                $query->whereBetween('created_at', [$request->start_date, $request->end_date]);
            } else {
                $query->where('created_at', '>=', $request->start_date);
            }
        }

        $issues = $query->get();

        session([
            'filter_category_id' => $request->category_id,
            'filter_department_id' => $request->department_id,
            'filter_hotel' => $request->hotel,
            'filter_status' => $request->status,
            'filter_start_date' => $request->start_date,
            'filter_end_date' => $request->end_date,
        ]);

        return view('/filter/filtered-data', compact('issues'));
    }

    public function downloadPDF(Request $request)
    {
        $issuesJson = $request->issues;
        if (empty($issuesJson)) {
            return redirect()->back()->with('error', 'No data available for download.');
        }

        $issues = json_decode($issuesJson, true);
        if (json_last_error() !== JSON_ERROR_NONE) {
            return redirect()->back()->with('error', 'Invalid data format.');
        }

        $start_date = session('filter_start_date') ? \Carbon\Carbon::parse(session('filter_start_date'))->format('d/m/y') : 'N/A';
        $end_date = session('filter_end_date') ? \Carbon\Carbon::parse(session('filter_end_date'))->format('d/m/y') : 'N/A';

        $data = [
            'issues' => $issues,
            'start_date' => $start_date,
            'end_date' => $end_date,
            'category' => session('filter_category_id') ? Category::find(session('filter_category_id'))->name : 'All',
            'department' => session('filter_department_id') ? Department::find(session('filter_department_id'))->name : 'All',
            'hotel' => session('filter_hotel', 'All'),
            'status' => session('filter_status') === '0' ? 'In-progress' : (session('filter_status') === '1' ? 'Done' : 'All'),
        ];

        $pdf = FacadePdf::loadView('/filter/pdf-report', $data);

        return $pdf->download('IT_Support_Report.pdf');
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
            ->when($start_date && !$end_date, function ($q) use ($start_date) {
                return $q->where('created_at', '>=', $start_date);
            })
            ->when($query, function ($q) use ($query) {
                return $q->where('room_no', 'like', "%{$query}%")
                    ->orWhere('location', 'like', "%{$query}%")
                    ->orWhere('ch_name', 'like', "%{$query}%");
            });

        return $paginate ? $query->paginate(10, ['*'], 'guests_page') : $query->get();
    }

    private function getNetSpeeds($prefix, $start_date, $end_date, $query, $paginate = true)
    {
        $query = DB::table("{$prefix}nets")
            ->when($start_date && $end_date, function ($q) use ($start_date, $end_date) {
                return $q->whereBetween('created_at', [$start_date, $end_date]);
            })
            ->when($start_date && !$end_date, function ($q) use ($start_date) {
                return $q->where('created_at', '>=', $start_date);
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
            ->when($start_date && !$end_date, function ($q) use ($start_date) {
                return $q->where('created_at', '>=', $start_date);
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
            ->when($start_date && !$end_date, function ($q) use ($start_date) {
                return $q->where('created_at', '>=', $start_date);
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
