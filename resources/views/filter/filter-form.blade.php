@extends('layouts.app')
@section('title', 'Filter Report Issues')

@section('content')
    <div class="container">
        <h2 class="my-4">Filter Report Issues</h2>
        <form action="{{ route('filter.data') }}" method="POST" class="row g-3">
            @csrf
            <div class="col-md-6">
                <label for="category_id" class="form-label">Issue Category</label>
                <select name="category_id" id="category_id" class="form-select">
                    <option value="">All</option>
                    @foreach ($categories as $category)
                        <option value="{{ $category->id }}">{{ $category->name }}</option>
                    @endforeach
                </select>
            </div>

            <div class="col-md-6">
                <label for="department_id" class="form-label">Department</label>
                <select name="department_id" id="department_id" class="form-select">
                    <option value="">All</option>
                    @foreach ($departments as $department)
                        <option value="{{ $department->id }}">{{ $department->name }}</option>
                    @endforeach
                </select>
            </div>

            <div class="col-md-6">
                <label for="hotel" class="form-label">Hotel</label>
                <select name="hotel" id="hotel" class="form-select">
                    <option value="All">All</option>
                    @foreach ($hotels as $hotel)
                        <option value="{{ $hotel }}">{{ $hotel }}</option>
                    @endforeach
                </select>
            </div>

            <div class="col-md-6">
                <label for="status" class="form-label">Status</label>
                <select name="status" id="status" class="form-select">
                    <option value="All">All</option>
                    <option value="0">In-progress</option>
                    <option value="1">Done</option>
                </select>
            </div>

            <div class="col-md-6">
                <label for="start_date" class="form-label">Start Date</label>
                <input type="date" name="start_date" id="start_date" class="form-control">
            </div>

            <div class="col-md-6">
                <label for="end_date" class="form-label">End Date</label>
                <input type="date" name="end_date" id="end_date" class="form-control">
            </div>

            <div class="col-12">
                <button type="submit" class="btn btn-primary">Filter</button>
            </div>
        </form>
    </div>
@endsection
