<?php
session_start();

// Handle update cart quantities
if (isset($_POST['update_cart'])) {
    foreach ($_POST['quantities'] as $product_id => $new_quantity) {
        foreach ($_SESSION['cart'] as &$item) {
            if ($item['id'] == $product_id) {
                if ($new_quantity > 0) {
                    $item['quantity'] = $new_quantity;
                } else {
                    // If quantity is 0 or less, remove the item
                    unset($_SESSION['cart'][$product_id]);
                }
                break;
            }
        }
    }
    // Reindex array after changes
    $_SESSION['cart'] = array_values($_SESSION['cart']);
    header('Location: cart.php');
    exit();
}

// Handle removing item directly
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

// Calculate total
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

<?php include 'navbar.php'; ?>

<main class="p-8">
  <h1 class="text-3xl text-center font-bold mb-8">Your Cart</h1>

  <?php if (!empty($_SESSION['cart'])): ?>
    <form method="post" action="cart.php">
      <div class="grid gap-4 max-w-2xl mx-auto">
        <?php foreach ($_SESSION['cart'] as $index => $item): ?>
          <div class="flex justify-between items-center bg-white p-4 rounded shadow">
            <div>
              <h3 class="font-bold"><?php echo htmlspecialchars($item['name']); ?></h3>
              <p>Price: $<?php echo number_format($item['price'], 2); ?></p>
              <p>Subtotal: $<?php echo number_format($item['price'] * $item['quantity'], 2); ?></p>
            </div>
            <div class="flex items-center space-x-4">
              <input type="number" name="quantities[<?php echo $item['id']; ?>]" value="<?php echo $item['quantity']; ?>" min="1" class="w-16 p-1 border rounded text-center">
              <a href="cart.php?remove=<?php echo $item['id']; ?>" class="text-red-500 font-bold">Remove</a>
            </div>
          </div>
        <?php endforeach; ?>
      </div>

      <div class="text-center mt-8">
        <button type="submit" name="update_cart" class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-2 rounded">Update Cart</button>
      </div>
    </form>

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
