<?php
session_start();
if (!isset($_SESSION['user'])) {
    header("Location: login.php");
    exit();
}
include '../config/database.php';

if (!isset($_GET['id'])) {
    header("Location: dashboard.php");
    exit();
}

$id = $conn->real_escape_string($_GET['id']);
$sql = "SELECT * FROM users WHERE id='$id'";
$result = $conn->query($sql);
$user = $result->fetch_assoc();
if (!$user) {
    echo "User not found!";
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>User Detail - Mid Project BNCC</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="../assets/css/style.css">
</head>
<body>
  <!-- Navbar -->
  <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <div class="container-fluid">
      <a class="navbar-brand" href="#">JAGO Admin</a>
      <div class="collapse navbar-collapse" id="navbarNav">
        <ul class="navbar-nav ms-auto">
          <li class="nav-item"><a class="nav-link" href="dashboard.php">Dashboard</a></li>
          <li class="nav-item"><a class="nav-link" href="profile.php">Profile</a></li>
          <li class="nav-item"><a class="nav-link" href="../actions/logout_action.php">Logout</a></li>
        </ul>
      </div>
    </div>
  </nav>
  
  <!-- Konten Detail -->
  <div class="container mt-5">
    <div class="card mx-auto" style="max-width: 400px;">
      <div class="card-body text-center">
        <?php $photo = $user['photo'] ? '../assets/images/' . $user['photo'] : '../assets/images/default.png'; ?>
        <img src="<?php echo $photo; ?>" alt="User Photo" class="rounded-circle mb-3" style="width:150px; height:150px; object-fit:cover;">
        <h4 class="card-title"><?php echo htmlspecialchars($user['first_name'] . ' ' . $user['last_name']); ?></h4>
        <p class="card-text"><?php echo htmlspecialchars($user['email']); ?></p>
        <p class="card-text"><?php echo htmlspecialchars($user['bio']); ?></p>
        <a href="dashboard.php" class="btn btn-secondary">Back to Dashboard</a>
      </div>
    </div>
  </div>
  
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>