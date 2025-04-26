<?php
session_start();
require_once 'config.php';

// Check if product ID is provided
if (!isset($_GET['id'])) {
    die("Product not found.");
}

$product_id = intval($_GET['id']);

// Fetch product details
$stmt = $conn->prepare("SELECT * FROM products WHERE id = ?");
$stmt->bind_param("i", $product_id);
$stmt->execute();
$result = $stmt->get_result();
$product = $result->fetch_assoc();

if (!$product) {
    die("Product not found.");
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title><?php echo htmlspecialchars($product['name']); ?> - SurfCity Collectibles</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <link rel="stylesheet" href="style.css">
</head>
<body>

<?php include 'navbar.php'; ?>

<main class="p-8 max-w-4xl mx-auto">
  <div class="flex flex-col md:flex-row gap-8 items-start">

    <!-- Product Image -->
    <img src="images/<?php echo htmlspecialchars($product['image']); ?>" alt="<?php echo htmlspecialchars($product['name']); ?>" class="w-full md:w-1/2 rounded shadow">

    <!-- Product Details -->
    <div>
      <h1 class="text-4xl font-bold mb-4"><?php echo htmlspecialchars($product['name']); ?></h1>
      <p class="text-2xl text-gray-700 mb-2">$<?php echo number_format($product['price'], 2); ?></p>
      <p class="text-gray-600 mb-2">Available: <?php echo (int)$product['stock']; ?></p>
      <p class="text-gray-600 mb-4"><?php echo nl2br(htmlspecialchars($product['description'])); ?></p>

      <form method="post" action="shop.php">
        <input type="hidden" name="product_id" value="<?php echo $product['id']; ?>">
        <input type="hidden" name="product_name" value="<?php echo htmlspecialchars($product['name']); ?>">
        <input type="hidden" name="product_price" value="<?php echo $product['price']; ?>">
        <button type="submit" name="add_to_cart" class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-2 rounded">
          Add to Cart
        </button>
      </form>

    </div>
  </div>
</main>

<footer class="text-center bg-blue-600 text-white p-4 mt-8">
  &copy; 2025 SurfCity Collectibles. All rights reserved.
</footer>

</body>
</html>
