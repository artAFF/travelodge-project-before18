@extends('layouts.app')
@section('title', 'Manage Buildings')
@section('content')
    <div class="container">
        <h2>Manage Buildings</h2>

        <form action="{{ route('structure.buildings.store') }}" method="POST" class="mb-4">
            @csrf
            <div class="row">
                <div class="col-md-4">
                    <input type="text" name="name" class="form-control" placeholder="New Building Name" required>
                </div>
                <div class="col-md-4">
                    <select name="position" class="form-control" required>
                        <option value="">Add after...</option>
                        @foreach ($buildings as $building)
                            <option value="{{ $building->id }}">after {{ $building->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-4">
                    <button type="submit" class="btn btn-primary">Add Building</button>
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
                @foreach ($buildings as $building)
                    <tr>
                        <td>{{ $building->id }}</td>
                        <td>{{ $building->name }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@endsection
