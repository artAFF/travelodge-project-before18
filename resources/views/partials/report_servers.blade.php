@if (count($ReportServers) > 0)
    <div class="container">
        <h1 class="text text-center">All Report Daily Checklist at <b class='text-danger'>Server Room</b></h1><br>
        <a href="/server/addServer" class="btn btn-primary">Add Server Room Check</a>
        <table class="table table-striped table-hover ">
            <thead>
                <tr>
                    <th scope="col">#</th>
                    <th scope="col" class="col-md-1">Server Temperature</th>
                    <th scope="col"class="col-md-1">UPS Temperature</th>
                    <th scope="col"class="col-md-2">USP Battery {{-- Percentage --}}</th>
                    <th scope="col"class="col-md-2">UPS Period Of Service {{-- Available --}}</th>
                    <th scope="col"class="col-md-2">Created Time</th>
                    <th scope="col"class="col-md-2">Updated time</th>
                    <th scope="col">Action


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
                        <td style="text-center">
                            {{ \Carbon\Carbon::parse($ReportServer->updated_at)->format('d/m/Y H:i:s') }}</td>
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
        <h1 class="text text-center py-5 ">No data found, Pleases add report server<a href="/server/addServer"
                class="btn btn-primary px-5">Add</a></h1>
    </div>
@endif

<br>
<hr><br>
