<p><strong>ID:</strong> {{ $report->id }}</p>
<p><strong>Issue:</strong> {{ $report->issue }}</p>
<p><strong>Detail:</strong> {{ $report->detail }}</p>
<p><strong>Remarks:</strong>
    @if ($report->remarks)
        {{ $report->remarks }}
    @else
        No Remarks
    @endif
</p>
<p><strong>Department:</strong> {{ $report->department }}</p>
<p><strong>Hotel:</strong> {{ $report->hotel }}</p>
<p><strong>Location:</strong> {{ $report->location }}</p>
<p><strong>Status:</strong> {{ $report->status === 0 ? 'In Progress' : 'Completed' }}</p>
<p><strong>Created:</strong> {{ \Carbon\Carbon::parse($report->created_at)->format('l, d F Y H:i:s') }}</p>
<p><strong>Updated:</strong> {{ \Carbon\Carbon::parse($report->updated_at)->format('l, d F Y H:i:s') }}</p>
@if ($report->file_path)
    <p><strong>Attached File:</strong></p> @php         $extension = pathinfo(storage_path('app/public/' . $report->file_path), PATHINFO_EXTENSION);     @endphp @if (in_array($extension, ['jpg', 'jpeg', 'png', 'gif']))
        <img src="{{ asset('storage/' . $report->file_path) }}" alt="Attached Image"
            style="max-width: 100%; height: auto;">
    @elseif($extension == 'pdf')
        <embed src="{{ asset('storage/' . $report->file_path) }}" type="application/pdf" width="100%" height="600px">
    @else
        <p>File type not supported for preview. <a href="{{ asset('storage/' . $report->file_path) }}"
                target="_blank">Download File</a></p>
    @endif
@else
    <p>No file attached.</p>
@endif
