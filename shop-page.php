<?php 


include("server/connection.php");

$stmt = $conn->prepare("SELECT * FROM products");

$stmt->execute();

$products = $stmt->get_result();

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
    <link rel="stylesheet" href="css/shop-page.css">

</head>
<body>

    <?php include('layouts/navbar.php')?>

      <!-- Search -->
      <!-- <section id="search" class="my-5 py-5 ms-2">
        <div class="container mt-5 py-5">
          <p>Search products</p>
          <hr>
        </div>

        <form action="">
          <div class="row mx-auto container">
            <div class="col-lg-12 col-sm-12 col-sm-12">

              <p>Category</p>
              <div class="form-check">
                <input type="radio" name="category" id="category-one" class="form-check-input">
                <label form="flexRadioDefault1" class="form-check-label">
                  Liquid
                </label>
              </div>

              <div class="form-check">
                <input type="radio" name="category" id="category-two" class="form-check-input" checked>
                <label form="flexRadioDefault2" class="form-check-label">
                  MOD
                </label>
              </div>

            </div>
          </div>

          <div class="row mx-auto container mt-5">
            <div class="col-lg-12 col-md-12 col-sm-12">

                <p>Price</p>
                <input type="text" class="form-range w-50" min="0" max="5000000" id="customRage2">
                <div class="w-50">
                  <span style="float: left;">1</span>
                  <span style="float: right;">5.000.000/span>
                </div>
            </div>
          </div>

          <div class="form-group my-3 mx-3">
            <input type="submit" name="search" value="Search" class="btn btn-primary">
          </div>

        </form>

      </section> -->
      <!-- Search-end -->
      
     <!-- Shop -->
     <section id="featured" class="my-5 py-5">
      <div class="container mt-5 py-5">
        <h3>Our Product</h3>
        <hr>
        <br>
        <p>Here you can check out our featured products</p>
      </div>
      <div class="row mx-auto container-fluid">


        <!-- Product -->
        <?php while ($row = $products->fetch_assoc()) { ?>
        <div class="product text-center col-lg-3 col-md-4 col-sm-12">
          <a href="<?php echo "single-product.php?product_id=".$row['product_id'];?>">
            <img  class="img-fluid mb-3" src="assets/products/<?php echo $row['product_image'];?>" width="500px" height="200px">
          </a>
          <h5 class="p-name"><?php echo $row['product_name'];?></h5>
          <h4 class="p-price"><?php echo $row['product_price'];?></h4>
          <a class="btn btn-buy" href="<?php echo "single-product.php?product_id=".$row['product_id'];?>" >Buy</a>
        </div>

        <?php } ?>
        <!-- Product-end -->

        <!-- pagination -->
        <nav aria-label="Page navigation example">
          <ul class="pagination mt-5">
            <li class="page-item"><a href="#" class="page-link">Previous</a></li>
            <li class="page-item"><a href="#" class="page-link">1</a></li>
            <li class="page-item"><a href="#" class="page-link">2</a></li>
            <li class="page-item"><a href="#" class="page-link">Next</a></li>
            
          </ul>
        </nav>
        <!-- pagination-end -->

      </div>
    </section>
    <!-- Shop-end -->

    <?php include('layouts/footer.php')?>

</body>
</html>