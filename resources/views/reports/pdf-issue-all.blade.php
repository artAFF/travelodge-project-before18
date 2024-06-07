<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Download All Report Issue</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Sarabun:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: "Sarabun", sans-serif;
            font-weight: 400;
            font-style: normal;
            font-size: 12pt;
            margin: 20px;
        }

        h1 {
            text-align: center;
        }

        .report-container {
            max-width: 600px;
            margin: auto;
            border: 1px solid #ccc;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        .report-item {
            margin-bottom: 10px;
        }

        .report-item span {
            font-weight: bold;
        }
    </style>
</head>

<body>

    @foreach ($issues as $page)
        <div class="report-container">
            <h1>Report IT Support reportAll</h1>
            @foreach ($page as $issue)
            <div class="report-item">
                <span>ID:</span> {{ $issue['id'] }}
            </div>
                <div class="report-item">
                    <span>Issue:</span> {{ $issue['issue'] }}
                </div>
                <div class="report-item">
                    <span>Detail:</span> {{ $issue['detail'] }}
                </div>
                <div class="report-item">
                    <span>Department:</span> {{ $issue['department'] }}
                </div>
                <div class="report-item">
                    <span>Hotel:</span> {{ $issue['hotel'] }}
                </div>
                <div class="report-item">
                    <span>Location:</span> {{ $issue['location'] }}
                </div>
                <div class="report-item">
                    <span>Status:</span>
                    @if ($issue['status'] == 0)
                        In-process
                    @elseif ($issue['status'] == 1)
                        Done
                    @endif
                </div>
                <div class="report-item">
                    <span>Created At:</span> {{ \Carbon\Carbon::parse($issue['created_at'])->format('d-m-Y H:i:s') }}
                </div>
                <div class="report-item">
                    <span>Updated At:</span> {{ \Carbon\Carbon::parse($issue['updated_at'])->format('d-m-Y H:i:s') }}
                </div>

                <br>
                <hr><br>
            @endforeach
        </div>
    @endforeach
</body>

</html>
