<?php
session_start();
include 'config.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $year_level = $conn->real_escape_string($_POST['year_level']);
    $major = $conn->real_escape_string($_POST['major']);
    $stud_id = $conn->real_escape_string($_POST['stud_id']);
    $student_name = $conn->real_escape_string($_POST['student_name']);
    $membership_fee = floatval($_POST['membership_fee']);
    $acquaintance_contribution = floatval($_POST['acquaintance_contribution']);
    $sportsfest_contribution = floatval($_POST['sportsfest_contribution']);
    $sanction = floatval($_POST['sanction']);
    $school_year = $conn->real_escape_string($_POST['school_year']);

    $sql = "INSERT INTO collections 
        (year_level, major, stud_id, student_name, membership_fee, acquaintance_contribution, sportsfest_contribution, sanction, school_year) 
        VALUES 
        ('$year_level', '$major', '$stud_id', '$student_name', $membership_fee, $acquaintance_contribution, $sportsfest_contribution, $sanction, '$school_year')";

    if ($conn->query($sql)) {
        header("Location: collections.php");
        exit();
    } else {
        $error = "Error adding collection: " . $conn->error;
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Add Collection</title>
    <link href="css/bootstrap.min.css" rel="stylesheet">
</head>

<body>

    <?php include 'navbar.php'; ?>

    <div class="container mt-5">
        <h2 class="mb-4">Add Student Collection</h2>

        <?php if (isset($error)): ?>
            <div class="alert alert-danger"><?php echo $error; ?></div>
        <?php endif; ?>

        <form class="mb-3" method="post">
            <div class="row">
                <div class="mb-3 col-md-6">
                    <label class="form-label">Year Level</label>
                    <select name="year_level" class="form-select" required>
                        <option value="" disabled selected>Select Year Level</option>
                        <option value="1st Year">1st Year</option>
                        <option value="2nd Year">2nd Year</option>
                        <option value="3rd Year">3rd Year</option>
                        <option value="4th Year">4th Year</option>
                    </select>
                </div>
                <div class="mb-3 col-md-6">
                    <label class="form-label">Major</label>
                    <select name="major" class="form-select" required>
                        <option value="" disabled selected>Select Major</option>
                        <option value="BS Entrepeneur">BS ENTREP</option>
                        <option value="BTVTED-CCT">BTVTED-CCT</option>
                        <option value="BTVTED-CHS">BTVTED-CHS</option>
                    </select>
                </div>
            </div>
            <div class="row">
                <div class="mb-3 col-md-6">
                    <label class="form-label">Student ID No.:</label>
                    <input type="text" name="stud_id" class="form-control" required>
                </div>
                <div class="mb-3 col-md-6">
                    <label class="form-label">Student Name</label>
                    <input type="text" name="student_name" class="form-control" required>
                </div>
            </div>
            <div class="row">
                <div class="mb-3 col-md-6">
                    <label class="form-label">Membership Fee (₱)</label>
                    <input type="number" step="1" name="membership_fee" class="form-control" required>
                </div>
                <div class="mb-3 col-md-6">
                    <label class="form-label">Acquaintance Contribution (₱)</label>
                    <input type="number" step="1" name="acquaintance_contribution" class="form-control" required>
                </div>
            </div>
            <div class="row">
                <div class="mb-3 col-md-6">
                    <label class="form-label">Sportsfest Contribution (₱)</label>
                    <input type="number" step="1" name="sportsfest_contribution" class="form-control" required>
                </div>
                <div class="mb-3 col-md-6">
                    <label class="form-label">Sanction (₱)</label>
                    <input type="number" step="1" name="sanction" class="form-control" required>
                </div>
            </div>
            <div class="mb-3 col-md-3">
                <label class="form-label">School Year (e.g., 2024-2025)</label>
                <input type="text" name="school_year" class="form-control" required>
            </div>
            <button type="submit" class="btn btn-success">Save Collection</button>
            <a href="collections.php" class="btn btn-secondary">Cancel</a>
        </form>
    </div>

    <?php include 'footer.php'; ?>
    <script src="js/bootstrap.bundle.min.js"></script>
</body>

</html>