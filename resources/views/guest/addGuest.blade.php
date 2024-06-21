@extends('layout')
@section('title', 'Add Guest Room Check')

@section('content')
    <form action="/insertGuest" method="POST">
        @csrf

        <div class="mb-3">
            <label for="hotel" class="form-label"><b>Hotel</b></label>
            <select class="form-select" id="hotel" name="hotel">
                <option value="tlcmn">TLCMN</option>
                <option value="ehcm">EHCM</option>
                <option value="uncm">UNCM</option>
            </select>
        </div>

        <div class="mb-3" id="form1">
            <label for="location1" class="form-label">Location</label>
            <select class="form-select" id="location1" name="location1">
                @foreach ($buildings as $building)
                    <option value="{{ $building->name }}">{{ $building->name }}</option>
                @endforeach
            </select>
        </div>

        <div class="mb-3 hidden" id="form2">
            <label for="location2" class="form-label">Location</label>
            <select class="form-select" id="location2" name="location2">
                <option value="Floor 1">Floor 1</option>
                <option value="Floor 2">Floor 2</option>
                <option value="Floor 3">Floor 3</option>
                <option value="Floor 4">Floor 4</option>
                <option value="Floor 5">Floor 5</option>
                <option value="Floor 6">Floor 6</option>
                <option value="Floor 7">Floor 7</option>
                <option value="Floor 8">Floor 8</option>
                <option value="Floor 9">Floor 9</option>
            </select>
        </div>

        <div class="form-check mb-3">
            <input class="form-check-input" type="checkbox" value="" id="othersCheckbox">
            <label class="form-check-label" for="othersCheckbox">
                Others ( Only EHCM and UNCM )
            </label>
        </div>

        <div class="mb-3">
            <label for="room_no" class="form-label">Room Number</label>
            <input type="number" class="form-control" id="room_no" name="room_no">
        </div>
        @error('room_no')
            <div class="my-error">
                <span class="text-danger">{{ $message }}</span>
            </div>
        @enderror

        <div class="mb-3">
            <label for="download" class="form-label">Download</label>
            <input type="number" step="0.01" class="form-control" id="download" name="download"></input>
        </div>
        @error('download')
            <div class="my-error">
                <span class="text-danger">{{ $message }}</span>
            </div>
        @enderror

        <div class="mb-3">
            <label for="upload" class="form-label">Upload</label>
            <input type="number" step="0.01" class="form-control" id="upload" name="upload">
        </div>
        @error('upload')
            <div class="my-error">
                <span class="text-danger">{{ $message }}</span>
            </div>
        @enderror

        <br>
        <hr><br>

        <h2>TV Channel</h2>
        <br>

        <div class="mb-3">
            <label for="ch_no" class="form-label">Channel Number</label>
            <input type="number" step="0.01" class="form-control" id="ch_no" name="ch_no">
        </div>
        @error('ch_no')
            <div class="my-error">
                <span class="text-danger">{{ $message }}</span>
            </div>
        @enderror

        <div class="mb-3">
            <label for="ch_name" class="form-label">Channel Name</label>
            <input type="text" class="form-control" id="ch_name" name="ch_name"></input>
        </div>
        @error('ch_name')
            <div class="my-error">
                <span class="text-danger">{{ $message }}</span>
            </div>
        @enderror

        <br>
        <button type="submit" class="btn btn-primary">Submit</button>
        <a href="/tlcmn" class="btn btn-secondary">Cancel</a>
    </form>

    <script>
        document.getElementById('othersCheckbox').addEventListener('change', function() {
            var form1 = document.getElementById('form1');
            var form2 = document.getElementById('form2');

            if (this.checked) {
                form1.classList.add('hidden');
                form2.classList.remove('hidden');
            } else {
                form1.classList.remove('hidden');
                form2.classList.add('hidden');
            }
        });
    </script>

    <style>
        .hidden {
            display: none;
        }
    </style>
@endsection
