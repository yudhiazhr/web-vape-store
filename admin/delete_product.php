<?php 
session_start();
include('../server/connection.php');

if(!isset($_SESSION['admin_logged_in'])) {
    header('location: login.php');
    exit();
}

if(isset($_GET['product_id'])) {
    $product_id = $_GET['product_id'];

    $stmt_select = $conn->prepare("SELECT product_image, product_image2, product_image3, product_image4 FROM products WHERE product_id=?");
    $stmt_select->bind_param('i', $product_id);
    $stmt_select->execute();
    $stmt_select->store_result();

    if($stmt_select->num_rows > 0) {
        $stmt_select->bind_result($image1, $image2, $image3, $image4);
        $stmt_select->fetch();

        // Delete product entry from the database
        $stmt_delete = $conn->prepare("DELETE FROM products WHERE product_id=?");
        $stmt_delete->bind_param('i', $product_id);
        if($stmt_delete->execute()) {
            // Delete images from the directory
            unlink("../assets/products/".$image1);
            unlink("../assets/products/".$image2);
            unlink("../assets/products/".$image3);
            unlink("../assets/products/".$image4);
            header('location: products.php?deleted_successfully=Product has been deleted successfully');
        } else {
            header('location: products.php?deleted_failure=Could not delete product');
        }
    } else {
        header('location: products.php?deleted_failure=Product not found');
    }
} 
?>
