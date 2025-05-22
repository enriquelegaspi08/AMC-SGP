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
    <link rel="stylesheet" href="styles/home.css">
    <link href="css/bootstrap.min.css" rel="stylesheet">
</head>

<body>

    <!-- Navbar -->
    <?php include 'navbar.php'; ?>

    <!-- Activities Slider -->
    <section id="questions" class="py-1 bg-light">
        <div class="container-fluid text-center">
            <h2>ACTIVITIES</h2>
            <h4>COLLEGE STUDENT COUNCIL</h4>
            <hr class="w-25 mx-auto mb-4">

            <?php if (isset($_SESSION['account_type']) && $_SESSION['account_type'] === 'admin'): ?>
                <div class="mb-3 text-end pe-3">
                    <a href="update_activities.php" class="btn btn-primary">Update Activities</a>
                </div>
            <?php endif; ?>

            <div id="activityCarousel" class="carousel slide" data-bs-ride="carousel">
                <div class="carousel-inner">
                    <?php
                    $photos = $conn->query("SELECT * FROM activities ORDER BY uploaded_at DESC");
                    $first = true;
                    while ($photo = $photos->fetch_assoc()):
                        $image = htmlspecialchars($photo['filename']);
                    ?>
                        <div class="carousel-item <?= $first ? 'active' : '' ?>">
                            <img src="uploads/activities/<?= $image ?>" class="d-block w-100" alt="Activity Photo">
                        </div>
                        <?php $first = false; ?>
                    <?php endwhile; ?>
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
    <?php include 'footer.php'; ?>

    <script src="js/bootstrap.bundle.min.js"></script>
</body>

</html>