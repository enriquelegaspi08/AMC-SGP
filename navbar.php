<nav class="navbar navbar-expand-lg sticky-top">
        <div class="container-fluid">
            <a class="navbar-brand" href="#"><img src="LOGO/CSC LOGO.png" alt="CSC Logo" width="40"></a>
            <a id="navBrand" class="navbar-brand" href="index.php">AMC Student Government Portal</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item"><a class="nav-link active" href="index.php">Home</a></li>
                    <li class="nav-item"><a class="nav-link" href="organization.php">Organization</a></li>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="servicesDropdown" role="button" data-bs-toggle="dropdown">Services</a>
                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item" href="Activities.html">Activities</a></li>
                            <li><a class="dropdown-item" href="#">Announcement</a></li>
                            <li class="dropdown-submenu dropend">
                                <a class="dropdown-item dropdown-toggle" href="#">Student Records</a>
                                <ul class="dropdown-menu">
                                    <li><a class="dropdown-item" href="#">Membership Fee</a></li>
                                    <li><a class="dropdown-item" href="#">Contributions</a></li>
                                    <li><a class="dropdown-item" href="#">Sanction</a></li>
                                </ul>
                            </li>
                        </ul>
                    </li>
                    <li class="nav-item"><a class="nav-link" href="Feedbacks.html">Feedback</a></li>
                    <li class="nav-item"><a class="nav-link" href="Register.html">Register</a></li>
                </ul>
            </div>
        </div>
</nav>

<style>
    /* Navigation Styles */
    nav {
        background-color: #152459 !important;
        padding: 10px 0;
    }

    .navbar-toggler-icon {
        background-image: url("logo/toggler-white.png");
    }
    
    .navbar .nav-link,
    .navbar .navbar-brand,
    .navbar .dropdown-item {
        color: #fddd5d !important;
        background-color: #152459 !important
    }

    .navbar .nav-link:hover{
        color: #ff8a01 !important;
        transform: scale(1.1);
    }

    /* Footer Styles */
    footer {
        background-color: #152459 !important;
        color: #fddd5d !important;
        margin-top: 10px;
        align-items: center;
    }
    
    footer .container {    
        display: flex;
    }
    
    .designer {
        font-weight: bold;
        color: #00ace6;
    }
</style>