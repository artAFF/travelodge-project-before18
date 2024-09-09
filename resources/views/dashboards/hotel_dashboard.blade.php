@extends('layout')
@section('title', 'Hotel Dashboard')
@section('content')
    <script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.2/dist/chart.umd.min.js"></script>

    <style>
        #viewSelector {
            width: auto;
            min-width: 150px;
            max-width: 200px;
            background-color: #f8f9fa;
            border: 1px solid #ced4da;
            border-radius: 4px;
            padding: 5px 10px;
        }

        .form-group {
            margin-left: 20px;
        }

        @media (max-width: 768px) {
            .row>div {
                flex-direction: column;
            }

            #viewSelector {
                margin-top: 10px;
                margin-left: 0;
            }
        }
    </style>

    <div class="container-fluid px-4">
        <div class="row mb-3">
            <div class="col-12 d-flex justify-content-between align-items-center">
                <h1>Dashboard for {{ $hotel_name }}</h1>
                <div class="form-group mb-0">
                    <select id="viewSelector" class="form-control">
                        <option value="category">Category</option>
                        <option value="department">Department</option>
                    </select>
                </div>
            </div>
        </div>

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
                        <h3 class="card-title text-center mb-4"><span id="reportTitle"></span> Reports</h3>
                        <div id="reportCards" class="row row-cols-1 row-cols-md-2 row-cols-lg-3 g-4">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        var categoryData = @json($category_data);
        var departmentData = @json($department_data);
        var currentView = 'category';

        var barChart, pieChart;

        function updateCharts() {
            var data = currentView === 'category' ? categoryData : departmentData;
            updateBarChart(data);
            updatePieChart(data);
            updateReportCards(data);
        }

        function updateBarChart(data) {
            if (barChart) {
                barChart.destroy();
            }

            var ctx = document.getElementById('barChart').getContext('2d');
            barChart = new Chart(ctx, {
                type: 'bar',
                data: {
                    labels: data.labels,
                    datasets: [{
                        label: currentView.charAt(0).toUpperCase() + currentView.slice(1),
                        data: data.data,
                        backgroundColor: data.backgroundColor
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                }
            });
        }

        function updatePieChart(data) {
            if (pieChart) {
                pieChart.destroy();
            }

            var ctx = document.getElementById('pieChart').getContext('2d');
            pieChart = new Chart(ctx, {
                type: 'pie',
                data: {
                    labels: data.labels,
                    datasets: [{
                        data: data.data,
                        backgroundColor: data.backgroundColor
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                }
            });
        }

        function updateReportCards(data) {
            var reportCards = document.getElementById('reportCards');
            reportCards.innerHTML = '';

            data.labels.forEach((label, index) => {
                var card = document.createElement('div');
                card.className = 'col';
                card.innerHTML = `
            <div class="card h-100">
                <div class="card-body">
                    <h5 class="card-title">${label}</h5>
                    <p class="card-text">
                        <span class="fs-4 fw-bold text-primary">${data.data[index]}</span>
                        reports
                    </p>
                </div>
            </div>
        `;
                reportCards.appendChild(card);
            });

            document.getElementById('reportTitle').textContent = currentView.charAt(0).toUpperCase() + currentView.slice(1);
        }

        document.getElementById('viewSelector').addEventListener('change', function() {
            currentView = this.value;
            updateCharts();
        });

        // Initial chart render
        updateCharts();
    </script>
@endsection
