@extends('layouts.app')
@section('title', 'Edit User')
@section('content')
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">
                        <h2 class="mb-0">Edit User</h2>
                    </div>
                    <div class="card-body">
                        <form method="POST" action="{{ route('users.update', $user) }}">
                            @csrf
                            @method('PUT')
                            <div class="mb-4">
                                <label for="name" class="form-label">Name</label>
                                <input type="text" class="form-control" id="name" name="name"
                                    value="{{ $user->name }}" required>
                            </div>
                            <div class="mb-4">
                                <label for="role" class="form-label">Role</label>
                                <select class="form-control" id="role" name="role" required>
                                    <option value="user" {{ $user->role == 'user' ? 'selected' : '' }}>Regular User
                                    </option>
                                    <option value="admin" {{ $user->role == 'admin' ? 'selected' : '' }}>Administrator
                                    </option>
                                </select>
                            </div>
                            <div class="mb-4">
                                <label for="department_id" class="form-label">Department</label>
                                <select class="form-control" id="department_id" name="department_id" required>
                                    @foreach ($departments as $department)
                                        <option value="{{ $department->id }}"
                                            {{ $user->department_id == $department->id ? 'selected' : '' }}>
                                            {{ $department->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="mb-4">
                                <label for="password" class="form-label">New Password (leave blank to keep current)</label>
                                <input type="password" class="form-control" id="password" name="password">
                            </div>
                            <div class="mb-4">
                                <label for="password_confirmation" class="form-label">Confirm New Password</label>
                                <input type="password" class="form-control" id="password_confirmation"
                                    name="password_confirmation">
                            </div>
                            <div class="d-grid">
                                <button type="submit" class="btn btn-primary btn-lg">Update User</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
