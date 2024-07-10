<p><strong>ID:</strong> {{ $report->id }}</p>
<p><strong>Issue:</strong> {{ $report->issue }}</p>
<p><strong>Detail:</strong> {{ $report->detail }}</p>
<p><strong>Department:</strong> {{ $report->department }}</p>
<p><strong>Hotel:</strong> {{ $report->hotel }}</p>
<p><strong>Location:</strong> {{ $report->location }}</p>
<p><strong>Status:</strong> {{ $report->status === 0 ? 'In Progress' : 'Completed' }}</p>
<p><strong>Created:</strong> {{ \Carbon\Carbon::parse($report->created_at)->format('l, d F Y H:i:s') }}</p>
<p><strong>Updated:</strong> {{ \Carbon\Carbon::parse($report->updated_at)->format('l, d F Y H:i:s') }}</p>
