<div class="container">
    @if (count($ReportServers) > 0)

        <h1 class="text text-center">All Report Daily Checklist at <b class='text-danger'>Server Room</b></h1><br>
        <a href="{{ route('addServer', ['type' => $source]) }}" class="btn btn-primary">Add Server Room Check</a>
        <table class="table table-striped table-hover ">
            <thead>
                <tr>
                    <th scope="col">#</th>
                    <th scope="col">Server Temperature</th>
                    <th scope="col">UPS Temperature</th>
                    <th scope="col">USP Battery</th>
                    <th scope="col">UPS Period Of Service</th>
                    <th scope="col">Created Time</th>
                    <th scope="col">Action</th>


                </tr>
            </thead>
            <tbody>
                @foreach ($ReportServers as $ReportServer)
                    <tr>
                        <th scope="row">{{ $ReportServer->id }}</th>
                        <td style="text-center">{{ $ReportServer->server_temp }}</td>
                        <td style="text-center">{{ $ReportServer->ups_temp }}</td>
                        <td style="text-center">{{ $ReportServer->ups_battery }}</td>
                        <td style="text-center">{{ $ReportServer->ups_time }}</td>
                        <td style="text-center">
                            {{ \Carbon\Carbon::parse($ReportServer->created_at)->format('d/m/Y H:i:s') }}</td>
                        <td>
                            <a href="{{ route('updateServer', ['type' => $source, 'id' => $ReportServer->id]) }}"
                                class="btn btn-primary btn-sm"><i class="bi bi-pencil-square"></i></a>

                            <form action="{{ route('deleteServer', ['type' => $source, 'id' => $ReportServer->id]) }}"
                                method="POST" style="display: inline-block;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm"
                                    onclick="return confirm('Are you sure you want to delete this report?')">
                                    <i class="bi bi-trash3-fill"></i>
                                </button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        <div class="justify-content-center">
            {{ $ReportServers->links() }}
        </div>
    @else
        <h2 class="text text-center py-5">
            No data found, Please add report server
            <a href="/server/addServer" class="btn btn-primary px-5 ms-2">Add</a>
        </h2>
    @endif
</div>

<hr><br>
