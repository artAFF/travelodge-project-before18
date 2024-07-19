<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Download All Report Issue</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Sarabun:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800&display=swap"
        rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"></script>
    <style>
        body {
            font-family: "Sarabun", sans-serif;
            font-weight: 400;
            font-style: normal;
            font-size: 6pt;
            margin: 20px;
        }

        h1 {
            text-align: center;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }

        th,
        td {
            border: 1px solid #000;
            padding: 8px;
            text-align: center;
        }

        th {
            background-color: #f2f2f2;
        }

        .btn {
            display: inline-block;
            padding: 5px 10px;
            text-align: center;
            border-radius: 5px;
            text-decoration: none;
            color: #fff;
        }

        .btn-warning {
            background-color: #f0ad4e;
        }

        .btn-success {
            background-color: #5cb85c;
        }

        .bi {
            font-family: 'Glyphicons Halflings';
            font-style: normal;
            font-weight: normal;
            line-height: 1;
        }

        .bi-hourglass-split:before {
            content: "\e329";
        }

        .bi-check2:before {
            content: "\e013";
        }
    </style>
</head>

<body>
    <h1>Report IT Support reportAll</h1>
    w<table class="table table-striped table-hover">
        <thead>
            <tr>
                <th scope="col" class="text-center">#</th>
                <th scope="col" class="text-center">Issue</th>
                <th class="col-md-2 text-center" scope="col">Detail</th>
                <th class="col-md-1 text-center" scope="col">Department</th>
                <th class="col-md-1 text-center" scope="col">Hotel</th>
                <th scope="col" class="text-center">Location</th>
                <th scope="col" class="text-center">Status</th>
                <th scope="col" class="text-center">Created Time</th>
                <th scope="col" class="text-center">Updated Time</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($issues as $issue)
                <tr>
                    <th scope="row">{{ $issue['id'] }}</th>
                    <td>{{ $issue['issue'] }}</td>
                    <td>{{ $issue['detail'] }}</td>
                    <td>{{ $issue['department'] }}</td>
                    <td>{{ $issue['hotel'] }}</td>
                    <td>{{ $issue['location'] }}</td>
                    <td class="text-center">
                        @if ($issue['status'] === 0)
                            In-progress
                        @else
                            Done
                        @endif
                    </td>
                    <td>{{ \Carbon\Carbon::parse($issue['created_at'])->format('d/m/Y H:i:s') }}</td>
                    <td>{{ \Carbon\Carbon::parse($issue['updated_at'])->format('d/m/Y H:i:s') }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>

</html>
