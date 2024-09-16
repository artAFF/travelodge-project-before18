@extends('layouts.app')

@section('title', 'Unauthorized')

@section('content')
    <div class="d-flex justify-content-center align-items-center" style="height: 100vh;">
        <div class="text-center">
            <h1 class="display-1">403</h1>
            <p class="lead">
                Unauthorized action.<br>
                Please contact the administrator if you believe this is an error.
            </p>
        </div>
    </div>
@endsection
