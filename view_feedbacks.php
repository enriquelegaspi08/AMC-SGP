<?php
session_start();
include 'config.php';

if (!isset($_SESSION['account_type']) || $_SESSION['account_type'] !== 'admin') {
    header('Location: index.php');
    exit();
}

// Handle response submission
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['feedback_id'], $_POST['response'])) {
    $feedback_id = intval($_POST['feedback_id']);
    $response = trim($_POST['response']);
    $stmt = $conn->prepare("UPDATE feedbacks SET response = ?, responded_at = NOW() WHERE id = ?");
    $stmt->bind_param("si", $response, $feedback_id);
    $stmt->execute();
}

$result = $conn->query("SELECT * FROM feedbacks ORDER BY created_at DESC");
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>View Feedbacks</title>
    <link href="css/bootstrap.min.css" rel="stylesheet">
</head>

<body>

    <?php include 'navbar.php'; ?>

    <div class="container mt-5">
        <h2 class="mb-4">Feedbacks</h2>
        <?php if ($result->num_rows > 0): ?>
            <div class="table-responsive">
                <table class="table table-bordered table-hover align-middle text-center">
                    <thead class="table-success">
                        <tr>
                            <th>#</th>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Message</th>
                            <th>Date Sent</th>
                            <th>Response</th>
                            <th>Action/Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $count = 1; ?>
                        <?php while ($row = $result->fetch_assoc()): ?>
                            <tr>
                                <td><?= $count++; ?></td>
                                <td><?= htmlspecialchars($row['name']); ?></td>
                                <td><?= htmlspecialchars($row['email']); ?></td>
                                <td><?= nl2br(htmlspecialchars($row['message'])); ?></td>
                                <td><?= date('F j, Y g:i A', strtotime($row['created_at'])); ?></td>
                                <td>
                                    <?php if (!empty($row['response'])): ?>
                                        <?= nl2br(htmlspecialchars($row['response'])); ?>
                                    <?php else: ?>
                                        <span class="text-muted">Pending</span>
                                    <?php endif; ?>
                                </td>
                                <td>
                                    <?php if (empty($row['response'])): ?>
                                        <button class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#respondModal<?= $row['id'] ?>">Respond</button>

                                        <!-- Modal -->
                                        <div class="modal fade" id="respondModal<?= $row['id'] ?>" tabindex="-1" aria-labelledby="respondModalLabel<?= $row['id'] ?>" aria-hidden="true">
                                            <div class="modal-dialog">
                                                <form method="POST" class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title" id="respondModalLabel<?= $row['id'] ?>">Respond to Feedback</h5>
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <p><strong>From:</strong> <?= htmlspecialchars($row['name']); ?> (<?= htmlspecialchars($row['email']); ?>)</p>
                                                        <p><strong>Message:</strong><br><?= nl2br(htmlspecialchars($row['message'])); ?></p>
                                                        <div class="mb-3">
                                                            <label for="response" class="form-label">Your Response</label>
                                                            <textarea name="response" class="form-control" rows="4" required></textarea>
                                                            <input type="hidden" name="feedback_id" value="<?= $row['id'] ?>">
                                                        </div>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="submit" class="btn btn-success">Send Response</button>
                                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    <?php else: ?>
                                        <span class="badge bg-success">Responded</span>
                                    <?php endif; ?>
                                </td>
                            </tr>
                        <?php endwhile; ?>
                    </tbody>
                </table>
            </div>
        <?php else: ?>
            <div class="alert alert-info">No feedbacks submitted yet.</div>
        <?php endif; ?>
    </div>

    <?php include 'footer.php'; ?>
    <script src="js/bootstrap.bundle.min.js"></script>
</body>

</html>