<?php
session_start();
require_once 'config.php';

// Handle Add to Cart action
if (isset($_POST['add_to_cart'])) {
    $product_id = $_POST['product_id'];
    $product_name = $_POST['product_name'];
    $product_price = $_POST['product_price'];

    $cart_item = [
        'id' => $product_id,
        'name' => $product_name,
        'price' => $product_price,
        'quantity' => 1
    ];

    if (!isset($_SESSION['cart'])) {
        $_SESSION['cart'] = [];
    }

    // Check if product already exists in cart
    $found = false;
    foreach ($_SESSION['cart'] as &$item) {
        if ($item['id'] == $product_id) {
            $item['quantity'] += 1;
            $found = true;
            break;
        }
    }
    if (!$found) {
        $_SESSION['cart'][] = $cart_item;
    }

    header("Location: shop.php");
    exit();
}

// Handle category filtering
$category_filter = '';
if (isset($_GET['category'])) {
    $category_filter = $_GET['category'];
}

// Fetch products
if (!empty($category_filter)) {
    $stmt = $conn->prepare("SELECT * FROM products WHERE category = ?");
    $stmt->bind_param("s", $category_filter);
    $stmt->execute();
    $result = $stmt->get_result();
} else {
    $result = $conn->query("SELECT * FROM products");
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Shop - SurfCity Collectibles</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <link rel="stylesheet" href="style.css">
</head>
<body>

<?php include 'navbar.php'; ?>

<main class="p-8">
  <h1 class="text-3xl text-center font-bold mb-8">Shop Collectibles</h1>

  <div class="grid grid-cols-1 md:grid-cols-3 gap-8">

    <?php if ($result && $result->num_rows > 0): ?>
      <?php while($row = $result->fetch_assoc()): ?>
        <div class="bg-white shadow-lg rounded-lg overflow-hidden">

          <!-- Link the image to product page -->
          <a href="product.php?id=<?php echo $row['id']; ?>">
            <img src="images/<?php echo htmlspecialchars($row['image']); ?>" alt="<?php echo htmlspecialchars($row['name']); ?>" class="w-full h-48 object-cover">
          </a>

          <div class="p-4">
            <!-- Link the product name too -->
            <a href="product.php?id=<?php echo $row['id']; ?>">
              <h3 class="text-xl font-bold mb-2"><?php echo htmlspecialchars($row['name']); ?></h3>
            </a>

            <p class="text-gray-700 mb-2">$<?php echo number_format($row['price'], 2); ?></p>
            <p class="text-gray-600 mb-2">Available: <?php echo (int)$row['stock']; ?></p>
            <p class="text-gray-500 text-sm"><?php echo htmlspecialchars($row['category']); ?></p>
            <p class="text-gray-600 mt-2"><?php echo htmlspecialchars($row['description']); ?></p>

            <!-- Out of Stock Logic -->
            <?php if ((int)$row['stock'] > 0): ?>
              <form method="post" action="shop.php">
                <input type="hidden" name="product_id" value="<?php echo $row['id']; ?>">
                <input type="hidden" name="product_name" value="<?php echo htmlspecialchars($row['name']); ?>">
                <input type="hidden" name="product_price" value="<?php echo $row['price']; ?>">
                <button type="submit" name="add_to_cart" class="bg-blue-600 text-white mt-4 px-4 py-2 rounded hover:bg-blue-700 w-full">
                  Add to Cart
                </button>
              </form>
            <?php else: ?>
              <button class="bg-gray-400 text-white mt-4 px-4 py-2 rounded w-full cursor-not-allowed" disabled>
                Out of Stock
              </button>
            <?php endif; ?>

          </div>
        </div>
      <?php endwhile; ?>
    <?php else: ?>
      <p class="text-center">No products found.</p>
    <?php endif; ?>

  </div>
</main>

<footer class="text-center bg-blue-600 text-white p-4 mt-8">
  &copy; 2025 SurfCity Collectibles. All rights reserved.
</footer>

</body>
</html>
