<?php
session_start();
include 'config.php';

if (!isset($_SESSION['account_type']) || $_SESSION['account_type'] !== 'admin') {
    header("Location: organization.php");
    exit();
}

// Handle Add Officer
if (isset($_POST['add_officer'])) {
    $position = $_POST['position'];
    $name = $_POST['name'];
    $category = $_POST['category'];

    // Handle photo upload
    $photo_name = '';
    if (isset($_FILES['photo']) && $_FILES['photo']['error'] == 0) {
        $photo_tmp = $_FILES['photo']['tmp_name'];
        $photo_name = uniqid() . "_" . basename($_FILES['photo']['name']);
        move_uploaded_file($photo_tmp, "uploads/officers/" . $photo_name);
    }

    $stmt = $conn->prepare("INSERT INTO officers (position, name, photo, category) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("ssss", $position, $name, $photo_name, $category);
    $stmt->execute();
    $stmt->close();
    header("Location: update_officers.php");
    exit();
}

if (isset($_POST['update_officer'])) {
    $id = $_POST['officer_id'];
    $position = $_POST['position'];
    $name = $_POST['name'];
    $category = $_POST['category'];

    // Handle optional new photo
    $photo_update = '';
    if (isset($_FILES['photo']) && $_FILES['photo']['error'] == 0) {
        $photo_tmp = $_FILES['photo']['tmp_name'];
        $photo_name = uniqid() . "_" . basename($_FILES['photo']['name']);
        move_uploaded_file($photo_tmp, "uploads/officers/" . $photo_name);
        $photo_update = ", photo = '$photo_name'";
    }

    $stmt = $conn->prepare("UPDATE officers SET position = ?, name = ?, category = ? $photo_update WHERE id = ?");
    if ($photo_update) {
        // manual SQL because of dynamic part
        $sql = "UPDATE officers SET position=?, name=?, category=?, photo=? WHERE id=?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ssssi", $position, $name, $category, $photo_name, $id);
    } else {
        $sql = "UPDATE officers SET position=?, name=?, category=? WHERE id=?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("sssi", $position, $name, $category, $id);
    }

    $stmt->execute();
    $stmt->close();
    header("Location: update_officers.php");
    exit();
}

if (isset($_GET['delete'])) {
    $id = $_GET['delete'];
    // Optionally delete photo file from folder
    $photo = $conn->query("SELECT photo FROM officers WHERE id = $id")->fetch_assoc()['photo'];
    if ($photo && file_exists("uploads/$photo")) unlink("uploads/$photo");

    $conn->query("DELETE FROM officers WHERE id = $id");
    header("Location: update_officers.php");
    exit();
}

$edit_mode = false;
$edit_data = [];

if (isset($_GET['edit'])) {
    $edit_id = $_GET['edit'];
    $stmt = $conn->prepare("SELECT * FROM officers WHERE id = ?");
    $stmt->bind_param("i", $edit_id);
    $stmt->execute();
    $result_edit = $stmt->get_result();
    if ($result_edit->num_rows > 0) {
        $edit_data = $result_edit->fetch_assoc();
        $edit_mode = true;
    }
    $stmt->close();
}

$result = $conn->query("SELECT * FROM officers");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Update Officers</title>
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <style>
        img.rounded-circle {
            object-fit: cover;
        }
    </style>
</head>
<body>
    <?php include 'navbar.php'; ?>
    <div class="container mt-5">
        <h3 class="mb-4">Manage Student Council Officers</h3>

        <!-- Add Officer Form -->
        <form method="post" enctype="multipart/form-data" class="row g-3 mb-4">
            <input type="hidden" name="officer_id" value="<?= $edit_mode ? $edit_data['id'] : '' ?>">
            <div class="col-md-2">
                <input type="text" name="position" class="form-control" placeholder="Position"
                    value="<?= $edit_mode ? htmlspecialchars($edit_data['position']) : '' ?>" required>
            </div>
            <div class="col-md-3">
                <input type="text" name="name" class="form-control" placeholder="Full Name"
                    value="<?= $edit_mode ? htmlspecialchars($edit_data['name']) : '' ?>" required>
            </div>
            <div class="col-md-2">
                <select name="category" class="form-select" required>
                    <option value="" disabled <?= !$edit_mode ? 'selected' : '' ?>>Select Category</option>
                    <?php
                    $categories = ['executive-set-1', 'executive-set-2', 'executive-additional', 'senate', 'representatives'];
                    foreach ($categories as $cat) {
                        $selected = ($edit_mode && $edit_data['category'] === $cat) ? 'selected' : '';
                        echo "<option value=\"$cat\" $selected>" . ucfirst(str_replace('-', ' ', $cat)) . "</option>";
                    }
                    ?>
                </select>
            </div>
            <div class="col-md-3">
                <input type="file" name="photo" class="form-control" accept="image/*">
                <?php if ($edit_mode && $edit_data['photo']): ?>
                    <small class="text-muted">Current: <?= htmlspecialchars($edit_data['photo']) ?></small>
                <?php endif; ?>
            </div>
            <div class="col-md-2">
                <button type="submit" name="<?= $edit_mode ? 'update_officer' : 'add_officer' ?>" class="btn btn-<?= $edit_mode ? 'primary' : 'success' ?> w-100">
                    <?= $edit_mode ? 'Update' : 'Add' ?> Officer
                </button>
            </div>
        </form>

        <!-- Officers Table -->
        <table class="table table-bordered">
            <thead class="table-light">
                <tr>
                    <th>Photo</th>
                    <th>Position</th>
                    <th>Name</th>
                    <th>Category</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php while($row = $result->fetch_assoc()): ?>
                <tr>
                    <td>
                        <?php if ($row['photo']): ?>
                            <img src="uploads/officers/<?= htmlspecialchars($row['photo']) ?>" width="60" height="60" class="rounded-circle">
                        <?php else: ?>
                            <span class="text-muted">No Photo</span>
                        <?php endif; ?>
                    </td>
                    <td><?= htmlspecialchars($row['position']) ?></td>
                    <td><?= htmlspecialchars($row['name']) ?></td>
                    <td><?= htmlspecialchars($row['category']) ?></td>
                    <td>
                        <a href="update_officers.php?edit=<?= $row['id'] ?>" class="btn btn-sm btn-primary">Edit</a>
                        <a href="update_officers.php?delete=<?= $row['id'] ?>" class="btn btn-sm btn-danger"
                        onclick="return confirm('Are you sure you want to delete this officer?')">Delete</a>
                    </td>
                </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    </div>

    <script src="js/bootstrap.bundle.min.js"></script>
</body>
</html>