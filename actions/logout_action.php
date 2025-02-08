<?php
session_start();
session_destroy();
setcookie("user_email", "", time() - 3600, "/"); // Hapus cookie
header("Location: ../pages/login.php");
exit();
?>
