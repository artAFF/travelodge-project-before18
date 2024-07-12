<?php

namespace App\Http\Controllers;

use App\Models\Travelodge;
use Illuminate\Http\Request;
use App\Models\User;

class ChartController extends Controller
{
    private function calculatePercentages($data)
    {
        $total = array_sum($data);
        return array_map(function ($value) use ($total) {
            return round(($value / $total) * 100, 2);
        }, $data);
    }

    public function WeekChart(Request $request)
    {
        $chartType = $request->input('chart_type', 'bar');

        $travelodges = Travelodge::selectRaw('DAYOFWEEK(created_at) as day_of_week, COUNT(*) as count')
            ->whereYear('created_at', '=', now()->year)
            ->groupBy('day_of_week')
            ->orderBy('day_of_week')
            ->get();

        $status = ['Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat', 'Sun'];
        $data = [0, 0, 0, 0, 0, 0, 0];
        $colors = ['#C71585', '#E63946', '#F1C23B', '#53577A', '#2ECC40', '#3598DC', '#90CAF9'];

        foreach ($travelodges as $travelodge) {
            $index = ($travelodge->day_of_week + 5) % 7;
            $data[$index] = $travelodge->count;
        }

        $percentages = $this->calculatePercentages($data);

        $datasets = [
            [
                'label' => 'Issue',
                'data' => $chartType == 'bar' ? $data : $percentages,
                'backgroundColor' => $colors
            ]
        ];

        return view('/dashboards/dashboardWeek', compact('datasets', 'status', 'chartType'));
    }

    public function MonthChart(Request $request)
    {
        $chartType = $request->input('chart_type', 'bar');

        $travelodges = Travelodge::selectRaw('MONTH(created_at) as month, COUNT(*) as count')
            ->whereYear('created_at', date('Y'))
            ->groupBy('month')
            ->orderBy('month')
            ->get();

        $status = [];
        $data = [];
        $colors = ['#C71585', '#E63946', '#F1C23B', '#53577A', '#2ECC40', '#3598DC', '#90CAF9', '#D81B60', '#FF9999', '#6A3AB1', '#2196F3', '#1976D2'];

        for ($i = 1; $i < 13; $i++) {
            $month = date('F', mktime(0, 0, 0, $i, 1));
            $count = 0;

            foreach ($travelodges as $travelodge) {
                if ($travelodge->month == $i) {
                    $count = $travelodge->count;
                    break;
                }
            }

            array_push($status, $month);
            array_push($data, $count);
        }

        $percentages = $this->calculatePercentages($data);

        $datasets = [
            [
                'label' => 'Issue',
                'data' => $chartType == 'bar' ? $data : $percentages,
                'backgroundColor' => $colors
            ]
        ];

        return view('/dashboards/dashboardMonth', compact('datasets', 'status', 'chartType'));
    }

    public function DepartmentChart(Request $request)
    {
        $chartType = $request->input('chart_type', 'bar');

        $departmentsWithCounts = Travelodge::select('department')
            ->selectRaw('COUNT(*) as count')
            ->groupBy('department')
            ->orderByDesc('count')
            ->get();

        $departments = $departmentsWithCounts->pluck('department')->toArray();
        $data = $departmentsWithCounts->pluck('count')->toArray();

        $colors = ['#C71585', '#E63946', '#F1C23B', '#53577A', '#2ECC40', '#3598DC', '#90CAF9', '#D81B60', '#FF9999', '#6A3AB1', '#2196F3', '#1976D2', '#007bff'];
        $colors = array_slice($colors, 0, count($departments));

        $percentages = $this->calculatePercentages($data);

        $datasets = [
            [
                'label' => 'Issue',
                'data' => $chartType == 'bar' ? $data : $percentages,
                'backgroundColor' => $colors
            ]
        ];

        return view('/dashboards/dashboardDepartment', compact('datasets', 'departments', 'chartType'));
    }

    public function CategoryChart(Request $request)
    {
        $chartType = $request->input('chart_type', 'bar');

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
                'data' => $chartType == 'bar' ? $data : $percentages,
                'backgroundColor' => $colors
            ]
        ];

        return view('/dashboards/dashboardCategory', compact('datasets', 'categories', 'chartType'));
    }

    public function HotelChart(Request $request)
    {
        $chartType = $request->input('chart_type', 'bar');

        $hotels = [
            'TLCMN' => 'Travelodge Nimman',
            'EHCM' => 'Eastin Tan',
            'UNCM' => 'U Nimman'
        ];

        $data = [];
        $colors = ['#E74C3C', '#2CA02C', '#3498DB'];

        foreach ($hotels as $hotel => $hotelLabel) {
            $count = Travelodge::where('hotel', $hotel)->count();
            array_push($data, $count);
        }

        $percentages = $this->calculatePercentages($data);

        $datasets = [
            [
                'label' => 'Hotels',
                'data' => $chartType == 'bar' ? $data : $percentages,
                'backgroundColor' => $colors
            ]
        ];

        $hotels = array_values($hotels);

        return view('/dashboards/dashboardHotel', compact('datasets', 'hotels', 'chartType'));
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
