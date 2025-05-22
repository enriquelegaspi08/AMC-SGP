<?php
session_start();
include 'config.php';

if (!isset($_SESSION['account_type']) || $_SESSION['account_type'] !== 'admin') {
    header('Location: index.php');
    exit();
}

$id = intval($_GET['id']);
$user = $conn->query("SELECT * FROM users WHERE id = $id")->fetch_assoc();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $stud_id = $_POST['stud_id'];
    $full_name = $_POST['full_name'];
    $username = $_POST['username'];
    $email = $_POST['email'];
    $year_block = $_POST['year_block'];
    $major = $_POST['major'];
    $account_type = $_POST['account_type'];

    $stmt = $conn->prepare("UPDATE users SET stud_id=?, full_name=?, username=?, email=?, year_block=?, major=?, account_type=? WHERE id=?");
    $stmt->bind_param("sssssssi", $stud_id, $full_name, $username, $email, $year_block, $major, $account_type, $id);
    $stmt->execute();

    header("Location: users.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Edit User</title>
    <link href="css/bootstrap.min.css" rel="stylesheet">
</head>

<body>

    <?php include 'navbar.php'; ?>

    <div class="container mt-5">
        <h2>Edit User</h2>
        <form method="POST">
            <div class="mb-3">
                <label class="form-label">Student ID</label>
                <input type="text" name="stud_id" class="form-control" value="<?= htmlspecialchars($user['stud_id']) ?>" required>
            </div>
            <div class="mb-3">
                <label class="form-label">Full Name</label>
                <input type="text" name="full_name" class="form-control" value="<?= htmlspecialchars($user['full_name']) ?>" required>
            </div>
            <div class="mb-3">
                <label class="form-label">Username</label>
                <input type="text" name="username" class="form-control" value="<?= htmlspecialchars($user['username']) ?>" required>
            </div>
            <div class="mb-3">
                <label class="form-label">Email</label>
                <input type="email" name="email" class="form-control" value="<?= htmlspecialchars($user['email']) ?>" required>
            </div>
            <div class="mb-3">
                <label class="form-label">Year & Block</label>
                <input type="text" name="year_block" class="form-control" value="<?= htmlspecialchars($user['year_block']) ?>" required>
            </div>
            <div class="mb-3">
                <label class="form-label">Major</label>
                <input type="text" name="major" class="form-control" value="<?= htmlspecialchars($user['major']) ?>" required>
            </div>
            <div class="mb-3">
                <label class="form-label">Account Type</label>
                <select name="account_type" class="form-select" required>
                    <option value="student" <?= $user['account_type'] === 'student' ? 'selected' : '' ?>>Student</option>
                    <option value="admin" <?= $user['account_type'] === 'admin' ? 'selected' : '' ?>>Admin</option>
                </select>
            </div>
            <button type="submit" class="btn btn-success">Update User</button>
            <a href="users.php" class="btn btn-secondary">Back</a>
        </form>
    </div>

    <script src="js/bootstrap.bundle.min.js"></script>
</body>

</html>