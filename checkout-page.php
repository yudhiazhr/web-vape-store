<?php 

session_start();

if(!empty($_SESSION['cart']) ){

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

    <?php include('layouts/navbar.php')?>

    <!-- checkout -->
    <section class="checkout my-5 py-5">
        <div class="container text-center mt-3 pt-5">
            <h2 class="form-weight-bold">Checkout</h2>
            <hr class="mx-auto">
        </div>
        <div class="mx-auto container">
            <form id="checkout-form" method="POST" action="server/place_order.php">
                
                <p class="text-center" style="color: red;" >
                    <?php if(isset($_GET['message'])) { echo $_GET['message']; }?>
                        <?php if(isset($_GET['message'])) { ?>
                            <a href="login.php" class="btn btn-primary">Login</a>
                        <?php } ?>
                </p>

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
                    <p>Total amount: $ <?php echo number_format($_SESSION['total'], 0 ,',', '.'); ?> </p>
                    <input type="submit" class="btn" id="checkout-btn" name="place_order" value="Place Order">
                </div>

            </form>
        </div>
    </section>
    <!-- checkout-end -->

    <?php include('layouts/footer.php')?>

</body>
</html>