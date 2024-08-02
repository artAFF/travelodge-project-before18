@extends('layout')
@section('title', 'Update Switch Room Check')

@section('content')
    <div class="container">
        <form action="{{ route('updatePSwitch', ['type' => $type, 'id' => $ReportSwitchs->id]) }}" method="POST">
            @csrf

            @php
                $isOthers = in_array($ReportSwitchs->location, [
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
                        <option value="{{ $building->name }}"
                            {{ $ReportSwitchs->location == $building->name ? 'selected' : '' }}>
                            {{ $building->name }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="mb-3" id="form2" {!! !$isOthers ? 'style="display:none;"' : '' !!}>
                <label for="location2" class="form-label">Location</label>
                <select class="form-select" id="location2" name="location">
                    @foreach (['Floor 1', 'Floor 2', 'Floor 3', 'Floor 4', 'Floor 5', 'Floor 6', 'Floor 7', 'Floor 8', 'Floor 9'] as $floor)
                        <option value="{{ $floor }}" {{ $ReportSwitchs->location == $floor ? 'selected' : '' }}>
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
                <label for="ups_battery" class="form-label">USP Battery Percentage</label>
                <input type="number" step="0.1" class="form-control" id="ups_battery" name="ups_battery"
                    value="{{ $ReportSwitchs->ups_battery }}">
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
            <a href="/{{ $type }}" class="btn btn-secondary">Cancel</a>
        </form>
    </div>

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
