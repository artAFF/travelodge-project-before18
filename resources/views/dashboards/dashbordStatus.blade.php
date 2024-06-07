@extends('layout')
@section('title', 'Dashboard')
@section('content')

    <script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.2/dist/chart.umd.min.js"></script>

    <h1 class="text text-center">Status Report</h1>

    <div>
        <canvas id='chart' style="width:600px; height:400px; margin: auto;"></canvas> {{-- style="width:600px; height:400px; --}}
      </div>

    <script>
        var ctx = document.getElementById('chart').getContext('2d');
        var userChart = new Chart(ctx, {
            type: 'doughnut',
            data: {
                labels: <?php echo json_encode($status); ?>,
                datasets: <?php echo json_encode($datasets); ?>
            },
        });
    </script>

@endsection
