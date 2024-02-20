<?php 
namespace Midtrans;
session_start();

if (isset($_POST['order_pay_btn'])) {
   $order_status =  $_POST['order_status'];
   $order_total_price = $_POST['order_total_price'];
}

// Set your server key
$server_key = 'SB-Mid-server-10Dr4ULfMa42pHA6VbJOxEOt';

if(isset($_POST['order_status']) && $_POST['order_status'] == "not paid") {
    // Include the Midtrans library
    require_once('midtrans/Midtrans.php');

    // Set your client key
    Config::$clientKey = 'SB-Mid-client-A4xo8S8KfljkK5QP';
    // Set your server key
    Config::$serverKey = $server_key;
    // Set to development mode
    Config::$isProduction = false;

    // Transaction details
    $transaction_details = array(
        'order_id' => 'ORDER-' . rand(),
        'gross_amount' => $_POST['order_total_price'], // amount in Rupiah
    );

    // Customer details
    $customer_details = array(
        'user_name'    => 'testing',
        'email'         => 'test@gmail.com',
    );

    // Transaction data
    $transaction_data = array(
        'transaction_details' => $transaction_details,
        'customer_details'    => $customer_details,
    );

    $snap_token = '';
try {
  $snap_token = Snap::getSnapToken($transaction_data);
}
catch (\Exception $e) {
    echo $e->getMessage();
}

function printExampleWarningMessage() {
    if (strpos(Config::$serverKey, 'your ') != false ) {
        echo "<code>";
        echo "<h4>Please set your server key from sandbox</h4>";
        echo "In file: " . __FILE__;
        echo "<br>";
        echo "<br>";
        echo htmlspecialchars('Config::$serverKey = \'SB-Mid-server-10Dr4ULfMa42pHA6VbJOxEOt\';');
        die();
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
    <link rel="stylesheet" href="css/checkout.css">

    <!-- JS -->
    <script type="text/javascript"
      src="https://app.sandbox.midtrans.com/snap/snap.js"
      data-client-key="SB-Mid-client-A4xo8S8KfljkK5QP"></script>

</head>
<body>

    

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
                    <input id="pay-button" type="submit" class="btn btn-primary" value="Pay now">
                    

    <script type="text/javascript">
      // For example trigger on button clicked, or any time you need
      var payButton = document.getElementById('pay-button');
      payButton.addEventListener('click', function () {
        // Trigger snap popup. @TODO: Replace TRANSACTION_TOKEN_HERE with your transaction token
        window.snap.pay('<?php echo $snap_token?>', {
          onSuccess: function(result){
            /* You may add your own implementation here */
            alert("payment success!"); console.log(result);
          },
          onPending: function(result){
            /* You may add your own implementation here */
            alert("wating your payment!"); console.log(result);
          },
          onError: function(result){
            /* You may add your own implementation here */
            alert("payment failed!"); console.log(result);
          },
          onClose: function(){
            /* You may add your own implementation here */
            alert('you closed the popup without finishing the payment');
          }
        })
      });
    </script>
            <?php } else { ?>
              <p>You dont have an order</p>
            <?php } ?>

        </div>
    </section>
    <!-- payment-end -->

    <?php include('layouts/footer.php')?>

</body>
</html>