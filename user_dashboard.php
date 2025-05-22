<?php
session_start();
include 'config.php';

// Redirect if not logged in or not a regular user
if (!isset($_SESSION['user_id']) || $_SESSION['account_type'] !== 'student') {
    header("Location: login.php");
    exit();
}

$user_name = $_SESSION['full_name'];

// Dummy fee/collection logic (replace with actual query)
$stud_id = $_SESSION['stud_id'] ?? null;

if (!$stud_id) {
    die("Student ID not found in session.");
}

// Use prepared statements to avoid SQL injection (recommended)
$stmt = $conn->prepare("SELECT membership_fee, acquaintance_contribution, sportsfest_contribution, sanction FROM collections WHERE stud_id = ?");
$stmt->bind_param("i", $stud_id);
$stmt->execute();
$fee_result = $stmt->get_result();
$fees = $fee_result->fetch_assoc();

// Get user's feedback & response
$feedbacks_stmt = $conn->prepare("SELECT * FROM feedbacks WHERE stud_id = ? ORDER BY created_at DESC");
$feedbacks_stmt->bind_param("i", $stud_id); // 'i' stands for integer
$feedbacks_stmt->execute();
$feedbacks_result = $feedbacks_stmt->get_result();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>User Dashboard</title>
    <link href="css/bootstrap.min.css" rel="stylesheet">
</head>

<body>

    <?php include 'navbar.php'; ?>

    <div class="container mt-5">
        <h2 class="mb-4">Welcome, <?= htmlspecialchars($user_name); ?>!</h2>

        <!-- Fee Summary -->
        <div class="card mb-4">
            <div class="card-header bg-success text-white">Fees and Collections Summary</div>
            <div class="card-body">
                <p><strong>Membership Fee:</strong> ₱<?= number_format($fees['membership_fee'] ?? 0, 2); ?></p>
                <p><strong>Acquaintance Contribution:</strong> ₱<?= number_format($fees['acquaintance_contribution'] ?? 0, 2); ?></p>
                <p><strong>Sportsfest Contribution:</strong> ₱<?= number_format($fees['sportsfest_contribution'] ?? 0, 2); ?></p>
                <p><strong>Sanction:</strong> ₱<?= number_format($fees['sanction'] ?? 0, 2); ?></p>
            </div>
        </div>

        <!-- Feedback and Response Section -->
        <div class="card">
            <div class="card-header bg-success text-white">Your Feedback & Admin Response</div>
            <div class="card-body">
                <?php if ($feedbacks_result->num_rows > 0): ?>
                    <table class="table table-bordered table-hover">
                        <thead class="table-light">
                            <tr>
                                <th>Message</th>
                                <th>Date Sent</th>
                                <th>Response</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php while ($f = $feedbacks_result->fetch_assoc()): ?>
                                <tr>
                                    <td><?= nl2br(htmlspecialchars($f['message'])); ?></td>
                                    <td><?= date('F j, Y g:i A', strtotime($f['created_at'])); ?></td>
                                    <td>
                                        <?php if (!empty($f['response'])): ?>
                                            <?= nl2br(htmlspecialchars($f['response'])); ?>
                                        <?php else: ?>
                                            <span class="text-muted">No response yet</span>
                                        <?php endif; ?>
                                    </td>
                                </tr>
                            <?php endwhile; ?>
                        </tbody>
                    </table>
                <?php else: ?>
                    <p class="text-muted">You have not submitted any feedback yet.</p>
                <?php endif; ?>
            </div>
        </div>
    </div>

    <?php include 'footer.php'; ?>
    <script src="js/bootstrap.bundle.min.js"></script>
</body>

</html>