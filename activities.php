<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>AMC STUDENT COUNCIL (CSC)</title>
    <link rel="stylesheet" href="styles/home.css">
    <link href="css/bootstrap.min.css" rel="stylesheet">
</head>

<body>

    <!-- Navbar -->
    <?php include 'navbar.php';?>

    <!-- Activities Slider -->
    <section id="questions" class="py-1 bg-light">
        <div class="container-fluid text-center">
            <h2>ACTIVITIES</h2>
            <h4>COLLEGE STUDENT COUNCIL</h4>
            <hr class="w-25 mx-auto mb-4">
            <div id="activityCarousel" class="carousel slide" data-bs-ride="carousel">
                <div class="carousel-inner">
                    <div class="carousel-item active">
                        <img src="SERVICES/cheerdance.jpg" class="d-block w-100" alt="Cheerdance">
                    </div>
                    <div class="carousel-item">
                        <img src="SERVICES/parade.jpg" class="d-block w-100" alt="Parade">
                    </div>
                    <div class="carousel-item">
                        <img src="SERVICES/parade1.jpg" class="d-block w-100" alt="Parade 1">
                    </div>
                    <div class="carousel-item">
                        <img src="SERVICES/csc parade.jpg" class="d-block w-100" alt="CSC Parade">
                    </div>
                    <div class="carousel-item">
                        <img src="SERVICES/sportsfest.jpg" class="d-block w-100" alt="Sportsfest">
                    </div>
                </div>
                <button class="carousel-control-prev" type="button" data-bs-target="#activityCarousel" data-bs-slide="prev">
                    <span class="carousel-control-prev-icon"></span>
                </button>
                <button class="carousel-control-next" type="button" data-bs-target="#activityCarousel" data-bs-slide="next">
                    <span class="carousel-control-next-icon"></span>
                </button>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <?php include 'footer.php';?>

    <script src="js/bootstrap.bundle.min.js"></script>
</body>
</html>