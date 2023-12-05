<?php 

include("server/connection.php");

if(isset($_GET['product_id'])) {

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

    <!-- bootsrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">

    <!-- fontawesome cdn -->
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.15.4/css/all.css" integrity="sha384-DyZ88mC6Up2uqS4h/KRgHuoeGwBcD4Ng9SiP4dIRy0EXTlnuz47vAwmeGwVChigm" crossorigin="anonymous"/>

    <!-- css -->
    <link rel="stylesheet" href="css/single-product.css">

</head>
<body>

    <!-- navbar -->
    <nav class="navbar navbar-expand-lg bg-body-tertiary fixed-top">
        <div class="container-fluid">
          <a class="navbar-brand" href="index.php"><span>V</span>APE STORE</a>
          <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
          </button>
          <div class="collapse navbar-collapse nav-buttons" id="navbarSupportedContent">
            <ul class="navbar-nav me-auto mb-2 mb-lg-0">

             <!-- Link -->
              <li class="nav-item">
                <a class="nav-link" href="index.php">Home</a>
              </li>

              <li class="nav-item">
                <a class="nav-link" href="shop-page.html">Shop</a>
              </li>

              <li class="nav-item">
                <a class="nav-link" href="cart-page.php">Cart</a>
              </li>

              <li class="nav-item">
                <a class="nav-link" href="contact-us-page.html">Contact</a>
              </li>
            <!-- Link-end -->
            </ul>
            <!-- Login /Signup -->
            <div class="btn-login-signup d-grid gap-2 d-md-flex justify-content-md-end">
                <button type="button" class="btn btn-primary ">Login</button>
                <button type="button" class="btn btn-secondary">Sign Up</button>
            </div>
            <!-- Login /Signup-end -->
          </div>
        </div>
      </nav>
    <!-- navbar-end -->

    <!-- single product -->
      <section class="container single-product my-5 pt-5">
        <div class="row mt-5">

          <?php  while($row = $product->fetch_assoc()) { ?>

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
                <h2>IDR <?php echo $row['product_price']; ?></h2>

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
      </section>

      <!-- changeImgProduct.js -->
      <script src="js/changeImgProduct.js"></script>

    <!-- single product-end -->

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
        <img class="img-fluid mb-3" src="/assets/products/<?php echo $row['product_image'];?>"/>
        <h5 class="p-name"><?php echo $row['product_name'];?></h5>
        <h4 class="p-price">IDR <?php echo $row['product_price'];?></h4>
        <a href="<?php echo "single-product.php?product_id=", $row['product_id'];?>"><button class="btn-buy">Buy</button></a>
      </div>
      
      <?php } ?>

      </div>
    </section>
    <!-- Featured-end -->

    <!-- Footer -->
    <footer>
      <div class="container">
          <div class="foot-left">
            <h5>SUBSCRIBE NEWSLETTER</h5>
            <h5>FAQ</h5>
            <h5>CONTACT US</h5>
          </div>
          <div class="foot-right">
            <h5>Terms & Conditions</h5>
            <h5>Privacy Policy</h5>
            <div class="copyright">
              <h5>&copy; 2023 vapestore.com</h5>
            </div>
          </div>
      </div>
    </footer>
    <!-- Footer -->

    <!-- Js dari bootsrap-->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>

</body>
</html>