@extends('layouts.app')
@section('title', 'Dashboard Hotel')
@section('content')
    <script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.2/dist/chart.umd.min.js"></script>
    <h1 class="text text-center">Issue by Hotel</h1>

    <div class="row">
        <div class="col-md-6">
            <h2 class="text-center">Bar Chart</h2>
            <div style="height: 400px; width: 100%;">
                <canvas id='barChart'></canvas>
            </div>
        </div>
        <div class="col-md-6">
            <h2 class="text-center">Pie Chart</h2>
            <div style="height: 400px; width: 100%;">
                <canvas id='pieChart'></canvas>
            </div>
        </div>
    </div>

    <div class="row mt-4">
        @foreach ($latestReports as $hotel => $reports)
            <div class="col-md-4">
                <h5>{{ $hotel }} - Latest 5 Reports</h3>
                    <ul class="list-group">
                        @foreach ($reports as $report)
                            <li class="list-group-item">
                                ID: {{ $report->id }} <br>
                                Detail: {{ $report->detail }} <br>
                                Created at: {{ $report->created_at }}
                            </li>
                        @endforeach
                    </ul>
            </div>
        @endforeach
    </div>

    <script>
        var barCtx = document.getElementById('barChart').getContext('2d');
        var pieCtx = document.getElementById('pieChart').getContext('2d');

        var chartData = {
            labels: <?php echo json_encode($hotels); ?>,
            datasets: <?php echo json_encode($datasets); ?>
        };

        var chartOptions = {
            responsive: true,
            maintainAspectRatio: false,
        };

        var barChart = new Chart(barCtx, {
            type: 'bar',
            data: chartData,
            options: {
                ...chartOptions,
                plugins: {
                    tooltip: {
                        callbacks: {
                            label: function(context) {
                                return context.label + ': ' + context.parsed.y;
                            }
                        }
                    }
                }
            }
        });

        var pieChart = new Chart(pieCtx, {
            type: 'pie',
            data: {
                labels: <?php echo json_encode($hotels); ?>,
                datasets: [{
                    data: <?php echo json_encode($percentages); ?>,
                    backgroundColor: <?php echo json_encode($datasets[0]['backgroundColor']); ?>
                }]
            },
            options: {
                ...chartOptions,
                plugins: {
                    tooltip: {
                        callbacks: {
                            label: function(context) {
                                return context.label + ': ' + context.parsed + '%';
                            }
                        }
                    }
                }
            }
        });

        // Add click event handlers for both charts
        barChart.options.onClick = pieChart.options.onClick = function(event, elements) {
            if (elements.length > 0) {
                var hotelCode = chartData.labels[elements[0].index];
                window.location.href = "{{ url('/dashboard') }}/" + hotelCode;
            }
        };
    </script>
@endsection
