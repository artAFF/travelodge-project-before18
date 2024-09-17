@extends('layouts.app')
@section('title', 'Home')
@section('content')
    <div class="container">

        <h2 class="text text-center">Number of current states By Department</h2>
        <table class="table table-striped table-hover">
            <thead>
                <th>Department</th>
                <th>In-process</th>
                <th>Done</th>
                <th>Total</th>
                <th>View</th>
            </thead>
            <tbody>
                @foreach ($departments as $department_id => $statuse)
                    <tr>
                        <td>{{ App\Models\Department::find($department_id)->name ?? 'N/A' }}</td>
                        <td>{{ $statuse['0'] ?? 'N/A' }}</td>
                        <td>{{ $statuse['1'] ?? 'N/A' }}</td>
                        <td>{{ $statuse['total'] ?? 'N/A' }}</td>
                        <td>
                            @if (isset($departmentLinks[$department_id]))
                                @if (auth()->user()->role === 'admin' || auth()->user()->department_id === $department_id)
                                    <a href="{{ $departmentLinks[$department_id] }}" class="btn btn-primary">
                                        <i class="bi bi-hourglass-split"></i>
                                    </a>
                                @else
                                    <button class="btn btn-secondary" disabled>
                                        <i class="bi bi-hourglass-split"></i>
                                    </button>
                                @endif
                            @endif
                        </td>
                    </tr>
                @endforeach
                <tr>
                    <td>Total All</td>
                    <td>{{ $allTotals['0'] }}</td>
                    <td>{{ $allTotals['1'] }}</td>
                    <td>{{ $allTotals['total'] }}</td>
                    <td></td>
                </tr>
            </tbody>
        </table><br>
        <hr><br>
    </div>
@endsection
