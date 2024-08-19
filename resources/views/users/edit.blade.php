@extends('layout')
@section('title', 'Edit User')
@section('content')
    <div class="container">
        <h2>Edit User</h2>
        <form method="POST" action="{{ route('users.update', $user) }}">
            @csrf
            @method('PUT')
            <div class="form-group">
                <label for="name">Name</label>
                <input type="text" class="form-control" id="name" name="name" value="{{ $user->name }}" required>
            </div>
            <div class="form-group">
                <label for="role">Role</label>
                <select class="form-control" id="role" name="role" required>
                    <option value="user" {{ $user->role == 'user' ? 'selected' : '' }}>User</option>
                    <option value="admin" {{ $user->role == 'admin' ? 'selected' : '' }}>Administrator</option>
                </select>
            </div>
            <div class="form-group">
                <label for="password">New Password (leave blank to keep current)</label>
                <input type="password" class="form-control" id="password" name="password">
            </div>
            <div class="form-group">
                <label for="password_confirmation">Confirm New Password</label>
                <input type="password" class="form-control" id="password_confirmation" name="password_confirmation">
            </div>
            <br><button type="submit" class="btn btn-primary">Update User</button>
        </form>
    </div>
@endsection
