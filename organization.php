<?php
session_start();
include 'config.php';

?>



<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>AMC STUDENT COUNCIL (CSC)</title>
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <style>
        .section-title {
            text-align: center;
            margin-top: 40px;
        }

        .section-title h1 {
            font-size: 50px;
            color: #023e8a; /* Darker blue for header */
        }

        .section-title h2 {
            font-size: 30px;
            color: #00aaff; /* Lighter blue for subheading */
            margin-bottom: 20px;
        }

        .section-title .line {
            width: 150px;
            height: 4px;
            background: #023e8a; /* Matching the color of the title */
            margin: auto;
            margin-bottom: 40px;
        }

        .main-card {
            display: flex;
            flex-wrap: wrap;
            justify-content: center;
            gap: 20px;
            margin-bottom: 20px;
        }

        .card {
            background: #023e8a;
            padding: 20px;
            border-radius: 15px;
            transition: all 0.3s ease-in-out;
            text-align: center;
            color: white;
            width: 320px;
            height: 250px;
        }

        .card:hover {
            transform: translateY(-5px);
        }

        .card img {
            height: 150px;
            width: 150px;
            margin-bottom: 15px;
            background: white;
            padding: 3px;
            border-radius: 50%;
            overflow: hidden;
            margin: 0 auto;
            object-fit: cover;
        }

        .card .details {
            padding: 5px;
            text-align: center;
        }

        .name {
            font-size: 1.1rem;
            font-weight: bold;
        }

        .job {
            font-size: 0.95rem;
            color: whitesmoke;
        }

        .officers .main-card {
            margin-bottom: 20px;
        }

        @media (min-width: 992px) {
            .officer-set {
                position: absolute;
                top: 0;
                left: 0;
                right: 0;
                opacity: 0;
                transform: translateX(100%);
                transition: all 0.6s ease;
                pointer-events: none;
            }

            .officers {
                position: relative;
                min-height: 300px;
                overflow: hidden;
            }

            input#one:checked~.officers .set-1,
            input#two:checked~.officers .set-2 {
                opacity: 1;
                transform: translateX(0%);
                pointer-events: all;
                z-index: 1;
            }

            input#one:checked~.officers .set-2 {
                transform: translateX(100%);
            }

            input#two:checked~.officers .set-1 {
                transform: translateX(-100%);
            }

            .button label {
                height: 15px;
                width: 15px;
                background: #00aaff;
                margin: 0 5px;
                border-radius: 50%;
                display: inline-block;
                cursor: pointer;
                transition: 0.3s;
            }

            input[type="radio"] {
                display: none;
            }

            input#one:checked~.button label.one,
            input#two:checked~.button label.two {
                width: 35px;
            }
        }

        @media (max-width: 991px) {
            .officer-set {
                opacity: 1 !important;
                transform: none !important;
                position: static;
                pointer-events: all;
                margin-bottom: 20px;
            }

            .button {
                display: none;
            }

            input[type="radio"] {
                display: none;
            }
        }
    </style>
</head>

<body>
    <?php include 'navbar.php'; ?>

    <div class="container my-5">
        <div class="section-title text-center">
            <h1>ORGANIZATIONAL CHART</h1>
            <h2>COLLEGE STUDENT COUNCIL</h2>
            <div class="line"></div>
        </div>

        <ul class="nav nav-tabs justify-content-center mb-4" id="officerTabs" role="tablist">
            <li class="nav-item" role="presentation">
                <button class="nav-link active" id="executive-tab" data-bs-toggle="tab" data-bs-target="#executive" type="button" role="tab">Executive</button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link" id="senate-tab" data-bs-toggle="tab" data-bs-target="#senate" type="button" role="tab">Senate</button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link" id="representatives-tab" data-bs-toggle="tab" data-bs-target="#representatives" type="button" role="tab">Representatives</button>
            </li>
        </ul>

        <!-- Admin-only Update Button -->
        <?php if (isset($_SESSION['account_type']) && $_SESSION['account_type'] === 'admin'): ?>
            <div class="mb-3 text-end">
                <a href="update_officers.php" class="btn btn-primary">
                    <i class="fa fa-edit"></i> Update Officers
                </a>
            </div>
        <?php endif; ?>

        <div class="tab-content">
            <div class="tab-pane fade show active" id="executive" role="tabpanel">

                <!-- Radio buttons for sliding -->
                <input type="radio" name="slider" id="one" checked>
                <input type="radio" name="slider" id="two">

                <!-- Card Slide Container -->
                <div class="officers">
                    <!-- Set 1 -->
                     <div class="main-card row justify-content-center officer-set set-1">
                        <?php
                        $sql = "SELECT * FROM officers WHERE category='executive-set-1' ORDER BY display_order ASC";
                        $result = $conn->query($sql);

                        while ($row = $result->fetch_assoc()) {
                            echo '<div class="card col-12 col-lg-3 mb-3">
                                    <img src="uploads/OFFICERS/' . $row['photo'] . '" alt="' . $row['name'] . '">
                                    <div class="details">
                                        <h3 class="name">' . $row['name'] . '</h3>
                                        <h3 class="job">' . $row['position'] . '</h3>
                                    </div>
                                </div>';
                        }
                        ?>
                    </div>

                    <!-- Set 2 -->
                    <div class="main-card row justify-content-center officer-set set-2">
                        <?php
                        $sql = "SELECT * FROM officers WHERE category='executive-set-2' ORDER BY display_order ASC";
                        $result = $conn->query($sql);

                        while ($row = $result->fetch_assoc()) {
                            echo '<div class="card col-12 col-lg-3 mb-3">
                                    <img src="uploads/OFFICERS/' . $row['photo'] . '" alt="' . $row['name'] . '">
                                    <div class="details">
                                        <h3 class="name">' . $row['name'] . '</h3>
                                        <h3 class="job">' . $row['position'] . '</h3>
                                    </div>
                                </div>';
                        }
                        ?>
                    </div>
                </div>

                <!-- Navigation dots -->
                <div class="button text-center mt-4">
                    <label for="one" class="one"></label>
                    <label for="two" class="two"></label>
                </div>

                <!-- Additional Officers -->
                <div class="main-card row justify-content-center mt-4">
                    <?php
                    $sql = "SELECT * FROM officers WHERE category='executive-additional' ORDER BY display_order ASC";
                    $result = $conn->query($sql);

                    while ($row = $result->fetch_assoc()) {
                        echo '<div class="card col-12 col-lg-3 mb-4">
                                <img src="uploads/OFFICERS/' . $row['photo'] . '" alt="' . $row['name'] . '">
                                <div class="details">
                                    <h3 class="name">' . $row['name'] . '</h3>
                                    <h3 class="job">' . $row['position'] . '</h3>
                                </div>
                            </div>';
                    }
                    ?>
                </div>
            </div>

            <!-- SENATE -->
            <div class="tab-pane fade" id="senate" role="tabpanel">
                <div class="main-card row justify-content-center mt-4">
                    <?php
                    $sql = "SELECT * FROM officers WHERE category='senate' ORDER BY display_order ASC";
                    $result = $conn->query($sql);

                    while ($row = $result->fetch_assoc()) {
                        echo '<div class="card col-12 col-lg-3 mb-4">
                                <img src="uploads/OFFICERS/' . $row['photo'] . '" alt="' . $row['name'] . '">
                                <div class="details">
                                    <h3 class="name">' . $row['name'] . '</h3>
                                    <h3 class="job">' . $row['position'] . '</h3>
                                </div>
                            </div>';
                    }
                    ?>
                </div>
            </div>

            <!-- REPRESENTATIVES -->
            <div class="tab-pane fade" id="representatives" role="tabpanel">
                <div class="main-card row justify-content-center mt-4">
                    <?php
                    $sql = "SELECT * FROM officers WHERE category='representatives' ORDER BY display_order ASC";
                    $result = $conn->query($sql);

                    while ($row = $result->fetch_assoc()) {
                        echo '<div class="card col-12 col-lg-3 mb-4">
                                <img src="uploads/OFFICERS/' . $row['photo'] . '" alt="' . $row['name'] . '">
                                <div class="details">
                                    <h3 class="name">' . $row['name'] . '</h3>
                                    <h3 class="job">' . $row['position'] . '</h3>
                                </div>
                            </div>';
                    }
                    ?>
                </div>
            </div>
        </div>
    </div>

    <?php include 'footer.php'; ?>
    <script src="js/bootstrap.bundle.min.js"></script>
</body>

</html>