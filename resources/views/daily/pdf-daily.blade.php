<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>IT Infrastructure Daily Status Report</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 12pt;
            line-height: 1.6;
            color: #333;
            margin: 0;
            padding: 20px;
        }

        .header {
            text-align: center;
            margin-bottom: 30px;
        }

        h1 {
            color: #003366;
            border-bottom: 2px solid #003366;
            padding-bottom: 10px;
        }

        h2 {
            color: #003366;
            margin-top: 30px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 30px;
        }

        th,
        td {
            border: 1px solid #ccc;
            padding: 10px;
            text-align: left;
        }

        th {
            background-color: #f0f0f0;
            font-weight: bold;
        }

        .section {
            margin-bottom: 40px;
        }

        .no-data {
            font-style: italic;
            color: #666;
        }

        .footer {
            margin-top: 50px;
            text-align: center;
            font-size: 10pt;
            color: #666;
        }
    </style>
</head>

<body>
    <div class="header">
        <h1>IT Infrastructure Daily Status Report</h1>
        <p>Date: {{ date('F d, Y') }}</p>
        <p>Report Generated: {{ date('H:i:s') }}</p>
        <p>Department: IT Operations</p>
    </div>


    <div class="section">
        <h2>1. Guest Room Network Performance</h2>
        @if (isset($guests) && $guests->count() > 0)
            <table>
                <thead>
                    <tr>
                        <th>Room No.</th>
                        <th>Location</th>
                        <th>Download Speed (Mbps)</th>
                        <th>Upload Speed (Mbps)</th>
                        <th>Channel Name</th>
                        <th>Timestamp</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($guests as $guest)
                        <tr>
                            <td>{{ $guest->room_no }}</td>
                            <td>{{ $guest->location }}</td>
                            <td>{{ number_format($guest->download, 2) }}</td>
                            <td>{{ number_format($guest->upload, 2) }}</td>
                            <td>{{ $guest->ch_name }}</td>
                            <td>{{ \Carbon\Carbon::parse($guest->created_at)->format('Y-m-d H:i:s') }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @else
            <p class="no-data">No guest room network data available for this reporting period.</p>
        @endif
    </div>

    <div class="section">
        <h2>2. Switch Room Status</h2>
        @if (isset($switches) && $switches->count() > 0)
            <table>
                <thead>
                    <tr>
                        <th>Location</th>
                        <th>UPS Battery Level (%)</th>
                        <th>UPS Runtime (Minutes)</th>
                        <th>Temperature (°C)</th>
                        <th>Timestamp</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($switches as $switch)
                        <tr>
                            <td>{{ $switch->location }}</td>
                            <td>{{ number_format($switch->ups_battery, 1) }}</td>
                            <td>{{ $switch->ups_time }}</td>
                            <td>{{ number_format($switch->ups_temp, 1) }}</td>
                            <td>{{ \Carbon\Carbon::parse($switch->created_at)->format('Y-m-d H:i:s') }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @else
            <p class="no-data">No switch room data available for this reporting period.</p>
        @endif
    </div>

    <div class="section">
        <h2>3. Server Room Environment</h2>
        @if (isset($servers) && $servers->count() > 0)
            <table>
                <thead>
                    <tr>
                        <th>Server Temperature (°C)</th>
                        <th>UPS Battery Level (%)</th>
                        <th>UPS Runtime (Hours:Minutes)</th>
                        <th>Timestamp</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($servers as $server)
                        <tr>
                            <td>{{ number_format($server->server_temp, 1) }}</td>
                            <td>{{ number_format($server->ups_battery, 1) }}</td>
                            <td>{{ $server->ups_time }}</td>
                            <td>{{ \Carbon\Carbon::parse($server->created_at)->format('Y-m-d H:i:s') }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @else
            <p class="no-data">No server room data available for this reporting period.</p>
        @endif
    </div>

    <div class="section">
        <h2>4. Internet Connection Performance</h2>
        @if (isset($netSpeeds) && $netSpeeds->count() > 0)
            <table>
                <thead>
                    <tr>
                        <th>Location</th>
                        <th>Download Speed (Mbps)</th>
                        <th>Upload Speed (Mbps)</th>
                        <th>Timestamp</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($netSpeeds as $netSpeed)
                        <tr>
                            <td>{{ $netSpeed->location }}</td>
                            <td>{{ number_format($netSpeed->download, 2) }}</td>
                            <td>{{ number_format($netSpeed->upload, 2) }}</td>
                            <td>{{ \Carbon\Carbon::parse($netSpeed->created_at)->format('Y-m-d H:i:s') }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @else
            <p class="no-data">No internet performance data available for this reporting period.</p>
        @endif
    </div>

    <div class="footer">
        <p>This report is generated for internal IT department use. For any issues or concerns, please contact the team
            lead.</p>
    </div>
</body>

</html>
