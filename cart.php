<?php
session_start();

// Handle removing item from cart
if (isset($_GET['remove'])) {
    $remove_id = $_GET['remove'];
    foreach ($_SESSION['cart'] as $key => $item) {
        if ($item['id'] == $remove_id) {
            unset($_SESSION['cart'][$key]);
            $_SESSION['cart'] = array_values($_SESSION['cart']); // Reindex array
            break;
        }
    }
    header('Location: cart.php');
    exit();
}

// Calculate cart total
$total = 0;
if (!empty($_SESSION['cart'])) {
    foreach ($_SESSION['cart'] as $item) {
        $total += $item['price'] * $item['quantity'];
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Your Cart - SurfCity Collectibles</title>
  <script src="https://cdn.tailwindcss.com"></script>
</head>
<body>

<header>
  <nav style="background-color: #2563eb; padding: 1rem;">
    <ul style="display: flex; justify-content: center; gap: 2rem; color: white; font-weight: bold; list-style: none; margin: 0; padding: 0;">

      <li><a href="index.html" style="color: white; text-decoration: none;">Home</a></li>

      <li style="position: relative;" id="shop-menu">
        <a href="shop.php" style="color: white; text-decoration: none;">Shop ▼</a>
        <ul id="dropdown" style="display: none; position: absolute; top: 100%; left: 0; background-color: #2563eb; list-style: none; margin: 0; padding: 0.5rem;">
          <li><a href="shop.php?category=Pokemon" style="color: white; text-decoration: none; padding: 0.5rem; display: block;">Pokémon</a></li>
          <li><a href="shop.php?category=One%20Piece" style="color: white; text-decoration: none; padding: 0.5rem; display: block;">One Piece</a></li>
          <li><a href="shop.php?category=LEGO" style="color: white; text-decoration: none; padding: 0.5rem; display: block;">LEGO</a></li>
        </ul>
      </li>

      <li><a href="about.html" style="color: white; text-decoration: none;">About</a></li>
      <li><a href="contact.html" style="color: white; text-decoration: none;">Contact</a></li>
      <li><a href="cart.php" style="color: white; text-decoration: none;">Cart</a></li>

    </ul>
  </nav>
</header>

<!-- ✅ Simple JavaScript to toggle dropdown -->
<script>
  const shopMenu = document.getElementById('shop-menu');
  const dropdown = document.getElementById('dropdown');

  shopMenu.addEventListener('mouseenter', () => {
    dropdown.style.display = 'block';
  });

  shopMenu.addEventListener('mouseleave', () => {
    dropdown.style.display = 'none';
  });
</script>




<main class="p-8">
  <h1 class="text-3xl text-center font-bold mb-8">Your Cart</h1>

  <?php if (!empty($_SESSION['cart'])): ?>
    <div class="grid gap-4 max-w-2xl mx-auto">
      <?php foreach ($_SESSION['cart'] as $item): ?>
        <div class="flex justify-between items-center bg-white p-4 rounded shadow">
          <div>
            <h3 class="font-bold"><?php echo htmlspecialchars($item['name']); ?></h3>
            <p>Quantity: <?php echo $item['quantity']; ?></p>
            <p>Price: $<?php echo number_format($item['price'], 2); ?></p>
            <p>Subtotal: $<?php echo number_format($item['price'] * $item['quantity'], 2); ?></p>
          </div>
          <div>
            <a href="cart.php?remove=<?php echo $item['id']; ?>" class="text-red-500 font-bold">Remove</a>
          </div>
        </div>
      <?php endforeach; ?>
    </div>

    <div class="text-center mt-8">
      <h2 class="text-2xl font-bold">Cart Total: $<?php echo number_format($total, 2); ?></h2>
      <button class="bg-green-600 hover:bg-green-700 text-white px-6 py-2 rounded mt-4">Proceed to Checkout</button>
    </div>

  <?php else: ?>
    <p class="text-center">Your cart is empty.</p>
  <?php endif; ?>

</main>

<footer class="text-center bg-blue-600 text-white p-4 mt-8">
  &copy; 2025 SurfCity Collectibles. All rights reserved.
</footer>

</body>
</html>
 