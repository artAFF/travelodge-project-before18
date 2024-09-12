@extends('layout')
@section('title', 'Issue Preview')
@section('content')
    <div class="container mt-4">
        <h3 id="previewTitle"></h3>
        <table class="table">
            <thead>
                <tr>
                    <th class="text-center">ID</th>
                    <th class="text-center">Category</th>
                    <th class="text-center">Detail</th>
                    <th class="text-center">Remarks</th>
                    <th class="text-center">Department</th>
                    <th class="text-center">Hotel</th>
                    <th class="text-center">Status</th>
                    <th class="text-center">Assignee</th>
                    <th class="text-center">Created At</th>
                    <th class="text-center">Updated At</th>
                </tr>
            </thead>
            <tbody id="previewTableBody">
            </tbody>
        </table>
    </div>
    <script>
        function formatDate(dateString) {
            const date = new Date(dateString);
            const day = date.getDate().toString().padStart(2, '0');
            const month = (date.getMonth() + 1).toString().padStart(2, '0');
            const year = date.getFullYear();
            const hours = date.getHours().toString().padStart(2, '0');
            const minutes = date.getMinutes().toString().padStart(2, '0');
            const seconds = date.getSeconds().toString().padStart(2, '0');

            return `${day}/${month}/${year} ${hours}:${minutes}:${seconds}`;
        }

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
                                <td class="text-center">${issue.id}</td>
                                <td class="text-center">${issue.category?.name || 'N/A'}</td>
                                <td class="text-center">${issue.detail || 'N/A'}</td>
                                <td class="text-center">${issue.remarks || 'N/A'}</td>
                                <td class="text-center">${issue.department?.name || 'N/A'}</td>
                                <td class="text-center">${issue.hotel || 'N/A'}</td>
                                <td class="text-center">${issue.status === 0 ? 'In Process' : 'Done'}</td>
                                <td class="text-center">${issue.assignee?.name || 'N/A'}</td>
                                <td class="text-center">${formatDate(issue.created_at)}</td>
                                <td class="text-center">${formatDate(issue.updated_at)}</td>
                            </tr>
                        `).join('');
                    })
                    .catch(error => {
                        console.error('Error fetching data:', error);
                        document.getElementById('previewTitle').textContent = 'Error loading data';
                    });
            }
        });
    </script>
@endsection
