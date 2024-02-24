<?php 


session_start();

if (!isset($_SESSION["logged_in"])) {
    header('location: login.php');
    exit();
}

  /* 
    not paid
    paid
    shipped
    delivered
  */

  include ('server/connection.php');

  if(isset($_POST['order-details-btn']) && isset($_POST['order_id'])) {

    $order_id = $_POST['order_id'];
    $order_status = $_POST['order_status'];

    $stmt = $conn->prepare("SELECT * FROM order_item WHERE order_id=?");
    $stmt-> bind_param('i', $order_id);
    $stmt-> execute();
    $order_details = $stmt->get_result();

    $order_total_price = calculatedTotalOrderPrice($order_details);

  } else {

    header ('location: my-account-page.php');
    exit;

  }


  function calculatedTotalOrderPrice ($order_details) {
    
    $total = 0;

    foreach($row = $order_details as $row) {

        $product_price = $row['product_price'];
        $product_quantity = $row['product_quantity'];

        $total = $total + ($product_price * $product_quantity);

    }
    return $total;
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

    <?php include('layouts/navbar.php')?>

    <!-- order detail -->
    <section id="my-orders" class="my-orders container my-5 py-3">
        <div class="container mt-5">
            <h2 class="font-weight-bold text-center">Order details</h2>
            <hr class="mx-auto">
        </div>
        
        <table class="mt-5 pt-5" >
            <tr>
                <th>Product </th>
                <th>Price</th>
                <th>Quantity</th>

            </tr>
            <?php foreach ($order_details as $row) { ?>
         
                <tr>
                    <td>
                    <div class="product-info">
                        <img src="assets/products/<?php echo $row['product_image'];?>">
                            <div>
                                <p class="mt-3"><?php echo $row['product_name'];?></p>
                            </div>
                        </div>
                      
                    </td>

                    <td>
                        <span><?php echo number_format($row['product_price'], 0, ',', '.');?></span>
                    </td>
                    <td>
                        <span><?php echo $row['product_quantity']; ?></span>
                    </td>
                  
                </tr>
              <?php } ?>
        </table>

        <?php if($order_status == "not paid"){?>
                <form style="float: right;" method="POST" action="payment-page.php">
                <input type="hidden" name="order_total_price" value="<?php echo $order_total_price ?>">
                <input type="hidden" name="order_status" value="<?php echo $order_status ?>">
                <input type="hidden" name="order_id" value="<?php echo $order_id ?>">
                <input class="btn btn-primary" name="order_pay_btn" type="submit" value="Pay Now" >
                </form>

        <?php } ?>
    </section>
    <!-- order detail -->
    
    <?php include('layouts/footer.php')?>

</body>
</html>