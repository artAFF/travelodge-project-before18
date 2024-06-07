@extends('layout')
@section('title', 'Add Switch Room Check')

@section('content')
    <form action="/insertSwitch" method="POST">
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
            <label for="ups_battery" class="form-label">UPS Battery Percentage</label>
            <input type="number" step="0.01" class="form-control" id="ups_battery" name="ups_battery">
        </div>
        @error('ups_battery')
            <div class="my-error">
                <span class="text-danger">{{ $message }}</span>
            </div>
        @enderror

        <div class="mb-3">
            <label for="ups_time" class="form-label">UPS Period Of Service Available</label>
            <input type="number" step="0.01" class="form-control" id="ups_time" name="ups_time">
        </div>
        @error('ups_time')
            <div class="my-error">
                <span class="text-danger">{{ $message }}</span>
            </div>
        @enderror

        <div class="mb-3">
            <label for="ups_temp" class="form-label">Switch Temperature</label>
            <input type="number" step="0.01" class="form-control" id="ups_temp" name="ups_temp">
        </div>
        @error('ups_time')
            <div class="my-error">
                <span class="text-danger">{{ $message }}</span>
            </div>
        @enderror

        <button type="submit" class="btn btn-primary">Submit</button>
        <a href="/reportSwitch" class="btn btn-secondary">Cancel</a>

    </form>

@endsection
