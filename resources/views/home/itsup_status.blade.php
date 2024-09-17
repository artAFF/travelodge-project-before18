@extends('layouts.app')
@section('title', 'IT Support Status')

@section('content')
    @if (count($itsup_statuses) > 0)
        <div class="container">
            <h1 class="text-center">{{ $department->name ?? 'N/A' }} Issues in the Process</h1>

            <form method="GET" action="/filter">
                <div class="row pb-3">
                    <div class="col-md-3">
                        <label>Start Date:</label>
                        <input type="date" name="start_date" class="form-control">
                    </div>
                    <div class="col-md-3">
                        <label>End Date:</label>
                        <input type="date" name="end_date" class="form-control">
                    </div>
                    <div class="col-md pt-4">
                        <button type="submit" class="btn btn-primary col-md-3">Filter</button>
                    </div>
                </div>
            </form>

            <table class="table table-striped table-hover">
                <thead>
                    <tr>
                        <th>#</th>
                        <td>Issue</td>
                        <th class="col-md-3" scope="col">Detail</th>
                        <th>Department</th>
                        <th>Hotel</th>
                        <th>Status</th>
                        <th>Created At</th>
                        <th>Updated At</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($itsup_statuses as $itsup_status)
                        <tr>
                            <td>{{ $itsup_status->id ?? 'N/A' }}</td>
                            <td>{{ $itsup_status->issue ?? 'N/A' }}</td>
                            <td>{{ $itsup_status->detail ?? 'N/A' }}</td>
                            <td>{{ $itsup_status->department->name ?? 'N/A' }}</td>
                            <td>{{ $itsup_status->hotel ?? 'N/A' }}</td>
                            <td class="text-center">
                                @if (($itsup_status->status ?? null) === 0)
                                    <a href="#" class="btn btn-warning"><i class="bi bi-hourglass-split"></i></a>
                                @elseif (($itsup_status->status ?? null) === 1)
                                    <a href="#" class="btn btn-success"><i class="bi bi-check2"></i></a>
                                @else
                                    <span class="btn btn-secondary">N/A</span>
                                @endif
                            </td>
                            <td>{{ $itsup_status->created_at ? \Carbon\Carbon::parse($itsup_status->created_at)->format('d-m-Y H:i:s') : 'N/A' }}
                            </td>
                            <td>{{ $itsup_status->updated_at ? \Carbon\Carbon::parse($itsup_status->updated_at)->format('d-m-Y H:i:s') : 'N/A' }}
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            <div class="justify-content-center">
                {{ $itsup_statuses->links() }}
            </div>
        </div>
    @else
        <h1 class="text text-center py-5">No data</h1>
    @endif
@endsection
