@if (count($ReportNetSpeeds) > 0)
    <div class="container">
        <h1 class="text text-center">All <b class='text-danger'>Internet Checking</b> Report</h1><br>
        {{-- <h2 class="text text-center text-danger"><b>Only as follows Lobby, The Lodge, Pool, Gym, Grab and Go,
                Office</b></h2> --}}
        <a href="/netspeed/addNetSpeed" class="btn btn-primary">Add Internet Check</a>
        <table class="table table-striped table-hover ">
            <thead>
                <tr>
                    <th scope="col">#</th>
                    <th scope="col">Location</th>
                    <th scope="col">Downlaod</th>
                    <th scope="col">Upload</th>
                    <th scope="col">Created Time</th>
                    <th scope="col">Updated time</th>
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
                        <td>{{ $ReportNetSpeed->created_at }}</td>
                        <td>{{ $ReportNetSpeed->updated_at }}</td>
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
        <h1 class="text text-center py-5 ">No data found, Pleases add report Internet Speed <a
                href="/netspeed/addNetSpeed" class="btn btn-primary px-5">Add</a></h1>
    </div>
@endif

<br>
<hr>
