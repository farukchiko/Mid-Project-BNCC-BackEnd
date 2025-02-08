<?php
session_start();
if (!isset($_SESSION['user'])) {
    header("Location: login.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Create User - Mid Project BNCC</title>
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
  
  <!-- Form Create User -->
  <div class="container mt-5">
    <div class="card mx-auto" style="max-width: 600px;">
      <div class="card-body">
        <h3 class="card-title mb-4 text-center">Create New User</h3>
        <form action="../actions/create_action.php" method="POST" enctype="multipart/form-data">
          <div class="mb-3">
            <label for="photo" class="form-label">Photo <span class="text-danger">*</span></label>
            <input type="file" name="photo" id="photo" class="form-control" accept="image/*" required>
          </div>
          <div class="mb-3">
            <label for="first_name" class="form-label">First Name <span class="text-danger">*</span></label>
            <input type="text" name="first_name" id="first_name" class="form-control" maxlength="255" required>
          </div>
          <div class="mb-3">
            <label for="last_name" class="form-label">Last Name <span class="text-danger">*</span></label>
            <input type="text" name="last_name" id="last_name" class="form-control" maxlength="255" required>
          </div>
          <div class="mb-3">
            <label for="email" class="form-label">Email <span class="text-danger">*</span></label>
            <input type="email" name="email" id="email" class="form-control" required>
          </div>
          <div class="mb-3">
            <label for="bio" class="form-label">Bio</label>
            <textarea name="bio" id="bio" class="form-control" rows="3"></textarea>
          </div>
          <div class="d-grid">
            <button type="submit" class="btn btn-success">Create User</button>
          </div>
        </form>
      </div>
    </div>
  </div>
  
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>