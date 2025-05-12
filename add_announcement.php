<?php
session_start();
include 'config.php';

// Only allow admins
if (!isset($_SESSION['account_type']) || $_SESSION['account_type'] !== 'admin') {
    header("Location: announcements.php");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $title = trim($_POST['title']);
    $content = trim($_POST['content']);
    $date_posted = date('Y-m-d H:i:s');

    $stmt = $conn->prepare("INSERT INTO announcements (title, content, date_posted) VALUES (?, ?, ?)");
    $stmt->bind_param("sss", $title, $content, $date_posted);

    if ($stmt->execute()) {
        header("Location: announcements.php");
        exit();
    } else {
        $error = "Error adding announcement.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Add Announcement</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap 5 CSS -->
    <link href="css/bootstrap.min.css" rel="stylesheet">

    <!-- TinyMCE -->
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
    <h2 class="mb-4">Add Announcement</h2>

    <?php if (isset($error)): ?>
        <div class="alert alert-danger"><?= $error ?></div>
    <?php endif; ?>

    <form class="mb-3" action="add_announcement.php" method="post" onsubmit="return validateEditor();">
        <div class="mb-3">
            <label for="title" class="form-label">Title:</label>
            <input type="text" name="title" id="title" class="form-control" required>
        </div>
        <div class="mb-3">
            <label for="content" class="form-label">Content:</label>
            <textarea id="content" name="content" class="form-control" rows="8" required></textarea>
        </div>
        <div class="d-flex justify-content-between">
            <a href="announcements.php" class="btn btn-secondary">Cancel</a>
            <button type="submit" class="btn btn-primary">Post</button>
        </div>
    </form>
</div>

<?php include 'footer.php'; ?>

<!-- Bootstrap 5 JS -->
<script src="js/bootstrap.bundle.min.js"></script>

<!-- TinyMCE content validation -->
<script>
function validateEditor() {
    const content = tinymce.get("content").getContent({ format: "text" }).trim();
    if (content === "") {
        alert("Please enter announcement content.");
        tinymce.get("content").focus();
        return false;
    }
    return true;
}
</script>

</body>
</html>
