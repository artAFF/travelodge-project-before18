{{-- @extends('layout')
@section('title', 'Report Guest Room')

@section('content')
    @if (count($ReportGuests) > 0)
        <div class="container">
            <h1 class="text text-center">All Report Daily Checklist on <b class='text-danger'>Guest Rooms</b></h1><br>

            <a href="/guest/addGuest" class="btn btn-primary">Add Guest Room Check</a>
            <table class="table table-striped table-hover ">
                <thead>
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">Location</th>
                        <th scope="col">Room No.</th>
                        <th scope="col">Upload</th>
                        <th scope="col">Downlaod</th>
                        <th scope="col">Channel Number</th>
                        <th scope="col">Channel Name</th>
                        <th scope="col">Created Time</th>
                        <th scope="col">Updated time</th>
                        <th scope="col">Action</th>

                    </tr>
                </thead>
                <tbody>
                    @foreach ($ReportGuests as $ReportGuest)
                        <tr>
                            <th scope="row">{{ $ReportGuest->id }}</th>
                            <td>{{ $ReportGuest->location }}</td>
                            <td>{{ $ReportGuest->room_no }}</td>
                            <td>{{ $ReportGuest->upload }}</td>
                            <td>{{ $ReportGuest->download }}</td>
                            <td>{{ $ReportGuest->ch_no }}</td>
                            <td>{{ $ReportGuest->ch_name }}</td>
                            <td>{{ $ReportGuest->created_at }}</td>
                            <td>{{ $ReportGuest->updated_at }}</td>
                            <td>
                                <a href="{{ route('updateGuest', $ReportGuest->id) }}"
                                    class="btn btn-primary btn-sm"><i class="bi bi-pencil-square"></i></a>

                                <form action="{{ route('deleteGuest', $ReportGuest->id) }}" method="POST"
                                    style="display: inline-block;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-sm"
                                        onclick="return confirm('Are you sure you want to delete this report?')"><i class="bi bi-trash3-fill"></i>
                                    </button>
                                </form>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            <div class="justify-content-center">
                {{ $ReportGuests->links() }}
            </div>
        @else
            <h1 class="text text-center py-5 ">No data found, Pleases add report guest room <a href="/guest/addGuest"
                    class="btn btn-primary padding: 10px 20px">Add</a></h1>
        </div>
    @endif
<br><hr><br>

@if (count($ReportSwitchs) > 0)
<div class="container">
    <h1 class="text text-center">All Report Daily Checklist at <b class='text-danger'>Switch Room</b></h1><br>
    <a href="/addSwitch" class="btn btn-primary">Add Switch Room Check</a>
    <table class="table table-striped table-hover ">
        <thead>
            <tr>
                <th scope="col">#</th>
                <th scope="col">Location</th>
                <th scope="col">USP Battery Percentage</th>
                <th scope="col">UPS Period Of Service Available</th>
                <th scope="col">Switch Temperature</th>
                <th scope="col">Created Time</th>
                <th scope="col">Updated time</th>
                <th scope="col">Action</th>

            </tr>
        </thead>
        <tbody>
            @foreach ($ReportSwitchs as $ReportSwitch)
                <tr>
                    <th scope="row">{{ $ReportSwitch->id }}</th>
                    <td>{{ $ReportSwitch->location }}</td>
                    <td>{{ $ReportSwitch->ups_battery }}</td>
                    <td>{{ $ReportSwitch->ups_time }}</td>
                    <td>{{ $ReportSwitch->ups_temp }}</td>
                    <td>{{ $ReportSwitch->created_at }}</td>
                    <td>{{ $ReportSwitch->updated_at }}</td>
                    <td>
                        <a href="{{ route('updateSwitch', $ReportSwitch->id) }}"
                            class="btn btn-primary btn-sm"><i class="bi bi-pencil-square"></i>
                            </a>

                        <form action="{{ route('deleteSwitch', $ReportSwitch->id) }}" method="POST"
                            style="display: inline-block;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger btn-sm"
                                onclick="return confirm('Are you sure you want to delete this report?')"><i class="bi bi-trash3-fill"></i>
                            </button>
                        </form>
                </tr>
            @endforeach
        </tbody>
    </table>
    <div class="justify-content-center">
        {{ $ReportSwitchs->links() }}
    </div>
@else
    <h1 class="text text-center py-5 ">No data found, Pleases add report switch<a href="/addSwitch"
            class="btn btn-primary px-5">Add</a></h1>
</div>
@endif

<br><hr><br>

@if (count($ReportServers) > 0)
<div class="container">
    <h1 class="text text-center">All Report Daily Checklist at <b class='text-danger'>Server Room</b></h1><br>
    <a href="/server/addServer" class="btn btn-primary">Add Server Room Check</a>
    <table class="table table-striped table-hover ">
        <thead>
            <tr>
                <th scope="col">#</th>
                <th scope="col">Server Temperature</th>
                <th scope="col">UPS Temperature</th>
                <th scope="col">USP Battery Percentage</th>
                <th scope="col">UPS Period Of Service Available</th>
                <th scope="col">Created Time</th>
                <th scope="col">Updated time</th>
                <th scope="col">Action
                </th>

            </tr>
        </thead>
        <tbody>
            @foreach ($ReportServers as $ReportServer)
                <tr>
                    <th scope="row">{{ $ReportServer->id }}</th>
                    <td style="text-center">{{ $ReportServer->server_temp }}</td>
                    <td style="text-center">{{ $ReportServer->ups_temp }}</td>
                    <td style="text-center">{{ $ReportServer->ups_battery }}</td>
                    <td style="text-center">{{ $ReportServer->ups_time }}</td>
                    <td style="text-center">{{ $ReportServer->created_at }}</td>
                    <td style="text-center">{{ $ReportServer->updated_at }}</td>
                    <td>
                        <a href="{{ route('updateServer', $ReportServer->id) }}"
                            class="btn btn-primary btn-sm"><i class="bi bi-pencil-square"></i>
                            </a>

                        <form action="{{ route('deleteServer', $ReportServer->id) }}" method="POST"
                            style="display: inline-block;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger btn-sm"
                                onclick="return confirm('Are you sure you want to delete this report?')"><i class="bi bi-trash3-fill"></i>
                            </button>
                        </form>
                </tr>
            @endforeach
        </tbody>
    </table>
    <div class="justify-content-center">
        {{ $ReportServers->links() }}
    </div>
@else
    <h1 class="text text-center py-5 ">No data found, Pleases add report server<a href="/server/addServer"
            class="btn btn-primary px-5">Add</a></h1>
</div>
@endif

<br><hr><br>

@if (count($ReportNetSpeeds) > 0)
<div class="container">
    <h1 class="text text-center">All <b class='text-danger'>Internet Checking</b> Report</h1><br>
    <h2 class="text text-center text-danger"><b>Only as follows Lobby, The Lodge, Pool, Gym, Grab and Go,
            Office</b></h2>
    <a href="/netspeed/addNetSpeed" class="btn btn-primary">Add Internet Check</a>
    <table class="table table-striped table-hover ">
        <thead>
            <tr>
                <th scope="col">#</th>
                <th scope="col">Location</th>
                <th scope="col">Upload</th>
                <th scope="col">Downlaod</th>
                <th scope="col">Created Time</th>
                <th scope="col">Updated time</th>
                <th scope="col">Action</th>

            </tr>
        </thead>
        <tbody>
            @foreach ($ReportNetSpeeds as $ReportNetSpeed)
                <tr>
                    <th scope="row">{{ $ReportNetSpeed->id }}</th>
                    <td>{{ $ReportNetSpeed->location }}</td>
                    <td>{{ $ReportNetSpeed->upload }}</td>
                    <td>{{ $ReportNetSpeed->download }}</td>
                    <td>{{ $ReportNetSpeed->created_at }}</td>
                    <td>{{ $ReportNetSpeed->updated_at }}</td>
                    <td>
                        <a href="{{ route('updateNetSpeed', $ReportNetSpeed->id) }}"
                            class="btn btn-primary btn-sm"><i class="bi bi-pencil-square"></i>
                            </a>

                        <form action="{{ route('deleteNetSpeed', $ReportNetSpeed->id) }}" method="POST"
                            style="display: inline-block;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger btn-sm"
                                onclick="return confirm('Are you sure you want to delete this report?')"><i class="bi bi-trash3-fill"></i>
                            </button>
                        </form>
                </tr>
            @endforeach
        </tbody>
    </table>
    <div class="justify-content-center">
        {{ $ReportNetSpeeds->links() }}
    </div>
@else
    <h1 class="text text-center py-5 ">No data found, Pleases add report Internet Speed <a href="/netspeed/addNetSpeed"
            class="btn btn-primary px-5">Add</a></h1>
</div>
@endif

<br><hr>
@endsection --}}

@extends('layout')
@section('title', 'Daily Report TLCMN')

@section('content')
    <div id="report-content">
        @include('partials.report_guests')
        @include('partials.report_switchs')
        @include('partials.report_servers')
        @include('partials.report_netspeeds')
    </div>

    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script>
        function loadPage(url) {
            $.ajax({
                url: url,
                type: 'GET',
                dataType: 'json',
                success: function(data) {
                    $('#report-content').append(data.ReportGuests);
                    $('#report-content').append(data.ReportSwitchs);
                    $('#report-content').append(data.ReportServers);
                    $('#report-content').append(data.ReportNetSpeeds);
                }
            });
        }

        $(document).on('click', '.pagination a', function(event) {
            event.preventDefault();
            let url = $(this).attr('href');
            loadPage(url);
        });
    </script>
@endsection
