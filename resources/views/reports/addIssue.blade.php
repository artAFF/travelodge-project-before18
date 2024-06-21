@extends('layout')
@section('title', 'Add Report')

@section('content')
    <form action="/insertIssue" method="POST" id="issueForm">
        @csrf
        <div id="issueFormsContainer">
            <div class="issue-form">
                <div class="mb-3">
                    <label for="issue" class="form-label">Issue Category</label>
                    <select class="form-select" id="issue" name="issues[0][issue]">
                        @foreach ($categories as $category)
                            <option value="{{ $category->name }}">{{ $category->name }}</option>
                        @endforeach
                    </select>
                </div>
                @error('issues.0.issue')
                    <div class="my-error">
                        <span class="text-danger">{{ $message }}</span>
                    </div>
                @enderror

                <div class="mb-3">
                    <label for="detail" class="form-label">Detail</label>
                    <textarea class="form-control" id="detail" name="issues[0][detail]" rows="3"></textarea>
                </div>
                @error('issues.0.detail')
                    <div class="my-error">
                        <span class="text-danger">{{ $message }}</span>
                    </div>
                @enderror

                <div class="mb-3">
                    <label for="department" class="form-label">Department</label>
                    <select class="form-select" id="department" name="issues[0][department]">
                        @foreach ($departments as $department)
                            <option value="{{ $department->name }}">{{ $department->name }}</option>
                        @endforeach
                    </select>
                </div>
                @error('issues.0.department')
                    <div class="my-error">
                        <span class="text-danger">{{ $message }}</span>
                    </div>
                @enderror

                <div class="mb-3">
                    <label for="hotel" class="form-label">Hotel</label>
                    <select class="form-select" id="hotel" name="issues[0][hotel]">
                        <option value="TLCMN">TLCMN</option>
                        <option value="EHCM">EHCM</option>
                        <option value="UNMC">UNMC</option>
                    </select>
                </div>
                @error('issues.0.hotel')
                    <div class="my-error">
                        <span class="text-danger">{{ $message }}</span>
                    </div>
                @enderror

                <div class="mb-3">
                    <label for="location" class="form-label">Location</label>
                    <select class="form-select" id="location" name="issues[0][location]">
                        @foreach ($buildings as $building)
                            <option value="{{ $building->name }}">{{ $building->name }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="mb-3">
                    <label for="status" class="form-label">Status</label>
                    <select class="form-select" id="status" name="issues[0][status]">
                        <option value="0">In-progress</option>
                        <option value="1">Done</option>
                    </select>
                </div>
                <br>
                <hr>
                <br>
            </div>
        </div>
        <button type="button" id="addIssueButton" class="btn btn-warning"><i class="bi bi-plus-circle"></i>
        </button>
        <button type="submit" class="btn btn-primary">Submit</button>
        <a href="/reports/reportIssue" class="btn btn-secondary">Cancel</a>
    </form>

    <script>
        let issueIndex = 1;

        document.getElementById('addIssueButton').addEventListener('click', function() {
            const issueFormsContainer = document.getElementById('issueFormsContainer');
            const newIssueForm = issueFormsContainer.firstElementChild.cloneNode(true);

            Array.from(newIssueForm.querySelectorAll('input, select, textarea')).forEach((input) => {
                const name = input.getAttribute('name');
                if (name) {
                    input.setAttribute('name', name.replace(/\[\d+\]/, `[${issueIndex}]`));
                }
                input.value = '';
            });

            issueFormsContainer.appendChild(newIssueForm);
            issueIndex++;
        });
    </script>
@endsection
