<header>
  <nav class="bg-[#2A9D8F] p-4">
    <ul class="flex justify-between items-center max-w-7xl mx-auto text-white font-bold list-none m-0 p-0">

      <!-- Left Section -->
      <div class="flex items-center gap-8">
        <li><a href="index.php" class="hover:underline">Home</a></li>

        <li class="relative" id="shop-menu">
          <a href="shop.php" class="hover:underline">Shop ▼</a>
          <ul id="dropdown" class="absolute hidden bg-[#2A9D8F] list-none mt-2 p-2 rounded">
            <li><a href="shop.php?category=Pokemon" class="hover:underline block p-2">Pokémon</a></li>
            <li><a href="shop.php?category=One%20Piece" class="hover:underline block p-2">One Piece</a></li>
            <li><a href="shop.php?category=LEGO" class="hover:underline block p-2">LEGO</a></li>
          </ul>
        </li>

        <li><a href="about.php" class="hover:underline">About</a></li>
        <li><a href="contact.php" class="hover:underline">Contact</a></li>

        <li><a href="cart.php" class="hover:underline">
          Cart (<?php echo isset($_SESSION['cart']) ? array_sum(array_column($_SESSION['cart'], 'quantity')) : 0; ?>)
        </a></li>
      </div>

      <!-- Right Section -->
      <div class="flex items-center gap-4">
        <?php if (isset($_SESSION['user'])): ?>
          <li><a href="logout.php" class="hover:underline">Logout (<?php echo htmlspecialchars($_SESSION['user']); ?>)</a></li>
        <?php else: ?>
          <li><a href="login.php" class="hover:underline">Login</a></li>
          <li><a href="register.php" class="hover:underline">Register</a></li>
        <?php endif; ?>
      </div>

    </ul>
  </nav>

  <!-- Dropdown Script -->
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
</header>
