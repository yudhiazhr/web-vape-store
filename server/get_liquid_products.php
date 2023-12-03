<?php 

    include("connection.php");

   $stmt = $conn->prepare("SELECT * FROM products WHERE product_category= 'Liquid' LIMIT 4");

   $stmt->execute();

   $liquid_products = $stmt->get_result();

?>