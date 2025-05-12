<?php
session_start();
include 'config.php';

// Fetch announcements
$sql = "SELECT * FROM announcements ORDER BY date_posted DESC";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Announcements</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap CSS -->
    <link href="css/bootstrap.min.css" rel="stylesheet">

    <style>
        body {
            background-color: #f8f9fa;
        }

        .card-header {
            font-weight: bold;
        }
    </style>
</head>

<body>
    <?php include'navbar.php'?>
    <div class="container mt-5">
        <h2 class="text-center mb-4">Latest Announcements</h2>

        <?php if (isset($_SESSION['account_type']) && $_SESSION['account_type'] === 'admin'): ?>
            <div class="mb-3 text-end">
                <a href="add_announcement.php" class="btn btn-success">+ Add Announcement</a>
            </div>
        <?php endif; ?>

        <?php if ($result->num_rows > 0): ?>
            <div class="row">
                <?php while ($row = $result->fetch_assoc()): ?>
                    <div class="col-12 mb-4">
                        <div class="card h-100">
                            <div class="card-header bg-primary text-white d-flex justify-content-between">
                                <span><?php echo htmlspecialchars($row['title']); ?></span>
                                <?php if (isset($_SESSION['account_type']) && $_SESSION['account_type'] === 'admin'): ?>
                                    <div class="btn-group btn-group-sm">
                                        <a href="edit_announcement.php?id=<?= $row['id'] ?>" class="btn btn-light">Edit</a>
                                        <a href="delete_announcement.php?id=<?= $row['id'] ?>" class="btn btn-danger" onclick="return confirm('Delete this announcement?');">Delete</a>
                                    </div>
                                <?php endif; ?>
                            </div>
                            <div class="card-body">
                                <p class="card-text"><?php echo nl2br($row['content']); ?></p>
                            </div>
                            <div class="card-footer text-muted small">
                                Posted on: <?php echo date('F j, Y, g:i A', strtotime($row['date_posted'])); ?>
                            </div>
                        </div>
                    </div>
                <?php endwhile; ?>
            </div>
        <?php else: ?>
            <div class="alert alert-info text-center">No announcements found.</div>
        <?php endif; ?>
    </div>

    <?php include'footer.php'?>

    <!-- Bootstrap Bundle JS -->
    <script src="js/bootstrap.bundle.min.js"></script>

</body>

</html>