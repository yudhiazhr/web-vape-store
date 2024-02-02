<?php

include('../server/connection.php');

if(isset($_POST['create_product'])) {

    $product_name = $_POST['name'];
    $product_price = $_POST['price'];
    $product_spesial_offer = $_POST['offer'];
    $product_color = $_POST['color'];
    $product_category = $_POST['category'];
    $product_description = $_POST['description'];

    $product_image1 = $_FILES['image1']['name']; // updated variable
    $product_image2 = $_FILES['image2']['name']; // updated variable
    $product_image3 = $_FILES['image3']['name']; // updated variable
    $product_image4 = $_FILES['image4']['name']; // updated variable

    $image_name1 = $product_name . "_1." . pathinfo($_FILES['image1']['name'], PATHINFO_EXTENSION); // ensure correct extension
    $image_name2 = $product_name . "_2." . pathinfo($_FILES['image2']['name'], PATHINFO_EXTENSION); // ensure correct extension
    $image_name3 = $product_name . "_3." . pathinfo($_FILES['image3']['name'], PATHINFO_EXTENSION); // ensure correct extension
    $image_name4 = $product_name . "_4." . pathinfo($_FILES['image4']['name'], PATHINFO_EXTENSION); // ensure correct extension

    // Define allowed file extensions
    $allowed_extensions = array('jpg', 'jpeg', 'png');

    // Check if the uploaded files have allowed extensions
    if (in_array(pathinfo($_FILES['image1']['name'], PATHINFO_EXTENSION), $allowed_extensions) &&
        in_array(pathinfo($_FILES['image2']['name'], PATHINFO_EXTENSION), $allowed_extensions) &&
        in_array(pathinfo($_FILES['image3']['name'], PATHINFO_EXTENSION), $allowed_extensions) &&
        in_array(pathinfo($_FILES['image4']['name'], PATHINFO_EXTENSION), $allowed_extensions)) {

        // Upload images to assets folder
        move_uploaded_file($_FILES['image1']['tmp_name'], "../assets/products/" . $image_name1);
        move_uploaded_file($_FILES['image2']['tmp_name'], "../assets/products/" . $image_name2);
        move_uploaded_file($_FILES['image3']['tmp_name'], "../assets/products/" . $image_name3);
        move_uploaded_file($_FILES['image4']['tmp_name'], "../assets/products/" . $image_name4);

        $stmt = $conn->prepare("INSERT INTO products (product_name, product_price, product_spesial_offer, product_color, product_category, 
                                                       product_description, product_image, product_image2, product_image3, product_image4)
                                                       VALUES (?,?,?,?,?,?,?,?,?,?)");

        $stmt->bind_param('ssssssssss', $product_name, $product_price, $product_spesial_offer, $product_color, $product_category,
            $product_description, $image_name1, $image_name2, $image_name3, $image_name4);

        if ($stmt->execute()) {
            header('location: products.php?product_created=Product has been created successfully');
        } else {
            header('location: products.php?product_failed=Error occured, try again');
        }
    } else {
        header('location: products.php?product_failed=Only JPG, JPEG, and PNG files are allowed');
    }
}

?>
