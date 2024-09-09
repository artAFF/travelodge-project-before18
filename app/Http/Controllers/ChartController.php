<?php

namespace App\Http\Controllers;

use App\Models\Travelodge;
use Illuminate\Http\Request;
use App\Models\User;

class ChartController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    private function calculatePercentages($data)
    {
        $total = array_sum($data);
        return array_map(function ($value) use ($total) {
            return round(($value / $total) * 100, 2);
        }, $data);
    }

    public function DepartmentChart(Request $request)
    {
        $departmentsWithCounts = Travelodge::select('department')
            ->selectRaw('COUNT(*) as count')
            ->groupBy('department')
            ->orderByDesc('count')
            ->get();

        $departments = $departmentsWithCounts->pluck('department')->toArray();
        $data = array_combine($departments, $departmentsWithCounts->pluck('count')->toArray());


        $colors = ['#C71585', '#E63946', '#F1C23B', '#53577A', '#2ECC40', '#3598DC', '#90CAF9', '#D81B60', '#FF9999', '#6A3AB1', '#2196F3', '#1976D2', '#007bff'];
        $colors = array_slice($colors, 0, count($departments));

        $percentages = $this->calculatePercentages($data);

        $datasets = [
            [
                'label' => 'Issue',
                'data' => $data,
                'backgroundColor' => $colors
            ]
        ];

        return view('/dashboards/dashboardDepartment', compact('datasets', 'departments', 'percentages'));
    }

    public function CategoryChart(Request $request)
    {
        $categoriesWithCounts = Travelodge::select('issue as category')
            ->selectRaw('COUNT(*) as count')
            ->groupBy('issue')
            ->orderByDesc('count')
            ->get();

        $categories = $categoriesWithCounts->pluck('category')->toArray();
        $data = $categoriesWithCounts->pluck('count')->toArray();

        $colors = ['#C71585', '#E63946', '#F1C23B', '#53577A', '#6495ED', '#20B2AA', '#FFA07A', '#808080', '#7FFFD4', '#D3D3D3', '#90CAF9'];
        $colors = array_slice($colors, 0, count($categories));

        $percentages = $this->calculatePercentages($data);

        $datasets = [
            [
                'label' => 'Issue',
                'data' => $data,
                'backgroundColor' => $colors
            ]
        ];

        return view('/dashboards/dashboardCategory', compact('datasets', 'categories', 'percentages'));
    }

    public function HotelChart(Request $request)
    {
        $hotels = [
            'TLCMN' => 'Travelodge Nimman',
            'EHCM' => 'Eastin Tan',
            'UNCM' => 'U Nimman'
        ];
        $data = [];
        $colors = ['#E74C3C', '#2CA02C', '#3498DB'];
        $latestReports = [];

        foreach ($hotels as $hotel => $hotelLabel) {
            $count = Travelodge::where('hotel', $hotel)->count();
            array_push($data, $count);

            // Fetch the 5 latest reports for each hotel
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

    public function StatusChart(Request $request)
    {
        $chartType = $request->input('chart_type', 'bar');

        $inProcessCount = Travelodge::where('status', 0)->count();
        $doneCount = Travelodge::where('status', 1)->count();

        $data = [
            'done' => $doneCount,
            'in_process' => $inProcessCount
        ];

        $status = ['Done', 'In-process'];
        $colors = ['#2CA02C', '#E74C3C'];

        $percentages = $this->calculatePercentages($data);

        $datasets = [
            [
                'label' => 'Issue',
                'data' => $chartType == 'bar' ? array_values($data) : array_values($percentages),
                'backgroundColor' => $colors
            ]
        ];

        return view('/dashboards/dashbordStatus', compact('datasets', 'status', 'chartType'));
    }
}
