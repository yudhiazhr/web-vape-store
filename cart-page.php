<?php

session_start();

if (!isset($_SESSION["logged_in"])) {
    header('location: login.php');
    exit();
}

if (!isset($_SESSION['cart'])) {
    $_SESSION['cart'] = array();
}

if (!isset($_SESSION['total'])) {
    $_SESSION['total'] = 0;
}

if (isset($_POST['add_to_cart'])) {

    /* already added a product to cart */
    if (isset($_SESSION['cart'])) {

        $products_array_ids = array_column($_SESSION['cart'], "product_id");
        /* product already add in cart or not */
        if (!in_array($_POST['product_id'], $products_array_ids)) {

            $product_id = $_POST['product_id'];

            $product_array = array(
                'product_id' => $_POST['product_id'],
                'product_name' => $_POST['product_name'],
                'product_price' => $_POST['product_price'],
                'product_image' => $_POST['product_image'],
                'product_quantity' => $_POST['product_quantity']

            );
            $_SESSION['cart'][$product_id] = $product_array;

            /* product already add */
        } else {

            echo '<script>alert("Product was already to cart")</script>';
        }

        /* if is the first product */
    } else {
        $product_id = $_POST['product_id'];
        $product_name = $_POST['product_name'];
        $product_price = $_POST['product_price'];
        $product_image = $_POST['product_image'];
        $product_quantity = $_POST['product_quantity'];

        $product_array = array(
            'product_id' => $product_id,
            'product_name' => $product_name,
            'product_price' => $product_price,
            'product_image' => $product_image,
            'product_quantity' => $product_quantity

        );
        $_SESSION['cart'][$product_id] = $product_array;
    }

    // calculated total
    calculatedTotalCart();

    /* remove product from cart */
} else if (isset($_POST['remove_product'])) {

    $product_id = $_POST['product_id'];
    unset($_SESSION['cart'][$product_id]);

    calculatedTotalCart();
} else if (isset($_POST['edit_quantity'])) {

    // get id and quantity from the from
    $product_id = $_POST['product_id'];
    $product_quantity = $_POST['product_quantity'];

    //get the product array from the session
    $product_array = $_SESSION['cart'][$product_id];

    //update product quantity
    $product_array['product_quantity'] = $product_quantity;

    //return array back its place
    $_SESSION['cart'][$product_id] = $product_array;

    calculatedTotalCart();
} else {
}

function calculatedTotalCart()
{

    $total = 0;

    foreach ($_SESSION['cart'] as $key => $value) {
        $product = $_SESSION['cart'][$key];
        $price = $product['product_price'];
        $quantity = $product['product_quantity'];

        $total = $total + ($price * $quantity);
    }

    $_SESSION['total'] = $total;
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

    <!-- Cart -->

    <section class=" pt-36 pb-16 min-h-[88.5vh] ">
        <div class="container">
            <h2 class="font-bold text-xl md:text-2xl">Your Cart</h2>
            <hr class="mt-6 mb-6  border-t-2 border-gray-400">

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
                    <?php if (empty($_SESSION['cart'])) { ?>
                        <tr>
                            <td colspan="3">
                                <p class="text-center mt-1 pt-5">You haven't add product's yet</p>
                            </td>
                        </tr>
                    <?php } else { ?>
                        <?php foreach ($_SESSION['cart'] as $key => $value) { ?>
                            <tr class="border-b">
                                <td class="px-2 py-4">
                                    <div class=" px-6 flex flex-col md:flex-row gap-4 items-start">
                                        <img class="w-[120px] h-[120px] mr-4" src="assets/products/<?php echo $value['product_image']; ?>">
                                        <div class="flex flex-col ">
                                            <p><?php echo  $value['product_name']; ?></p>
                                            <medium>
                                                <h1 class="text-red-500">IDR <?php echo number_format($value['product_price'], 0, ',', '.'); ?></h1>
                                            </medium>
                                            <br>

                                            <form method="POST" action="cart-page.php">
                                                <input type="hidden" name="product_id" value="<?php echo $value['product_id']; ?>">
                                                <button type="submit" name="remove_product" class="w-24 text-white bg-primary hover:bg-blue-500 focus:outline-none focus:bg-gray-400 font-bold rounded-lg text-sm px-2 py-2 text-center ">Remove</button>
                                            </form>

                                        </div>
                                    </div>
                                </td>

                                <td>
                                    <form method="POST" action="cart-page.php">
                                        <div class="flex flex-col gap-4 items-start justify-center ">
                                            <input type="hidden" name="product_id" value="<?php echo $product_id; ?>">
                                            <input class="w-16  border border-gray-300 rounded-xl py-1 px-2" type="number" name="product_quantity" value="<?php echo  $value['product_quantity']; ?>" min="1" oninput="validity.valid||(value=1);">
                                            <button type="submit" name="edit_quantity" class="w-16 text-white bg-gray-700 hover:bg-gray-500 focus:outline-none focus:bg-gray-400 font-bold rounded-lg text-sm px-2 py-2 text-center ">Edit</button>
                                        </div>
                                    </form>

                                </td>

                                <td class="px-6 text-right">
                                    <span class="font-bold ">IDR <?php echo number_format($value['product_quantity'] * $value['product_price'], 0, ',', '.'); ?></span>
                                </td>

                            </tr>
                        <?php } ?>
                    <?php } ?>
                </table>
            </div>
        </div>
        <div class="container w-full flex flex-wrap justify-end py-6">
            <div class="px-6 ">
                <h1 class="text-sm md:text-base">Total :</h1>
                <table>
                    <tr class="px-6 py-3">
                        <td class="text-sm md:text-base lg:text-lg font-bold">IDR <?php echo number_format($_SESSION['total'], 0, ',', '.'); ?></td>
                    </tr>
                </table>
                <form method="POST" action="checkout-page.php">
                    <button type="submit" name="checkout" class="mt-4 w-full text-white bg-primary hover:bg-blue-500 focus:outline-none focus:bg-gray-400 font-bold rounded-lg text-sm px-2 py-2 text-center ">Checkout</button>
                </form>
            </div>
        </div>
    </section>
    <!-- Cart-end -->

    <?php include('layouts/footer.php') ?>
</body>

</html>