<div class="container">
    @if (count($ReportGuests) > 0)
        <h1 class="text text-center">All Report Daily Checklist on <b class='text-danger'>Guest Rooms</b></h1><br>

        <a href="/guest/addGuest" class="btn btn-primary">Add Guest Room Check</a>
        <table class="table table-striped table-hover ">
            <thead>
                <tr>
                    <th scope="col">#</th>
                    <th scope="col">Location</th>
                    <th scope="col">Room No.</th>
                    <th scope="col">Downlaod</th>
                    <th scope="col">Upload</th>
                    <th scope="col">Channel Number</th>
                    <th scope="col">Channel Name</th>
                    <th scope="col">Created Time</th>
                    {{-- <th scope="col">Updated time</th> --}}
                    <th scope="col">Action</th>

                </tr>
            </thead>
            <tbody>
                @foreach ($ReportGuests as $ReportGuest)
                    <tr>
                        <th scope="row">{{ $ReportGuest->id }}</th>
                        <td>{{ $ReportGuest->location }}</td>
                        <td>{{ $ReportGuest->room_no }}</td>
                        <td>{{ $ReportGuest->download }}</td>
                        <td>{{ $ReportGuest->upload }}</td>
                        <td>{{ $ReportGuest->ch_no }}</td>
                        <td>{{ $ReportGuest->ch_name }}</td>
                        <td>{{ \Carbon\Carbon::parse($ReportGuest->created_at)->format('d/m/Y H:i:s') }}</td>
                        {{-- <td>{{ \Carbon\Carbon::parse($ReportGuest->updated_at)->format('d/m/Y H:i:s') }}</td> --}}
                        <td>
                            <a href="{{ route('updateGuest', ['type' => $source, 'id' => $ReportGuest->id]) }}"
                                class="btn btn-primary btn-sm"><i class="bi bi-pencil-square"></i></a>

                            <form action="{{ route('deleteGuest', ['type' => $source, 'id' => $ReportGuest->id]) }}"
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
            {{ $ReportGuests->links() }}
        </div>
    @else
        <h2 class="text text-center py-5">
            No data found, Please add report guest room
            <a href="/guest/addGuest" class="btn btn-primary px-5 ms-2">Add</a>
        </h2>
    @endif
</div>

<hr><br>
