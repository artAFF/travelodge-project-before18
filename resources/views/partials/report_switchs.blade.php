@if (count($ReportSwitchs) > 0)
    <div class="container">
        <h1 class="text text-center">All Report Daily Checklist at <b class='text-danger'>Switch Room</b></h1><br>
        <a href="/switchs/addSwitch" class="btn btn-primary">Add Switch Room Check</a>
        <table class="table table-striped table-hover ">
            <thead>
                <tr>
                    <th scope="col">#</th>
                    <th scope="col">Location</th>
                    <th scope="col">USP Battery Percentage</th>
                    <th scope="col">UPS Period Of Service {{-- Available --}}</th>
                    <th scope="col">Switch Temperature</th>
                    <th scope="col">Created Time</th>
                    <th scope="col">Updated time</th>
                    <th scope="col">Action</th>

                </tr>
            </thead>
            <tbody>
                @foreach ($ReportSwitchs as $ReportSwitch)
                    <tr>
                        <th scope="row">{{ $ReportSwitch->id }}</th>
                        <td>{{ $ReportSwitch->location }}</td>
                        <td>{{ $ReportSwitch->ups_battery }}</td>
                        <td>{{ $ReportSwitch->ups_time }}</td>
                        <td>{{ $ReportSwitch->ups_temp }}</td>
                        <td>{{ $ReportSwitch->created_at }}</td>
                        <td>{{ $ReportSwitch->updated_at }}</td>
                        <td>
                            <a href="{{ route('updateSwitch', ['type' => $source, 'id' => $ReportSwitch->id]) }}"
                                class="btn btn-primary btn-sm"><i class="bi bi-pencil-square"></i></a>

                            <form action="{{ route('deleteSwitch', ['type' => $source, 'id' => $ReportSwitch->id]) }}"
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
            {{ $ReportSwitchs->links() }}
        </div>
    @else
        <h1 class="text text-center py-5 ">No data found, Pleases add report switch<a href="/addSwitch"
                class="btn btn-primary px-5">Add</a></h1>
    </div>
@endif

<br>
<hr><br>
