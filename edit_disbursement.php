<?php
session_start();
include 'config.php';

// Redirect if not admin
if (!isset($_SESSION['account_type']) || $_SESSION['account_type'] !== 'admin') {
    header("Location: disbursements.php");
    exit;
}

// Get disbursement ID
if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    header("Location: disbursements.php");
    exit;
}

$id = (int)$_GET['id'];
$error = '';
$success = '';

// Fetch current data
$stmt = $conn->prepare("SELECT * FROM disbursements WHERE id = ?");
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();
$disbursement = $result->fetch_assoc();
$stmt->close();

if (!$disbursement) {
    header("Location: disbursements.php");
    exit;
}

// Handle form submission
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $newTitle = trim($_POST['title']);

    // Update with or without new image
    if (!empty($_FILES['photo']['name'])) {
        $uploadDir = "uploads/disbursements/";
        $newFileName = time() . '_' . basename($_FILES['photo']['name']);
        $targetFile = $uploadDir . $newFileName;

        if (move_uploaded_file($_FILES['photo']['tmp_name'], $targetFile)) {
            // Delete old image
            $oldPath = $uploadDir . $disbursement['filename'];
            if (file_exists($oldPath)) unlink($oldPath);

            $stmt = $conn->prepare("UPDATE disbursements SET title = ?, filename = ? WHERE id = ?");
            $stmt->bind_param("ssi", $newTitle, $newFileName, $id);
        } else {
            $error = "Error uploading new file.";
        }
    } else {
        $stmt = $conn->prepare("UPDATE disbursements SET title = ? WHERE id = ?");
        $stmt->bind_param("si", $newTitle, $id);
    }

    if (empty($error) && $stmt->execute()) {
        $stmt->close();
        header("Location: disbursements.php");
        exit;
    } else {
        $error = $error ?: "Database error: " . $conn->error;
        $stmt->close();
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Edit Disbursement</title>
    <link rel="stylesheet" href="css/bootstrap.min.css">
</head>

<body>

    <?php include 'navbar.php'; ?>

    <div class="container mt-4">
        <h2>Edit Disbursement</h2>

        <?php if ($error): ?>
            <div class="alert alert-danger"><?php echo $error; ?></div>
        <?php endif; ?>

        <form method="post" enctype="multipart/form-data" class="my-3">
            <div class="mb-3">
                <label class="form-label">Title</label>
                <input type="text" name="title" class="form-control" required value="<?php echo htmlspecialchars($disbursement['title']); ?>">
            </div>

            <div class="mb-3">
                <label class="form-label">Current Photo</label><br>
                <img src="uploads/disbursements/<?php echo htmlspecialchars($disbursement['filename']); ?>" alt="Current Photo" style="height:150px;">
            </div>

            <div class="mb-3">
                <label class="form-label">Replace Photo (optional)</label>
                <input type="file" name="photo" class="form-control">
            </div>

            <button type="submit" class="btn btn-primary">Update</button>
            <a href="disbursements.php" class="btn btn-secondary">Cancel</a>
        </form>
    </div>

    <?php include 'footer.php'; ?>
    <script src="js/bootstrap.bundle.min.js"></script>
</body>

</html>