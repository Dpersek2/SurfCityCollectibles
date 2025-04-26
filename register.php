<?php
session_start();
require_once 'config.php';

// Handle Registration
if (isset($_POST['register'])) {
    $username = trim($_POST['username']);
    $email = trim($_POST['email']);
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];

    if ($password !== $confirm_password) {
        $error = "Passwords do not match.";
    } else {
        $stmt = $conn->prepare("SELECT id FROM users WHERE username = ? OR email = ?");
        $stmt->bind_param("ss", $username, $email);
        $stmt->execute();
        $stmt->store_result();
        
        if ($stmt->num_rows > 0) {
            $error = "Username or email already taken.";
        } else {
            $hashed_password = password_hash($password, PASSWORD_DEFAULT);
            $insert_stmt = $conn->prepare("INSERT INTO users (username, email, password) VALUES (?, ?, ?)");
            $insert_stmt->bind_param("sss", $username, $email, $hashed_password);
            $insert_stmt->execute();

            $_SESSION['user'] = $username;
            header('Location: index.php');
            exit();
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Register - SurfCity Collectibles</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <link rel="stylesheet" href="style.css">
</head>
<body class="bg-[#FAF3E0] text-[#333333]">

<?php include 'navbar.php'; ?>

<main class="p-8 md:p-16 max-w-md mx-auto text-center">

  <h1 class="text-4xl font-bold mb-8">Create an Account</h1>

  <?php if (isset($error)): ?>
    <div class="bg-red-100 text-red-700 p-4 rounded mb-6"><?php echo $error; ?></div>
  <?php endif; ?>

  <form method="post" action="register.php" class="space-y-6">

    <input type="text" name="username" placeholder="Username" required class="border p-3 w-full rounded">
    <input type="email" name="email" placeholder="Email Address" required class="border p-3 w-full rounded">
    <input type="password" name="password" placeholder="Password" required class="border p-3 w-full rounded">
    <input type="password" name="confirm_password" placeholder="Confirm Password" required class="border p-3 w-full rounded">

    <button type="submit" name="register" class="bg-[#F4A261] hover:bg-[#e88d3b] text-white font-bold px-6 py-3 rounded-full w-full shadow-md">
      Register
    </button>

  </form>

  <div class="text-center mt-6">
    <p>Already have an account? <a href="login.php" class="text-[#2A9D8F] font-bold hover:underline">Login here</a>.</p>
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
