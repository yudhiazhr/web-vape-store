<?php 

session_start();
include('server/connection.php');

if (!isset($_SESSION["logged_in"])) {
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
  
    <!-- required meta tags -->
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Vape Store</title>

    <!-- bootsrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">

    <!-- fontawesome cdn -->
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.15.4/css/all.css" integrity="sha384-DyZ88mC6Up2uqS4h/KRgHuoeGwBcD4Ng9SiP4dIRy0EXTlnuz47vAwmeGwVChigm" crossorigin="anonymous"/>

    <!-- css -->
    <link rel="stylesheet" href="css/style.css">

</head>
<body>

<?php include('layouts/navbar.php')?>

    <!-- Home -->
    <section id="home">
        <div class="container">
            <h5>NEW ARRIVALS</h5>
            <h1><span>Harga Terbaik</span> Di Tahun Ini!!!</h1>
            <p>Liquid rasa anggur mixed with leci.<br>Lorem, ipsum dolor sit amet consectetur adipisicing elit. Deserunt, cumque!</p>
            <button class="btn-shop-now" onclick="window.location.href='/shop-page.php'">Shop Now</button>
          </div> 
        <img class="imageHome" src="assets/images/liquid-anggur.png" alt="">
        <img class="blob" src="assets/images/blob.svg" alt="">
    </section>
    <!-- Home-end -->

    <!-- Featured -->
    <section id="featured" class="my-5 pb-5">
      <div class="Container text-center mt-5 py-5">
        <h3>Our Featured</h3>
        <hr>
        <br>
        <p>Here you can check out our featured products</p>
      </div>
      <div class="row mx-auto container-fluid">

      <?php include("server/get_featured_products.php"); ?>

      <?php while($row= $featured_products->fetch_assoc()) { ?>
       
        <div class="product text-center col-lg-3 col-md-4 col-sm-12">
        <a href="<?php echo "single-product.php?product_id=".$row['product_id'];?>">
          <img class="img-fluid mb-3" src="/assets/products/<?php echo $row['product_image'];?>"/>
        </a>
        <h5 class="p-name"><?php echo $row['product_name'];?></h5>
        <h4 class="p-price">IDR <?php echo number_format($row['product_price'], 0, ',', '.');?></h4>
        <a href="<?php echo "single-product.php?product_id=", $row['product_id'];?>"><button class="btn-buy">Buy</button></a>
      </div>
      
      <?php } ?>

      </div>
    </section>
    <!-- Featured-end -->

    <!-- Banner -->
    <section id="banner" class="my-5 pb-5">
      <div class="container">
        <h4>MID SEASON'S SALE</h4>
        <h1>Summer Collection <br> UP to 30% OFF</h1>
        <button class="btn-buy text-uppercase">shop now</button>
      </div>
    </section>
    <!-- Banner-End -->

    <!-- category Liquid -->
    <section id="featured" class="my-5 pb-5">
      <div class="Container text-center mt-5 py-5">
        <h3>Liquid</h3>
        <hr>
        <br>
        <p>Here you can check out our liquid products</p>
      </div>
      <div class="row mx-auto container-fluid">

      <?php include("server/get_liquid_products.php"); ?>

      <?php while($row= $liquid_products->fetch_assoc()) { ?>

        <div class="product text-center col-lg-3 col-md-4 col-sm-12">
        <a href="<?php echo "single-product.php?product_id=".$row['product_id'];?>">
          <img class="img-fluid mb-3" src="/assets/products/<?php echo $row['product_image'];?>"/>
        </a>
          <h5 class="p-name"><?php echo $row['product_name'];?></h5>
          <h4 class="p-price">IDR <?php echo number_format($row['product_price'], 0, ',', '.');?></h4>
          <a href="<?php echo "single-product.php?product_id=", $row['product_id'];?>"><button class="btn-buy">Buy</button></a>
        </div>

      <?php } ?>
      
      </div>
    </section>
    <!-- category liquid-end -->

    <!-- Brand -->
    <hr class="brand">
    <section id="brand">
      <img class="brand1" src="/assets/brands/hexohm.png" alt="">
      <img class="brand2" src="/assets/brands/jam-monster.png" alt="">
      <img class="brand3" src="/assets/brands/voopoo.png" alt="">
      <img class="brand4" src="assets/brands/oat-drips.png" alt="">
    </section>
    <!-- Brand-end -->

<?php include('layouts/footer.php')?>
