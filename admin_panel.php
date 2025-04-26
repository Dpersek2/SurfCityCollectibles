<?php
session_start();
require_once 'config.php';

// Turn on error reporting for debugging
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Handle adding a product
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
    $stmt->bind_param("sssdss", $name, $category, $price, $stock, $description, $image);
    $stmt->execute();

    echo "<p class='text-green-600 font-bold p-4 text-center'>Product added successfully!</p>";
}

// Handle deleting a product
if (isset($_GET['delete'])) {
    $product_id = intval($_GET['delete']);

    // Fetch the image filename to delete it
    $stmt = $conn->prepare("SELECT image FROM products WHERE id = ?");
    $stmt->bind_param("i", $product_id);
    $stmt->execute();
    $stmt->bind_result($image_filename);
    $stmt->fetch();
    $stmt->close();

    // Delete image file if it exists
    if (!empty($image_filename) && file_exists("images/" . $image_filename)) {
        unlink("images/" . $image_filename);
    }

    // Delete the product from database
    $stmt = $conn->prepare("DELETE FROM products WHERE id = ?");
    $stmt->bind_param("i", $product_id);
    $stmt->execute();

    echo "<p class='text-green-600 font-bold p-4 text-center'>Product deleted successfully!</p>";
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

<main class="p-8 md:p-16 max-w-4xl mx-auto">

  <h1 class="text-4xl font-bold text-center mb-12">Admin Panel</h1>

  <!-- Add Product Form -->
  <form method="post" action="admin_panel.php" enctype="multipart/form-data" class="space-y-6 bg-white p-8 rounded-lg shadow-lg">

    <input type="text" name="name" placeholder="Product Name" required class="border p-3 w-full rounded">
    <input type="text" name="category" placeholder="Category (e.g., Pokémon, One Piece, LEGO)" required class="border p-3 w-full rounded">
    <input type="number" step="0.01" name="price" placeholder="Price" required class="border p-3 w-full rounded">
    <input type="number" name="stock" placeholder="Stock Quantity" required class="border p-3 w-full rounded">
    <textarea name="description" placeholder="Product Description" required class="border p-3 w-full rounded"></textarea>
    <input type="file" name="image" accept="image/*" required class="border p-3 w-full rounded">

    <button type="submit" name="add_product" class="bg-[#F4A261] hover:bg-[#e88d3b] text-white font-bold px-6 py-3 rounded-full w-full shadow-md">
      Add Product
    </button>

  </form>

  <!-- Divider -->
  <hr class="my-16">

  <!-- List Current Products -->
  <h2 class="text-3xl font-bold text-center mb-8">Current Products</h2>

  <div class="space-y-6">
    <?php
    $products = $conn->query("SELECT * FROM products ORDER BY id DESC");

    if ($products->num_rows > 0):
      while ($row = $products->fetch_assoc()):
    ?>
      <div class="bg-white p-6 rounded-lg shadow-md flex flex-col md:flex-row justify-between items-center gap-4">

        <div class="text-center md:text-left">
          <h3 class="text-2xl font-bold"><?php echo htmlspecialchars($row['name']); ?></h3>
          <p class="text-gray-600">Category: <?php echo htmlspecialchars($row['category']); ?></p>
          <p class="text-gray-600">Price: $<?php echo number_format($row['price'], 2); ?></p>
          <p class="text-gray-600">Stock: <?php echo (int)$row['stock']; ?></p>
        </div>

        <a href="admin_panel.php?delete=<?php echo $row['id']; ?>"
           class="bg-red-500 hover:bg-red-600 text-white font-bold px-6 py-2 rounded-full shadow-md"
           onclick="return confirm('Are you sure you want to delete this product?');">
          Delete
        </a>

      </div>
    <?php endwhile; else: ?>
      <p class="text-center text-lg">No products found.</p>
    <?php endif; ?>
  </div>

</main>

<?php include 'footer.php'; ?>

</body>
</html>
