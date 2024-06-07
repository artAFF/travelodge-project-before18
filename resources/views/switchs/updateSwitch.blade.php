@extends('layout')
@section('title', 'Update Switch Room Check')

@section('content')
    <form action="{{ route('updatePSwitch', $ReportSwitchs->id) }}" method="POST">
        @csrf

        <div class="mb-3">
            <label for="location" class="form-label">Location</label>
            <select class="form-select" id="location" name="location">
                <option disabled>{{ $ReportSwitchs->location }}</option>

                @foreach ($buildings as $building)
                    <option value="{{ $building->name }}">{{ $building->name }}</option>
                @endforeach

            </select>
        </div>

        <div class="mb-3">
            <label for="ups_battery" class="form-label">USP Battery Percentage</label>
            <input type="number" step="0.1" class="form-control" id="ups_battery" name="ups_battery"
                value="{{ $ReportSwitchs->ups_temp }}">
        </div>
        @error('ups_battery')
            <div class="my-error">
                <span class="text-danger">{{ $message }}</span>
            </div>
        @enderror

        <div class="mb-3">
            <label for="ups_time" class="form-label">UPS Period Of Service Available</label>
            <input type="number" step="0.1" class="form-control" id="ups_time" name="ups_time"
                value="{{ $ReportSwitchs->ups_time }}">
        </div>
        @error('ups_time')
            <div class="my-error">
                <span class="text-danger">{{ $message }}</span>
            </div>
        @enderror

        <div class="mb-3">
            <label for="ups_temp" class="form-label">UPS Temperature</label>
            <input type="number" step="0.1" class="form-control" id="ups_temp" name="ups_temp"
                value="{{ $ReportSwitchs->ups_temp }}">
        </div>
        @error('ups_temp')
            <div class="my-error">
                <span class="text-danger">{{ $message }}</span>
            </div>
        @enderror

        <button type="submit" class="btn btn-primary">Submit</button>
        <a href="/reportSwitch" class="btn btn-secondary">Cancel</a>

    </form>

@endsection
