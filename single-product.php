<?php

include("server/connection.php");

if (isset($_GET['product_id'])) {

  $product_id = $_GET['product_id'];

  $stmt = $conn->prepare("SELECT * FROM products WHERE product_id = ?");
  $stmt->bind_param("i", $product_id);

  $stmt->execute();

  $product = $stmt->get_result();
} else {
}

?>

<!DOCTYPE html>
<html lang="en">

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

  <!-- single product -->
  <section class="container mt-36 min-h-[50dvh]">
    <?php while ($row = $product->fetch_assoc()) { ?>
      <div class="grid grid-cols-1 md:grid-cols-2 gap-4 md:gap-8">
        <!-- Image Column -->
        <div>
          <div class="flex justify-center">
            <img class="w-[360px] h-[360px] pb-6" src="assets/products/<?php echo $row['product_image']; ?>" id="mainImg" />
          </div>

          <!-- Small Images -->
          <div class="grid grid-cols-4 gap-0">
            <div>
              <img src="assets/products/<?php echo $row['product_image']; ?>" class="w-full" />
            </div>
            <div>
              <img src="assets/products/<?php echo $row['product_image2']; ?>" class=" w-full" />
            </div>
            <div>
              <img src="assets/products/<?php echo $row['product_image3']; ?>" class=" w-full" />
            </div>
            <div>
              <img src="assets/products/<?php echo $row['product_image4']; ?>" class=" w-full" />
            </div>
          </div>
        </div>
        <!-- Product Info Column -->
        <div class="col-lg-6 col-md-12 col-12 pt-8">
          <h6 class="text-gray-400 font-bold text-base"><?php echo $row['product_category']; ?></h6>
          <h3 class="text-dark font-bold text-lg mt-2"><?php echo $row['product_name']; ?></h3>
          <h2 class="text-xl text-red-500 ">IDR <?php echo number_format($row['product_price'], 0, ',', '.'); ?></h2>
          <!-- Add to Cart Form -->
          <form method="POST" action="cart-page.php" class="mt-4">
            <input type="hidden" name="product_id" value="<?php echo $row['product_id']; ?>">
            <input type="hidden" name="product_image" value="<?php echo $row['product_image']; ?>">
            <input type="hidden" name="product_name" value="<?php echo $row['product_name']; ?>">
            <input type="hidden" name="product_price" value="<?php echo $row['product_price']; ?>">

            <input type="number" name="product_quantity" value="1" class="w-16 border border-gray-300 rounded-xl py-1 px-2">
            <button class="buy-btn bg-primary font-bold text-white px-4 py-2 rounded-xl ml-2 hover:bg-blue-500" type="submit" name="add_to_cart">Add to cart</button>
          </form>
          <!-- Product Details -->
          <h4 class="mt-5 mb-2 text-gray-500 text-base ">Product details:</h4>
          <p class="text-gray-700 text-justify"><?php echo $row['product_description']; ?></p>
        </div>
      </div>

    <?php } ?>
  </section>
  <!-- <section class="container single-product my-5 pt-5">
        <div class="row mt-5">

          <?php while ($row = $product->fetch_assoc()) { ?>

            <div class="col-lg-4 col-md-6 col-sm-12">
                <img class="img-fluid w-100 pb-1" src="assets/products/<?php echo $row['product_image']; ?>" id="mainImg" />
                <div class="small-img-group">
                    
                    <div class="small-img-col">
                        <img src="assets/products/<?php echo $row['product_image']; ?>" width="100%" class="small-img"/>
                    </div>
                    <div class="small-img-col">
                        <img src="assets/products/<?php echo $row['product_image2']; ?>" width="100%" class="small-img"/>
                    </div>
                    <div class="small-img-col">
                        <img src="assets/products/<?php echo $row['product_image3']; ?>" width="100%" class="small-img"/>
                    </div>
                    <div class="small-img-col">
                        <img src="assets/products/<?php echo $row['product_image4']; ?>" width="100%" class="small-img"/>
                    </div>
                </div>
            </div>

            

            <div class="col-lg-6 col-md-12 col-12">
                <h6><?php echo $row['product_category']; ?></h6>
                <h3 class="py-4"><?php echo $row['product_name']; ?></h3>
                <h2>IDR <?php echo number_format($row['product_price'], 0, ',', '.'); ?></h2>

                <form  method="POST" action="cart-page.php">
                <input type="hidden" name="product_id" value="<?php echo $row['product_id']; ?>" >
                <input type="hidden" name="product_image" value="<?php echo $row['product_image']; ?>" >
                <input type="hidden" name="product_name" value="<?php echo $row['product_name']; ?>">
                <input type="hidden" name="product_price" value="<?php echo $row['product_price']; ?>">

                <input type="number" name="product_quantity" value="1">
                <button class="buy-btn" type="submit" name="add_to_cart">Add to cart</button>
                </from>

               
                <h4 class="mt-5 mb-5">Product details</h4>
                <span><?php echo $row['product_description']; ?></span>
            </div>
          
            <?php } ?>
        </div>
      </section> -->

  <!-- changeImgProduct.js -->
  <script src="js/changeImgProduct.js"></script>

  <!-- single product-end -->

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
          <h4 class="mb-4 text-lg text-red-500">IDR <?php echo number_format($row['product_price'], 0, ',', '.'); ?></h4>
          <a href="<?php echo "single-product.php?product_id=", $row['product_id']; ?>"><button class="w-1/2 text-base font-semibold text-light bg-dark border border-transparent hover:bg-slate-700 py-3 px-5 rounded-full hover:shadow-lg transition duration-300 ease-in-out">Buy</button></a>
        </div>
      <?php } ?>
    </div>
  </section>
  <!-- Featured-end -->

  <?php include('layouts/footer.php') ?>

</body>

</html>