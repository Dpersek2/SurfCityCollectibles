<header>
  <nav style="background-color: #2563eb; padding: 1rem;">
    <ul style="display: flex; justify-content: center; gap: 2rem; color: white; font-weight: bold; list-style: none; margin: 0; padding: 0;">

      <li><a href="index.php" style="color: white; text-decoration: none;">Home</a></li>

      <li style="position: relative;" id="shop-menu">
        <a href="shop.php" style="color: white; text-decoration: none;">Shop ▼</a>
        <ul id="dropdown" style="display: none; position: absolute; background-color: #2563eb; list-style: none; margin: 0; padding: 0.5rem;">
          <li><a href="shop.php?category=Pokemon" style="color: white; text-decoration: none; padding: 0.5rem; display: block;">Pokémon</a></li>
          <li><a href="shop.php?category=One%20Piece" style="color: white; text-decoration: none; padding: 0.5rem; display: block;">One Piece</a></li>
          <li><a href="shop.php?category=LEGO" style="color: white; text-decoration: none; padding: 0.5rem; display: block;">LEGO</a></li>
        </ul>
      </li>

      <li><a href="about.php" style="color: white; text-decoration: none;">About</a></li>
      <li><a href="contact.php" style="color: white; text-decoration: none;">Contact</a></li>

      <!-- Cart Counter -->
      <li><a href="cart.php" style="color: white; text-decoration: none;">
        Cart (<?php echo isset($_SESSION['cart']) ? array_sum(array_column($_SESSION['cart'], 'quantity')) : 0; ?>)
      </a></li>

    </ul>
  </nav>
</header>

<!-- JavaScript to show dropdown -->
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
