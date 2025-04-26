<?php
session_start();
require_once 'config.php';

// Handle Login
if (isset($_POST['login'])) {
    $username_or_email = trim($_POST['username_or_email']);
    $password = $_POST['password'];

    $stmt = $conn->prepare("SELECT id, username, password FROM users WHERE username = ? OR email = ?");
    $stmt->bind_param("ss", $username_or_email, $username_or_email);
    $stmt->execute();
    $result = $stmt->get_result();
    $user = $result->fetch_assoc();

    if ($user && password_verify($password, $user['password'])) {
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
<body class="bg-[#FAF3E0] text-[#333333]">

<?php include 'navbar.php'; ?>

<main class="p-8 md:p-16 max-w-md mx-auto text-center">

  <h1 class="text-4xl font-bold mb-8">Login to Your Account</h1>

  <?php if (isset($error)): ?>
    <div class="bg-red-100 text-red-700 p-4 rounded mb-6"><?php echo $error; ?></div>
  <?php endif; ?>

  <form method="post" action="login.php" class="space-y-6">

    <input type="text" name="username_or_email" placeholder="Username or Email" required class="border p-3 w-full rounded">
    <input type="password" name="password" placeholder="Password" required class="border p-3 w-full rounded">

    <button type="submit" name="login" class="bg-[#F4A261] hover:bg-[#e88d3b] text-white font-bold px-6 py-3 rounded-full w-full shadow-md">
      Login
    </button>

  </form>

  <div class="text-center mt-6">
    <p>Don't have an account? <a href="register.php" class="text-[#2A9D8F] font-bold hover:underline">Register here</a>.</p>
  </div>

</main>

<footer class="bg-[#247A73] text-white text-center p-4 mt-16">
  &copy; 2025 SurfCity Collectibles. All rights reserved.
  <br>
  <a href="index.php" class="underline hover:text-gray-200">Home</a> |
  <a href="shop.php" class="underline hover:text-gray-200">Shop</a> |
  <a href="cart.php" class="underline hover:text-gray-200">Cart</a>
</footer>

</body>
</html>
