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
    <style>
        .nav-link {
            color: #fff;
            display: flex;
            align-items: center;
        }

        .nav-link:hover {
            background-color: #495057;
        }

        .nav-link.active {
            background-color: #0d6efd;
        }

        .nav-link i.bi-chevron-right,
        .nav-link i.bi-chevron-down {
            margin-left: auto;
        }

        .sidebar-submenu {
            padding-left: 1rem;
        }

        .sidebar-submenu .nav-link {
            padding-left: 1rem;
            font-size: 0.9rem;
        }

        .main-menu-item {
            margin-bottom: 10px;

        }
    </style>
</head>

<body>
    <div class="container-fluid">
        <div class="row flex-nowrap">
            <!-- Sidebar -->
            <div class="col-auto col-md-3 col-xl-2 px-sm-2 px-0 bg-dark">
                <div class="d-flex flex-column align-items-center align-items-sm-start px-3 pt-2 text-white min-vh-100">
                    <a href="/"
                        class="d-flex align-items-center pb-3 mb-md-0 me-md-auto text-white text-decoration-none">
                        <span class="fs-5 d-none d-sm-inline">IT Support Dashboard</span>
                    </a>
                    <ul class="nav nav-pills flex-column mb-sm-auto mb-0 align-items-center align-items-sm-start"
                        id="menu">
                        <li class="nav-item main-menu-item">
                            <a href="{{ route('main') }}" class="nav-link align-middle px-0">
                                <i class="bi bi-house"></i> <span class="ms-1 d-none d-sm-inline">Home</span>
                            </a>
                        </li>
                        <li class="nav-item main-menu-item">
                            <a href="#submenu1" data-bs-toggle="collapse" class="nav-link px-0 align-middle">
                                <i class="bi bi-graph-up"></i>
                                <span class="ms-1 d-none d-sm-inline">Dashboard</span>
                                <i class="bi bi-chevron-right ms-auto px-2"></i>
                            </a>
                            <ul class="collapse nav flex-column ms-1" id="submenu1" data-bs-parent="#menu">
                                <li class="w-100">
                                    <a href="{{ route('dashboardStatus') }}" class="nav-link px-0">
                                        <span class="d-none d-sm-inline px-3">Status
                                            Report</span>
                                    </a>
                                </li>
                                <li>
                                    <a href="{{ route('week.chart') }}" class="nav-link px-0">
                                        <span class="d-none d-sm-inline px-3">Issue By Weeks</span>
                                    </a>
                                </li>
                                <li>
                                    <a href="{{ route('month.chart') }}" class="nav-link px-0">
                                        <span class="d-none d-sm-inline px-3">Issue By Months</span>
                                    </a>
                                </li>
                                <li>
                                    <a href="{{ route('department.chart') }}" class="nav-link px-0">
                                        <span class="d-none d-sm-inline px-3">Issue By Departments</span>
                                    </a>
                                </li>
                                <li>
                                    <a href="{{ route('category.chart') }}" class="nav-link px-0">
                                        <span class="d-none d-sm-inline px-3">Issue By Categories</span>
                                    </a>
                                </li>
                                <li>
                                    <a href="{{ route('hotel.chart') }}" class="nav-link px-0">
                                        <span class="d-none d-sm-inline px-3">Issue By Hotels</span>
                                    </a>
                                </li>
                            </ul>
                        </li>
                        <li class="nav-item main-menu-item">
                            <a href="{{ route('reportIssue') }}" class="nav-link px-0 align-middle">
                                <i class="bi bi-clipboard"></i> <span class="ms-1 d-none d-sm-inline">Report
                                    Issue</span>
                            </a>
                        </li>
                        <li class="nav-item main-menu-item">
                            <a href="{{ route('filter.form') }}" class="nav-link px-0 align-middle">
                                <i class="bi bi-funnel"></i> <span class="ms-1 d-none d-sm-inline">Filter Report
                                    PDF</span>
                            </a>
                        </li>
                        <li class="main-menu-item">
                            <a href="#submenu2" data-bs-toggle="collapse" class="nav-link px-0 align-middle">
                                <i class="bi bi-calendar-check"></i>
                                <span class="ms-1 d-none d-sm-inline">Daily Checklist</span>
                                <i class="bi bi-chevron-right ms-auto px-2"></i>
                            </a>
                            <ul class="collapse nav flex-column ms-1" id="submenu2" data-bs-parent="#menu">
                                <li class="w-100">
                                    <a href="/tlcmn" class="nav-link px-0">
                                        <span class="d-none d-sm-inline px-3">TLCMN</span>
                                    </a>
                                </li>
                                <li>
                                    <a href="/ehcm" class="nav-link px-0">
                                        <span class="d-none d-sm-inline px-3">EHCM</span>
                                    </a>
                                </li>
                                <li>
                                    <a href="/uncm" class="nav-link px-0">
                                        <span class="d-none d-sm-inline px-3">UNCM</span>
                                    </a>
                                </li>
                            </ul>
                        </li>
                    </ul>
                </div>
            </div>
            <!-- Main Content -->
            <div class="col py-3">
                @yield('content')
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const dropdownToggles = document.querySelectorAll('[data-bs-toggle="collapse"]');

            dropdownToggles.forEach(toggle => {
                const collapseId = toggle.getAttribute('href');
                const collapse = document.querySelector(collapseId);

                collapse.addEventListener('show.bs.collapse', function() {
                    const icon = toggle.querySelector('.bi-chevron-right');
                    if (icon) {
                        icon.classList.replace('bi-chevron-right', 'bi-chevron-down');
                    }

                    dropdownToggles.forEach(otherToggle => {
                        if (otherToggle !== toggle) {
                            const targetId = otherToggle.getAttribute('href');
                            const targetCollapse = document.querySelector(targetId);
                            const bsCollapse = bootstrap.Collapse.getInstance(
                                targetCollapse);
                            if (bsCollapse && bsCollapse._isShown()) {
                                bsCollapse.hide();
                            }
                        }
                    });
                });

                collapse.addEventListener('hide.bs.collapse', function() {
                    const icon = toggle.querySelector('.bi-chevron-down');
                    if (icon) {
                        icon.classList.replace('bi-chevron-down', 'bi-chevron-right');
                    }
                });
            });
        });
    </script>
</body>

</html>
{{-- <!DOCTYPE html>
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
                            <li><a class="dropdown-item" href="/tlcmn"><i
                                        class="bi bi-1-circle-fill px-2"></i>TLCMN</a>
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

</html> --}}
