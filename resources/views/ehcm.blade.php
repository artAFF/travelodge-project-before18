@extends('layout')
@section('title', 'Daily Report EHCM')

@section('content')
    <div id="report-content">
        @include('partials.report_guests', ['type' => 'ehcm'])
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
                    $('#report-content').html(data.ReportGuests);
                    $('#report-content').append(data.ReportSwitchs);
                    $('#report-content').append(data.ReportServers);
                    $('#report-content').append(data.ReportNetSpeeds);
                }
            });
        }

        $(document).on('click', '.pagination a', function(event) {
            event.preventDefault();
            let url = $(this).attr('href');
            loadPage(url);
        });
    </script>
@endsection
