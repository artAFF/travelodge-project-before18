@extends('layouts.app')
@section('title', 'Manage Categories Issues')
@section('content')
    <div class="container">
        <h2>Manage Categories</h2>

        <form action="{{ route('structure.categories.store') }}" method="POST" class="mb-4">
            @csrf
            <div class="row">
                <div class="col-md-4">
                    <input type="text" name="name" class="form-control" placeholder="New Category Name" required>
                </div>
                <div class="col-md-4">
                    <select name="position" class="form-control" required>
                        <option value="">Add after...</option>
                        @foreach ($categories as $category)
                            <option value="{{ $category->id }}">after {{ $category->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-4">
                    <button type="submit" class="btn btn-primary">Add Category</button>
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
                @foreach ($categories as $category)
                    <tr>
                        <td>{{ $category->id }}</td>
                        <td>{{ $category->name }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@endsection
