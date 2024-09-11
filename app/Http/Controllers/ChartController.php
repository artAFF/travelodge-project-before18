<?php

namespace App\Http\Controllers;

use App\Models\Travelodge;
use Illuminate\Http\Request;
use App\Models\User;
use Carbon\Carbon;

class ChartController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function HotelChart(Request $request)
    {
        $hotels = [
            'TLCMN' => 'TLCMN',
            'EHCM' => 'EHCM',
            'UNCM' => 'UNCM '
        ];
        $data = [];
        $colors = ['#E74C3C', '#2CA02C', '#3498DB'];
        $latestReports = [];

        foreach ($hotels as $hotel => $hotelLabel) {
            $count = Travelodge::where('hotel', $hotel)->count();
            array_push($data, $count);

            $latestHotelReports = Travelodge::where('hotel', $hotel)
                ->orderBy('created_at', 'desc')
                ->take(5)
                ->get(['id', 'detail', 'created_at']);
            $latestReports[$hotelLabel] = $latestHotelReports;
        }

        $percentages = $this->calculatePercentages($data);
        $datasets = [
            [
                'label' => 'Hotels',
                'data' => $data,
                'backgroundColor' => $colors
            ]
        ];
        $hotels = array_values($hotels);

        return view('/home', compact('datasets', 'hotels', 'percentages', 'latestReports'));
    }

    public function HotelDashboard(Request $request, $hotel)
    {
        $hotel_names = [
            'TLCMN' => 'Travelodge Nimman',
            'EHCM' => 'Eastin Tan',
            'UNCM' => 'U nimman'
        ];

        $category_data = $this->getCategoryData($hotel);
        $department_data = $this->getDepartmentData($hotel);

        return view('dashboards.hotel_dashboard', [
            'hotel_name' => $hotel_names[$hotel],
            'hotel_code' => $hotel,
            'category_data' => $category_data,
            'department_data' => $department_data
        ]);
    }

    public function getHotelDataByDate($view, $filterType, Request $request)
    {
        $hotel = $request->query('hotel');
        $query = Travelodge::where('hotel', $hotel);

        if ($filterType !== 'all_time') {
            $this->applyDateFilter($query, $filterType);
        }

        if ($view === 'category') {
            $data = $this->getCategoryDataFromQuery($query);
        } else {
            $data = $this->getDepartmentDataFromQuery($query);
        }

        return response()->json($data);
    }

    public function getIssueDetails($type, $label, Request $request)
    {
        $hotel = $request->query('hotel');
        $dateFilter = $request->query('dateFilter');
        $startDate = $request->query('start');
        $endDate = $request->query('end');

        $query = Travelodge::query();

        // Filter by hotel
        if ($hotel) {
            $query->where('hotel', $hotel);
        }

        // Filter by type (category or department)
        if ($type === 'category') {
            $query->where('issue', $label);
        } elseif ($type === 'department') {
            $query->where('department', $label);
        }

        // Apply date filter
        if ($dateFilter && $dateFilter !== 'all_time') {
            $this->applyDateFilter($query, $dateFilter);
        } elseif ($startDate && $endDate) {
            $query->whereBetween('created_at', [$startDate, $endDate]);
        }

        $issues = $query->get();

        return response()->json($issues);
    }

    private function applyDateFilter($query, $filterType)
    {
        switch ($filterType) {
            case 'today':
                $query->whereDate('created_at', Carbon::today());
                break;
            case 'yesterday':
                $query->whereDate('created_at', Carbon::yesterday());
                break;
            case 'this_week':
                $query->whereBetween('created_at', [Carbon::now()->startOfWeek(), Carbon::now()->endOfWeek()]);
                break;
            case 'last_week':
                $query->whereBetween('created_at', [Carbon::now()->subWeek()->startOfWeek(), Carbon::now()->subWeek()->endOfWeek()]);
                break;
            case 'this_month':
                $query->whereMonth('created_at', Carbon::now()->month);
                break;
            case 'last_month':
                $query->whereMonth('created_at', Carbon::now()->subMonth()->month);
                break;
            case 'last_30_days':
                $query->where('created_at', '>=', Carbon::now()->subDays(30));
                break;
            case 'this_quarter':
                $query->whereBetween('created_at', [Carbon::now()->startOfQuarter(), Carbon::now()->endOfQuarter()]);
                break;
            case 'last_quarter':
                $query->whereBetween('created_at', [Carbon::now()->subQuarter()->startOfQuarter(), Carbon::now()->subQuarter()->endOfQuarter()]);
                break;
            case 'this_year':
                $query->whereYear('created_at', Carbon::now()->year);
                break;
            case 'last_year':
                $query->whereYear('created_at', Carbon::now()->subYear()->year);
                break;
            case 'last_365_days':
                $query->where('created_at', '>=', Carbon::now()->subDays(365));
                break;
        }
    }

    private function getCategoryData($hotel)
    {
        $query = Travelodge::where('hotel', $hotel);
        return $this->getCategoryDataFromQuery($query);
    }

    private function getDepartmentData($hotel)
    {
        $query = Travelodge::where('hotel', $hotel);
        return $this->getDepartmentDataFromQuery($query);
    }

    private function getCategoryDataFromQuery($query)
    {
        $categoriesWithCounts = $query->select('issue as category')
            ->selectRaw('COUNT(*) as count')
            ->groupBy('issue')
            ->orderByDesc('count')
            ->get();

        $categories = $categoriesWithCounts->pluck('category')->toArray();
        $data = $categoriesWithCounts->pluck('count')->toArray();

        $colors = ['#C71585', '#E63946', '#F1C23B', '#53577A', '#6495ED', '#20B2AA', '#FFA07A', '#808080', '#7FFFD4', '#D3D3D3', '#90CAF9'];
        $colors = array_slice($colors, 0, count($categories));

        return [
            'labels' => $categories,
            'data' => $data,
            'backgroundColor' => $colors
        ];
    }

    private function getDepartmentDataFromQuery($query)
    {
        $departmentsWithCounts = $query->select('department')
            ->selectRaw('COUNT(*) as count')
            ->groupBy('department')
            ->orderByDesc('count')
            ->get();

        $departments = $departmentsWithCounts->pluck('department')->toArray();
        $data = $departmentsWithCounts->pluck('count')->toArray();

        $colors = ['#C71585', '#E63946', '#F1C23B', '#53577A', '#2ECC40', '#3598DC', '#90CAF9', '#D81B60', '#FF9999', '#6A3AB1', '#2196F3', '#1976D2', '#007bff'];
        $colors = array_slice($colors, 0, count($departments));

        return [
            'labels' => $departments,
            'data' => $data,
            'backgroundColor' => $colors
        ];
    }

    private function calculatePercentages($data)
    {
        $total = array_sum($data);
        return array_map(function ($value) use ($total) {
            return round(($value / $total) * 100, 2);
        }, $data);
    }
}
