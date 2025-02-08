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
  <title>Delete User - Mid Project BNCC</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="../assets/css/style.css">
</head>
<body>
  <!-- Navbar -->
  <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <div class="container-fluid">
      <a class="navbar-brand" href="#">BNCC Admin</a>
      <div class="collapse navbar-collapse" id="navbarNav">
        <ul class="navbar-nav ms-auto">
          <li class="nav-item"><a class="nav-link" href="dashboard.php">Dashboard</a></li>
          <li class="nav-item"><a class="nav-link" href="profile.php">Profile</a></li>
          <li class="nav-item"><a class="nav-link" href="../actions/logout_action.php">Logout</a></li>
        </ul>
      </div>
    </div>
  </nav>
  
  <!-- Konfirmasi Hapus -->
  <div class="container mt-5">
    <div class="card mx-auto" style="max-width: 500px;">
      <div class="card-body text-center">
        <h3 class="card-title mb-4">Delete User</h3>
        <p>Are you sure you want to delete the following user?</p>
        <ul class="list-group mb-4">
          <li class="list-group-item"><strong>Full Name:</strong> <?php echo htmlspecialchars($user['first_name'].' '.$user['last_name']); ?></li>
          <li class="list-group-item"><strong>Email:</strong> <?php echo htmlspecialchars($user['email']); ?></li>
        </ul>
        <form action="../actions/delete_action.php" method="POST">
          <input type="hidden" name="id" value="<?php echo $user['id']; ?>">
          <div class="d-grid gap-2">
            <button type="submit" class="btn btn-danger">Yes, Delete</button>
            <a href="dashboard.php" class="btn btn-secondary">Cancel</a>
          </div>
        </form>
      </div>
    </div>
  </div>
  
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>