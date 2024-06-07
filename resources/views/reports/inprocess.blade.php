@extends('layout')
@section('title', 'In-process')

@section('content')

@if (count($in_process) > 0)
<div class="container">
    <h1 class="text-center">Report all IT Support Issues  in the process</h1><br>
        <form  method="GET" action="/filter">
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

            <div class="col-md-3 pt-4">

            </div>
        </div>
        </form>
        <form class=" method="GET" action="{{ route('inprocess') }}">
            <div class="row pb-3">
                <div class="col-md-3">
                    <input type="text" name="query" class="form-control" placeholder="Search" value="{{ request('query') }}">
                </div>
                <div class="col-md-2">
                    <button type="submit" class="btn btn-info">Search</button>
                </div>
            </div>
        </form>

    <table class="table table-striped table-hover ">
    <thead>
        <tr>
            <th><a class="text-dark text-decoration-none" href="{{ route('inprocess', array_merge(request()->all(), ['sort_by' => 'id', 'sort_order' => request('sort_order') === 'asc' ? 'desc' : 'asc'])) }}">#</a></th>
            <th><a class="text-dark text-decoration-none" href="{{ route('inprocess', array_merge(request()->all(), ['sort_by' => 'issue', 'sort_order' => request('sort_order') === 'asc' ? 'desc' : 'asc'])) }}">Issue</a></th>
            <th class="col-md-3"><a class="text-dark text-decoration-none" href="{{ route('inprocess', array_merge(request()->all(), ['sort_by' => 'detail', 'sort_order' => request('sort_order') === 'asc' ? 'desc' : 'asc'])) }}">Detail</a></th>
            <th><a class="text-dark text-decoration-none" href="{{ route('inprocess', array_merge(request()->all(), ['sort_by' => 'department', 'sort_order' => request('sort_order') === 'asc' ? 'desc' : 'asc'])) }}">Department</a></th>
            <th><a class="text-dark text-decoration-none" href="{{ route('inprocess', array_merge(request()->all(), ['sort_by' => 'hotel', 'sort_order' => request('sort_order') === 'asc' ? 'desc' : 'asc'])) }}">Hotel</a></th>
            <th><a class="text-dark text-decoration-none" href="{{ route('inprocess', array_merge(request()->all(), ['sort_by' => 'location', 'sort_order' => request('sort_order') === 'asc' ? 'desc' : 'asc'])) }}">Location</a></th>
            <th>Status</th>
            <th><a class="text-dark text-decoration-none" href="{{ route('inprocess', array_merge(request()->all(), ['sort_by' => 'created_at', 'sort_order' => request('sort_order') === 'asc' ? 'desc' : 'asc'])) }}">Created At</a></th>
            <th><a class="text-dark text-decoration-none" href="{{ route('inprocess', array_merge(request()->all(), ['sort_by' => 'updated_at', 'sort_order' => request('sort_order') === 'asc' ? 'desc' : 'asc'])) }}">Updated At</a></th>
            <th scope="col">Action</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($in_process as $in_process1)
            <tr>
                <td>{{ $in_process1->id }}</td>
                <td>{{ $in_process1->issue }}</td>
                <td>{{ $in_process1->detail }}</td>
                <td>{{ $in_process1->department }}</td>
                <td>{{ $in_process1->hotel }}</td>
                <td>{{ $in_process1->location }}</td>
                <td class="text-center">
                    @if ($in_process1->status === 0)
                        <a href="#" class="btn btn-warning"><i class="bi bi-hourglass-split"></i></a>
                    @else
                        <a href="#" class="btn btn-success"><i class="bi bi-check2"></i></a>
                    @endif
                </td>
                <td>{{ \Carbon\Carbon::parse($in_process1->created_at)->format('d-m-Y H:i:s') }}</td>
                <td>{{ \Carbon\Carbon::parse($in_process1->updated_at)->format('d-m-Y H:i:s') }}</td>
                <td>
                    <a href="{{ route('updateReport', $in_process1->id) }}" class="btn btn-primary btn-sm"><i class="bi bi-pencil-square"></i></a>
                </td>
            </tr>
        @endforeach
    </tbody>
    </table>
    <div class="justify-content-center">
        {{ $in_process->links() }}
    </div>
@else
    <h1 class="text text-center py-5">No data found</h1>
@endif
</div>

@endsection
