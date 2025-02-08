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
    <link rel="stylesheet" href="../assets/css/bootstrap.min.css">
</head>
<body>
<nav class="navbar navbar-expand-lg navbar-light bg-light">
  <div class="container-fluid">
    <a class="navbar-brand" href="#">BNCC Admin</a>
    <div class="collapse navbar-collapse" id="navbarNav">
      <ul class="navbar-nav">
        <li class="nav-item"><a class="nav-link active" href="dashboard.php">Dashboard</a></li>
        <li class="nav-item"><a class="nav-link" href="profile.php">Profile</a></li>
        <li class="nav-item"><a class="nav-link" href="../actions/logout_action.php">Logout</a></li>
      </ul>
    </div>
  </div>
</nav>
<div class="container mt-4">
    <h2>Dashboard</h2>
    <form method="GET" class="mb-3">
        <div class="input-group">
            <input type="text" name="search" class="form-control" placeholder="Search user by name or email" value="<?php echo htmlspecialchars($search); ?>">
            <button type="submit" class="btn btn-outline-secondary">Search</button>
        </div>
    </form>
    <table class="table table-bordered">
        <thead>
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
                echo "<td><img src='$photo' alt='User Photo' style='width:50px; height:50px; object-fit:cover;'></td>";
                echo "<td>" . htmlspecialchars($row['first_name'] . ' ' . $row['last_name']) . "</td>";
                echo "<td>" . htmlspecialchars($row['email']) . "</td>";
                echo "<td>
                        <a class='btn btn-info btn-sm' href='detail.php?id=" . $row['id'] . "'>View</a>
                        <a class='btn btn-warning btn-sm' href='update.php?id=" . $row['id'] . "'>Edit</a>
                        <a class='btn btn-danger btn-sm' href='delete.php?id=" . $row['id'] . "'>Delete</a>
                      </td>";
                echo "</tr>";
            }
        ?>
        </tbody>
    </table>
    <a href="create.php" class="btn btn-primary">Add New User</a>
</div>
<script src="../assets/js/bootstrap.bundle.min.js"></script>
</body>
</html>
