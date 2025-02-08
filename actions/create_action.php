<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

session_start();
if (!isset($_SESSION['user'])) {
    header("Location: ../pages/login.php");
    exit();
}

error_reporting(E_ALL);
ini_set('display_errors', 1);

echo "Debug: Script create_action.php mulai berjalan.";

session_start();
if (!isset($_SESSION['user'])) {
    header("Location: ../pages/login.php");
    exit();
}
include '../config/database.php';

// Validasi field (selain bio)
if (empty($_POST['first_name']) || empty($_POST['last_name']) || empty($_POST['email'])) {
    echo "All fields except bio are required.";
    exit();
}

// Validasi email
$email = trim($_POST['email']);
if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    echo "Invalid email format.";
    exit();
}

// Cek apakah email sudah digunakan
$sql = "SELECT email FROM users WHERE email=?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $email);
$stmt->execute();
$stmt->store_result();
if ($stmt->num_rows > 0) {
    echo "Email already exists.";
    exit();
}
$stmt->close();

// Membersihkan input sebelum masuk ke database
$first_name = trim($_POST['first_name']);
$last_name  = trim($_POST['last_name']);
$bio        = isset($_POST['bio']) ? trim($_POST['bio']) : '';

// **PROSES UPLOAD FOTO**
if (!isset($_FILES['photo']) || $_FILES['photo']['error'] !== 0) {
    echo "Photo is required.";
    exit();
}

// Cek folder penyimpanan
$target_dir = "../assets/images/";
if (!is_dir($target_dir)) {
    mkdir($target_dir, 0777, true); // Buat folder jika belum ada
}

$photo_name = basename($_FILES["photo"]["name"]);
$target_file = $target_dir . $photo_name;
$imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

// **CEK JENIS FILE (Hanya gambar)**
$allowed_types = ['jpg', 'jpeg', 'png', 'gif'];
if (!in_array($imageFileType, $allowed_types)) {
    echo "Only JPG, JPEG, PNG, and GIF files are allowed.";
    exit();
}

// **CEK UKURAN FILE (Maksimal 2MB)**
if ($_FILES["photo"]["size"] > 2 * 1024 * 1024) {
    echo "File size should not exceed 2MB.";
    exit();
}

// Jika file sudah ada, buat nama unik
if (file_exists($target_file)) {
    $photo_name = uniqid() . "_" . $photo_name;
    $target_file = $target_dir . $photo_name;
}

// **Pindahkan file ke folder tujuan**
if (!move_uploaded_file($_FILES["photo"]["tmp_name"], $target_file)) {
    echo "Failed to upload photo.";
    exit();
}

// **GENERATE PASSWORD RANDOM (8 karakter)**
$random_password = substr(str_shuffle("0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ"), 0, 8);
$hashed_password = md5($random_password);

// **GENERATE ID USER**
$user_id = uniqid('U');

// **INSERT DATA KE DATABASE MENGGUNAKAN PREPARED STATEMENT**
$sql = "INSERT INTO users (id, first_name, last_name, email, password, bio, photo) VALUES (?, ?, ?, ?, ?, ?, ?)";
$stmt = $conn->prepare($sql);
$stmt->bind_param("sssssss", $user_id, $first_name, $last_name, $email, $hashed_password, $bio, $photo_name);

if ($stmt->execute()) {
    header("Location: ../pages/dashboard.php");
    exit();
} else {
    echo "Error: " . $conn->error;
}
$stmt->close();
$conn->close();
?>
