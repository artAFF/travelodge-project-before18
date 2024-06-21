<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>@yield('title')</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
    <style>
        .navbar-nav .nav-link:hover {
            background-color: grey;
        }

        .dropdown-menu .dropdown-item:hover {
            background-color: grey;
        }
    </style>
</head>

<body>

    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container-fluid">
            <a class="navbar-brand px-2">IT Support Dashboard</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
                aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav px-5">
                    <li class="nav-item">
                        <a class="nav-link active" aria-current="page" href="{{ route('main') }}"><i
                                class="bi bi-house px-2"></i>Home</a>
                    </li>
                    <li class="nav-item dropdown">
                        <a class="nav-link active dropdown-toggle " href="#" id="checklistDropdown" role="button"
                            data-bs-toggle="dropdown" aria-expanded="false">
                            <i class="bi bi-graph-up px-2"></i>Dashboard
                        </a>
                        <ul class="dropdown-menu" aria-labelledby="checklistDropdown">
                            <li>
                                <a class="dropdown-item" href="{{ route('dashboardStatus') }}"><i
                                        class="bi bi-cone-striped px-1"></i>
                                    </i>Status Report</a>
                            </li>
                            <li>
                                <a class="dropdown-item" href="{{ route('dashboardWeek') }}"><i
                                        class="bi bi-calendar-day-fill px-1">
                                    </i>Issue By Weeks</a>
                            </li>
                            <li>
                                <a class="dropdown-item" href="{{ route('dashboardMonth') }}"><i
                                        class="bi bi-calendar-check-fill px-1"></i>
                                    </i>Issue By Months</a>
                            </li>
                            <li>
                                <a class="dropdown-item" href="{{ route('dashboardDepartment') }}"><i
                                        class="bi bi-people-fill px-1">
                                    </i>Issue By Departments</a>
                            </li>
                            <li>
                                <a class="dropdown-item" href="{{ route('dashboardCategory') }}"><i
                                        class="bi bi-tags-fill px-1"></i>Issue By Categorys</a>
                            </li>
                            <li>
                                <a class="dropdown-item" href="{{ route('dashboardHotel') }}"><i
                                        class="bi bi-buildings-fill px-1"></i>Issue By Hotels</a>
                            </li>
                        </ul>
                    </li>
                    <li class="nav-item dropdown">
                        <a class="nav-link active" aria-current="page" href="{{ route('reportIssue') }}"><i
                                class="bi bi-clipboard px-2"></i>Report Issue</a>
                    </li>
                    <li class="nav-item dropdown">
                        <a class="nav-link active" aria-current="page" href="{{ route('filter.form') }}"><i
                                class="bi bi-funnel px-2"></i>Filter PDF</a>
                    </li>
                    <li class="nav-item dropdown">
                        <a class="nav-link active dropdown-toggle " href="#" id="checklistDropdown" role="button"
                            data-bs-toggle="dropdown" aria-expanded="false">
                            <i class="bi bi-calendar-check px-2"></i>Daily Checklist
                        </a>
                        <ul class="dropdown-menu" aria-labelledby="checklistDropdown">
                            {{-- <li><a class="dropdown-item" href="{{ route('reportGuest') }}"><i
                                        class="bi bi-person-fill px-1">
                                    </i>Guest Room</a>
                            </li>
                            <li><a class="dropdown-item" href="{{ route('reportSwitch') }}"><i
                                        class="bi bi-hdd-rack-fill px-1">
                                    </i>Switch Room</a></li>
                            <li><a class="dropdown-item" href="{{ route('reportServer') }}"><i
                                        class="bi bi-server px-1">
                                    </i>Server Room</a>
                            </li>
                            <li><a class="dropdown-item" href="{{ route('reportNet') }}">
                                    <i class="bi bi-router-fill px-1"></i>Speed Check</a></li> --}}
                            <li><a class="dropdown-item" href="/tlcmn">
                                    <i class="bi bi-1-circle-fill px-2"></i>TLCMN
                                </a>
                            </li>
                            <li><a class="dropdown-item" href="/ehcm"><i class="bi bi-2-circle-fill px-2"></i>EHCM</a>
                            </li>
                            <li><a class="dropdown-item" href="/uncm"><i class="bi bi-3-circle-fill px-2"></i>UNCM</a>
                            </li>
                        </ul>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <div class="container py-5">
        @yield('content')
    </div>

</body>

</html>



{{-- <style>
    .sidebar {
        position: fixed;
        top: 0;
        bottom: 0;
        left: 0;
        z-index: 100;
        padding: 90px 0 0;
        box-shadow: inset -1px 0 0 rgba(0, 0, 0, .1);
        z-index: 99;
    }

    @media (max-width: 767.98px) {
        .sidebar {
            top: 11.5rem;
            padding: 0;
        }
    }

    .navbar {
        box-shadow: inset 0 -1px 0 rgba(0, 0, 0, .1);
    }

    @media (min-width: 767.98px) {
        .navbar {
            top: 0;
            position: sticky;
            z-index: 999;
        }
    }

    .sidebar .nav-link {
        color: #333;
    }
</style>

     <div class='container-fluid'>
        <div class="row">
            <nav id="sidebar" class="col-md-3 col-lg-2 d-md-block bg-light sidebar collpase">
                <div class="position-sticky">
                    <ul class="nav flex-column">
                        <li class="nav-item">
                            <a class="nav-link active" aria-current="page" href="{{ route('home1') }}">
                                <i class="bi bi-house"></i>
                                <span class="ml-2">Home</span>
                            </a>
                        </li>
                        <li class="nav-item active">
                            <a class="nav-link" aria-current="page" href="{{ route('dashboard') }}">
                                <i class="bi bi-clipboard-data"></i>
                                <span class="ml-2">Dashboard</span>
                            </a>
                        </li>
                        <li class="nav-item active">
                            <a class="nav-link" aria-current="page" href="{{ route('reportIssue') }}">
                                <i class="bi bi-clipboard2-fill"></i>
                                <span class="ml-2">Report</span>
                            </a>
                        </li>

                    </ul>
                </div>
            </nav>

        </div>
    </div> --}}
