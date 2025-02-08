<?php
session_start();
if (!isset($_SESSION['user'])) {
    header("Location: ../pages/login.php");
    exit();
}
include '../config/database.php';

if (!isset($_POST['id'])) {
    echo "Invalid request.";
    exit();
}

$id = $conn->real_escape_string($_POST['id']);
$sql = "DELETE FROM users WHERE id='$id'";
if ($conn->query($sql) === TRUE) {
    header("Location: ../pages/dashboard.php");
    exit();
} else {
    echo "Error deleting user: " . $conn->error;
}
?>
