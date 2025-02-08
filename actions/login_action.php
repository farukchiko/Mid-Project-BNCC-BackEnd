<?php
session_start();
include '../config/database.php';

if (isset($_POST['email']) && isset($_POST['password'])) {
    // Pastikan menghapus spasi yang tidak diinginkan dan ubah email ke huruf kecil
    $email = strtolower(trim($_POST['email']));
    $password = md5(trim($_POST['password']));  // Hash password dengan MD5

    // Debugging: Uncomment baris berikut jika perlu melihat nilai email dan password hash
    // echo "Email: $email<br>Password Hash: $password<br>";

    // Gunakan LOWER(email) dalam query untuk memastikan perbandingan tidak case-sensitive
    $sql = "SELECT * FROM users WHERE LOWER(email)='$email' AND password='$password'";
    $result = $conn->query($sql);

    if ($result && $result->num_rows == 1) {
        $_SESSION['user'] = $email;
        // Jika opsi "Remember Me" dipilih, simpan cookie selama 7 hari
        if (isset($_POST['remember'])) {
            setcookie("user_email", $email, time() + (86400 * 7), "/");
        }
        header("Location: ../pages/dashboard.php");
        exit();
    } else {
        echo "Login failed! Invalid email or password.";
    }
} else {
    echo "Please fill in all required fields.";
}
?>
