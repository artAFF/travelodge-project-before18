@extends('layout')
@section('title', 'Update Issue')

@section('content')
    <form action="{{ route('updatePreport', $ReportIssues->id) }}" method="POST">
        @csrf
        <input type="hidden" name="previous_url" value="{{ url()->previous() }}">
        <div class="mb-3">
            <label for="issue" class="form-label">Issue Category</label>
            <select class="form-select" id="issue" name="issue">
                <option value="{{ $ReportIssues->issue }}" selected>{{ $ReportIssues->issue }}</option>
                @foreach ($categories as $category)
                    @if ($category->name !== $ReportIssues->issue)
                        <option value="{{ $category->name }}">{{ $category->name }}</option>
                    @endif
                @endforeach
            </select>
        </div>
        @error('issue')
            <div class="my-error">
                <span class="text-danger">{{ $message }}</span>
            </div>
        @enderror

        <div class="mb-3">
            <label for="detail" class="form-label">Detail</label>
            <textarea class="form-control" id="detail" name="detail" rows="3">{{ $ReportIssues->detail }}</textarea>
        </div>
        @error('detail')
            <div class="my-error">
                <span class="text-danger">{{ $message }}</span>
            </div>
        @enderror

        <div class="mb-3">
            <label for="department" class="form-label">Department</label>
            <select class="form-select" id="department" name="department">
                <option value="{{ $ReportIssues->department }}" selected>{{ $ReportIssues->department }}</option>
                @foreach ($departments as $department)
                    @if ($department->name !== $ReportIssues->department)
                        <option value="{{ $department->name }}">{{ $department->name }}</option>
                    @endif
                @endforeach
            </select>
        </div>

        <div class="mb-3">
            <label for="issue" class="form-label">Hotel</label>
            <select class="form-select" id="hotel" name="hotel">
                <option value="{{ $ReportIssues->hotel }}" selected>{{ $ReportIssues->hotel }}</option>
                <option value="TLCMN" @if ($ReportIssues->hotel == 'TLCMN') selected @endif>TLCMN</option>
                <option value="EHCM" @if ($ReportIssues->hotel == 'EHCM') selected @endif>EHCM</option>
                <option value="UNMC" @if ($ReportIssues->hotel == 'UNMC') selected @endif>UNMC</option>
            </select>
        </div>
        @error('hotel')
            <div class="my-error">
                <span class="text-danger">{{ $message }}</span>
            </div>
        @enderror

        <div class="mb-3">
            <label for="location" class="form-label">Location</label>
            <select class="form-select" id="location" name="location">
                <option value="{{ $ReportIssues->location }}" selected>{{ $ReportIssues->location }}</option>
                @foreach ($buildings as $building)
                    @if ($building->name !== $ReportIssues->location)
                        <option value="{{ $building->name }}">{{ $building->name }}</option>
                    @endif
                @endforeach
            </select>
        </div>

        <div class="mb-3">
            <label for="status" class="form-label">Status</label>
            <select class="form-select" id="status" name="status">
                <option value="0" @if ($ReportIssues->status === 0) selected @endif>In-process</option>
                <option value="1" @if ($ReportIssues->status === 1) selected @endif>Done</option>
            </select>
        </div>

        <button type="submit" class="btn btn-primary">Submit</button>
        <a href="/reports/reportIssue" class="btn btn-secondary">Cancel</a>
    </form>
@endsection
