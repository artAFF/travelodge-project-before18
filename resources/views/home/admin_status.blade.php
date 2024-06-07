@extends('layout')
@section('title', 'Admin and General')

@section('content')

@if (count($admin_statuses) > 0)
<div class="container">
    </div>
    </form>
    <table class="table table-striped table-hover ">
    <thead>
        <tr>
            <th>#</th>
            <td>Issue</td>
            <th class="col-md-3" scope="col">Detail</th>
            <th>Department</th>
            <th>Hotel</th>
            <th>Location</th>
            <th>Status</th>
            <th>Created At</th>
            <th>Updated At</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($admin_statuses as $admin_status)
            <tr>
                <td>{{ $admin_status->id }}</td>
                <td>{{ $admin_status->issue }}</td>
                <td>{{ $admin_status->detail }}</td>
                <td>{{ $admin_status->department }}</td>
                <td>{{ $admin_status->hotel }}</td>
                <td>{{ $admin_status->location }}</td>
                <td class="text-center">
                    @if ($admin_status->status === 0)
                        <a href="#" class="btn btn-warning"><i class="bi bi-hourglass-split"></i>{{-- In-process --}}</a>
                    @else
                        <a href="#" class="btn btn-success"><i class="bi bi-check2"></i>{{-- Succeed --}}</a>
                    @endif
                <td>{{ $admin_status->created_at }}</td>
                <td>{{ $admin_status->updated_at }}</td>
            </tr>
        @endforeach
    </tbody>
</table>
<div class="justify-content-center">
    {{ $admin_statuses->links() }}
</div>
@else
            <h1 class="text text-center py-5 ">No data found </h1>

        </div>
@endif


@endsection
