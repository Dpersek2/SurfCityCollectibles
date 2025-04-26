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

    header("Location: shop.php"); // Redirect to avoid form resubmission
    exit();
}

// Fetch all products from database
$sql = "SELECT * FROM products";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Shop - SurfCity Collectibles</title>
  <script src="https://cdn.tailwindcss.com"></script> <!-- Tailwind Ready for Later -->
  <link rel="stylesheet" href="style.css">
</head>
<body>

<header>
  <nav style="background-color: #2563eb; padding: 1rem; position: relative;">
    <ul style="display: flex; justify-content: center; gap: 2rem; color: white; font-weight: bold; list-style: none; margin: 0; padding: 0; position: relative;">

      <li><a href="index.html" style="color: white; text-decoration: none;">Home</a></li>

      <li style="position: relative;">
        <a href="shop.php" style="color: white; text-decoration: none;">Shop ▼</a>
        <ul class="dropdown" style="display: none; position: absolute; top: 100%; left: 0; background-color: #2563eb; list-style: none; padding: 0; margin: 0;">
          <li><a href="shop.php?category=Pokemon" style="color: white; text-decoration: none; display: block; padding: 0.5rem 1rem;">Pokémon</a></li>
          <li><a href="shop.php?category=One%20Piece" style="color: white; text-decoration: none; display: block; padding: 0.5rem 1rem;">One Piece</a></li>
          <li><a href="shop.php?category=LEGO" style="color: white; text-decoration: none; display: block; padding: 0.5rem 1rem;">LEGO</a></li>
        </ul>
      </li>

      <li><a href="about.html" style="color: white; text-decoration: none;">About</a></li>
      <li><a href="contact.html" style="color: white; text-decoration: none;">Contact</a></li>
      <li><a href="cart.php" style="color: white; text-decoration: none;">Cart</a></li>

    </ul>
  </nav>
</header>

<style>
/* Proper CSS for showing the dropdown on hover */
nav li:hover > ul.dropdown {
    display: block;
}
</style>





<main class="p-8">
  <h1 class="text-3xl text-center font-bold mb-8">Shop Collectibles</h1>

  <div class="grid grid-cols-1 md:grid-cols-3 gap-8">

    <?php if ($result->num_rows > 0): ?>
      <?php while($row = $result->fetch_assoc()): ?>
        <div class="bg-white shadow-lg rounded-lg overflow-hidden">
          <img src="images/<?php echo htmlspecialchars($row['image']); ?>" alt="<?php echo htmlspecialchars($row['name']); ?>" class="w-full h-48 object-cover">
          <div class="p-4">
            <h3 class="text-xl font-bold mb-2"><?php echo htmlspecialchars($row['name']); ?></h3>
            <p class="text-gray-700 mb-2">$<?php echo number_format($row['price'], 2); ?></p>
            <p class="text-gray-500 text-sm"><?php echo htmlspecialchars($row['category']); ?></p>
            <p class="text-gray-600 mt-2"><?php echo htmlspecialchars($row['description']); ?></p>

            <!-- ADD TO CART FORM -->
            <form method="post" action="shop.php">
              <input type="hidden" name="product_id" value="<?php echo $row['id']; ?>">
              <input type="hidden" name="product_name" value="<?php echo htmlspecialchars($row['name']); ?>">
              <input type="hidden" name="product_price" value="<?php echo $row['price']; ?>">
              <button type="submit" name="add_to_cart" class="bg-blue-600 text-white mt-4 px-4 py-2 rounded hover:bg-blue-700 w-full">
                Add to Cart
              </button>
            </form>

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
