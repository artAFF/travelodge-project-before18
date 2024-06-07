@extends('layout')
@section('title', 'IT Support Status')

@section('content')

@if (count($itsup_statuses) > 0)
<div class="container">
    <h1 class="text-center">All IT Support Depaertment Issue in the Process</h1>

   {{--  <form method="GET" action="/filter">
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
    </form> --}}

    <table class="table table-striped table-hover ">
    <thead>
        <tr>
            <th>#</th>
            <td>Issue</td>
            <th class="col-md-3" scope="col">Detail</th>
            <th>Department</th>
            <th>Hotel</th>
            <th>Location</th>
            <th>Status</th>
            <th>Created At</th>
            <th>Updated At</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($itsup_statuses as $itsup_status)
            <tr>
                <td>{{ $itsup_status->id }}</td>
                <td>{{ $itsup_status->issue }}</td>
                <td>{{ $itsup_status->detail }}</td>
                <td>{{ $itsup_status->department }}</td>
                <td>{{ $itsup_status->hotel }}</td>
                <td>{{ $itsup_status->location }}</td>
                <td class="text-center">
                    @if ($itsup_status->status === 0)
                        <a href="#" class="btn btn-warning"><i class="bi bi-hourglass-split"></i>{{-- In-process --}}</a>
                    @else
                        <a href="#" class="btn btn-success"><i class="bi bi-check2"></i>{{-- Succeed --}}</a>
                    @endif
                    <td>{{ \Carbon\Carbon::parse($itsup_status->created_at)->format('d-m-Y H:i:s') }}</td>
                    <td>{{ \Carbon\Carbon::parse($itsup_status->updated_at)->format('d-m-Y H:i:s') }}</td>
            </tr>
        @endforeach
    </tbody>
</table>
<div class="justify-content-center">
    {{ $itsup_statuses->links() }}
</div>
@else
            <h1 class="text text-center py-5 ">No data found </h1>

        </div>
@endif


@endsection
