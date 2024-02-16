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
    if(isset( $_SESSION['cart'])) {

        $products_array_ids = array_column($_SESSION['cart'],"product_id");
        /* product already add in cart or not */
        if(!in_array($_POST['product_id'], $products_array_ids)) {

            $product_id = $_POST['product_id'];

            $product_array = array (
                'product_id' => $_POST['product_id'],
                'product_name'=> $_POST['product_name'],
                'product_price'=> $_POST['product_price'],
                'product_image'=> $_POST['product_image'],
                'product_quantity'=> $_POST['product_quantity']
    
                );
            $_SESSION['cart'][$product_id] = $product_array;

            /* product already add */
        } else {
            
            echo'<script>alert("Product was already to cart")</script>';

        }

        /* if is the first product */
    } else {
        $product_id = $_POST['product_id'];
        $product_name = $_POST['product_name'];
        $product_price = $_POST['product_price'];
        $product_image = $_POST['product_image'];
        $product_quantity = $_POST['product_quantity'];

        $product_array = array (
            'product_id' => $product_id,
            'product_name'=> $product_name,
            'product_price'=> $product_price,
            'product_image'=> $product_image,
            'product_quantity'=> $product_quantity

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

} else if (isset($_POST['edit_quantity']) ){

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

function calculatedTotalCart () {
    
    $total = 0;

    foreach($_SESSION['cart'] as $key => $value) {
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

    <!-- bootsrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">

    <!-- fontawesome cdn -->
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.15.4/css/all.css" integrity="sha384-DyZ88mC6Up2uqS4h/KRgHuoeGwBcD4Ng9SiP4dIRy0EXTlnuz47vAwmeGwVChigm" crossorigin="anonymous"/>

    <!-- css -->
    <link rel="stylesheet" href="css/cart-page.css">

</head>
<body>

    <?php include('layouts/navbar.php')?>

    <!-- Cart -->
    <section class="cart container my-5 py-5">
        <div class="container mt-5">
            <h2 class="font-weight-bold">Your Cart</h2>
            <hr>
        </div>
        
        <table class="mt-5 pt-5" >
            <tr>
                <th>Product</th>
                <th>Quantity</th>
                <th>Subtotal</th>
            </tr>

            <?php foreach($_SESSION['cart'] as $key => $value)  { ?>

            <tr>
                <td>
                    <div class="product-info">
                        <img src="assets/products/<?php echo $value ['product_image']; ?>">
                        <div>
                            <p><?php echo  $value ['product_name']; ?></p>
                            <small><span>IDR </span><?php echo number_format($value['product_price'], 0, ',', '.');?></small>
                            <br>

                            <form method ="POST" action="cart-page.php">
                                <input type="hidden" name="product_id" value="<?php echo $value['product_id']; ?>">
                                <input type="submit" name="remove_product" class="remove-btn" value="remove">
                            </form>
                           
                        </div>
                    </div>
                </td>

                <td>
                    
                    <form method="POST" action="cart-page.php">
                        <input type="hidden" name="product_id" value="<?php echo $value ['product_id'];?>">
                        <input type="number" name="product_quantity" value="<?php echo  $value['product_quantity']; ?>" min="1" oninput="validity.valid||(value=1);">
                        <input type="submit" class="edit-btn" value="edit" name="edit_quantity">
                    </form>

                </td>

                <td>
                    <span>IDR </span>
                    <span class="product-price"><?php echo number_format($value['product_quantity'] * $value ['product_price'], 0, ',', '.');?></span>
                </td>
            </tr>
            
            <?php } ?>
           
        </table>

        <div class="cart-total">
            <table>
                <tr>
                    <td>Total</td>
                    <td>IDR <?php echo number_format($_SESSION['total'], 0, ',', '.'); ?></td>
                </tr>
            </table>
        </div>
        <div class="checkout-container">
            <form method="POST" action="checkout-page.php">
                <input type="submit" class="btn checkout-btn" value="Checkout" name="checkout">
            </form>
        </div>

    </section>
    <!-- Cart-end -->

    <?php include('layouts/footer.php')?>

   
            
</body>
</html>