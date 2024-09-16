@extends('layouts.app')
@section('title', 'Add Switch Room Check')

@section('content')
    <form action="/insertSwitch" method="POST">
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
                <option value="1">Floor 1</option>
                <option value="2">Floor 2</option>
                <option value="3">Floor 3</option>
                <option value="4">Floor 4</option>
                <option value="5">Floor 5</option>
                <option value="6">Floor 6</option>
                <option value="7">Floor 7</option>
                <option value="8">Floor 8</option>
                <option value="9">Floor 9</option>
            </select>
        </div>

        <div class="form-check mb-3">
            <input class="form-check-input" type="checkbox" value="" id="othersCheckbox">
            <label class="form-check-label" for="othersCheckbox">
                Others ( Only EHCM and UNCM )
            </label>
        </div>

        <input type="hidden" id="location" name="location" value="">

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
        @error('ups_temp')
            <div class="my-error">
                <span class="text-danger">{{ $message }}</span>
            </div>
        @enderror

        <button type="submit" class="btn btn-primary">Submit</button>
        <a href="/daily/hotels/{{ $type }}" class="btn btn-secondary">Cancel</a>

    </form>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            var form = document.querySelector('form');
            var form1 = document.getElementById('form1');
            var form2 = document.getElementById('form2');
            var location1 = document.getElementById('location1');
            var location2 = document.getElementById('location2');
            var locationHidden = document.createElement('input');
            locationHidden.type = 'hidden';
            locationHidden.name = 'location';
            form.appendChild(locationHidden);

            var othersCheckbox = document.getElementById('othersCheckbox');

            othersCheckbox.addEventListener('change', function() {
                if (this.checked) {
                    form1.classList.add('hidden');
                    form2.classList.remove('hidden');
                } else {
                    form1.classList.remove('hidden');
                    form2.classList.add('hidden');
                }
            });

            form.addEventListener('submit', function(e) {
                if (othersCheckbox.checked) {
                    locationHidden.value = location2.value;
                } else {
                    locationHidden.value = location1.value;
                }
            });
        });
    </script>

    <style>
        .hidden {
            display: none;
        }
    </style>
@endsection
