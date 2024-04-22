<?php

session_start();
include('server/connection.php');

if (!isset($_SESSION["logged_in"])) {
}

?>

<!DOCTYPE html>
<html lang="en" class="scroll-smooth">

<head>

  <!-- required meta tags -->
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Vape Store</title>

  <!-- fontawesome cdn -->
  <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.15.4/css/all.css" integrity="sha384-DyZ88mC6Up2uqS4h/KRgHuoeGwBcD4Ng9SiP4dIRy0EXTlnuz47vAwmeGwVChigm" crossorigin="anonymous" />

  <!-- css -->
  <link rel="stylesheet" href="css/output.css">


</head>

<body>

  <?php include('layouts/navbar.php') ?>

  <!-- Home -->
  <section id="home" class="pt-48 bg-gradient-to-r from-bluedark to-bluegray min-h-[100vh]">
    <div class="container">
      <div class="flex flex-wrap">
        <div class="w-full self-center px-4 lg:w-1/2">
          <h1 class="text-base font-semibold text-light md:text-2xl">NEW ARRIVAL<span class="block font-bold text-light text-4xl mt-1 lg:text-5xl mb-5 ">Purple Gummy</span></h1>
          <p class="text-base text-justify font-medium text-light mb-10 leading-relaxed lg:text-xl">Liquid Rasa Purple Gummy adalah pilihan terbaik untuk menikmati kelezatan purple dan gummy dalam satu produk yang menggugah selera dan memberikan kepuasan maksimal. Rasakan sensasi baru dengan Liquid Rasa Purple Gummy sekarang!</p>
          <button class="text-base font-semibold text-light bg-primary border border-transparent hover:bg-blue-500 py-3 px-5 rounded-full hover:shadow-lg transition duration-300 ease-in-out" onclick="window.location.href='/shop-page.php'">SHOP NOW</button>
        </div>

        <div class="w-full self-end px-4 lg:w-1/2">
          <div class="relative mt-10 lg:mt-0 lg:right-0">
            <img src="assets/images/liquid-anggur.png" class=" max-w-full mx-auto ">
            <span class=" absolute bottom-12 left-1/2 -translate-x-1/2 md:scale-125 -z-10 ">
              <svg width="420" height="420" viewBox="0 0 200 200" xmlns="http://www.w3.org/2000/svg">
                <path fill="#2563eb" d="M45.9,-54.9C56.9,-45.6,61.2,-28.6,66.2,-10.2C71.2,8.2,76.9,27.9,71.1,43.9C65.3,59.8,47.9,71.9,28.8,78.8C9.6,85.6,-11.3,87.2,-29.2,80.5C-47.1,73.9,-61.9,59.1,-71.6,41.7C-81.2,24.2,-85.7,4.2,-80,-11.7C-74.3,-27.5,-58.5,-39.2,-43.5,-47.8C-28.4,-56.4,-14.2,-61.9,1.6,-63.9C17.5,-65.9,35,-64.2,45.9,-54.9Z" transform="translate(100 100) scale(1.1)" />
              </svg>
            </span>
          </div>
        </div>
      </div>
    </div>
  </section>
  <!-- Home-end -->

  <!-- Featured -->
  <section id="featured" class="pt-24 pb-16">
    <div class="container text-center mt-5 py-5">
      <h4 class="font-semibold text-2xl text-dark mb-2">Featured Products</h4>
      <hr class="mt-6 mb-6  border-t-2 border-gray-400">
      <p class="text-md mb-12">Here you can check out our featured products</p>
    </div>

    <div class="flex flex-wrap gap-12 px-24 justify-center ">
      <?php include("server/get_featured_products.php"); ?>

      <?php while ($row = $featured_products->fetch_assoc()) { ?>
        <div class="text-center p-4">
          <a href="<?php echo "single-product.php?product_id=" . $row['product_id']; ?>">
            <img class=" w-64 h-64 cursor-pointer transition ease-in-out duration-300 hover:opacity-70" src="/assets/products/<?php echo $row['product_image']; ?>" />
          </a>
          <h5 class="mt-4 text-base font-semibold"><?php echo $row['product_name']; ?></h5>
          <h4 class="mb-4 text-lg font-bold text-red-500">IDR <?php echo number_format($row['product_price'], 0, ',', '.'); ?></h4>
          <a href="<?php echo "single-product.php?product_id=", $row['product_id']; ?>"><button class="w-1/2 text-base font-semibold text-light bg-dark border border-transparent hover:bg-slate-700 py-3 px-5 rounded-full hover:shadow-lg transition duration-300 ease-in-out">Buy</button></a>
        </div>
      <?php } ?>
    </div>
  </section>
  <!-- Featured-end -->

  <!-- Banner -->
  <section id="banner" class="my-5 pb-5 bg-cover bg-fixed flex flex-col justify-center items-start bg-[url('https://img.freepik.com/premium-photo/vaping-device-ecigarette-banner-blue-pink-light-background_638202-27.jpg?w=996')] h-[60vh]">
    <div class="container text-white">
      <h4 class="text-xl md:text-2xl">MID SEASON'S SALE</h4>
      <h1 class="text-3xl md:text-4xl">Summer Collection <br> UP to 30% OFF</h1>
      <button class="text-sm md:text-lg uppercase font-bold bg-dark text-white py-3 px-6 rounded-full mt-4 hover:bg-slate-700 transition duration-500 ease-in-out" onclick="window.location.href='/shop-page.php'">Shop now</button>
    </div>
  </section>
  <!-- Banner-End -->

  <!-- category Liquid -->
  <section id="featured" class="pt-24 pb-16">
    <div class="container text-center mt-5 py-5">
      <h4 class="font-semibold text-2xl text-dark mb-2">Liquid Products</h4>
      <hr class="mt-6 mb-6  border-t-2 border-gray-400">
      <p class="text-md mb-12">Here you can check out our liquid products</p>
    </div>

    <div class="flex flex-wrap gap-12 px-24 justify-center ">
      <?php include("server/get_liquid_products.php"); ?>

      <?php while ($row = $liquid_products->fetch_assoc()) { ?>
        <div class="text-center p-4">
          <a href="<?php echo "single-product.php?product_id=" . $row['product_id']; ?>">
            <img class=" w-64 h-64 cursor-pointer transition ease-in-out duration-300 hover:opacity-70" src="/assets/products/<?php echo $row['product_image']; ?>" />
          </a>
          <h5 class="mt-4 text-base font-semibold"><?php echo $row['product_name']; ?></h5>
          <h4 class="mb-4 text-lg font-bold text-red-500">IDR <?php echo number_format($row['product_price'], 0, ',', '.'); ?></h4>
          <a href="<?php echo "single-product.php?product_id=", $row['product_id']; ?>"><button class="w-1/2 text-base font-semibold text-light bg-dark border border-transparent hover:bg-slate-700 py-3 px-5 rounded-full hover:shadow-lg transition duration-300 ease-in-out">Buy</button></a>
        </div>
      <?php } ?>
    </div>
  </section>
  <!-- category liquid-end -->

  <!-- Brand -->
  <section id="featured" class="pt-12 pb-16 bg-slate-200">
    <div class="container text-center py-5">
      <h4 class="font-semibold text-2xl text-dark mb-12">Brand Partner's</h4>
    </div>
    <div class="flex flex-wrap gap-12 lg:gap-24 lg:px-24 justify-center">
      <img class=" w-16 h-16 md:w-24 md:h-24 xl:w-36 xl:h-36 cursor-pointer transition ease-in-out duration-300 hover:opacity-70" src="/assets/brands/hexohm.png" />
      <img class=" w-16 h-16 md:w-24 md:h-24 xl:w-36 xl:h-36 cursor-pointer transition ease-in-out duration-300 hover:opacity-70" src="/assets/brands/jam-monster.png" />
      <img class=" w-16 h-16 md:w-24 md:h-24 xl:w-36 xl:h-36 cursor-pointer transition ease-in-out duration-300 hover:opacity-70" src="/assets/brands/voopoo.png" />
      <img class=" w-16 h-16 md:w-24 md:h-24 xl:w-36 xl:h-36 cursor-pointer transition ease-in-out duration-300 hover:opacity-70" src="/assets/brands/oat-drips.png" />
    </div>
  </section>

  <?php include('layouts/footer.php') ?>

