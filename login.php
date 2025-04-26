<?php
session_start();
require_once 'config.php';

// Handle Login Form Submission
if (isset($_POST['login'])) {
    $username_or_email = trim($_POST['username_or_email']);
    $password = $_POST['password'];

    // Check if user exists
    $stmt = $conn->prepare("SELECT id, username, password FROM users WHERE username = ? OR email = ?");
    $stmt->bind_param("ss", $username_or_email, $username_or_email);
    $stmt->execute();
    $result = $stmt->get_result();
    $user = $result->fetch_assoc();

    if ($user && password_verify($password, $user['password'])) {
        // Password correct, log user in
        $_SESSION['user'] = $user['username'];
        header('Location: index.php');
        exit();
    } else {
        $error = "Invalid username/email or password.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Login - SurfCity Collectibles</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <link rel="stylesheet" href="style.css">
</head>
<body>

<?php include 'navbar.php'; ?>

<main class="p-8 max-w-md mx-auto">
  <h1 class="text-3xl font-bold text-center mb-8">Login to Your Account</h1>

  <?php if (isset($error)): ?>
    <div class="bg-red-100 text-red-700 p-4 rounded mb-6"><?php echo $error; ?></div>
  <?php endif; ?>

  <form method="post" action="login.php" class="space-y-4">

    <input type="text" name="username_or_email" placeholder="Username or Email" required class="border p-2 w-full rounded">
    <input type="password" name="password" placeholder="Password" required class="border p-2 w-full rounded">

    <button type="submit" name="login" class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-2 rounded w-full">
      Login
    </button>
  </form>

  <div class="text-center mt-4">
    <p>Don't have an account yet? <a href="register.php" class="text-blue-600 hover:underline">Register here</a>.</p>
  </div>

</main>

<footer class="text-center bg-blue-600 text-white p-4 mt-8">
  &copy; 2025 SurfCity Collectibles. All rights reserved.
</footer>

</body>
</html>
