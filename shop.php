<?php
require_once 'config.php';

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
  <link rel="stylesheet" href="style.css"> <!-- Your custom CSS too -->
</head>
<body>

<nav class="bg-blue-600 p-4">
  <ul class="flex justify-center space-x-8 text-white font-bold">
    <li><a href="index.php">Home</a></li>
    <li><a href="shop.php">Shop</a></li>
    <li><a href="about.html">About</a></li>
    <li><a href="contact.html">Contact</a></li>
    <li><a href="cart.html">Cart 🛒</a></li>
  </ul>
</nav>

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
            <button class="bg-blue-600 text-white mt-4 px-4 py-2 rounded hover:bg-blue-700 w-full">Add to Cart</button>
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
