<?php
session_start();
require_once 'config.php';

// Check if product ID is set
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
<body class="bg-[#FAF3E0] text-[#333333]">

<?php include 'navbar.php'; ?>

<main class="p-8 md:p-16 max-w-5xl mx-auto">

  <div class="flex flex-col md:flex-row gap-8 items-start">

    <!-- Product Image -->
    <img src="images/<?php echo htmlspecialchars($product['image']); ?>" alt="<?php echo htmlspecialchars($product['name']); ?>" class="w-full md:w-1/2 rounded-lg shadow-md">

    <!-- Product Details -->
    <div class="flex-grow">
      <h1 class="text-4xl font-bold mb-4"><?php echo htmlspecialchars($product['name']); ?></h1>
      <p class="text-2xl text-gray-700 mb-2">$<?php echo number_format($product['price'], 2); ?></p>
      <p class="text-gray-600 mb-4">Available: <?php echo (int)$product['stock']; ?></p>
      <p class="text-gray-700 mb-8"><?php echo nl2br(htmlspecialchars($product['description'])); ?></p>

      <!-- Out of Stock Logic -->
      <?php if ((int)$product['stock'] > 0): ?>
        <form method="post" action="shop.php">
          <input type="hidden" name="product_id" value="<?php echo $product['id']; ?>">
          <input type="hidden" name="product_name" value="<?php echo htmlspecialchars($product['name']); ?>">
          <input type="hidden" name="product_price" value="<?php echo $product['price']; ?>">
          <button type="submit" name="add_to_cart" class="bg-[#F4A261] hover:bg-[#e88d3b] text-white font-bold px-8 py-3 rounded-full shadow-md">
            Add to Cart
          </button>
        </form>
      <?php else: ?>
        <button class="bg-gray-400 text-white font-bold px-8 py-3 rounded-full cursor-not-allowed" disabled>
          Out of Stock
        </button>
      <?php endif; ?>

    </div>

  </div>

</main>

<?php include 'footer.php'; ?>


</body>
</html>
