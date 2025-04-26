<?php
session_start();
require_once 'config.php';

// Check if admin is logged in
if (!isset($_SESSION['admin'])) {
    header('Location: admin_login.php');
    exit();
}

// Handle logout
if (isset($_GET['logout'])) {
    session_destroy();
    header('Location: admin_login.php');
    exit();
}

// Handle new product submission
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = $_POST['name'];
    $price = $_POST['price'];
    $image = $_POST['image'];
    $category = $_POST['category'];
    $description = $_POST['description'];

    $stmt = $conn->prepare("INSERT INTO products (name, price, image, category, description) VALUES (?, ?, ?, ?, ?)");
    $stmt->bind_param("sdsss", $name, $price, $image, $category, $description);

    if ($stmt->execute()) {
        $success = "Product added successfully!";
    } else {
        $error = "Error adding product.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Admin Panel - SurfCity Collectibles</title>
  <link rel="stylesheet" href="style.css">
</head>
<body>

  <h1 style="text-align:center; margin-top:2rem;">Welcome, <?php echo $_SESSION['admin']; ?>!</h1>

  <div style="text-align:center; margin:1rem;">
    <a href="?logout=true">Logout</a>
  </div>

  <h2 style="text-align:center;">Add New Product</h2>

  <?php if (isset($success)): ?>
    <p style="color:green; text-align:center;"><?php echo $success; ?></p>
  <?php endif; ?>
  <?php if (isset($error)): ?>
    <p style="color:red; text-align:center;"><?php echo $error; ?></p>
  <?php endif; ?>

  <form method="post" style="max-width:400px; margin:2rem auto;">
    <input type="text" name="name" placeholder="Product Name" required style="width:100%; margin-bottom:1rem; padding:0.5rem;"><br>
    <input type="text" name="price" placeholder="Price (e.g., 19.99)" required style="width:100%; margin-bottom:1rem; padding:0.5rem;"><br>
    <input type="text" name="image" placeholder="Image Filename (e.g., raichu.png)" style="width:100%; margin-bottom:1rem; padding:0.5rem;"><br>
    <input type="text" name="category" placeholder="Category (e.g., Pokémon, One Piece, LEGO)" style="width:100%; margin-bottom:1rem; padding:0.5rem;"><br>
    <textarea name="description" placeholder="Description" rows="4" style="width:100%; margin-bottom:1rem; padding:0.5rem;"></textarea><br>
    <button type="submit" style="width:100%; padding:0.5rem;">Add Product</button>
  </form>

</body>
</html>
