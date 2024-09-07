@extends('layout')
@section('title', 'Dashboard Category')
@section('content')
    <script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.2/dist/chart.umd.min.js"></script>
    <h1 class="text text-center">Issue By Category</h1>

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
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <h3 class="card-title text-center mb-4">Category Reports</h3>
                    <div class="row row-cols-1 row-cols-md-2 row-cols-lg-3 g-4">
                        @foreach ($categories as $index => $category)
                            <div class="col">
                                <div class="card h-100">
                                    <div class="card-body">
                                        <h5 class="card-title">{{ $category }}</h5>
                                        <p class="card-text">
                                            <span class="fs-4 fw-bold text-primary">
                                                {{ $datasets[0]['data'][$index] }}
                                            </span>
                                            reports
                                        </p>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        var barCtx = document.getElementById('barChart').getContext('2d');
        var pieCtx = document.getElementById('pieChart').getContext('2d');

        var chartData = {
            labels: <?php echo json_encode($categories); ?>,
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
                                return context.dataset.label + ': ' + context.parsed.y;
                            }
                        }
                    }
                }
            }
        });

        var pieChart = new Chart(pieCtx, {
            type: 'pie',
            data: {
                labels: <?php echo json_encode($categories); ?>,
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
    </script>
@endsection
