<?php
session_start();
include 'config.php';

// Redirect if not admin
if (!isset($_SESSION['account_type']) || $_SESSION['account_type'] !== 'admin') {
    header("Location: announcements.php");
    exit();
}

$id = $_GET['id'] ?? null;
if (!$id) {
    header("Location: announcements.php");
    exit();
}

// Fetch current announcement
$stmt = $conn->prepare("SELECT * FROM announcements WHERE id = ?");
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 0) {
    header("Location: announcements.php");
    exit();
}
$announcement = $result->fetch_assoc();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $title = trim($_POST['title']);
    $content = trim($_POST['content']);

    $stmt = $conn->prepare("UPDATE announcements SET title = ?, content = ? WHERE id = ?");
    $stmt->bind_param("ssi", $title, $content, $id);

    if ($stmt->execute()) {
        header("Location: announcements.php");
        exit();
    } else {
        $error = "Error updating announcement.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Edit Announcement</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap 5 CSS -->
    <link href="css/bootstrap.min.css" rel="stylesheet">

    <!-- TinyMCE Rich Text Editor -->
    <script src="https://cdn.tiny.cloud/1/ardpr7zq2m3t906nt1t0sjyltc4n9cfz5bivo7ik1ki1k9t1/tinymce/6/tinymce.min.js" referrerpolicy="origin"></script>
    <script>
      tinymce.init({
        selector: '#content',
        menubar: false,
        plugins: 'link lists',
        toolbar: 'undo redo | bold italic underline | bullist numlist | link',
        branding: false
      });
    </script>
</head>
<body>

<?php include 'navbar.php'; ?>

<div class="container mt-5">
    <h2 class="mb-4">Edit Announcement</h2>

    <?php if (isset($error)): ?>
        <div class="alert alert-danger"><?php echo $error; ?></div>
    <?php endif; ?>

    <form class="mb-3" method="post">
        <div class="mb-3">
            <label for="title" class="form-label">Title:</label>
            <input type="text" name="title" id="title" class="form-control" value="<?= htmlspecialchars($announcement['title']) ?>" required>
        </div>
        <div class="mb-3">
            <label for="content" class="form-label">Content:</label>
            <textarea id="content" name="content" class="form-control" rows="8" required><?= htmlspecialchars($announcement['content']) ?></textarea>
        </div>
        <div class="d-flex justify-content-between">
            <a href="announcements.php" class="btn btn-secondary">Cancel</a>
            <button type="submit" class="btn btn-primary">Update</button>
        </div>
    </form>
</div>

<?php include 'footer.php'; ?>

<!-- Bootstrap JS -->
<script src="js/bootstrap.bundle.min.js"></script>

</body>
</html>