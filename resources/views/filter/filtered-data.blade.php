@extends('layout')
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
                    <th scope="col" class="text-center">Location</th>
                    <th scope="col" class="text-center">Status</th>
                    <th scope="col" class="text-center">Created At</th>
                    <th scope="col" class="text-center">Updated At</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($issues as $issue)
                    <tr>
                        <td>{{ $issue->id }}</td>
                        <td>{{ $issue->issue }}</td>
                        <td>{{ $issue->detail }}</td>
                        <td>{{ $issue->department }}</td>
                        <td>{{ $issue->hotel }}</td>
                        <td>{{ $issue->location }}</td>
                        <td>{{ $issue->status == 0 ? 'In-progress' : 'Done' }}</td>
                        <td>{{ \Carbon\Carbon::parse($issue->created_at)->format('d/m/Y H:i:s') }}</td>
                        <td>{{ \Carbon\Carbon::parse($issue->updated_at)->format('d/m/Y H:i:s') }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        <form action="{{ route('download.pdf') }}" method="GET">
            <input type="hidden" name="issues" value="{{ json_encode($issues) }}">
            <button type="submit">Download PDF</button>
        </form>
    </div>
@endsection
