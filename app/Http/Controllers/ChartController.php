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

    private function getCategoryData($hotel)
    {
        $categoriesWithCounts = Travelodge::where('hotel', $hotel)
            ->select('issue as category')
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

    private function getDepartmentData($hotel)
    {
        $departmentsWithCounts = Travelodge::where('hotel', $hotel)
            ->select('department')
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

    public function getIssueDetails($type, $label, Request $request)
    {
        $hotel = $request->query('hotel');

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

        $issues = $query->get();

        return response()->json($issues);
    }

    private function calculatePercentages($data)
    {
        $total = array_sum($data);
        return array_map(function ($value) use ($total) {
            return round(($value / $total) * 100, 2);
        }, $data);
    }
}
