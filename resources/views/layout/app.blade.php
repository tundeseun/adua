<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
        <meta name="description" content="" />
        <meta name="author" content="" />
        <title>@yield('title', 'Dashboard') - ADUA</title>
        <link href="https://cdn.jsdelivr.net/npm/simple-datatables@7.1.2/dist/style.min.css" rel="stylesheet" />
        <link href="{{ asset('css/styles.css') }}" rel="stylesheet" />
        <script src="https://use.fontawesome.com/releases/v6.3.0/js/all.js" crossorigin="anonymous"></script>
        <style>
            /* Gradient background for the navbar */
            .navbar {
                background: linear-gradient(to right, #4e54c8, #8f94fb);
            }

            /* Styling for the ADUA logo */
            .navbar-brand {
                font-family: 'Arial Black', sans-serif;
                font-size: 1.5rem;
                color: #fff;
                letter-spacing: 0.1rem;
            }

            /* Custom gradient for the sidebar */
            .sb-sidenav {
                background: navy;
                z-index: 1000; /* Ensure sidebar doesn't overlap the footer */
            }

            /* Sidebar menu item text color */
            .sb-sidenav .nav-link, .sb-sidenav .sb-sidenav-footer {
                color: white;
            }

            .sb-sidenav .nav-link:hover {
                color: #0000;
            }

            /* Footer background styling */
            footer.bg-dark {
                background-color: linear-gradient(to right, #4e54c8, #8f94fb) !important;
                color: white !important;
                margin-top: auto;
                width: 100%;
                position: relative; /* Use relative to prevent overlapping */
                bottom: 0;
            }

            footer a {
                color: #ffdd57;
            }

            /* Ensure the content area pushes the footer to the bottom */
            #layoutSidenav_content {
                display: flex;
                flex-direction: column;
                min-height: 100vh; /* Ensures footer sticks to bottom */
            }

            /* The main content area should grow to take available space */
            main {
                flex: 1;
            }
        </style>
    </head>
    <body class="sb-nav-fixed">
        <nav class="sb-topnav navbar navbar-expand">
            <!-- Navbar Brand-->
            <a class="navbar-brand ps-3" href="{{ route('admin.dashboard') }}">ADUA</a>
            <!-- Sidebar Toggle-->
            <button class="btn btn-link btn-sm order-1 order-lg-0 me-4 me-lg-0" id="sidebarToggle"><i class="fas fa-bars"></i></button>
            <!-- Navbar Search-->
            <form class="d-none d-md-inline-block form-inline ms-auto me-0 me-md-3 my-2 my-md-0">
                <!-- Optional search form -->
            </form>
            <!-- Navbar-->
            <ul class="navbar-nav ms-auto ms-md-0 me-3 me-lg-4">
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" id="navbarDropdown" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false"><i class="fas fa-user fa-fw"></i></a>
                    <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                        <li><a class="dropdown-item" href="#!">Settings</a></li>
                        <li><hr class="dropdown-divider" /></li>
                        <li><a class="dropdown-item" href="{{ route('admin.login') }}">Logout</a></li>
                    </ul>
                </li>
            </ul>
        </nav>
        <div id="layoutSidenav">
            <div id="layoutSidenav_nav">
                <nav class="sb-sidenav accordion sb-sidenav-dark" id="sidenavAccordion">
                    <!-- Sidebar Menu -->
                    @include('partials.menu')
                </nav>
            </div>
            <div id="layoutSidenav_content">
                <main>
                    @yield('content')
                </main>
                <footer class="py-4 bg-dark mt-auto">
                    <div class="container-fluid px-4">
                        <div class="d-flex align-items-center justify-content-between small">
                            <div class="text-muted">Copyright &copy; ADUA 2024</div>
                            <div>
                                <a href="#">Privacy Policy</a>
                                &middot;
                                <a href="#">Terms & Conditions</a>
                            </div>
                        </div>
                    </div>
                </footer>
            </div>
        </div>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
        <script src="{{ asset('js/scripts.js') }}"></script>
    </body>
</html>
