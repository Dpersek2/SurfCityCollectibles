<?php
session_start();
require_once 'config.php';

// Handle adding product
if (isset($_POST['add_product'])) {
    $name = $_POST['name'];
    $category = $_POST['category'];
    $price = $_POST['price'];
    $stock = $_POST['stock']; // 🆕 stock added
    $description = $_POST['description'];

    // Handle image upload
    $image = $_FILES['image']['name'];
    $image_tmp = $_FILES['image']['tmp_name'];
    move_uploaded_file($image_tmp, "images/" . $image);

    // Insert into database including stock
    $stmt = $conn->prepare("INSERT INTO products (name, category, price, stock, description, image) VALUES (?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("ssdis", $name, $category, $price, $stock, $description, $image);
    $stmt->execute();

    echo "<p class='text-green-500 font-bold'>Product added successfully!</p>";
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Admin Panel - SurfCity Collectibles</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <link rel="stylesheet" href="style.css">
</head>
<body>

<?php include 'navbar.php'; ?> <!-- ✅ Navbar included -->

<main class="p-8">
  <h1 class="text-4xl font-bold text-center mb-8">Admin Panel</h1>

  <div class="max-w-2xl mx-auto">

    <h2 class="text-2xl font-bold mb-6">Add New Product</h2>

    <form method="post" action="admin_panel.php" enctype="multipart/form-data" class="space-y-4">

      <input type="text" name="name" placeholder="Product Name" required class="border p-2 w-full rounded">
      <input type="text" name="category" placeholder="Category (e.g., Pokémon, One Piece, LEGO)" required class="border p-2 w-full rounded">
      <input type="number" name="price" placeholder="Price" step="0.01" required class="border p-2 w-full rounded">

      <!-- 🆕 Stock Quantity Field -->
      <input type="number" name="stock" placeholder="Stock Quantity" required class="border p-2 w-full rounded">

      <textarea name="description" placeholder="Product Description" required class="border p-2 w-full rounded"></textarea>
      <input type="file" name="image" accept="image/*" required class="border p-2 w-full rounded">

      <button type="submit" name="add_product" class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-2 rounded">Add Product</button>

    </form>

  </div>

</main>

<footer class="text-center bg-blue-600 text-white p-4 mt-8">
  &copy; 2025 SurfCity Collectibles. All rights reserved.
</footer>

</body>
</html>
