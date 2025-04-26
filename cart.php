<?php
session_start();

// Handle update cart
if (isset($_POST['update_cart'])) {
    foreach ($_POST['quantities'] as $product_id => $new_quantity) {
        foreach ($_SESSION['cart'] as &$item) {
            if ($item['id'] == $product_id) {
                if ($new_quantity > 0) {
                    $item['quantity'] = $new_quantity;
                } else {
                    unset($_SESSION['cart'][$product_id]);
                }
                break;
            }
        }
    }
    $_SESSION['cart'] = array_values($_SESSION['cart']);
    header('Location: cart.php');
    exit();
}

// Handle remove item
if (isset($_GET['remove'])) {
    $remove_id = $_GET['remove'];
    foreach ($_SESSION['cart'] as $key => $item) {
        if ($item['id'] == $remove_id) {
            unset($_SESSION['cart'][$key]);
            $_SESSION['cart'] = array_values($_SESSION['cart']);
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
  <title>Cart - SurfCity Collectibles</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <link rel="stylesheet" href="style.css">
</head>
<body class="bg-[#FAF3E0] text-[#333333]">

<?php include 'navbar.php'; ?>

<main class="p-8 md:p-16 max-w-4xl mx-auto">

  <h1 class="text-4xl font-bold text-center mb-8">Your Cart</h1>

  <?php if (!empty($_SESSION['cart'])): ?>
    <form method="post" action="cart.php" class="space-y-6">

      <?php foreach ($_SESSION['cart'] as $index => $item): ?>
        <div class="bg-white rounded-lg shadow-md p-6 flex flex-col md:flex-row justify-between items-center">

          <div class="text-center md:text-left">
            <h3 class="text-2xl font-bold mb-2"><?php echo htmlspecialchars($item['name']); ?></h3>
            <p class="text-lg mb-2">Price: $<?php echo number_format($item['price'], 2); ?></p>
            <p class="text-gray-600 mb-2">Subtotal: $<?php echo number_format($item['price'] * $item['quantity'], 2); ?></p>
          </div>

          <div class="flex flex-col md:flex-row items-center gap-4 mt-4 md:mt-0">
            <input type="number" name="quantities[<?php echo $item['id']; ?>]" value="<?php echo $item['quantity']; ?>" min="1" class="border rounded p-2 w-20 text-center">
            <a href="cart.php?remove=<?php echo $item['id']; ?>" class="text-red-500 font-bold hover:underline">Remove</a>
          </div>

        </div>
      <?php endforeach; ?>

      <div class="text-center mt-8">
        <button type="submit" name="update_cart" class="bg-[#F4A261] hover:bg-[#e88d3b] text-white font-bold px-6 py-2 rounded-full shadow-md">
          Update Cart
        </button>
      </div>

    </form>

    <div class="text-center mt-12">
      <h2 class="text-3xl font-bold mb-4">Cart Total: $<?php echo number_format($total, 2); ?></h2>
      <button class="bg-[#F4A261] hover:bg-[#e88d3b] text-white font-bold px-8 py-3 rounded-full shadow-md">
        Proceed to Checkout
      </button>
    </div>

  <?php else: ?>
    <p class="text-center text-xl">Your cart is empty.</p>
  <?php endif; ?>

</main>

<footer class="bg-[#247A73] text-white text-center p-4 mt-16">
  &copy; 2025 SurfCity Collectibles. All rights reserved. 
  <br>
  <a href="index.php" class="underline hover:text-gray-200">Home</a> |
  <a href="shop.php" class="underline hover:text-gray-200">Shop</a> |
  <a href="cart.php" class="underline hover:text-gray-200">Cart</a>
</footer>

</body>
</html>

