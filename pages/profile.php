<?php
session_start();
if (!isset($_SESSION['user'])) {
    header("Location: login.php");
    exit();
}
include '../config/database.php';

$email = $_SESSION['user'];
$sql = "SELECT * FROM users WHERE email='$email'";
$result = $conn->query($sql);
$admin = $result->fetch_assoc();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Profile - Mid Project BNCC</title>
    <link rel="stylesheet" href="../assets/css/bootstrap.min.css">
</head>
<body>
<nav class="navbar navbar-expand-lg navbar-light bg-light">
  <div class="container-fluid">
    <a class="navbar-brand" href="#">BNCC Admin</a>
    <div class="collapse navbar-collapse" id="navbarNav">
      <ul class="navbar-nav">
        <li class="nav-item"><a class="nav-link" href="dashboard.php">Dashboard</a></li>
        <li class="nav-item"><a class="nav-link active" href="profile.php">Profile</a></li>
        <li class="nav-item"><a class="nav-link" href="../actions/logout_action.php">Logout</a></li>
      </ul>
    </div>
  </div>
</nav>
<div class="container mt-4">
    <h2>Profile</h2>
    <div class="card" style="width: 18rem;">
        <?php $photo = $admin['photo'] ? '../assets/images/' . $admin['photo'] : '../assets/images/default.png'; ?>
        <img src="<?php echo $photo; ?>" class="card-img-top" alt="Admin Photo">
        <div class="card-body">
            <h5 class="card-title"><?php echo htmlspecialchars($admin['first_name'] . ' ' . $admin['last_name']); ?></h5>
            <p class="card-text">Email: <?php echo htmlspecialchars($admin['email']); ?></p>
            <p class="card-text">Bio: <?php echo htmlspecialchars($admin['bio']); ?></p>
        </div>
    </div>
    <a href="../actions/logout_action.php" class="btn btn-danger mt-3">Logout</a>
</div>
<script src="../assets/js/bootstrap.bundle.min.js"></script>
</body>
</html>
