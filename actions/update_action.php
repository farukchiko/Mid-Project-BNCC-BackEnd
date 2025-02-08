<?php
session_start();
if (!isset($_SESSION['user'])) {
    header("Location: ../pages/login.php");
    exit();
}
include '../config/database.php';

if (!isset($_POST['id']) || empty($_POST['first_name']) || empty($_POST['last_name']) || empty($_POST['email'])) {
    echo "All fields except bio are required.";
    exit();
}

$id         = $conn->real_escape_string($_POST['id']);
$first_name = $conn->real_escape_string(trim($_POST['first_name']));
$last_name  = $conn->real_escape_string(trim($_POST['last_name']));
$email      = trim($_POST['email']);
if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    echo "Invalid email format.";
    exit();
}
$bio = isset($_POST['bio']) ? $conn->real_escape_string(trim($_POST['bio'])) : '';

// Cek duplikat email untuk user lain
$sql = "SELECT * FROM users WHERE email='$email' AND id != '$id'";
$result = $conn->query($sql);
if ($result && $result->num_rows > 0) {
    echo "Email already exists.";
    exit();
}

// Dapatkan data user saat ini
$sql = "SELECT * FROM users WHERE id='$id'";
$result = $conn->query($sql);
$user = $result->fetch_assoc();
if (!$user) {
    echo "User not found.";
    exit();
}

$photo_name = $user['photo']; // Gunakan foto lama jika tidak ada perubahan
if (isset($_FILES['photo']) && $_FILES['photo']['error'] == 0) {
    $target_dir = "../assets/images/";
    $new_photo_name = basename($_FILES['photo']['name']);
    $target_file = $target_dir . $new_photo_name;
    if (file_exists($target_file)) {
        $new_photo_name = uniqid() . "_" . $new_photo_name;
        $target_file = $target_dir . $new_photo_name;
    }
    if (!move_uploaded_file($_FILES['photo']['tmp_name'], $target_file)) {
        echo "Failed to upload new photo.";
        exit();
    }
    $photo_name = $new_photo_name;
}

$sql = "UPDATE users SET first_name='$first_name', last_name='$last_name', email='$email', bio='$bio', photo='$photo_name' WHERE id='$id'";
if ($conn->query($sql) === TRUE) {
    header("Location: ../pages/dashboard.php");
    exit();
} else {
    echo "Error updating record: " . $conn->error;
}
?>
