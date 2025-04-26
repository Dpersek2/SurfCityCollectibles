<?php
session_start();
require_once 'config.php'; // Include database connection

// If already logged in, redirect to admin panel
if (isset($_SESSION['admin'])) {
    header('Location: admin_panel.php');
    exit();
}

// Handle login form submission
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Prepare and execute query
    $stmt = $conn->prepare("SELECT * FROM admins WHERE username = ?");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows === 1) {
        $admin = $result->fetch_assoc();
        // For now using plain password (later we hash it)
        if ($password === $admin['password']) {
            $_SESSION['admin'] = $admin['username'];
            header('Location: admin_panel.php');
            exit();
        } else {
            $error = "Incorrect password.";
        }
    } else {
        $error = "Admin user not found.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Admin Login - SurfCity Collectibles</title>
  <link rel="stylesheet" href="style.css">
</head>
<body>

  <h1 style="text-align:center; margin-top:2rem;">Admin Login</h1>

  <?php if (isset($error)): ?>
    <p style="color:red; text-align:center;"><?php echo $error; ?></p>
  <?php endif; ?>

  <form method="post" style="max-width:300px; margin:2rem auto;">
    <input type="text" name="username" placeholder="Username" required style="width:100%; padding:0.5rem; margin-bottom:1rem;"><br>
    <input type="password" name="password" placeholder="Password" required style="width:100%; padding:0.5rem; margin-bottom:1rem;"><br>
    <button type="submit" style="width:100%; padding:0.5rem;">Login</button>
  </form>

</body>
</html>
