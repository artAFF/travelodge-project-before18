@extends('layout')
@section('title', 'Add Guest Room Check')

@section('content')
    <form action="/insertGuest" method="POST">
        @csrf

        <h2>Internet Guest Speed</h2>
        <br>
        <div class="mb-3">
            <label for="location" class="form-label">Location</label>
            <select class="form-select" id="location" name="location">
                @foreach ($buildings as $building)
                    <option value="{{ $building->name }}">{{ $building->name }}</option>
                @endforeach
            </select>
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
            <label for="upload" class="form-label">Upload</label>
            <input type="number" step="0.01" class="form-control" id="upload" name="upload">
        </div>
        @error('upload')
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
@endsection
