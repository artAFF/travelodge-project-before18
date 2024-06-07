@extends('layout')
@section('title', 'Add Report')

@section('content')
    <form action="/insertIssue" method="POST" id="issueForm">
        @csrf

        <div class="mb-3">
            <label for="issue" class="form-label">Issue Category</label>
            <select class="form-select" id="issue" name="issue">
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
            <textarea class="form-control" id="detail" name="detail" rows="3"></textarea>
        </div>
        @error('detail')
            <div class="my-error">
                <span class="text-danger">{{ $message }}</span>
            </div>
        @enderror

        <div class="mb-3">
            <label for="department" class="form-label">Department</label>
            <select class="form-select" id="department" name="department">
                @foreach ($departments as $department)
                    <option value="{{ $department->name }}">{{ $department->name }}</option>
                @endforeach
            </select>
        </div>
        @error('department')
        <div class="my-error">
            <span class="text-danger">{{ $message }}</span>
        </div>
        @enderror

        <div class="mb-3">
            <label for="issue" class="form-label">Hotel</label>
            <select class="form-select" id="hotel" name="hotel">
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
                @foreach ($buildings as $building)
                    <option value="{{ $building->name }}">{{ $building->name }}</option>
                @endforeach
            </select>
        </div>

        <div class="mb-3">
            <label for="status" class="form-label">Status</label>
            <select class="form-select" id="status" name="status">
                <option value="0">In-progress</option>
                <option value="1">Done</option>
            </select>
        </div>
        {{-- <input type="hidden" name="created_at" value="<?= now() ?>"> --}}
        <button type="submit" class="btn btn-primary">Submit</button>
        <a href="/reports/reportIssue" class="btn btn-secondary">Cancel</a>
    </form>

    <script>

        document.getElementById('issueForm').addEventListener('submit', function(event) {
            event.preventDefault();
            swal("Success!", "Form submission successful", "success")
                .then((value) => {
                    document.getElementById('issueForm').submit();
                });
        });
    </script>

@endsection





