<?php
session_start();
include 'config.php';

// Ensure only admin can access this page
if (!isset($_SESSION['account_type']) || $_SESSION['account_type'] !== 'admin') {
    header("Location: disbursements.php");
    exit;
}

// Check for valid ID
if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    header("Location: disbursements.php");
    exit;
}

$id = (int)$_GET['id'];

// Fetch the file to delete
$stmt = $conn->prepare("SELECT filename FROM disbursements WHERE id = ?");
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();
$disbursement = $result->fetch_assoc();
$stmt->close();

if (!$disbursement) {
    header("Location: disbursements.php");
    exit;
}

// Delete the file from the server
$uploadDir = "uploads/disbursements/";
$filepath = $uploadDir . $disbursement['filename'];
if (file_exists($filepath)) {
    unlink($filepath);
}

// Delete record from database
$stmt = $conn->prepare("DELETE FROM disbursements WHERE id = ?");
$stmt->bind_param("i", $id);
$stmt->execute();
$stmt->close();

// Redirect back to disbursements page
header("Location: disbursements.php");
exit;
