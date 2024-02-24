<?php

session_start();
include("connection.php");

//if user not login
if(!isset($_SESSION['logged_in'])) {
    header('location: ../checkout-page.php?message=Please login/register to place an order');
    exit;
    
// if user login
}else{
    if(isset($_POST['place_order'])) {

        //get user info and store it in database
        $name = $_POST['name'];
        $email = $_POST['email'];
        $phone = $_POST['phone'];
        $city = $_POST['city'];
        $address = $_POST['address'];
        $order_cost = $_SESSION['total'];
        $order_status =  "not paid";
        $user_id = $_SESSION['user_id'];
        $order_date = $_POST['order_date'];
    
    
       $stmt = $conn-> prepare("INSERT INTO orders (order_cost, order_status, user_id, user_name, user_phone, user_city, user_address, order_date)
                         VALUES (?,?,?,?,?,?,?,?); ");
        
        $stmt->bind_param('isisssss',$order_cost, $order_status, $user_id, $name, $phone, $city, $address, $order_date);
    
        $stmt_status = $stmt->execute();
    
        if(!$stmt_status) {
            header('location: index.php');
            exit;
        }
    
        $order_id = $stmt -> insert_id;
    
        //get product from cart (from session)
        foreach ($_SESSION['cart'] as $key => $value) {
    
            $product = $_SESSION['cart'][$key];
            $product_id = $product['product_id'];
            $product_name = $product['product_name'];
            $product_image = $product['product_image'];
            $product_price = $product['product_price'];
            $product_quantity = $product['product_quantity'];
    
            //store each single item in order_items database
            $stmt1 = $conn->prepare("INSERT INTO order_item (order_id, product_id, product_name, product_image, product_price, product_quantity, user_id, order_date)
                            VALUES (?,?,?,?,?,?,?,?)");
    
            $stmt1->bind_param('iissiiis', $order_id, $product_id, $product_name, $product_image, $product_price, $product_quantity, $user_id, $order_date);
    
            $stmt1->execute();
        }
    
        //remove everything from cart
      
        $_SESSION['order_id'] = $order_id;
    
        //inform user whether everything is fine or there is a problem
        header ('location: ../my-account-page.php?order-status=Order placed successfully');
    }
}

?>