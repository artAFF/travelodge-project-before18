@extends('layout')
@section('title', 'Dashboard')
@section('content')

    <script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.2/dist/chart.umd.min.js"></script>

    <h1 class="text text-center">Issue By Category</h1>

    <div>
        <canvas id='chart' style="width:900px; margin: auto;"></canvas> {{-- style="width:600px; height:400px; --}}
      </div>

    <script>
        var ctx = document.getElementById('chart').getContext('2d');
        var userChart = new Chart(ctx, {
            type: 'bar',
            data: {
                labels: <?php echo json_encode($categories); ?>,
                datasets: <?php echo json_encode($datasets); ?>
            },
        });
    </script>

@endsection
