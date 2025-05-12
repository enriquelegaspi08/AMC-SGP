<?php
session_start();
include 'config.php';

// Fetch all collections
$sql = "SELECT * FROM collections ORDER BY school_year DESC, year_level ASC, major ASC, student_name ASC";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Fees and Collections</title>
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <style>
        html, body {
            height: 100%;
            margin: 0;
            display: flex;
            flex-direction: column;
        }

        body {
            flex: 1;
        }

        .main-content {
            flex: 1; /* Allows content area to grow and push footer down */
        }
    </style>
</head>
<body>

<?php include 'navbar.php'; ?>

<div class="container mt-5">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h2>Fees and Collections</h2>
        <?php if (isset($_SESSION['account_type']) && $_SESSION['account_type'] === 'admin'): ?>
            <a href="add_collection.php" class="btn btn-primary mb-3">Add Collection</a>
        <?php endif; ?>
    </div>

    <?php if ($result->num_rows > 0): ?>
    <div class="table-responsive">
        <table class="table table-bordered table-striped text-center">
            <thead class="table-primary">
                <tr>
                    <th>#</th>
                    <th>Year Level</th>
                    <th>Major</th>
                    <th>Student Name</th>
                    <th>Membership Fee</th>
                    <th>Acquaintance Contribution</th>
                    <th>Sportsfest Contribution</th>
                    <th>Sanction</th>
                    <th>School Year</th>
                    <?php if (isset($_SESSION['account_type']) && $_SESSION['account_type'] === 'admin'): ?>
                        <th>Actions</th>
                    <?php endif; ?>
                </tr>
            </thead>
            <tbody>
                
                <?php 
                    $count = 1;
                    while($row = $result->fetch_assoc()): 
                ?>
                <tr>
                    <td><?php echo $count++; ?></td>
                    <td><?= htmlspecialchars($row['year_level']) ?></td>
                    <td><?= htmlspecialchars($row['major']) ?></td>
                    <td><?= htmlspecialchars($row['student_name']) ?></td>
                    <td>₱<?= number_format($row['membership_fee'], 2) ?></td>
                    <td>₱<?= number_format($row['acquaintance_contribution'], 2) ?></td>
                    <td>₱<?= number_format($row['sportsfest_contribution'], 2) ?></td>
                    <td>₱<?= number_format($row['sanction'], 2) ?></td>
                    <td><?= htmlspecialchars($row['school_year']) ?></td>
                    <?php if (isset($_SESSION['account_type']) && $_SESSION['account_type'] === 'admin'): ?>
                        <td>
                            <a href="edit_collection.php?id=<?php echo $row['id']; ?>" class="btn btn-sm btn-info">Update</a>
                        </td>
                    <?php endif; ?>
                </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    </div>
    <?php else: ?>
        <div class="alert alert-info">No collection records found.</div>
    <?php endif; ?>
</div>

<?php include 'footer.php'; ?>
<script src="js/bootstrap.bundle.min.js"></script>
</body>
</html>