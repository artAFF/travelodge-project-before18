@extends('layout')
@section('title', 'Update Guest Room Check')

@section('content')
    <form action="{{ route('updatePguest', ['type' => $type, 'id' => $ReportGuests->id]) }}" method="POST">
        @csrf

        <h2>Internet Guest Speed</h2><br>
        @php
            $isOthers = in_array($ReportGuests->location, [
                'Floor 1',
                'Floor 2',
                'Floor 3',
                'Floor 4',
                'Floor 5',
                'Floor 6',
                'Floor 7',
                'Floor 8',
                'Floor 9',
            ]);
        @endphp

        <div class="mb-3" id="form1" {!! $isOthers ? 'style="display:none;"' : '' !!}>
            <label for="location" class="form-label">Location</label>
            <select class="form-select" id="location" name="location">
                @foreach ($buildings as $building)
                    <option value="{{ $building->name }}" {{ $ReportGuests->location == $building->name ? 'selected' : '' }}>
                        {{ $building->name }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="mb-3" id="form2" {!! !$isOthers ? 'style="display:none;"' : '' !!}>
            <label for="location2" class="form-label">Location</label>
            <select class="form-select" id="location2" name="location">
                @foreach (['Floor 1', 'Floor 2', 'Floor 3', 'Floor 4', 'Floor 5', 'Floor 6', 'Floor 7', 'Floor 8', 'Floor 9'] as $floor)
                    <option value="{{ $floor }}" {{ $ReportGuests->location == $floor ? 'selected' : '' }}>
                        {{ $floor }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="form-check mb-3">
            <input class="form-check-input" type="checkbox" value="" id="othersCheckbox"
                {{ $isOthers ? 'checked' : '' }}>
            <label class="form-check-label" for="othersCheckbox">
                Others ( Only EHCM and UNCM )
            </label>
        </div>

        <div class="mb-3">
            <label for="room_no" class="form-label">Room Number</label>
            <input type="number" class="form-control" id="room_no" name="room_no" value="{{ $ReportGuests->room_no }}">
        </div>
        @error('room_no')
            <div class="my-error">
                <span class="text-danger">{{ $message }}</span>
            </div>
        @enderror

        <div class="mb-3">
            <label for="download" class="form-label">Download</label>
            <input type="number" step="0.1" class="form-control" id="download" name="download"
                value="{{ $ReportGuests->download }}">
        </div>
        @error('download')
            <div class="my-error">
                <span class="text-danger">{{ $message }}</span>
            </div>
        @enderror

        <div class="mb-3">
            <label for="upload" class="form-label">Upload</label>
            <input type="number" step="0.1" class="form-control" id="upload" name="upload"
                value="{{ $ReportGuests->upload }}">
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
            <input type="number" step="0.1" class="form-control" id="ch_no" name="ch_no"
                value="{{ $ReportGuests->ch_no }}">
        </div>
        @error('ch_no')
            <div class="my-error">
                <span class="text-danger">{{ $message }}</span>
            </div>
        @enderror

        <div class="mb-3">
            <label for="ch_name" class="form-label">Channel Name</label>
            <input type="text" class="form-control" id="ch_name" name="ch_name" value="{{ $ReportGuests->ch_name }}">
        </div>
        @error('ch_name')
            <div class="my-error">
                <span class="text-danger">{{ $message }}</span>
            </div>
        @enderror

        <br>
        <button type="submit" class="btn btn-primary">Submit</button>
        <a href="/daily/hotels/{{ $type }}" class="btn btn-secondary">Cancel</a>
    </form>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            var othersCheckbox = document.getElementById('othersCheckbox');
            var form1 = document.getElementById('form1');
            var form2 = document.getElementById('form2');
            var locationSelect1 = document.getElementById('location');
            var locationSelect2 = document.getElementById('location2');

            function toggleForms() {
                if (othersCheckbox.checked) {
                    form1.style.display = 'none';
                    form2.style.display = 'block';
                    locationSelect1.name = '';
                    locationSelect2.name = 'location';
                } else {
                    form1.style.display = 'block';
                    form2.style.display = 'none';
                    locationSelect1.name = 'location';
                    locationSelect2.name = '';
                }
            }

            othersCheckbox.addEventListener('change', toggleForms);

            toggleForms();
        });
    </script>

    <style>
        .hidden {
            display: none;
        }
    </style>
@endsection
