<?php
session_start();
// Jika sudah login, redirect ke dashboard
if (isset($_SESSION['user'])) {
    header("Location: dashboard.php");
    exit();
}
// Jika ada cookie "remember me", set session dan redirect
if (isset($_COOKIE['user_email'])) {
    $_SESSION['user'] = $_COOKIE['user_email'];
    header("Location: dashboard.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Login - Mid Project BNCC</title>
  <!-- Gunakan Bootstrap CDN -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="../assets/css/style.css">
</head>
<body class="bg-gradient-primary">
  <div class="container">
    <div class="row justify-content-center align-items-center vh-100">
      <div class="col-md-6">
        <div class="card shadow-lg">
          <div class="card-body p-5">
            <h3 class="card-title mb-4 text-center">Login to Your Account</h3>
            <form action="../actions/login_action.php" method="POST">
              <div class="mb-3">
                <label for="email" class="form-label">Email Address</label>
                <input type="email" name="email" id="email" class="form-control" placeholder="Enter email" required>
              </div>
              <div class="mb-3">
                <label for="password" class="form-label">Password</label>
                <input type="password" name="password" id="password" class="form-control" placeholder="Enter password" required>
              </div>
              <div class="form-check mb-3">
                <input class="form-check-input" type="checkbox" name="remember" id="remember">
                <label class="form-check-label" for="remember">Remember Me</label>
              </div>
              <div class="d-grid">
                <button type="submit" class="btn btn-primary">Login</button>
              </div>
            </form>
          </div>
        </div>
        <div class="text-center mt-3 text-white">
          <small>&copy; <?php echo date("Y"); ?> BNCC LnT Back End Development</small>
        </div>
      </div>
    </div>
  </div>
  <!-- Bootstrap JS -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>