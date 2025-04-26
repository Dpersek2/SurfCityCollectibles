<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>SurfCity Collectibles - Home</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <link rel="stylesheet" href="style.css">
</head>
<body class="bg-[#FAF3E0] text-[#333333]">

<?php include 'navbar.php'; ?>

<main class="p-8 md:p-16 max-w-4xl mx-auto text-center">

  <!-- LOGO at top -->
  <div class="flex justify-center mb-8">
    <img src="images/sfcLogo.png" alt="SurfCity Collectibles Logo" class="w-64 h-auto rounded shadow-lg">
  </div>

  <h1 class="text-4xl md:text-5xl font-bold mb-6">Welcome to SurfCity Collectibles!</h1>

  <p class="text-lg md:text-xl mb-8">
    Ride the wave of awesome collectibles — Pokémon, One Piece, LEGO and more!
  </p>

  <a href="shop.php" class="inline-block bg-[#F4A261] hover:bg-[#e88d3b] text-white font-bold py-3 px-8 rounded-full text-lg shadow-md">
    Start Shopping
  </a>

</main>

<?php include 'footer.php'; ?>


</body>
</html>
