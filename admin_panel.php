<?php
session_start();
require_once 'config.php';

// Handle adding product
if (isset($_POST['add_product'])) {
    $name = $_POST['name'];
    $category = $_POST['category'];
    $price = $_POST['price'];
    $stock = $_POST['stock'];
    $description = $_POST['description'];

    $image = $_FILES['image']['name'];
    $image_tmp = $_FILES['image']['tmp_name'];
    move_uploaded_file($image_tmp, "images/" . $image);

    $stmt = $conn->prepare("INSERT INTO products (name, category, price, stock, description, image) VALUES (?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("ssdis", $name, $category, $price, $stock, $description, $image);
    $stmt->execute();

    echo "<p class='text-green-600 font-bold p-4 text-center'>Product added successfully!</p>";
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
<body class="bg-[#FAF3E0] text-[#333333]">

<?php include 'navbar.php'; ?>

<main class="p-8 md:p-16 max-w-2xl mx-auto">

  <h1 class="text-4xl font-bold text-center mb-8">Admin Panel</h1>

  <form method="post" action="admin_panel.php" enctype="multipart/form-data" class="space-y-6">

    <input type="text" name="name" placeholder="Product Name" required class="border p-3 w-full rounded">
    <input type="text" name="category" placeholder="Category (e.g., Pokémon, One Piece, LEGO)" required class="border p-3 w-full rounded">
    <input type="number" name="price" placeholder="Price" step="0.01" required class="border p-3 w-full rounded">
    <input type="number" name="stock" placeholder="Stock Quantity" required class="border p-3 w-full rounded">
    <textarea name="description" placeholder="Product Description" required class="border p-3 w-full rounded"></textarea>
    <input type="file" name="image" accept="image/*" required class="border p-3 w-full rounded">

    <button type="submit" name="add_product" class="bg-[#F4A261] hover:bg-[#e88d3b] text-white font-bold px-6 py-3 rounded-full w-full shadow-md">
      Add Product
    </button>

  </form>

</main>

<?php include 'footer.php'; ?>


</body>
</html>
