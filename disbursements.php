<?php
session_start();
include 'config.php';

// Fetch disbursement photos
$result = $conn->query("SELECT * FROM disbursements ORDER BY uploaded_at DESC");
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Disbursement Records</title>
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <style>
        .photo-card {
            box-shadow: 0 2px 6px rgba(0, 0, 0, 0.1);
            margin-bottom: 20px;
            cursor: pointer;
            transition: transform 0.2s;
        }

        .photo-card:hover {
            transform: scale(1.02);
        }

        .photo-card img {
            width: 100%;
            height: 200px;
            object-fit: cover;
        }

        .photo-title {
            font-weight: bold;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }
    </style>
</head>

<body>

    <?php include 'navbar.php'; ?>

    <div class="container mt-4">
        <div class="d-flex justify-content-between align-items-center mb-3 flex-wrap">
            <h2 class="mb-2">Disbursement Records</h2>
            <?php if (isset($_SESSION['account_type']) && $_SESSION['account_type'] === 'admin'): ?>
                <a href="add_disbursement.php" class="btn btn-primary mb-2">Add Disbursement</a>
            <?php endif; ?>
        </div>

        <div class="row">
            <?php while ($row = $result->fetch_assoc()): ?>
                <div class="col-sm-6 col-md-4 col-lg-3">
                    <div class="card photo-card" data-bs-toggle="modal" data-bs-target="#viewModal<?php echo $row['id']; ?>">
                        <img src="uploads/disbursements/<?php echo htmlspecialchars($row['filename']); ?>" class="card-img-top" alt="Disbursement Photo">
                        <div class="card-body">
                            <p class="photo-title mb-1"><?php echo htmlspecialchars($row['title']); ?></p>
                            <small class="text-muted">Uploaded: <?php echo date('M j, Y', strtotime($row['uploaded_at'])); ?></small>

                            <?php if (isset($_SESSION['account_type']) && $_SESSION['account_type'] === 'admin'): ?>
                                <div class="mt-2">
                                    <a href="edit_disbursement.php?id=<?php echo $row['id']; ?>" class="btn btn-sm btn-info">Edit</a>
                                    <a href="delete_disbursement.php?id=<?php echo $row['id']; ?>" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure you want to delete this photo?');">Delete</a>
                                </div>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>

                <!-- Modal for Viewing Full Image -->
                <div class="modal fade" id="viewModal<?php echo $row['id']; ?>" tabindex="-1" aria-labelledby="viewModalLabel<?php echo $row['id']; ?>" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered modal-lg">
                        <div class="modal-content">
                            <div class="modal-body p-0">
                                <img src="uploads/disbursements/<?php echo htmlspecialchars($row['filename']); ?>" class="img-fluid w-100" alt="Disbursement Full View">
                            </div>
                            <div class="modal-footer">
                                <h5 class="me-auto"><?php echo htmlspecialchars($row['title']); ?></h5>
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                            </div>
                        </div>
                    </div>
                </div>

            <?php endwhile; ?>
        </div>
    </div>

    <?php include 'footer.php'; ?>
    <script src="js/bootstrap.bundle.min.js"></script>
</body>

</html>