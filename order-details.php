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

include('server/connection.php');

if (isset($_POST['order-details-btn']) && isset($_POST['order_id'])) {

    $order_id = $_POST['order_id'];
    $order_status = $_POST['order_status'];

    $stmt = $conn->prepare("SELECT * FROM order_item WHERE order_id=?");
    $stmt->bind_param('i', $order_id);
    $stmt->execute();
    $order_details = $stmt->get_result();

    $order_total_price = calculatedTotalOrderPrice($order_details);
    $total = $order_total_price;
} else {

    header('location: my-account-page.php');
    exit;
}


function calculatedTotalOrderPrice($order_details)
{

    $total = 0;

    foreach ($row = $order_details as $row) {

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

    <!-- fontawesome cdn -->
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.15.4/css/all.css" integrity="sha384-DyZ88mC6Up2uqS4h/KRgHuoeGwBcD4Ng9SiP4dIRy0EXTlnuz47vAwmeGwVChigm" crossorigin="anonymous" />

    <!-- css -->
    <link rel="stylesheet" href="css/output.css">

</head>

<body>

    <?php include('layouts/navbar.php') ?>

    <!-- order detail -->
    <section class=" pt-36 pb-16 min-h-[88.5vh] ">
        <div class="container">
            <div class="overflow-x-auto overflow-y-auto">
                <table class="w-full text-sm md:text-base  text-dark rounded-xl">
                    <tr class="bg-primary text-light ">
                        <th scope="col" class="px-6 py-3 text-left">
                            Product
                        </th>
                        <th scope="col" class=" py-3 text-left">
                            Quantity
                        </th>
                        <th scope="col" class="px-6 py-3 text-right">
                            Subtotal
                        </th>
                    </tr>

                    <?php foreach ($order_details as $row) { ?>
                        <tr class="border-b">
                            <td class="px-2 py-4">
                                <div class=" px-6 flex flex-col md:flex-row gap-4 items-start">
                                    <img class="w-[120px] h-[120px] mr-4" src="assets/products/<?php echo $row['product_image']; ?>">
                                    <div class="mt-6">
                                        <p><?php echo  $row['product_name']; ?></p>
                                        <medium>
                                            <h1 class="text-red-500">IDR <?php echo number_format($row['product_price'], 0, ',', '.'); ?></h1>
                                        </medium>
                                    </div>
                                </div>
                            </td>

                            <td class="px-6 ">
                                <span><?php echo $row['product_quantity']; ?></span>
                            </td>

                            <td class="px-6 text-right">
                                <span class="font-bold ">IDR <?php echo number_format($row['product_quantity'] * $row['product_price'], 0, ',', '.'); ?></span>
                            </td>

                        </tr>
                    <?php } ?>
                </table>
            </div>
        </div>
        <div class="container w-full flex flex-wrap justify-end py-6">
            <div class="px-6 ">
            <h1 class="text-sm md:text-base">Total :</h1>
                <table>
                    <tr class="px-6 py-3">
                        <td class="text-sm md:text-base lg:text-lg font-bold">IDR <?php echo number_format($total, 0, ',', '.'); ?></td>
                    </tr>
                </table>

                <?php if ($order_status == "not paid") { ?>
                    <form style="float: right;" method="POST" action="payment-page.php">
                        <input type="hidden" name="order_total_price" value="<?php echo $order_total_price ?>">
                        <input type="hidden" name="order_status" value="<?php echo $order_status ?>">
                        <input type="hidden" name="order_id" value="<?php echo $order_id ?>">
                        <button type="submit" name="order_pay_btn" class="mt-4 text-white bg-primary hover:bg-blue-500 focus:outline-none focus:bg-gray-400 font-bold rounded-lg text-sm  px-6 py-2 text-center ">Pay now</button>
                    </form>
                <?php } ?>

            </div>
        </div>
    </section>
    <!-- order detail -->

    <?php include('layouts/footer.php') ?>

</body>

</html>