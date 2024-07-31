@extends('layout')
@section('title', 'Manage Departments')
@section('content')
    <div class="container">
        <h2>Manage Departments</h2>

        <form action="{{ route('structure.departments.store') }}" method="POST" class="mb-4">
            @csrf
            <div class="row">
                <div class="col-md-4">
                    <input type="text" name="name" class="form-control" placeholder="New Department Name" required>
                </div>
                <div class="col-md-4">
                    <select name="position" class="form-control" required>
                        <option value="">Add after...</option>
                        @foreach ($departments as $department)
                            <option value="{{ $department->id }}">after {{ $department->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-4">
                    <button type="submit" class="btn btn-primary">Add Department</button>
                </div>
            </div>
        </form>

        <table class="table">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Name</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($departments as $department)
                    <tr>
                        <td>{{ $department->id }}</td>
                        <td>{{ $department->name }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@endsection
