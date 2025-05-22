<?php
session_start();
include 'config.php';

$id = $_GET['id'] ?? null;
if (!$id) {
    header("Location: collections.php");
    exit();
}

// Fetch existing data
$result = $conn->query("SELECT * FROM collections WHERE id = $id");
if ($result->num_rows === 0) {
    header("Location: collections.php");
    exit();
}
$record = $result->fetch_assoc();

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $year_level = $conn->real_escape_string($_POST['year_level']);
    $major = $conn->real_escape_string($_POST['major']);
    $stud_id = $conn->real_escape_string($_POST['stud_id']);
    $student_name = $conn->real_escape_string($_POST['student_name']);
    $membership_fee = floatval($_POST['membership_fee']);
    $acquaintance_contribution = floatval($_POST['acquaintance_contribution']);
    $sportsfest_contribution = floatval($_POST['sportsfest_contribution']);
    $sanction = floatval($_POST['sanction']);
    $school_year = $conn->real_escape_string($_POST['school_year']);

    $sql = "UPDATE collections SET
        year_level = '$year_level',
        major = '$major',
        student_name = '$student_name',
        stud_id = '$stud_id',
        membership_fee = $membership_fee,
        acquaintance_contribution = $acquaintance_contribution,
        sportsfest_contribution = $sportsfest_contribution,
        sanction = $sanction,
        school_year = '$school_year'
        WHERE id = $id";

    if ($conn->query($sql)) {
        header("Location: collections.php");
        exit();
    } else {
        $error = "Error updating record: " . $conn->error;
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Edit Collection</title>
    <link rel="stylesheet" href="css/bootstrap.min.css">
</head>

<body>

    <?php include 'navbar.php'; ?>

    <div class="container mt-5">
        <h2>Edit Collection</h2>

        <?php if (isset($error)): ?>
            <div class="alert alert-danger"><?php echo $error; ?></div>
        <?php endif; ?>

        <form class="mb-3" method="post" class="row g-3">
            <div class="mb-3 col-md-6">
                <label class="form-label">Year Level</label>
                <select name="year_level" class="form-select" required>
                    <option value="1st Year" <?= $record['year_level'] == 'First Year' ? 'selected' : '' ?>>1st Year</option>
                    <option value="2nd Year" <?= $record['year_level'] == 'Second Year' ? 'selected' : '' ?>>2nd Year</option>
                    <option value="3rd Year" <?= $record['year_level'] == 'Third Year' ? 'selected' : '' ?>>3rd Year</option>
                    <option value="4th Year" <?= $record['year_level'] == 'Fourth Year' ? 'selected' : '' ?>>4th Year</option>
                </select>
            </div>

            <div class="mb-3 col-md-6">
                <label class="form-label">Major</label>
                <input type="text" name="major" class="form-control" value="<?php echo htmlspecialchars($record['major']); ?>" required>
            </div>

            <div class="mb-3 col-md-6">
                <label class="form-label">Student ID No.</label>
                <input type="text" name="stud_id" class="form-control" value="<?php echo htmlspecialchars($record['stud_id']); ?>" required>
            </div>

            <div class="mb-3 col-md-6">
                <label class="form-label">Student Name</label>
                <input type="text" name="student_name" class="form-control" value="<?php echo htmlspecialchars($record['student_name']); ?>" required>
            </div>

            <div class="mb-3 col-md-6">
                <label class="form-label">Membership Fee</label>
                <input type="number" name="membership_fee" class="form-control" value="<?php echo $record['membership_fee']; ?>" step="1" required>
            </div>

            <div class="mb-3 col-md-6">
                <label class="form-label">Acquaintance Contribution</label>
                <input type="number" name="acquaintance_contribution" class="form-control" value="<?php echo $record['acquaintance_contribution']; ?>" step="1" required>
            </div>

            <div class="mb-3 col-md-6">
                <label class="form-label">Sportsfest Contribution</label>
                <input type="number" name="sportsfest_contribution" class="form-control" value="<?php echo $record['sportsfest_contribution']; ?>" step="1" required>
            </div>

            <div class="mb-3 col-md-6">
                <label class="form-label">Sanction</label>
                <input type="number" name="sanction" class="form-control" value="<?php echo $record['sanction']; ?>" step="1" required>
            </div>

            <div class="mb-3 col-md-6">
                <label class="form-label">School Year</label>
                <input type="text" name="school_year" class="form-control" value="<?php echo htmlspecialchars($record['school_year']); ?>" required>
            </div>

            <div class="col-12">
                <button type="submit" class="btn btn-success">Update</button>
                <a href="collections.php" class="btn btn-secondary">Cancel</a>
            </div>
        </form>
    </div>

    <?php include 'footer.php'; ?>
    <script src="js/bootstrap.bundle.min.js"></script>
</body>

</html>