<?php 

session_start();

include("server/connection.php");

//if user has already sign-up then take user to account page
if (isset($_SESSION['logged_in'])) {
    header('location: my-account-page.php');
    exit;
 }


if(isset($_POST["signup"])) {

    $name = $_POST['name'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $confirmPassword = $_POST['confirmPassword'];

    //if password dont match
    if($password !== $confirmPassword) {
        header('location: sign-up.php?error=passwowrd dont match');
    }else if(strlen($password) < 6){
        header('location: sign-up.php?error=password must be at least 6 characters');
    } else {
        //check whether there is a user with this email
        $stmt1 = $conn->prepare('SELECT count(*) FROM users where user_email=?');
        $stmt1->bind_param('s', $email);
        $stmt1->execute();
        $stmt1->bind_result($num_row);
        $stmt1->store_result();
        $stmt1->fetch();
        
        // if there is a user already registered with this email
        if ($num_row != 0) {
            header('location: sign-up.php?error=user with this email alreadey exists');
        } else {
            //create a new user
            $stmt = $conn->prepare('INSERT INTO users (user_name, user_email, user_password)
            VALUES (?,?,?)');

            $stmt->bind_param('sss', $name, $email,md5($password));

           if ($stmt->execute()){
            $user_id = $stmt -> insert_id;
            $_SESSION['user_id'] = $user_id;
            $_SESSION['user_email'] = $email;
            $_SESSION['user_name'] = $name;
            $_SESSION['logged_in'] = true;
            header('location: my-account-page.php?sign-up-success=You sign-up successfully');

            // account could not be created
           } else {
            header('location: sign-up.php?error=Could not create an account at the moment');

           }

        }
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
    <link rel="stylesheet" href="css/signup.css">

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
                <a class="nav-link" href="shop-page.php">Shop</a>
              </li>

              <li class="nav-item">
                <a class="nav-link" href="cart-page.php">Cart</a>
              </li>

              <li class="nav-item">
                <a class="nav-link" href="contact-us-page.php">Contact</a>
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

    <!-- Sign up -->
    <section class="sign-up my-5 py-5">
        <div class="container text-center mt-3 pt-5">
            <h2 class="form-weight-bold">Sign up</h2>
            <hr class="mx-auto">
        </div>
        <div class="mx-auto container">
            <form action="sign-up.php" id="signup-form" method="POST">

            <p style="color: red"><?php if(isset($_GET['error'])){ echo $_GET ['error']; }?></p>
                
            <div class="form-group">
                    <label >Name</label>
                    <input type="text" class="form-control" id="signup-name" name="name" placeholder="Name" required>
                </div>

                <div class="form-group">
                    <label >Email</label>
                    <input type="text" class="form-control" id="signup-email" name="email" placeholder="Email" required>
                </div>

                <div class="form-group">
                    <label >Password</label>
                    <input type="password" class="form-control" id="signup-password" name="password" placeholder="Password" required>
                </div>

                <div class="form-group">
                    <label >Confirm Password</label>
                    <input type="password" class="form-control" id="signup-confirm-password" name="confirmPassword" placeholder="Confirm Password" required>
                </div>

                <div class="form-group">
                    <input type="submit" class="btn" id="signup-btn" name= "signup" value="Sign Up">
                </div>

                <div class="form-group">
                   <a id="login-url" href= "login.php" class="btn">Do you have account? Login</a>
                </div>

            </form>
        </div>
    </section>
    <!-- Sign up -end -->

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