<div class="container">
    @if (count($ReportNetSpeeds) > 0)

        <h1 class="text text-center">All <b class='text-danger'>Internet Checking</b> Report</h1><br>
        <a href="{{ route('addNetSpeed', ['type' => $source]) }}" class="btn btn-primary">Add Internet Check</a>
        <table class="table table-striped table-hover ">
            <thead>
                <tr>
                    <th scope="col">#</th>
                    <th scope="col">Location</th>
                    <th scope="col">Downlaod</th>
                    <th scope="col">Upload</th>
                    <th scope="col">Created Time</th>
                    {{-- <th scope="col">Updated time</th> --}}
                    <th scope="col">Action</th>

                </tr>
            </thead>
            <tbody>
                @foreach ($ReportNetSpeeds as $ReportNetSpeed)
                    <tr>
                        <th scope="row">{{ $ReportNetSpeed->id }}</th>
                        <td>{{ $ReportNetSpeed->location }}</td>
                        <td>{{ $ReportNetSpeed->download }}</td>
                        <td>{{ $ReportNetSpeed->upload }}</td>
                        <td>{{ \Carbon\Carbon::parse($ReportNetSpeed->created_at)->format('d/m/Y H:i:s') }}</td>
                        <td>
                            <a href="{{ route('updateNetSpeed', ['type' => $source, 'id' => $ReportNetSpeed->id]) }}"
                                class="btn btn-primary btn-sm"><i class="bi bi-pencil-square"></i></a>

                            <form
                                action="{{ route('deleteNetSpeed', ['type' => $source, 'id' => $ReportNetSpeed->id]) }}"
                                method="POST" style="display: inline-block;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm"
                                    onclick="return confirm('Are you sure you want to delete this report?')">
                                    <i class="bi bi-trash3-fill"></i>
                                </button>
                            </form>
                    </tr>
                @endforeach
            </tbody>
        </table>
        <div class="justify-content-center">
            {{ $ReportNetSpeeds->links() }}
        </div>
    @else
        <h2 class="text text-center py-5">
            No data found, Please add report Internet Speed
            <a href="/netspeed/addNetSpeed" class="btn btn-primary px-5 ms-2">Add</a>
        </h2>
    @endif
</div>

<hr>
