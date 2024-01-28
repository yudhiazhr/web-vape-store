<?php 

session_start();

include("server/connection.php");

if(isset($_SESSION['logged_in'])) {
  header('location: my-account-page.php');
  exit();
}

if(isset($_POST["login-btn"])){

  $email = $_POST['email'];
  $password = md5($_POST['password']);

  $stmt = $conn->prepare('SELECT user_id, user_name, user_email, user_password FROM users WHERE user_email=? AND user_password =? LIMIT 1');

  $stmt->bind_param('ss', $email, $password);
  
  if($stmt->execute()){
    $stmt->bind_result($user_id, $user_name, $user_email, $user_password);
    $stmt->store_result ();

    if($stmt->num_rows() == 1) {
      $stmt->fetch();

      $_SESSION['user_id'] = $user_id;
      $_SESSION['user_name'] = $user_name; 
      $_SESSION['user_email'] = $user_email;
      $_SESSION['logged_in'] = true;

      header('location: my-account-page.php?login-success=logged in successfully');
    
    } else {
      header('location: login.php?error=could not verify your account');
    }
  
  } else {

    header('location: login.php?error=something went wrong');
  
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
    <link rel="stylesheet" href="css/login.css">

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

    <!-- Login -->
    <section class="login my-5 py-5">
        <div class="container text-center mt-3 pt-5">
            <h2 class="form-weight-bold">Login</h2>
            <hr class="mx-auto">
        </div>
        <div class="mx-auto container">
            <form action="login.php" method="POST" id="login-form">

            <p style="color: red" class="text-center"><?php if(isset($_GET['error'])){ echo $_GET ['error']; }?></p>


                <div class="form-group">
                    <label >Email</label>
                    <input type="text" class="form-control" id="login-email" name="email" placeholder="Email" required>
                </div>

                <div class="form-group">
                    <label >Password</label>
                    <input type="password" class="form-control" id="login-password" name="password" placeholder="Password" required>
                </div>

                <div class="form-group">
                    <input type="submit" class="btn" id="login-btn" name="login-btn" value="Login">
                </div>

                <div class="form-group">
                   <a href="sign-up.php" id="register-url" class="btn">Don't have account? Sign Up</a>
                </div>

            </form>
        </div>
    </section>
    <!-- login-end -->

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