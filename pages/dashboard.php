<?php
session_start();
if (!isset($_SESSION['user'])) {
    header("Location: login.php");
    exit();
}
include '../config/database.php';

$search = "";
if (isset($_GET['search'])) {
    $search = $conn->real_escape_string(trim($_GET['search']));
    $sql = "SELECT * FROM users WHERE email != 'adminBNCC@gmail.com' 
            AND (CONCAT(first_name, ' ', last_name) LIKE '%$search%' OR email LIKE '%$search%')";
} else {
    $sql = "SELECT * FROM users WHERE email != 'adminBNCC@gmail.com'";
}

$result = $conn->query($sql);
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Dashboard - Mid Project BNCC</title>
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
          <li class="nav-item"><a class="nav-link active" href="dashboard.php">Dashboard</a></li>
          <li class="nav-item"><a class="nav-link" href="profile.php">Profile</a></li>
          <li class="nav-item"><a class="nav-link" href="../actions/logout_action.php">Logout</a></li>
        </ul>
      </div>
    </div>
  </nav>
  
  <!-- Konten -->
  <div class="container mt-5">
    <h2 class="mb-4">User Dashboard</h2>
    <div class="card mb-4">
      <div class="card-body">
        <form method="GET" class="row g-3">
          <div class="col-md-10">
            <input type="text" name="search" class="form-control" placeholder="Search user by name or email" value="<?php echo htmlspecialchars($search); ?>">
          </div>
          <div class="col-md-2">
            <button class="btn btn-primary w-100" type="submit">Search</button>
          </div>
        </form>
      </div>
    </div>
    <div class="table-responsive">
      <table class="table table-striped table-hover align-middle">
        <thead class="table-dark">
          <tr>
            <th>No</th>
            <th>Photo</th>
            <th>Full Name</th>
            <th>Email</th>
            <th>Action</th>
          </tr>
        </thead>
        <tbody>
          <?php
            $i = 1;
            while ($row = $result->fetch_assoc()) {
              echo "<tr>";
              echo "<td>" . $i++ . "</td>";
              $photo = $row['photo'] ? '../assets/images/' . $row['photo'] : '../assets/images/default.png';
              echo "<td><img src='$photo' alt='User Photo' class='img-thumbnail' style='width:50px; height:50px; object-fit:cover;'></td>";
              echo "<td>" . htmlspecialchars($row['first_name'] . ' ' . $row['last_name']) . "</td>";
              echo "<td>" . htmlspecialchars($row['email']) . "</td>";
              echo "<td>
                      <a href='detail.php?id=" . $row['id'] . "' class='btn btn-info btn-sm'>View</a>
                      <a href='update.php?id=" . $row['id'] . "' class='btn btn-warning btn-sm'>Edit</a>
                      <a href='delete.php?id=" . $row['id'] . "' class='btn btn-danger btn-sm'>Delete</a>
                    </td>";
              echo "</tr>";
            }
          ?>
        </tbody>
      </table>
    </div>
    <div class="mt-4">
      <a href="create.php" class="btn btn-success">Add New User</a>
    </div>
  </div>
  
  <!-- Footer -->
  <footer class="footer text-center text-white">
    <small>&copy; <?php echo date("Y"); ?> BNCC LnT Back End Development. All rights reserved.</small>
  </footer>
  
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>