@extends('layouts.app')

@section('title', 'User List')

@section('content')
    <div class="container">
        <h2>User List</h2>
        <a href="{{ route('users.create') }}" class="btn btn-primary mb-3">Add New User</a>
        <table class="table">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Department</th>
                    <th>Role</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($users as $user)
                    <tr>
                        <td>{{ $user->id }}</td>
                        <td>{{ $user->name }}</td>
                        <td>{{ $user->department ? $user->department->name : 'N/A' }}</td>
                        <td>
                            @if ($user->role === 'admin')
                                Administrator
                            @elseif($user->role === 'user')
                                User
                            @else
                                {{ $user->role }}
                            @endif
                        </td>

                        <td>
                            <a href="{{ route('users.edit', $user) }}" class="btn btn-primary">Edit</a>
                            <form action="{{ route('users.destroy', $user) }}" method="POST" style="display: inline-block;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger"
                                    onclick="return confirm('Are you sure you want to delete this user?')">Delete</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@endsection
