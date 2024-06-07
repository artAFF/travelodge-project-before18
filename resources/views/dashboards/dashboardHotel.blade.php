@extends('layout')
@section('title', 'Dashbaord')
@section('content')

    <script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.2/dist/chart.umd.min.js"></script>

    <h1 class="text text-center">Issue By Hotel</h1>

    <div>
        <canvas id='chart' style="width:900px; margin: auto;"></canvas>
    </div>

    <script>
        var ctx = document.getElementById('chart').getContext('2d');
        var userChart = new Chart(ctx, {
            type: 'bar',
            data: {
                labels: <?php echo json_encode($hotels); ?>,
                datasets: <?php echo json_encode($datasets); ?>
            },
        });
    </script>

@endsection
