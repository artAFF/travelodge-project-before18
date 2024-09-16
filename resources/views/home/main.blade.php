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
                @foreach ($departments as $department => $statuse)
                    <tr>
                        <td>{{ $department }}</td>
                        <td>{{ $statuse['0'] }}</td>
                        <td>{{ $statuse['1'] }}</td>
                        <td>{{ $statuse['total'] }}</td>
                        <td>
                            @if (isset($departmentLinks[$department]))
                                @if (auth()->user()->role === 'admin' || auth()->user()->department->name === $department)
                                    <a href="{{ $departmentLinks[$department] }}" class="btn btn-primary">
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
