<?php
session_start();

include("server/connection.php");

$exchange_rate_idr_to_usd = 15594;

if(isset($_POST['order_status']) && isset($_POST['order_total_price'])) {
    $order_status = $_POST['order_status'];
    $order_total_price_idr = $_POST['order_total_price'];
    $order_id = $_POST['order_id'];

    if($order_status === "not paid") {
        $amount_usd = $order_total_price_idr / $exchange_rate_idr_to_usd;
        $amount = number_format($amount_usd, 2, '.', ''); 
    } else {
        $amount_usd = $_SESSION['total'] / $exchange_rate_idr_to_usd;
        $amount = number_format($amount_usd, 2, '.', ''); 
        $order_id = $_SESSION['order_id'];
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

</head>
<body>

<?php include('layouts/navbar.php')?>


<!-- payment -->
<section id="payment" class="payment my-5 py-5">
    <div class="container text-center mt-3 pt-5">
        <h2 class="form-weight-bold">Payment</h2>
        <hr class="mx-auto">
    </div>
    <div class="mx-auto container text-center">
        <?php if (isset($order_status) && $order_status == "not paid"): ?>
            <p>Total payment: IDR <?= number_format($order_total_price_idr, 0 ,',', '.'); ?> or $ <?=  number_format($amount_usd, 2, '.', '');?></p> 
            <div class="pay-btn-container">
                <div id="paypal-button-container" class="pay-btn"></div>
            </div>
        <?php elseif(isset($_SESSION['total']) && $_SESSION['total'] != 0): ?>
            <p>Total payment: IDR <?= number_format($_SESSION['total'], 0 ,',', '.'); ?> or $ <?=  number_format($amount_usd, 2, '.', '');?></p>
            <div class="pay-btn-container">
                <div id="paypal-button-container" class="pay-btn"></div>
            </div>
        <?php else: ?>
            <p>You don't have an order</p>
        <?php endif; ?>
    </div>
</section>
<!-- payment-end -->

<?php include('layouts/footer.php')?>

<script src="https://www.paypal.com/sdk/js?client-id=ATmLx31OkFBDziChZjl14Jl2yOyvHzxPa6f_gTNqLgHcVrKTomOBO6AOqwM26eAx_1pCUl2YZRxNdyYd&currency=USD"></script>

<script>
    paypal.Buttons ({
        createOrder: function(data, actions) {
            return actions.order.create ({
                purchase_units: [{
                    amount: {
                        value: '<?= $amount; ?>'
                    }
                }]
            });
        },
        onApprove: function(data, actions) {
            return actions.order.capture().then(function(orderData) {
                console.log('Capture result', orderData, JSON.stringify(orderData, null, 2));
                var transaction = orderData.purchase_units[0].payments.captures[0];
                alert('Transaction '+ transaction.status + ': ' + transaction.id + '\n\nSee console for all available details');
                window.location.href = "server/complete_payment.php?transaction_id=" + transaction.id + "&order_id=<?= $order_id; ?>";
            })
        }
    }).render('#paypal-button-container')
</script>

</body>
</html>
