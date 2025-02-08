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
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="../assets/css/style.css">
</head>
<body>
  <!-- Navbar -->
  <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <div class="container-fluid">
      <a class="navbar-brand" href="#">JAGO Admin</a>
      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" 
              aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse" id="navbarNav">
        <ul class="navbar-nav ms-auto">
          <li class="nav-item"><a class="nav-link" href="dashboard.php">Dashboard</a></li>
          <li class="nav-item"><a class="nav-link active" href="profile.php">Profile</a></li>
          <li class="nav-item"><a class="nav-link" href="../actions/logout_action.php">Logout</a></li>
        </ul>
      </div>
    </div>
  </nav>
  
  <!-- Konten Profil -->
  <div class="container mt-5">
    <div class="card mx-auto" style="max-width: 400px;">
      <div class="card-body text-center">
        <?php $photo = $admin['photo'] ? '../assets/images/' . $admin['photo'] : '../assets/images/default.png'; ?>
        <img src="<?php echo $photo; ?>" alt="Admin Photo" class="rounded-circle mb-3" style="width:150px; height:150px; object-fit:cover;">
        <h4 class="card-title"><?php echo htmlspecialchars($admin['first_name'] . ' ' . $admin['last_name']); ?></h4>
        <p class="card-text"><?php echo htmlspecialchars($admin['email']); ?></p>
        <p class="card-text"><?php echo htmlspecialchars($admin['bio']); ?></p>
        <a href="../actions/logout_action.php" class="btn btn-danger">Logout</a>
      </div>
    </div>
  </div>
  
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>