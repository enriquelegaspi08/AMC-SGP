<nav class="navbar navbar-expand-lg sticky-top">
    <div class="container-fluid">
        <a class="navbar-brand" href="#"><img src="LOGO/CSC LOGO.png" alt="CSC Logo" width="40"></a>
        <a id="navBrand" class="navbar-brand" href="index.php">AMC Student Government Portal</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ms-auto">
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button" data-bs-toggle="dropdown">
                        <img src="images/user-logo1.png" alt="User" class="user-avatar">
                    </a>
                    <ul class="dropdown-menu">
                        <?php if (isset($_SESSION['username'])): ?>
                            <!-- Show Log-Out if the user is logged in -->
                            <li><span class="dropdown-item"> <?php echo htmlspecialchars($_SESSION['username']); ?> </span></li>
                            <li><a class="dropdown-item" href="logout.php">Log-Out</a></li>
                        <?php else: ?>
                            <!-- Show Log-In if the user is NOT logged in -->
                            <li class="nav-item dropdown d-flex align-items-center">
                                <a class="dropdown-item" href="login.php">Log-In</a>
                            </li>
                        <?php endif; ?>
                    </ul>
                </li>
                <li class="nav-item"><a class="nav-link active" href="index.php">Home</a></li>
                <li class="nav-item"><a class="nav-link" href="organization.php">Organization</a></li>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="servicesDropdown" role="button" data-bs-toggle="dropdown">Operations</a>
                    <ul class="dropdown-menu">
                        <li><a class="dropdown-item" href="activities.php">Activities</a></li>
                        <li><a class="dropdown-item" href="announcements.php">Announcements</a></li>
                    </ul>
                </li>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="servicesDropdown" role="button" data-bs-toggle="dropdown">Finance</a>
                    <ul class="dropdown-menu">
                        <li><a class="dropdown-item" href="collections.php">Fees and Collections</a></li>
                        <li><a class="dropdown-item" href="disbursements.php">Disbursements</a></li>
                    </ul>
                </li>
                <li class="nav-item"><a class="nav-link" href="feedback.php">Feedback</a></li>
                <!-- User Info Section -->                
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

    .navbar .nav-link:hover {
        color: #ff8a01 !important;
        transform: scale(1.1);
    }

    .navbar .dropdown-item:hover {
        color: #152459 !important;
        background-color: #ff8a01 !important;
    }

    .user-avatar {
        height: 35px;
        width: 35px;
        border-radius: 50%;
        border: 2px solid #ffffff;
    }

    /* Footer Styles */
    .footer, footer {
        background-color: #152459 !important;
        color: #fddd5d !important;
        transition: background 0.3s ease-in-out;
        text-align: center;
        padding: 10px 0;
        width: 100%;
        margin-top: auto;
    }

    footer .container {
        display: flex;
        justify-content: center;
        align-items: center;
    }

    .designer {
        font-weight: bold;
        color: #00ace6;
    }
</style>