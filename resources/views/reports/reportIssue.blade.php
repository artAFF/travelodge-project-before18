@extends('layout')
@section('title', 'IT Support Issue')

@section('content')

    <div class="container">
        <h3 class="text-center">All IT Support Issue</h1>
            <div class="row mb-3">
                <div class="col-md-8">
                    <a href="/reports/addIssue" class="btn btn-primary">Add Report</a>
                    <a href="/reports/inprocess" class="btn btn-warning">All In-process</a>
                </div>
                <div class="col-md-4">
                    <form action="{{ route('reportIssue') }}" method="GET">
                        <div class="input-group">
                            <input type="text" name="query" class="form-control" placeholder="Search"
                                value="{{ request('query') }}">
                            <span class="input-group-btn">
                                <button type="submit" class="btn btn-info">Search</button>
                            </span>
                        </div>
                    </form>
                </div>
            </div>
            @if (count($ReportIssues) > 0)
                <table class="table table-striped table-hover">
                    <thead>
                        <tr>
                            <th scope="col" class="text-center"><a class="text-dark text-decoration-none"
                                    href="{{ route('reportIssue', array_merge(request()->all(), ['sort_by' => 'id', 'sort_order' => request('sort_order') === 'asc' ? 'desc' : 'asc'])) }}">#</a>
                            </th>
                            <th scope="col" class="text-center"><a class="text-dark text-decoration-none"
                                    href="{{ route('reportIssue', array_merge(request()->all(), ['sort_by' => 'issue', 'sort_order' => request('sort_order') === 'asc' ? 'desc' : 'asc'])) }}">Issue</a>
                            </th>
                            <th class="col-md-4 text-center" scope="col"><a class="text-dark text-decoration-none"
                                    href="{{ route('reportIssue', array_merge(request()->all(), ['sort_by' => 'detail', 'sort_order' => request('sort_order') === 'asc' ? 'desc' : 'asc'])) }}">Detail</a>
                            </th>
                            <th class="col-md-2 text-center" scope="col"><a class="text-dark text-decoration-none"
                                    href="{{ route('reportIssue', array_merge(request()->all(), ['sort_by' => 'department', 'sort_order' => request('sort_order') === 'asc' ? 'desc' : 'asc'])) }}">Department</a>
                            </th>
                            <th class="col-md-1 text-center" scope="col"><a class="text-dark text-decoration-none"
                                    href="{{ route('reportIssue', array_merge(request()->all(), ['sort_by' => 'hotel', 'sort_order' => request('sort_order') === 'asc' ? 'desc' : 'asc'])) }}">Hotel</a>
                            </th>

                            <th scope="col" class="text-center"><a class="text-dark text-decoration-none"
                                    href="{{ route('reportIssue', array_merge(request()->all(), ['sort_by' => 'status', 'sort_order' => request('sort_order') === 'asc' ? 'desc' : 'asc'])) }}">Status</a>
                            </th>
                            <th class="  text-center" scope="col"><a class="text-dark text-decoration-none"
                                    href="{{ route('reportIssue', array_merge(request()->all(), ['sort_by' => 'assignee_id', 'sort_order' => request('sort_order') === 'asc' ? 'desc' : 'asc'])) }}">Assignee</a>
                            </th>
                            <th scope="col" class="text-center">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($ReportIssues as $reporter)
                            <tr>
                                <th class="text-center" scope="row">{{ $reporter->id }}</th>
                                <td class="text-center">{{ $reporter->category->name ?? 'N/A' }}</td>
                                <td class="text-center">{{ Str::limit($reporter->detail, 40, '...') }}</td>
                                <td class="text-center">{{ $reporter->department->name ?? 'N/A' }}</td>
                                <td class="text-center">{{ $reporter->hotel }}</td>
                                <td class="text-center">
                                    @if ($reporter->status === 0)
                                        <a href="#" class="btn btn-warning"><i class="bi bi-hourglass-split"></i></a>
                                    @else
                                        <a href="#" class="btn btn-success"><i class="bi bi-check2"></i></a>
                                    @endif
                                </td>
                                <td class="text-center">
                                    <select class="form-select assignee-select" data-issue-id="{{ $reporter->id }}">
                                        <option value="">Not Assign</option>
                                        @foreach ($itSupportUsers as $user)
                                            <option value="{{ $user->id }}"
                                                {{ $reporter->assignee_id == $user->id ? 'selected' : '' }}>
                                                {{ $user->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </td>
                                <td class="text-center">
                                    <button class="btn btn-secondary preview-btn" data-id="{{ $reporter->id }}"><i
                                            class="bi bi-eye"></i></button>
                                    <a href="{{ route('updateReport', $reporter->id) }}" class="btn btn-primary"><i
                                            class="bi bi-pencil-square"></i></a>

                                    {{-- <form action="{{ route('deletereport', $reporter->id) }}" method="POST"
                                    style="display: inline-block;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="button" class="btn btn-danger delete-report-btn"><i
                                            class="bi bi-trash3-fill"></i></button>
                                </form> --}}
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
                <div class="justify-content-center">
                    {{ $ReportIssues->appends(request()->input())->links() }}
                </div>
            @else
                <h1 class="text-center py-5">No data found, please add a report issue <a href="/addIssue"
                        class="btn btn-primary px-5">Add Report</a></h1>
            @endif
    </div>


    <div class="modal fade" id="previewModal" tabindex="-1" aria-labelledby="previewModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="previewModalLabel">Issue Preview</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body" id="previewContent">

                </div>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener("DOMContentLoaded", function() {
            // Delete confirmation
            document.querySelectorAll('.delete-report-btn').forEach(button => {
                button.addEventListener('click', function() {
                    let reportId = this.closest('form').getAttribute('action').split('/').pop();
                    swal({
                            title: "Are you sure?",
                            text: "Once deleted, you will not be able to recover this report!",
                            icon: "warning",
                            buttons: true,
                            dangerMode: true,
                        })
                        .then((willDelete) => {
                            if (willDelete) {
                                document.querySelector(
                                    `form[action="/deletereport/${reportId}"]`).submit();
                            }
                        });
                });
            });

            // Preview functionality
            document.querySelectorAll('.preview-btn').forEach(button => {
                button.addEventListener('click', function() {
                    let reportId = this.getAttribute('data-id');
                    fetch(`/reports/preview-issue/${reportId}`)
                        .then(response => response.text())
                        .then(data => {
                            document.getElementById('previewContent').innerHTML = data;
                            new bootstrap.Modal(document.getElementById('previewModal')).show();
                        });
                });
            });

            // Assignee update
            const assigneeSelects = document.querySelectorAll('.assignee-select');
            assigneeSelects.forEach(select => {
                select.addEventListener('change', function() {
                    const issueId = this.getAttribute('data-issue-id');
                    const assigneeId = this.value;

                    fetch(`/update-assignee/${issueId}`, {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': '{{ csrf_token() }}'
                            },
                            body: JSON.stringify({
                                assignee_id: assigneeId
                            })
                        })
                        .then(response => response.json())
                        .then(data => {
                            if (data.success) {
                                Swal.fire({
                                    title: 'Success!',
                                    text: `Assignee updated successfully from ${data.oldAssignee} to ${data.newAssignee}`,
                                    icon: 'success',
                                    confirmButtonText: 'OK'
                                });
                            } else {
                                Swal.fire({
                                    title: 'Error!',
                                    text: 'Failed to update assignee',
                                    icon: 'error',
                                    confirmButtonText: 'OK'
                                });
                            }
                        })
                        .catch(error => {
                            console.error('Error:', error);
                            Swal.fire({
                                title: 'Error!',
                                text: 'An error occurred while updating assignee',
                                icon: 'error',
                                confirmButtonText: 'OK'
                            });
                        });
                });
            });
        });
    </script>
@endsection
