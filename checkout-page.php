<?php 

session_start();

if( !empty($_SESSION['cart']) && isset($_POST['checkout']) ){

    //user in


    //send user to home page or index
} else {
    header('location: index.php');
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
    <link rel="stylesheet" href="css/checkout.css">

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

    <!-- checkout -->
    <section class="checkout my-5 py-5">
        <div class="container text-center mt-3 pt-5">
            <h2 class="form-weight-bold">Checkout</h2>
            <hr class="mx-auto">
        </div>
        <div class="mx-auto container">
            <form id="checkout-form" method="POST" action="server/place_order.php">
                

                <div class="form-group checkout-small-element">
                    <label >Name</label>
                    <input type="text" class="form-control" id="checkout-name" name="name" placeholder="Name" required>
                </div>

                <div class="form-group checkout-small-element">
                    <label >Email</label>
                    <input type="text" class="form-control" id="checkout-email" name="email" placeholder="Email" required>
                </div>

                <div class="form-group checkout-small-element">
                    <label >Phone number</label>
                    <input type="tel" class="form-control" id="checkout-phone" name="phone" placeholder="Phone" required>
                </div>
                

                <div class="form-group checkout-small-element">
                    <label >City</label>
                    <input type="text" class="form-control" id="checkout-city" name="city" placeholder="City" required>
                </div>

                <div class="form-group checkout-large-element">
                    <label >Address</label>
                    <input type="text" class="form-control" id="checkout-address" name="address" placeholder="Address" required>
                </div>

                <div class="form-group checkout-btn-container">
                    <p>Total amount: $ <?php echo $_SESSION['total']; ?> </p>
                    <input type="submit" class="btn" id="checkout-btn" name="place_order" value="Place Order">
                </div>

            </form>
        </div>
    </section>
    <!-- checkout-end -->

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
    <!-- Footer-end -->

    <!-- Js dari bootsrap-->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>

</body>
</html>