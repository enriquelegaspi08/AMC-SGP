<?php
session_start();
include 'config.php';

$search = $_GET['search'] ?? '';
$year = $_GET['year_level'] ?? '';
$major = $_GET['major'] ?? '';

$sql = "SELECT * FROM collections WHERE 1=1";

if (!empty($search)) {
    $sql .= " AND student_name LIKE '%" . $conn->real_escape_string($search) . "%'";
}
if (!empty($year)) {
    $sql .= " AND year_level = '" . $conn->real_escape_string($year) . "'";
}
if (!empty($major)) {
    $sql .= " AND major = '" . $conn->real_escape_string($major) . "'";
}

$sql .= " ORDER BY school_year DESC, year_level ASC, major ASC, student_name ASC";

$result = $conn->query($sql);

if ($result->num_rows > 0):
?>

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
                    <?php if ($_SESSION['account_type'] === 'admin'): ?>
                        <th>Actions</th>
                    <?php endif; ?>
                </tr>
            </thead>
            <tbody>
                <?php $count = 1;
                while ($row = $result->fetch_assoc()): ?>
                    <tr>
                        <td><?= $count++ ?></td>
                        <td><?= htmlspecialchars($row['year_level']) ?></td>
                        <td><?= htmlspecialchars($row['major']) ?></td>
                        <td><?= htmlspecialchars($row['student_name']) ?></td>
                        <td>₱<?= number_format($row['membership_fee'], 2) ?></td>
                        <td>₱<?= number_format($row['acquaintance_contribution'], 2) ?></td>
                        <td>₱<?= number_format($row['sportsfest_contribution'], 2) ?></td>
                        <td>₱<?= number_format($row['sanction'], 2) ?></td>
                        <td><?= htmlspecialchars($row['school_year']) ?></td>
                        <?php if ($_SESSION['account_type'] === 'admin'): ?>
                            <td>
                                <a href="edit_collection.php?id=<?= $row['id'] ?>" class="btn btn-sm btn-info">Update</a>
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