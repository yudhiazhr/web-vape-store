<?php 

session_start();

if (isset($_POST['order_pay_btn'])) {
   $order_status =  $_POST['order_status'];
   $order_total_price = $_POST['order_total_price'];

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

    <!-- payment -->
    <section class="payment my-5 py-5">
        <div class="container text-center mt-3 pt-5">
            <h2 class="form-weight-bold">Payment</h2>
            <hr class="mx-auto">
        </div>
        <div class="mx-auto container text-center">

            <?php if(isset($_SESSION['total']) && $_SESSION['total'] != 0 ) { ?>
               <p>Total payment: IDR <?php echo $_SESSION['total'];?></p>
               <input type="submit" class="btn btn-primary" value="Pay now">
                
            <?php } else if (isset($_POST['order_status']) && $_POST['order_status'] == "not paid") { ?>
                    <p>Total payment: IDR <?php echo $_POST['order_total_price'];?></p>
                    <input type="submit" class="btn btn-primary" value="Pay now">
            
            <?php } else { ?>
              <p>You dont have an order</p>
            <?php } ?>

        </div>
    </section>
    <!-- payment-end -->

    <?php include('layouts/footer.php')?>

</body>
</html>