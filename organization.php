<?php
session_start();
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
                        $set1 = [
                            ["verano.jpeg", "LAILA B. VERANO", "PRESIDENT"],
                            ["abunda.jpg", "SHAKAIRA MONIQUE ABUNDA", "VICE PRESIDENT"],
                            ["villanueva.jpeg", "LAURENCE VILLANUEVA", "EXECUTIVE SECRETARY"]
                        ];
                        foreach ($set1 as $officer) {
                            echo '<div class="card col-12 col-lg-3 mb-3">
                                        <img src="CSC OFFICERS/' . $officer[0] . '" alt="' . $officer[1] . '">
                                        <div class="details">
                                            <h3 class="name">' . $officer[1] . '</h3>
                                            <h3 class="job">' . $officer[2] . '</h3>
                                        </div>
                                </div>';
                        }
                        ?>
                    </div>

                    <!-- Set 2 -->
                    <div class="main-card row justify-content-center officer-set set-2">
                        <?php
                        $set2 = [
                            ["thea_.jpg", "DOROTHEA GERASTA", "LEGISLATIVE SECRETARY"],
                            ["Bulalacao.jpg", "LOUISSE GENESISS R. BULALACAO", "TREASURER"],
                            ["cristine L..jpg", "CHRISTINE G. LOPEZ", "AUDITOR"]
                        ];
                        foreach ($set2 as $officer) {
                            echo '<div class="card col-12 col-lg-3 mb-3">
                                        <img src="CSC OFFICERS/' . $officer[0] . '" alt="' . $officer[1] . '">
                                        <div class="details">
                                            <h3 class="name">' . $officer[1] . '</h3>
                                            <h3 class="job">' . $officer[2] . '</h3>
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
                    $extra = [
                        ["christine M..jpg", "CHRISTINE T. MAHINAY", "P.I.O"],
                        ["joana paula.jpg", "JOANA PAULA BELLO", "BUSINESS MANAGER"],
                        ["#", "JOHN DAVID T. SESE", "BUSINESS MANAGER"]
                    ];
                    foreach ($extra as $officer) {
                        echo '<div class="card col-12 col-lg-3 mb-4">
                                    <img src="CSC OFFICERS/' . $officer[0] . '" alt="' . $officer[1] . '">
                                    <div class="details">
                                        <h3 class="name">' . $officer[1] . '</h3>
                                        <h3 class="job">' . $officer[2] . '</h3>
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
                    $extra = [
                        ["BAJAR.jpeg", "JESSICA BAJAR", "SENATOR"],
                        ["khim.jpg", "KIMBERLY ROD M. NATURAL", "SENATOR"],
                        ["narciso.jpg", "NARCISO B. ANDRIN JR.", "SENATOR"],
                        ["te angie.jpg", "ANGIELYN P. UBAS", "SENATOR"],
                        ["lozano.jpg", "ROLLY S. LOZANO JR.", "SENATOR"]
                    ];
                    foreach ($extra as $officer) {
                        echo '<div class="card col-12 col-lg-3 mb-4">
                                    <img src="CSC OFFICERS/' . $officer[0] . '" alt="' . $officer[1] . '">
                                    <div class="details">
                                        <h3 class="name">' . $officer[1] . '</h3>
                                        <h3 class="job">' . $officer[2] . '</h3>
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
                    $extra = [
                        ["", "KATE CYRELLE DIOQUINO", "1ST YEAR-BTVTED REPRESENTATIVE"],
                        ["DANAO.jpg", "JOHN PAUL DANAO", "1ST YEAR-ENTREP REPRESENTATIVE"],
                        ["joice.jpg", "JOICE B. ARBOLADO", "2ND YEAR-BTVTED REPRESENTATIVE"],
                        ["kyla.jpg", "KYLA MAE Z. SALIVIO", "2ND YEAR-ENTREP REPRESENTATIVE"],
                        ["BTVTED-REPRESENTATIVE.jpg", "MARIAL A. CENDAÑA", "3RD YEAR-BTVTED REPRESENTATIVE"],
                        ["entrep 3.jpg", "ROSEMARIE MAGLENTE", "3RD YEAR-ENTREP REPRESENTATIVE"],
                        ["raquel.jpg", "RAQUEL DELA PEÑA", "4TH YEAR-BTVTED REPRESENTATIVE"],
                        ["mariemar.jpg", "MARIEMAR CANTORIA", "4TH YEAR-ENTREP REPRESENTATIVE"]
                    ];
                    foreach ($extra as $officer) {
                        echo '<div class="card col-12 col-lg-3 mb-4">
                                    <img src="CSC OFFICERS/' . $officer[0] . '" alt="' . $officer[1] . '">
                                    <div class="details">
                                        <h3 class="name">' . $officer[1] . '</h3>
                                        <h3 class="job">' . $officer[2] . '</h3>
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