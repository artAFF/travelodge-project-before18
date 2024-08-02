@extends('layout')
@section('title', 'Server Room')

@section('content')
    @if (count($ReportServers) > 0)
        <div class="container">
            <h1 class="text text-center">All Report Daily Checklist at <b>Server Room</b></h1><br>
            <a href="/server/addServer" class="btn btn-primary">Add Server Room Check</a>
            <table class="table table-striped table-hover ">
                <thead>
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">Server Temperature</th>
                        <th scope="col">UPS Temperature</th>
                        <th scope="col">USP Battery Percentage</th>
                        <th scope="col">UPS Period Of Service</th>
                        <th scope="col">Created Time</th>
                        <th scope="col">Updated time</th>
                        <th scope="col">Action
                        </th>

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
                            <td style="text-center">{{ $ReportServer->created_at }}</td>
                            <td style="text-center">{{ $ReportServer->updated_at }}</td>
                            <td>
                                <a href="{{ route('updateServer', $ReportServer->id) }}" class="btn btn-primary btn-sm"><i
                                        class="bi bi-pencil-square"></i>
                                </a>

                                <form action="{{ route('deleteServer', $ReportServer->id) }}" method="POST"
                                    style="display: inline-block;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-sm"
                                        onclick="return confirm('Are you sure you want to delete this report?')"><i
                                            class="bi bi-trash3-fill"></i>
                                    </button>
                                </form>
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

@endsection
