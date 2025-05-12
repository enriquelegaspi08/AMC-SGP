<?php
session_start();
include 'config.php';

// Redirect if not admin
if (!isset($_SESSION['account_type']) || $_SESSION['account_type'] !== 'admin') {
    header("Location: index.php");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title = $conn->real_escape_string($_POST['title']);
    $uploadDir = 'uploads/disbursements/';
    $fileName = basename($_FILES['photo']['name']);
    $targetFile = $uploadDir . $fileName;
    $uploadOk = 1;
    $imageFileType = strtolower(pathinfo($targetFile, PATHINFO_EXTENSION));

    // Check if it's a real image
    $check = getimagesize($_FILES['photo']['tmp_name']);
    if ($check === false) {
        $error = "File is not a valid image.";
        $uploadOk = 0;
    }

    // Allow only image types
    $allowedTypes = ['jpg', 'jpeg', 'png', 'gif'];
    if (!in_array($imageFileType, $allowedTypes)) {
        $error = "Only JPG, JPEG, PNG, and GIF files are allowed.";
        $uploadOk = 0;
    }

    // Upload and save
    if ($uploadOk) {
        if (!file_exists($uploadDir)) {
            mkdir($uploadDir, 0777, true);
        }

        if (move_uploaded_file($_FILES['photo']['tmp_name'], $targetFile)) {
            $stmt = $conn->prepare("INSERT INTO disbursements (title, filename) VALUES (?, ?)");
            $stmt->bind_param("ss", $title, $fileName);
            if ($stmt->execute()) {
                $success = "Photo uploaded successfully! Redirecting to Disbursements page...";
            } else {
                $error = "Error saving to database: " . $conn->error;
            }
            $stmt->close();
        } else {
            $error = "Error uploading the file.";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Add Disbursement Photo</title>
    <link href="css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

<?php include 'navbar.php'; ?>

<div class="container mt-5">
    <h2>Add Disbursement Photo</h2>

    <?php if (isset($error)): ?>
        <div class="alert alert-danger"><?php echo $error; ?></div>
    <?php elseif (isset($success)): ?>
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <?php echo $success; ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
        <script>
                setTimeout(function() {
                    window.location.href = "disbursements.php";
                }, 3000); // Redirect after 3 seconds
            </script>
    <?php endif; ?>

    <form class="mb-3" method="post" enctype="multipart/form-data">
        <div class="mb-3">
            <label class="form-label">Title:</label>
            <input type="text" name="title" class="form-control" required>
        </div>
        <div class="mb-3">
            <label class="form-label">Select Image:</label>
            <input type="file" name="photo" class="form-control" accept="image/*" required>
        </div>
        <button type="submit" class="btn btn-primary">Upload</button>
        <a href="disbursements.php" class="btn btn-secondary">Back</a>
    </form>
</div>

<?php include 'footer.php'; ?>
<script src="js/bootstrap.bundle.min.js"></script>
</body>
</html>