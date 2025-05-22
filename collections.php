<?php
session_start();
include 'config.php';

// Get distinct values for filter dropdowns
$years = $conn->query("SELECT DISTINCT year_level FROM collections ORDER BY year_level ASC");
$majors = $conn->query("SELECT DISTINCT major FROM collections ORDER BY major ASC");
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Fees and Collections</title>
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <style>
        html,
        body {
            height: 100%;
            margin: 0;
            display: flex;
            flex-direction: column;
        }

        body {
            flex: 1;
        }

        .main-content {
            flex: 1;
        }
    </style>
</head>

<body>

    <?php include 'navbar.php'; ?>

    <div class="container mt-5">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h2>Fees and Collections</h2>
            <?php if ($_SESSION['account_type'] === 'admin'): ?>
                <a href="add_collection.php" class="btn btn-primary mb-3">Add Collection</a>
            <?php endif; ?>
        </div>

        <!-- Search & Filters -->
        <div class="row g-2 mb-4">
            <div class="col-md-4">
                <input type="text" id="search" class="form-control" placeholder="Search by student name">
            </div>
            <div class="col-md-3">
                <select id="year_level" class="form-select">
                    <option value="">All Year Levels</option>
                    <?php while ($y = $years->fetch_assoc()): ?>
                        <option value="<?= $y['year_level'] ?>"><?= $y['year_level'] ?></option>
                    <?php endwhile; ?>
                </select>
            </div>
            <div class="col-md-3">
                <select id="major" class="form-select">
                    <option value="">All Majors</option>
                    <?php while ($m = $majors->fetch_assoc()): ?>
                        <option value="<?= $m['major'] ?>"><?= $m['major'] ?></option>
                    <?php endwhile; ?>
                </select>
            </div>
        </div>

        <div id="collectionTable">
            <!-- AJAX will load the table here -->
        </div>
    </div>

    <?php include 'footer.php'; ?>
    <script src="js/bootstrap.bundle.min.js"></script>

    <script>
        function fetchCollections() {
            const search = $('#search').val();
            const year = $('#year_level').val();
            const major = $('#major').val();

            $.ajax({
                url: 'fetch_collections.php',
                method: 'GET',
                data: {
                    search: search,
                    year_level: year,
                    major: major
                },
                success: function(response) {
                    $('#collectionTable').html(response);
                }
            });
        }

        $(document).ready(function() {
            // Initial load
            fetchCollections();

            // Live search & filters
            $('#search').on('keyup', fetchCollections);
            $('#year_level, #major').on('change', fetchCollections);
        });
    </script>

</body>

</html>