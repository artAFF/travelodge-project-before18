@extends('layout')
@section('title', 'Issue Preview')
@section('content')
    <div class="container mt-4">
        <h3 id="previewTitle"></h3>
        <table class="table">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Issue</th>
                    <th>Detail</th>
                    <th>Department</th>
                    <th>Hotel</th>
                    <th>Status</th>
                    <th>Created At</th>
                </tr>
            </thead>
            <tbody id="previewTableBody">
            </tbody>
        </table>
    </div>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const urlParams = new URLSearchParams(window.location.search);
            const type = urlParams.get('type');
            const label = urlParams.get('label');
            const hotel = urlParams.get('hotel');
            const dateFilter = urlParams.get('dateFilter');
            const startDate = urlParams.get('start');
            const endDate = urlParams.get('end');

            if (type && label && hotel) {
                let apiUrl = `/api/issues/${type}/${label}?hotel=${encodeURIComponent(hotel)}`;

                if (dateFilter && dateFilter !== 'all_time') {
                    apiUrl += `&dateFilter=${dateFilter}`;
                } else if (startDate && endDate) {
                    apiUrl += `&start=${startDate}&end=${endDate}`;
                }

                fetch(apiUrl)
                    .then(response => response.json())
                    .then(data => {
                        const hotelNames = {
                            'TLCMN': 'Travelodge Nimman',
                            'EHCM': 'Eastin Tan',
                            'UNCM': 'U nimman'
                        };
                        const hotelFullName = hotelNames[hotel] || hotel;
                        document.getElementById('previewTitle').textContent =
                            `${label} Issues for ${hotelFullName}`;
                        const tableBody = document.getElementById('previewTableBody');
                        tableBody.innerHTML = data.map(issue => `
                    <tr>
                        <td>${issue.id}</td>
                        <td>${issue.issue}</td>
                        <td>${issue.detail}</td>
                        <td>${issue.department}</td>
                        <td>${issue.hotel}</td>
                        <td>${issue.status === 0 ? 'In Process' : 'Completed'}</td>
                        <td>${new Date(issue.created_at).toLocaleString()}</td>
                    </tr>
                `).join('');
                    });
            }
        });
    </script>
@endsection
