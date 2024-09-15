@extends('layout')
@section('title', 'Issue In-process')

@section('content')
    @if (count($in_process) > 0)
        <div class="container">
            <h3 class="text-center mb-4">Issues in the process</h3>
            <div class="row align-items-center justify-content-start">
                <div class="col-md-4">
                    <form action="{{ route('inprocess') }}" method="GET">
                        <div class="input-group">
                            <input type="text" name="query" class="form-control" placeholder="Search"
                                value="{{ request('query') }}">
                            <div class="input-group-append">
                                <button type="submit" class="btn btn-info">Search</button>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="col-md-auto ms-md-3">
                    <button id="captureAndSendBtn" class="btn btn-primary">Capture and Send to Line</button>
                </div>
            </div>
        </div>

        <table class="table table-striped table-hover mt-3">
            <thead>
                <tr>
                    <th class="text-center"><a class="text-dark text-decoration-none"
                            href="{{ route('inprocess', array_merge(request()->all(), ['sort_by' => 'id', 'sort_order' => request('sort_order') === 'asc' ? 'desc' : 'asc'])) }}">#</a>
                    </th>
                    <th class="text-center"><a class="text-dark text-decoration-none"
                            href="{{ route('inprocess', array_merge(request()->all(), ['sort_by' => 'issue', 'sort_order' => request('sort_order') === 'asc' ? 'desc' : 'asc'])) }}">Issue</a>
                    </th>
                    <th class="col-md-3 text-center"><a class="text-dark text-decoration-none"
                            href="{{ route('inprocess', array_merge(request()->all(), ['sort_by' => 'detail', 'sort_order' => request('sort_order') === 'asc' ? 'desc' : 'asc'])) }}">Detail</a>
                    </th>
                    <th class="text-center"><a class="text-dark text-decoration-none"
                            href="{{ route('inprocess', array_merge(request()->all(), ['sort_by' => 'department', 'sort_order' => request('sort_order') === 'asc' ? 'desc' : 'asc'])) }}">Department</a>
                    </th>
                    <th class="text-center"><a class="text-dark text-decoration-none"
                            href="{{ route('inprocess', array_merge(request()->all(), ['sort_by' => 'hotel', 'sort_order' => request('sort_order') === 'asc' ? 'desc' : 'asc'])) }}">Hotel</a>
                    </th>
                    <th class="text-center">Status</th>
                    <th class="text-center"><a class="text-dark text-decoration-none"
                            href="{{ route('inprocess', array_merge(request()->all(), ['sort_by' => 'assignee_id', 'sort_order' => request('sort_order') === 'asc' ? 'desc' : 'asc'])) }}">Assignee</a>
                    </th>
                    <th class="text-center"><a class="text-dark text-decoration-none"
                            href="{{ route('inprocess', array_merge(request()->all(), ['sort_by' => 'created_at', 'sort_order' => request('sort_order') === 'asc' ? 'desc' : 'asc'])) }}">Created
                            At</a>
                    </th>
                    <th scope="col" class="text-center">Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($in_process as $in_process1)
                    <tr>
                        <td class="text-center">{{ $in_process1->id }}</td>
                        <td class="text-center">{{ $in_process1->category->name ?? 'N/A' }}</td>
                        <td class="text-center">{{ $in_process1->detail }}</td>
                        <td class="text-center">{{ $in_process1->department->name ?? 'N/A' }}</td>
                        <td class="text-center">{{ $in_process1->hotel }}</td>
                        <td class="text-center">
                            @if ($in_process1->status === 0)
                                <a href="#" class="btn btn-warning"><i class="bi bi-hourglass-split"></i></a>
                            @else
                                <a href="#" class="btn btn-success"><i class="bi bi-check2"></i></a>
                            @endif
                        </td>
                        <td class="text-center">
                            <select class="form-select assignee-select" data-issue-id="{{ $in_process1->id }}">
                                <option value="">Not Assign</option>
                                @foreach ($itSupportUsers as $user)
                                    <option value="{{ $user->id }}"
                                        {{ $in_process1->assignee_id == $user->id ? 'selected' : '' }}>
                                        {{ $user->name }}
                                    </option>
                                @endforeach
                            </select>
                        </td>
                        <td class="text-center">
                            {{ \Carbon\Carbon::parse($in_process1->created_at)->format('d/m/Y H:i:s') }}</td>
                        <td class="text-center">
                            <button class="btn btn-secondary preview-btn" data-id="{{ $in_process1->id }}"><i
                                    class="bi bi-eye"></i></button>
                            <a href="{{ route('updateReport', $in_process1->id) }}" class="btn btn-primary "><i
                                    class="bi bi-pencil-square"></i></a>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        <div class="justify-content-center">
            {{ $in_process->links() }}
        </div>
    @else
        <h1 class="text text-center py-5">No data found</h1>
    @endif

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

    <script src="https://html2canvas.hertzen.com/dist/html2canvas.min.js"></script>
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            function submitSearch() {
                document.querySelector('form').submit();
            }

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

            // Capture and send to Line
            document.getElementById('captureAndSendBtn').addEventListener('click', function() {
                html2canvas(document.querySelector("table")).then(canvas => {
                    canvas.toBlob(function(blob) {
                        let formData = new FormData();
                        formData.append('image', blob, 'table_capture.png');

                        fetch('/send-to-line-image', {
                                method: 'POST',
                                headers: {
                                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                                },
                                body: formData
                            })
                            .then(response => response.json())
                            .then(data => {
                                if (data.success) {
                                    Swal.fire({
                                        title: 'Success!',
                                        text: 'Image sent to Line successfully!',
                                        icon: 'success',
                                        confirmButtonText: 'OK'
                                    });
                                } else {
                                    Swal.fire({
                                        title: 'Error!',
                                        text: 'Failed to send image to Line',
                                        icon: 'error',
                                        confirmButtonText: 'OK'
                                    });
                                }
                            })
                            .catch(error => {
                                console.error('Error:', error);
                                Swal.fire({
                                    title: 'Error!',
                                    text: 'An error occurred while sending image to Line',
                                    icon: 'error',
                                    confirmButtonText: 'OK'
                                });
                            });
                    });
                });
            });
        });
    </script>
@endsection
