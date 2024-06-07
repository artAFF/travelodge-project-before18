@extends('layout')
@section('title', 'Add Issue')

@section('content')
    <form action="/insertNetSpeed" method="POST">
        @csrf

        <div class="mb-3">
            <label for="location" class="form-label">Location</label>
            <select class="form-select" id="location" name="location">
                @foreach ($buildings as $building)
                    <option value="{{ $building->name }}">{{ $building->name }}</option>
                @endforeach
            </select>
        </div>

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

        <button type="submit" class="btn btn-primary">Submit</button>
        <a href="/tlcmn" class="btn btn-secondary">Cancel</a>
    </form>
@endsection
