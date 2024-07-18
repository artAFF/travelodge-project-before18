@extends('layout')
@section('title', 'Daily Search')
@section('content')
    <div class="container">
        <h1 class="text-center">Search Results</h1>
        <form action="{{ route('search') }}" method="GET" class="mb-4">
            <div class="row">
                <div class="col-md-5">
                    <input type="text" name="query" class="form-control" value="{{ $query ?? '' }}"
                        placeholder="Search...">
                </div>
                <div class="col-md-3">
                    <input type="date" name="date" class="form-control" value="{{ $date ?? '' }}">
                </div>
                <div class="col-md-2">
                    <select name="hotel" class="form-select">
                        <option value="tlcmn" {{ ($hotel ?? '') == 'tlcmn' ? 'selected' : '' }}>TLCMN</option>
                        <option value="ehcm" {{ ($hotel ?? '') == 'ehcm' ? 'selected' : '' }}>EHCM</option>
                        <option value="uncm" {{ ($hotel ?? '') == 'uncm' ? 'selected' : '' }}>UNCM</option>
                    </select>
                </div>
                <div class="col-md-2">
                    <button type="submit" class="btn btn-primary btn-block">Search</button>
                </div>
            </div>
        </form>

        <h2>Guest Rooms</h2>
        @if (count($guests) > 0)
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Location</th>
                        <th>Room No.</th>
                        <th>Download</th>
                        <th>Upload</th>
                        <th>Channel Number</th>
                        <th>Channel Name</th>
                        <th>Created Time</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($guests as $guest)
                        <tr>
                            <td>{{ $guest->id }}</td>
                            <td>{{ $guest->location }}</td>
                            <td>{{ $guest->room_no }}</td>
                            <td>{{ $guest->download }}</td>
                            <td>{{ $guest->upload }}</td>
                            <td>{{ $guest->ch_no }}</td>
                            <td>{{ $guest->ch_name }}</td>
                            <td>{{ $guest->created_at }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            {{ $guests->appends(request()->except('guests_page'))->links() }}
        @else
            <p>No guest room data found.</p>
        @endif

        <h2>Switch Room</h2>
        @if (count($switches) > 0)
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Location</th>
                        <th>UPS Battery Percentage</th>
                        <th>UPS Period of Service</th>
                        <th>Switch Temperature</th>
                        <th>Created Time</th>
                        <th>Updated Time</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($switches as $switch)
                        <tr>
                            <td>{{ $switch->id }}</td>
                            <td>{{ $switch->location }}</td>
                            <td>{{ $switch->ups_battery }}</td>
                            <td>{{ $switch->ups_time }}</td>
                            <td>{{ $switch->ups_temp }}</td>
                            <td>{{ $switch->created_at }}</td>
                            <td>{{ $switch->updated_at }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            {{ $switches->appends(request()->except('switches_page'))->links() }}
        @else
            <p>No switch room data found.</p>
        @endif

        <h2>Server Room</h2>
        @if (count($servers) > 0)
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Server Temperature</th>
                        <th>UPS Temperature</th>
                        <th>UPS Battery</th>
                        <th>UPS Period of Service</th>
                        <th>Created Time</th>
                        <th>Updated Time</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($servers as $server)
                        <tr>
                            <td>{{ $server->id }}</td>
                            <td>{{ $server->server_temp }}</td>
                            <td>{{ $server->ups_temp }}</td>
                            <td>{{ $server->ups_battery }}</td>
                            <td>{{ $server->ups_time }}</td>
                            <td>{{ $server->created_at }}</td>
                            <td>{{ $server->updated_at }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            {{ $servers->appends(request()->except('servers_page'))->links() }}
        @else
            <p>No server room data found.</p>
        @endif

        <h2>Internet Checking</h2>
        @if (count($netSpeeds) > 0)
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Location</th>
                        <th>Download</th>
                        <th>Upload</th>
                        <th>Created Time</th>
                        <th>Updated Time</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($netSpeeds as $netSpeed)
                        <tr>
                            <td>{{ $netSpeed->id }}</td>
                            <td>{{ $netSpeed->location }}</td>
                            <td>{{ $netSpeed->download }}</td>
                            <td>{{ $netSpeed->upload }}</td>
                            <td>{{ $netSpeed->created_at }}</td>
                            <td>{{ $netSpeed->updated_at }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            {{ $netSpeeds->appends(request()->except('netSpeeds_page'))->links() }}
        @else
            <p>No internet checking data found.</p>
        @endif
    </div>
@endsection
