<?php 

session_start();

if (!isset($_SESSION["logged_in"])) {
    header('location: login.php');
    exit();
}

if(isset($_GET['logout'])){
    if(isset($_SESSION['logged_in'])) {
        unset($_SESSION['logged_in']);
        unset($_SESSION['user_name']);
        unset($_SESSION['user_email']);
        header('location: login.php');
        exit();
    }
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
    <link rel="stylesheet" href="css/my-account.css">

</head>
<body>

    <!-- navbar -->
    <nav class="navbar navbar-expand-lg bg-body-tertiary fixed-top">
        <div class="container-fluid">
          <a class="navbar-brand" href="index.html"><span>V</span>APE STORE</a>
          <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
          </button>
          <div class="collapse navbar-collapse nav-buttons" id="navbarSupportedContent">
            <ul class="navbar-nav me-auto mb-2 mb-lg-0">

             <!-- Link -->
              <li class="nav-item">
                <a class="nav-link" href="index.html">Home</a>
              </li>

              <li class="nav-item">
                <a class="nav-link" href="shop-page.html">Shop</a>
              </li>

              <li class="nav-item">
                <a class="nav-link" href="cart-page.html">Cart</a>
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

    <!-- my account -->
    <section class="my-5 py-5">
        <div class="row container mx-auto">

            <div class="text-center mt-3 pt-5 col-lg-6 col-md-12 col-sm-12">
                <h3 class="font-weight-bold">My account</h3>
                <hr class="mx-auto">
                <div class="my-account-info">
                    <p>Name : <span><?php if(isset($_SESSION['user_name'])) { echo $_SESSION['user_name']; }?></span></p>
                    <p>Email : <span><?php if(isset($_SESSION['user_email'])) { echo $_SESSION['user_email']; }?></span></p>
                    <p><a href="#my-orders" id="my-orders-btn" class="btn">My orders</a></p>
                    <p><a href="my-account-page.php?logout=1" id="logout-btn" class="btn">Logout</a></p>
                </div>
            </div>

            <div class="col-lg-6 col-md-12 col-sm-12">
                <form id="my-account-form">
                    <h3>Change Password</h3>
                    <hr class="mx-auto">
                    
                    <div class="form-group">
                        <label >Password</label>
                        <input type="password" class="form-control" id="my-account-password" name="password" placeholder="Password" required>
                    </div>
    
                    <div class="form-group">
                        <label >Confirm Password</label>
                        <input type="password" class="form-control" id="my-account-confirm-password" name="confirm-password" placeholder="Confirm Password" required>
                    </div>
    
                    <div class="form-group">
                        <input type="submit" class="btn" id="change-pass-btn" value="Change Password">
                    </div>

                </form>
            </div>

        </div>
    </section>
    <!-- my account-end -->

    <!-- my orders -->
    <section id="my-orders" class="my-orders container my-2 py-3">
        <div class="container mt-5">
            <h2 class="font-weight-bold text-center">My orders</h2>
            <hr class="mx-auto">
        </div>
        
        <table class="mt-5 pt-5" >
            <tr>
                <th>Product</th>
                <th>date</th>
            </tr>

            <tr>
                <td>
                   <div class="product-info">
                    <img src="assets/products/hexohm-mod-blue.jpg" alt="">
                        <div>
                            <p class="mt-3">HEXOHM V3 Box Mod</p>
                            <small><span>IDR </span>699.000</small>
                        </div>
                    </div>
                </td>

                <td>
                    <span>2023-04-05</span>
                </td>
            </tr>

            <tr>
                <td>
                   <div class="product-info">
                    <img src="assets/products/oat.jpg" alt="">
                        <div>
                            <p class="mt-3">Oat drips original oat 30 ml</p>
                            <small><span>IDR </span>89.000</small>
                        </div>
                    </div>
                </td>

                <td>
                    <span>2023-04-05</span>
                </td>
                
            </tr>

        </table>

    </section>
    <!-- my orders-end -->

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