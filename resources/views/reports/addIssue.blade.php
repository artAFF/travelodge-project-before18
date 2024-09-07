@extends('layout')
@section('title', 'Add Report')

@section('content')
    <form action="/insertIssue" method="POST" id="issueForm" enctype="multipart/form-data">
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
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" id="needRemarks_0" onchange="toggleRemarks(0)">
                        <label class="form-check-label" for="needRemarks_0">
                            Add Remarks
                        </label>
                    </div>
                </div>

                <div class="mb-3" id="remarksContainer_0" style="display: none;">
                    <label for="remarks" class="form-label">Remarks</label>
                    <textarea class="form-control" id="remarks_0" name="issues[0][remarks]" rows="2"></textarea>
                </div>

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

                <div class="mb-3">
                    <label for="file" class="form-label">Upload File (PDF or Image)</label>
                    <input type="file" class="form-control" id="file" name="issues[0][file]"
                        accept=".pdf,.jpg,.jpeg,.png">
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

        function toggleRemarks(index) {
            const checkbox = document.getElementById(`needRemarks_${index}`);
            const remarksContainer = document.getElementById(`remarksContainer_${index}`);
            remarksContainer.style.display = checkbox.checked ? 'block' : 'none';
        }

        document.getElementById('addIssueButton').addEventListener('click', function() {
            const issueFormsContainer = document.getElementById('issueFormsContainer');
            const newIssueForm = issueFormsContainer.firstElementChild.cloneNode(true);

            Array.from(newIssueForm.querySelectorAll('input, select, textarea')).forEach((input) => {
                const name = input.getAttribute('name');
                if (name) {
                    input.setAttribute('name', name.replace(/\[\d+\]/, `[${issueIndex}]`));
                }
                if (input.type !== 'file') {
                    input.value = '';
                } else {
                    input.value = null;
                }
            });

            const newCheckbox = newIssueForm.querySelector('.form-check-input');
            const newRemarksContainer = newIssueForm.querySelector('[id^=remarksContainer_]');
            const newRemarksTextarea = newIssueForm.querySelector('[id^=remarks_]');

            newCheckbox.id = `needRemarks_${issueIndex}`;
            newCheckbox.checked = false;
            newCheckbox.setAttribute('onchange', `toggleRemarks(${issueIndex})`);

            newRemarksContainer.id = `remarksContainer_${issueIndex}`;
            newRemarksContainer.style.display = 'none';

            newRemarksTextarea.id = `remarks_${issueIndex}`;
            newRemarksTextarea.name = `issues[${issueIndex}][remarks]`;
            newRemarksTextarea.value = '';

            issueFormsContainer.appendChild(newIssueForm);
            issueIndex++;
        });
    </script>
@endsection
