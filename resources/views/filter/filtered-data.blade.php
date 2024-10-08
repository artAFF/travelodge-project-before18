@extends('layouts.app')
@section('title', 'Filtered Data')

@section('content')
    <div class="container">
        <h1>Filtered Data</h1>
        <table class="table table-striped table-hover">
            <thead>
                <tr>
                    <th scope="col" class="text-center">ID</th>
                    <th scope="col" class="text-center">Issue</th>
                    <th scope="col" class="text-center">Detail</th>
                    <th scope="col" class="text-center">Department</th>
                    <th scope="col" class="text-center">Hotel</th>
                    <th scope="col" class="text-center">Status</th>
                    <th scope="col" class="text-center">Created At</th>
                    <th scope="col" class="text-center">Updated At</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($issues as $issue)
                    <tr>
                        <td class="text-center">{{ $issue->id }}</td>
                        <td class="text-center">{{ $issue->category->name ?? 'N/A' }}</td>
                        <td class="text-center">{{ $issue->detail }}</td>
                        <td class="text-center">{{ $issue->department->name ?? 'N/A' }}</td>
                        <td class="text-center">{{ $issue->hotel }}</td>
                        <td class="text-center">{{ $issue->status == 0 ? 'In-progress' : 'Done' }}</td>
                        <td class="text-center">{{ \Carbon\Carbon::parse($issue->created_at)->format('d/m/Y H:i:s') }}</td>
                        <td class="text-center">{{ \Carbon\Carbon::parse($issue->updated_at)->format('d/m/Y H:i:s') }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        @if (count($issues) > 0)
            <form action="{{ route('download.pdf') }}" method="GET">
                <input type="hidden" name="issues" value="{{ json_encode($issues) }}">
                <button type="submit" class="btn btn-primary">Download PDF</button>
            </form>
        @else
            <p>No data available for download.</p>
        @endif
    </div>

    <input type="hidden" name="category_id" value="{{ request('category_id') }}">
    <input type="hidden" name="department_id" value="{{ request('department_id') }}">
    <input type="hidden" name="hotel" value="{{ request('hotel') }}">
    <input type="hidden" name="status" value="{{ request('status') }}">
    <input type="hidden" name="start_date" value="{{ request('start_date') }}">
    <input type="hidden" name="end_date" value="{{ request('end_date') }}">
@endsection
