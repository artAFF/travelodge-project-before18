<?php

namespace App\Http\Controllers;

use App\Models\Travelodge;
use Illuminate\Http\Request;
use App\Models\User;

class ChartController extends Controller
{
    /*     public function __construct()
    {
        $this->middleware('auth');
    } */

    public function WeekChart()
    {
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

        $datasets = [
            [
                'label' => 'Travelodges',
                'data' => $data,
                'backgroundColor' => $colors
            ]
        ];

        return view('/dashboards/dashboardWeek', compact('datasets', 'status'));
    }

    public function MonthChart()
    {

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

        $datasets = [
            [
                'label' => 'Issue',
                'data' => $data,
                'backgroundColor' => $colors
            ]
        ];

        return view('/dashboards/dashboardMonth', compact('datasets', 'status'));
    }

    public function DepartmentChart()
    {
        $departments = [
            'IT Support',
            'Front Office',
            'Food and Beverage',
            'Housekeeping',
            'Engineering',
            'Finance and Accounting',
            'Human Resources',
            'Sale and Catering',
            'Kitchen',
            'Reservation',
            'Security'

        ];

        $data = [];
        $colors = ['#C71585', '#E63946', '#F1C23B', '#53577A', '#2ECC40', '#3598DC', '#90CAF9', '#D81B60', '#FF9999', '#6A3AB1', '#2196F3', '#1976D2', '#007bff'];

        foreach ($departments as $department) {
            /* $count = Travelodge::where('department', $department)
                ->where('created_at', '>=', date('Y-m-d', strtotime('-1 week')))
                ->count(); */
            $count = Travelodge::where('department', $department)->count();
            array_push($data, $count);
        }

        $datasets = [
            [
                'label' => 'Travelodges',
                'data' => $data,
                'backgroundColor' => $colors
            ]
        ];

        // ส่งข้อมูลไปยังวิว
        return view('/dashboards/dashboardDepartment', compact('datasets', 'departments'));
    }



    public function CategoryChart()
    {

        $categories = ['Computer', 'Comanche', 'Internet', 'Server', 'Program', 'Printer', 'Telephone', 'CCTV', 'TV', 'Sound', 'Others'];

        $data = [];

        $colors = ['#C71585', '#E63946', '#F1C23B', '#53577A', '#6495ED', '#20B2AA', '#FFA07A', '#808080', '#7FFFD4', '#D3D3D3', '#90CAF9'];

        foreach ($categories as $category) {

            /* $count = Travelodge::where('issue', $category)
                ->where('created_at', '>=', date('Y-m-d', strtotime('-1 week')))
                ->count(); */
            $count = Travelodge::where('issue', $category)->count();
            array_push($data, $count);
        }

        $datasets = [
            [
                'label' => 'Travelodges',
                'data' => $data,
                'backgroundColor' => $colors
            ]
        ];

        return view('/dashboards/dashboardCategory', compact('datasets', 'categories'));
    }


    public function HotelChart()
    {

        $hotels = [
            'TLCMN' => 'Travelodge Nimman',
            'EHCM' => 'Eastin Tan',
            'UNCM' => 'U Nimman'
        ];

        $data = [];
        $colors = ['#E74C3C', '#2CA02C', '#3498DB'];

        foreach ($hotels as $hotel => $hotelLabel) {
            /*  $count = Travelodge::where('hotel', $hotel)
                ->where('created_at', '>=', date('Y-m-d', strtotime('-1 week')))
                ->count(); */
            $count = Travelodge::where('hotel', $hotel)->count();
            array_push($data, $count);
        }

        $datasets = [
            [
                'label' => 'Hotels',
                'data' => $data,
                'backgroundColor' => $colors
            ]
        ];


        $hotels = array_values($hotels);

        return view('/dashboards/dashboardHotel', compact('datasets', 'hotels'));
    }

    public function StatusChart()
    {
        $inProcessCount = Travelodge::where('status', 0)->count();
        $doneCount = Travelodge::where('status', 1)->count();

        $data = [
            'done' => $doneCount,
            'in_process' => $inProcessCount

        ];

        $status = ['Done', 'In-process'];
        $colors = ['#2CA02C', '#E74C3C'];

        $datasets = [
            [
                'label' => 'Status',
                'data' => array_values($data),
                'backgroundColor' => $colors
            ]
        ];

        return view('/dashboards/dashbordStatus', compact('datasets', 'status'));
    }
}
