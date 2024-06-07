@extends('layout')
@section('title', 'Report Guest Room')

@section('content')
    @if (count($ReportGuests) > 0)
        <div class="container">
            <h1 class="text text-center">All Report Daily Checklist on <b>Guest Rooms</b></h1><br>

            <a href="/guest/addGuest" class="btn btn-primary">Add Guest Room Check</a>
            <table class="table table-striped table-hover ">
                <thead>
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">Location</th>
                        <th scope="col">Room No.</th>
                        <th scope="col">Upload</th>
                        <th scope="col">Downlaod</th>
                        <th scope="col">Channel Number</th>
                        <th scope="col">Channel Name</th>
                        <th scope="col">Created Time</th>
                        <th scope="col">Updated time</th>
                        <th scope="col">Action</th>

                    </tr>
                </thead>
                <tbody>
                    @foreach ($ReportGuests as $ReportGuest)
                        <tr>
                            <th scope="row">{{ $ReportGuest->id }}</th>
                            <td>{{ $ReportGuest->location }}</td>
                            <td>{{ $ReportGuest->room_no }}</td>
                            <td>{{ $ReportGuest->upload }}</td>
                            <td>{{ $ReportGuest->download }}</td>
                            <td>{{ $ReportGuest->ch_no }}</td>
                            <td>{{ $ReportGuest->ch_name }}</td>
                            <td>{{ $ReportGuest->created_at }}</td>
                            <td>{{ $ReportGuest->updated_at }}</td>
                            <td>
                                <a href="{{ route('updateGuest', $ReportGuest->id) }}"
                                    class="btn btn-primary btn-sm"><i class="bi bi-pencil-square"></i></a>

                                <form action="{{ route('deleteGuest', $ReportGuest->id) }}" method="POST"
                                    style="display: inline-block;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-sm"
                                        onclick="return confirm('Are you sure you want to delete this report?')"><i class="bi bi-trash3-fill"></i>
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
            <h1 class="text text-center py-5 ">No data found, Pleases add report guest room <a href="/guest/addGuest"
                    class="btn btn-primary padding: 10px 20px">Add</a></h1>
        </div>
    @endif

@endsection
