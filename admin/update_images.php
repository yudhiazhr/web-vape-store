<?php 

include('../server/connection.php');

if(isset($_POST['update_image'])) {

    $product_id = $_POST['product_id'];

    // Inisialisasi nama gambar dengan string kosong untuk mencegah error
    $image_name1 = "";
    $image_name2 = "";
    $image_name3 = "";
    $image_name4 = "";

    // Memeriksa apakah file gambar di-upload dan mengatur nama gambar
    if($_FILES['image1']['size'] > 0) {
        $image_name1 = $_POST['product_name'] . "_1." . pathinfo($_FILES['image1']['name'], PATHINFO_EXTENSION);
        move_uploaded_file($_FILES['image1']['tmp_name'], "../assets/products/" . $image_name1);
    }

    if($_FILES['image2']['size'] > 0) {
        $image_name2 = $_POST['product_name'] . "_2." . pathinfo($_FILES['image2']['name'], PATHINFO_EXTENSION);
        move_uploaded_file($_FILES['image2']['tmp_name'], "../assets/products/" . $image_name2);
    }

    if($_FILES['image3']['size'] > 0) {
        $image_name3 = $_POST['product_name'] . "_3." . pathinfo($_FILES['image3']['name'], PATHINFO_EXTENSION);
        move_uploaded_file($_FILES['image3']['tmp_name'], "../assets/products/" . $image_name3);
    }

    if($_FILES['image4']['size'] > 0) {
        $image_name4 = $_POST['product_name'] . "_4." . pathinfo($_FILES['image4']['name'], PATHINFO_EXTENSION);
        move_uploaded_file($_FILES['image4']['tmp_name'], "../assets/products/" . $image_name4);
    }

    // Preparing the update query
    $stmt = $conn->prepare("UPDATE products SET product_image=?, product_image2=?, product_image3=?, product_image4=? WHERE product_id=?");

    // Binding parameters
    $stmt->bind_param('ssssi', $image_name1, $image_name2, $image_name3, $image_name4, $product_id);
                                
    // Executing the update query
    if($stmt->execute()) {
        header('location: products.php?images_updated=Images have been updated successfully');
    } else {
        header('location: products.php?images_failed=Error occurred, try again');
    }
}
?>
