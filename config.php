<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "amc_csc";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

date_default_timezone_set('Asia/Manila');

?>