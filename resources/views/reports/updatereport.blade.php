@extends('layout')
@section('title', 'Update Issue')

@section('content')
    <form action="{{ route('updatePreport', $ReportIssues->id) }}" method="POST">
        @csrf
        <input type="hidden" name="previous_url" value="{{ url()->previous() }}"> {{-- for test go back --}}
        <div class="mb-3">
            <label for="issue" class="form-label">Issue Category</label>
            <select class="form-select" id="issue" name="issue">
                <option disabled>{{ $ReportIssues->issue }}</<option>
                @foreach ($categories as $category)
                <option value="{{ $category->name }}">{{ $category->name }}</option>
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
                <option disabled>{{ $ReportIssues->department }}</<option>

                    @foreach ($departments as $department)
                <option value="{{ $department->name }}">{{ $department->name }}</option>
                @endforeach

            </select>
        </div>

        <div class="mb-3">
            <label for="issue" class="form-label">Hotel</label>
            <select class="form-select" id="hotel" name="hotel">
                <option disabled>{{ $ReportIssues->hotel }}</<option>
                <option value="TLCMN">TLCMN</option>
                <option value="EHCM">EHCM</option>
                <option value="UNMC">UNMC</option>
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
                <option disabled>{{ $ReportIssues->location }}</option>

                @foreach ($buildings as $building)
                    <option value="{{ $building->name }}">{{ $building->name }}</option>
                @endforeach

            </select>
        </div>

        <div class="mb-3">
            <label for="status" class="form-label">Status</label>
            <select class="form-select" id="status" name="status">
                @if ($ReportIssues->status === 0)
                    <option value="0" selected>In-process</option>
                @else
                    <option value="0">In-process</option>
                @endif
                @if ($ReportIssues->status === 1)
                    <option value="1" selected>Done</option>
                @else
                    <option value="1">Done</option>
                @endif
            </select>
        </div>

        {{-- <input type="hidden" name="updated_at" value="<?= now() ?>"> --}}

        <button type="submit" class="btn btn-primary">Submit</button>
        <a href="/reports/reportIssue" class="btn btn-secondary">Cancel</a>

    </form>

@endsection
