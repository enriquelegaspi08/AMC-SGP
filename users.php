<?php
session_start();
include 'config.php';

if (!isset($_SESSION['account_type']) || $_SESSION['account_type'] !== 'admin') {
    header('Location: index.php');
    exit();
}

// Delete user if delete is requested
if (isset($_GET['delete'])) {
    $id = intval($_GET['delete']);
    $conn->query("DELETE FROM users WHERE id = $id");
    header("Location: users.php");
    exit();
}

// Fetch all users
$users = $conn->query("SELECT * FROM users ORDER BY created_at DESC");
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Manage Users</title>
    <link href="css/bootstrap.min.css" rel="stylesheet">
</head>

<body>

    <?php include 'navbar.php'; ?>

    <div class="container mt-5">
        <h2 class="mb-4">Users List</h2>
        <div class="table-responsive">
            <table class="table table-bordered table-hover align-middle text-center">
                <thead class="table-dark">
                    <tr>
                        <th>#</th>
                        <th>Student ID</th>
                        <th>Full Name</th>
                        <th>Username</th>
                        <th>Email</th>
                        <th>Year & Block</th>
                        <th>Major</th>
                        <th>Account Type</th>
                        <th>Date Created</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $count = 1; ?>
                    <?php while ($row = $users->fetch_assoc()): ?>
                        <tr>
                            <td><?= $count++; ?></td>
                            <td><?= htmlspecialchars($row['stud_id']) ?></td>
                            <td><?= htmlspecialchars($row['full_name']) ?></td>
                            <td><?= htmlspecialchars($row['username']) ?></td>
                            <td><?= htmlspecialchars($row['email']) ?></td>
                            <td><?= htmlspecialchars($row['year_block']) ?></td>
                            <td><?= htmlspecialchars($row['major']) ?></td>
                            <td><?= htmlspecialchars($row['account_type']) ?></td>
                            <td><?= date("F j, Y", strtotime($row['created_at'])) ?></td>
                            <td>
                                <a href="edit_user.php?id=<?= $row['id'] ?>" class="btn btn-warning btn-sm">Edit</a>
                                <a href="users.php?delete=<?= $row['id'] ?>" class="btn btn-danger btn-sm"
                                    onclick="return confirm('Are you sure you want to delete this user?');">Delete</a>
                            </td>
                        </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        </div>
    </div>

    <script src="js/bootstrap.bundle.min.js"></script>
</body>

</html>