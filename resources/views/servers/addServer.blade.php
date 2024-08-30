@extends('layout')
@section('title', 'Add Server Room Check')

@section('content')
    <form action="/insertServer" method="POST">
        @csrf

        <div class="mb-3">
            <label for="hotel" class="form-label"><b>Hotel</b></label>
            <select class="form-select" id="hotel" name="hotel">
                <option value="tlcmn">TLCMN</option>
                <option value="ehcm">EHCM</option>
                <option value="uncm">UNCM</option>
            </select>
        </div>

        <div class="mb-3">
            <label for="server_temp" class="form-label">Server Temperature</label>
            <input type="number" class="form-control" id="server_temp" name="server_temp">
        </div>
        @error('server_temp')
            <div class="my-error">
                <span class="text-danger">{{ $message }}</span>
            </div>
        @enderror

        <div class="mb-3">
            <label for="ups_temp" class="form-label">UPS Temperature</label>
            <input type="number" step="0.1" class="form-control" id="ups_temp" name="ups_temp"></input>
        </div>
        @error('ups_temp')
            <div class="my-error">
                <span class="text-danger">{{ $message }}</span>
            </div>
        @enderror
        <div class="mb-3">
            <label for="ups_battery" class="form-label">USP Battery Percentage</label>
            <input type="number" step="0.1" class="form-control" id="ups_battery" name="ups_battery">
        </div>
        @error('ups_battery')
            <div class="my-error">
                <span class="text-danger">{{ $message }}</span>
            </div>
        @enderror

        <div class="mb-3">
            <label for="ups_time" class="form-label">UPS Period Of Service Available</label>
            <input type="number" step="0.01" class="form-control" id="ups_time" name="ups_time"></input>
        </div>
        @error('ups_time')
            <div class="my-error">
                <span class="text-danger">{{ $message }}</span>
            </div>
        @enderror

        <button type="submit" class="btn btn-primary">Submit</button>
        <a href="/daily/hotels/{{ $type }}" class="btn btn-secondary">Cancel</a>
    </form>
@endsection
