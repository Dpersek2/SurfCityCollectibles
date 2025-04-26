<?php
session_start();
require_once 'config.php';

// Handle Registration Form Submission
if (isset($_POST['register'])) {
    $username = trim($_POST['username']);
    $email = trim($_POST['email']);
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];

    // Check if passwords match
    if ($password !== $confirm_password) {
        $error = "Passwords do not match.";
    } else {
        // Check if username or email already exists
        $stmt = $conn->prepare("SELECT id FROM users WHERE username = ? OR email = ?");
        $stmt->bind_param("ss", $username, $email);
        $stmt->execute();
        $stmt->store_result();
        
        if ($stmt->num_rows > 0) {
            $error = "Username or email already taken.";
        } else {
            // Password Hashing
            $hashed_password = password_hash($password, PASSWORD_DEFAULT);

            // Insert new user
            $insert_stmt = $conn->prepare("INSERT INTO users (username, email, password) VALUES (?, ?, ?)");
            $insert_stmt->bind_param("sss", $username, $email, $hashed_password);
            $insert_stmt->execute();

            $_SESSION['user'] = $username; // Log the user in after registering
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
<body>

<?php include 'navbar.php'; ?>

<main class="p-8 max-w-md mx-auto">
  <h1 class="text-3xl font-bold text-center mb-8">Create an Account</h1>

  <?php if (isset($error)): ?>
    <div class="bg-red-100 text-red-700 p-4 rounded mb-6"><?php echo $error; ?></div>
  <?php endif; ?>

  <form method="post" action="register.php" class="space-y-4">

    <input type="text" name="username" placeholder="Username" required class="border p-2 w-full rounded">
    <input type="email" name="email" placeholder="Email Address" required class="border p-2 w-full rounded">
    <input type="password" name="password" placeholder="Password" required class="border p-2 w-full rounded">
    <input type="password" name="confirm_password" placeholder="Confirm Password" required class="border p-2 w-full rounded">

    <button type="submit" name="register" class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-2 rounded w-full">
      Register
    </button>
  </form>

  <div class="text-center mt-4">
    <p>Already have an account? <a href="login.php" class="text-blue-600 hover:underline">Login here</a>.</p>
  </div>

</main>

<footer class="text-center bg-blue-600 text-white p-4 mt-8">
  &copy; 2025 SurfCity Collectibles. All rights reserved.
</footer>

</body>
</html>
