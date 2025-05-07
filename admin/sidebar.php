<div class="container-fluid page-body-wrapper">
    <!-- partial:partials/_sidebar.html -->
    <nav class="sidebar sidebar-offcanvas" id="sidebar">
        <ul class="nav ">
            <li class="nav-item {{ request()->is('subcategory') ? 'active' : '' }} ">
                <a class="nav-link" href="./index.php">
                    <i class="mdi mdi-home menu-icon"></i>
                    <span class="menu-title">Dashboard</span>
                </a>
            </li>
            <li class="nav-item">
                 <a class="nav-link" href="./services.php">
                    <i class="mdi mdi-chart-pie menu-icon"></i>
                    <span class="menu-title">Services</span>
                </a>
            </li>
            <li class="nav-item">
                 <a class="nav-link" href="./mobile.php">
                    <i class="mdi mdi-cellphone-arrow-down menu-icon"></i>
                    <span class="menu-title">Mobile Requests</span>
                </a>
            </li>
        </ul>
    </nav>
