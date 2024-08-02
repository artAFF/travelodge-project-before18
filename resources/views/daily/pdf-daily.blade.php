<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daily Report</title>
    <style>
        body {
            font-family: sans-serif;
            font-size: 10pt;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }

        th,
        td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }

        th {
            background-color: #f2f2f2;
        }

        h2 {
            color: #333;
        }

        h1 {
            text-align: center;
        }
    </style>
</head>

<body>
    <h1 class="text-center">Daily Report</h1>

    @if ($category == 'all' || $category == 'guest')
        @if (isset($guests) && $guests->count() > 0)
            <h2>Guest Rooms</h2>
            <table>
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Room No.</th>
                        <th>Location</th>
                        <th>Download (Mbps)</th>
                        <th>Upload (Mbps)</th>
                        <th>Channel Name</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($guests as $guest)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $guest->room_no }}</td>
                            <td>{{ $guest->location }}</td>
                            <td>{{ $guest->download }}</td>
                            <td>{{ $guest->upload }}</td>
                            <td>{{ $guest->ch_name }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @else
            <h2>Guest Rooms</h2>
            <p>No guest room data found.</p>
        @endif
    @endif

    @if ($category == 'all' || $category == 'switch')
        @if (isset($switches) && $switches->count() > 0)
            <h2>Switch Room</h2>
            <table>
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Location</th>
                        <th>UPS Battery(%)</th>
                        <th>UPS Time (M)</th>
                        <th>Temperature (°C)</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($switches as $switch)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $switch->location }}</td>
                            <td>{{ $switch->ups_battery }}</td>
                            <td>{{ $switch->ups_time }}</td>
                            <td>{{ $switch->ups_temp }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @else
            <h2>Switch Room</h2>
            <p>No switch room data found.</p>
        @endif
    @endif

    @if ($category == 'all' || $category == 'server')
        @if (isset($servers) && $servers->count() > 0)
            <h2>Server Room</h2>
            <table>
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Server Temperature (°C)</th>
                        {{-- <th>UPS Temperature (°C)</th> --}}
                        <th>UPS Battery (%)</th>
                        <th>UPS Time (H.MM)</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($servers as $server)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $server->server_temp }}</td>
                            {{-- <td>{{ $server->ups_temp }}</td> --}}
                            <td>{{ $server->ups_battery }}</td>
                            <td>{{ $server->ups_time }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @else
            <h2>Server Room</h2>
            <p>No server room data found.</p>
        @endif
    @endif

    @if ($category == 'all' || $category == 'internet')
        @if (isset($netSpeeds) && $netSpeeds->count() > 0)
            <h2>Internet Checking</h2>
            <table>
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Location</th>
                        <th>Download (Mbps)</th>
                        <th>Upload (Mbps)</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($netSpeeds as $netSpeed)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $netSpeed->location }}</td>
                            <td>{{ $netSpeed->download }}</td>
                            <td>{{ $netSpeed->upload }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @else
            <h2>Internet Checking</h2>
            <p>No internet checking data found.</p>
        @endif
    @endif
</body>

</html>
