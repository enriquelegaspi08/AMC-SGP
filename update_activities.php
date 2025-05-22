<?php
session_start();
include 'config.php';

if (!isset($_SESSION['account_type']) || $_SESSION['account_type'] !== 'admin') {
    header("Location: index.php");
    exit();
}

// Handle file upload
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_FILES['activity_image'])) {
    $uploadDir = 'uploads/activities/';
    $filename = basename($_FILES['activity_image']['name']);
    $targetFile = $uploadDir . $filename;
    $fileType = strtolower(pathinfo($targetFile, PATHINFO_EXTENSION));

    // Allow only image files
    $allowed = ['jpg', 'jpeg', 'png', 'gif', 'webp'];

    if (in_array($fileType, $allowed)) {
        if (move_uploaded_file($_FILES['activity_image']['tmp_name'], $targetFile)) {
            $stmt = $conn->prepare("INSERT INTO activities (filename) VALUES (?)");
            $stmt->bind_param("s", $filename);
            $stmt->execute();
            $message = "Image uploaded successfully!";
        } else {
            $message = "Failed to upload image.";
        }
    } else {
        $message = "Invalid file type. Only images are allowed.";
    }
}

// Handle delete
if (isset($_GET['delete'])) {
    $id = intval($_GET['delete']);

    // Get filename
    $result = $conn->query("SELECT filename FROM activities WHERE id = $id");
    if ($result && $row = $result->fetch_assoc()) {
        $filePath = 'uploads/activities/' . $row['filename'];
        if (file_exists($filePath)) {
            unlink($filePath);
        }
        $conn->query("DELETE FROM activities WHERE id = $id");
        $message = "Image deleted successfully!";
    }
}

// Fetch all images
$images = $conn->query("SELECT * FROM activities ORDER BY uploaded_at DESC");
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Update Activities</title>
    <link href="css/bootstrap.min.css" rel="stylesheet">
</head>

<body>
    <?php include 'navbar.php'; ?>

    <div class="container mt-4">
        <h2>Update Activities</h2>
        <?php if (isset($message)): ?>
            <div class="alert alert-info"><?= $message ?></div>
        <?php endif; ?>

        <form method="POST" enctype="multipart/form-data" class="mb-4">
            <div class="mb-3">
                <label for="activity_image" class="form-label">Upload Activity Image</label>
                <input type="file" name="activity_image" id="activity_image" class="form-control" required>
            </div>
            <button type="submit" class="btn btn-success">Upload</button>
        </form>

        <h4>Uploaded Activity Images</h4>
        <div class="row">
            <?php while ($img = $images->fetch_assoc()): ?>
                <div class="col-md-3 mb-4">
                    <div class="card">
                        <img src="uploads/activities/<?= htmlspecialchars($img['filename']) ?>" class="card-img-top" alt="Activity">
                        <div class="card-body text-center">
                            <a href="?delete=<?= $img['id'] ?>" class="btn btn-danger btn-sm" onclick="return confirm('Delete this image?')">Delete</a>
                        </div>
                    </div>
                </div>
            <?php endwhile; ?>
        </div>
    </div>

    <script src="js/bootstrap.bundle.min.js"></script>
</body>

</html>