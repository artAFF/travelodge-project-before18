@extends('layout')
@section('title', 'Dashboard Hoel')
@section('content')

    <script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.2/dist/chart.umd.min.js"></script>

    <h1 class="text text-center">Issue By Hotel</h1>

    <div class="mb-3">
        <select id="chartType" class="form-select" onchange="updateChart(this.value)">
            <option value="bar" {{ $chartType == 'bar' ? 'selected' : '' }}>Bar Chart</option>
            <option value="pie" {{ $chartType == 'pie' ? 'selected' : '' }}>Pie Chart</option>
        </select>
    </div>

    <div>
        <canvas id='chart' style="width:600px; margin: auto;"></canvas>
    </div>

    <script>
        var ctx = document.getElementById('chart').getContext('2d');
        var chartData = {
            labels: <?php echo json_encode(isset($status) ? $status : (isset($departments) ? $departments : (isset($categories) ? $categories : (isset($hotels) ? $hotels : [])))); ?>,
            datasets: <?php echo json_encode($datasets); ?>
        };

        var chartOptions = {
            plugins: {
                tooltip: {
                    callbacks: {
                        label: function(context) {
                            let label = context.dataset.label || '';
                            if (label) {
                                label += ': ';
                            }
                            if (context.parsed.y !== undefined) {
                                label += context.parsed.y;
                            } else if (context.parsed !== undefined) {
                                label += context.parsed;
                                label += '%';
                            }
                            return label;
                        }
                    }
                }
            }
        };

        var myChart = new Chart(ctx, {
            type: '<?php echo $chartType; ?>',
            data: chartData,
            options: chartOptions
        });

        function updateChart(chartType) {
            window.location.href = '{{ route('hotel.chart') }}?chart_type=' + chartType;
        }
    </script>

@endsection
