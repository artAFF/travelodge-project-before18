@extends('layouts.app')
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
        <div id="pagination" class="d-flex justify-content-center"></div>
    </div>

    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script>
        let currentPage = 1;

        function loadIssues(page = 1) {
            const urlParams = new URLSearchParams(window.location.search);
            const type = urlParams.get('type');
            const label = urlParams.get('label');
            const hotel = urlParams.get('hotel');
            const dateFilter = urlParams.get('dateFilter');
            const startDate = urlParams.get('start');
            const endDate = urlParams.get('end');

            let apiUrl = `/api/issues/${type}/${label}?hotel=${encodeURIComponent(hotel)}&page=${page}`;

            if (dateFilter && dateFilter !== 'all_time') {
                apiUrl += `&dateFilter=${dateFilter}`;
            } else if (startDate && endDate) {
                apiUrl += `&start=${startDate}&end=${endDate}`;
            }

            $.ajax({
                url: apiUrl,
                method: 'GET',
                success: function(response) {
                    console.log('API Response:', response);
                    updateTable(response.data);
                    updatePagination(response);
                    updateTitle(label, hotel);
                },
                error: function(error) {
                    console.error('Error fetching data:', error);
                    console.log('Error details:', error.responseText);
                    $('#previewTitle').text('Error loading data');
                }
            });
        }

        function updateTable(issues) {
            const tableBody = $('#previewTableBody');
            tableBody.empty();

            issues.forEach(issue => {
                tableBody.append(`
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
                `);
            });
        }

        function updatePagination(response) {
            const pagination = $('#pagination');
            pagination.empty();

            if (response.last_page > 1) {
                if (response.current_page > 1) {
                    pagination.append(`
                        <button class="btn btn-sm btn-outline-primary m-1" onclick="loadIssues(${response.current_page - 1})">
                            Previous
                        </button>
                    `);
                }

                let startPage = Math.max(1, response.current_page - 2);
                let endPage = Math.min(response.last_page, response.current_page + 2);

                for (let i = startPage; i <= endPage; i++) {
                    pagination.append(`
                        <button class="btn btn-sm btn-outline-primary m-1 ${i === response.current_page ? 'active' : ''}"
                                onclick="loadIssues(${i})">
                            ${i}
                        </button>
                    `);
                }

                if (response.current_page < response.last_page) {
                    pagination.append(`
                        <button class="btn btn-sm btn-outline-primary m-1" onclick="loadIssues(${response.current_page + 1})">
                            Next
                        </button>
                    `);
                }
            }
        }

        function updateTitle(label, hotel) {
            const hotelNames = {
                'TLCMN': 'Travelodge Nimman',
                'EHCM': 'Eastin Tan',
                'UNCM': 'U nimman'
            };
            const hotelFullName = hotelNames[hotel] || hotel;
            $('#previewTitle').text(`${label} Issues for ${hotelFullName}`);
        }

        function formatDate(dateString) {
            const date = new Date(dateString);
            const options = {
                year: 'numeric',
                month: '2-digit',
                day: '2-digit',
                hour: '2-digit',
                minute: '2-digit',
                second: '2-digit',
                hour12: false
            };
            return date.toLocaleString('en-GB', options).replace(',', '');
        }

        $(document).ready(function() {
            loadIssues();
        });
    </script>
@endsection
