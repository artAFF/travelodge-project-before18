@extends('layouts.app')
@section('title', 'Daily Report UNCM')

@section('content')
    <div id="report-content">
        @include('partials.report_guests')
        @include('partials.report_switchs')
        @include('partials.report_servers')
        @include('partials.report_netspeeds')
    </div>

    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script>
        function loadPage(url) {
            $.ajax({
                url: url,
                type: 'GET',
                dataType: 'json',
                success: function(data) {
                    $('#report-content').empty();
                    $('#report-content').html(
                        data.ReportGuests +
                        data.ReportSwitchs +
                        data.ReportServers +
                        data.ReportNetSpeeds
                    );
                }
            });
        }

        $(document).on('click', '.pagination a', function(event) {
            event.preventDefault();
            let url = $(this).attr('href');
            if (url.indexOf('type=') === -1) {

                url += (url.indexOf('?') === -1 ? '?' : '&') + 'type={{ $source }}';
            }
            loadPage(url);
        });
    </script>
@endsection
