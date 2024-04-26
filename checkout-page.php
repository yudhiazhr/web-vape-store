<?php

session_start();

if (!empty($_SESSION['cart'])) {

    //send user to home page or index
} else {
    header('location: index.php');
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

    <!-- checkout -->
    <section class=" pt-36 pb-16 min-h-[88.5vh] ">
        <div class="container">
            <h2 class="font-bold text-xl md:text-2xl">Checkout your order</h2>
            <hr class="mt-6 mb-6  border-t-2 border-gray-400">
            <form id="checkout-form" method="POST" action="server/place_order.php">
                <div class="grid grid-cols-1  md:grid-cols-2 gap-4 mb-4">
                    <div>
                        <label for="" class="block mb-2 text-sm md:text-base font-medium text-dark">Name</label>
                        <input type="text" id="checkout-name" name="name" class="bg-gray-50 border border-gray-300 text-dark sm:text-sm rounded-lg block w-full p-2.5 " placeholder="Enter your name" required>
                    </div>

                    <div>
                        <label for="" class="block mb-2 text-sm md:text-base font-medium text-dark">Email</label>
                        <input type="email" id="checkout-email" name="email" class="bg-gray-50 border border-gray-300 text-dark sm:text-sm rounded-lg block w-full p-2.5 " placeholder="Enter your email" required>
                    </div>

                    <div>
                        <label for="" class="block mb-2 text-sm md:text-base font-medium text-dark">Phone number</label>
                        <input type="tel" id="checkout-phone" name="phone" class="bg-gray-50 border border-gray-300 text-dark sm:text-sm rounded-lg block w-full p-2.5 " placeholder="Enter your phone number" required>
                    </div>
                    <div>
                        <label for="" class="block mb-2 text-sm md:text-base font-medium text-dark">City</label>
                        <input type="text" id="checkout-city" name="city" class="bg-gray-50 border border-gray-300 text-dark sm:text-sm rounded-lg block w-full p-2.5 " placeholder="Enter your city" required>
                    </div>
                </div>
                <div >
                    <label for="" class="block mb-2 text-sm md:text-base font-medium text-dark">Address</label>
                    <textarea type="text" id="checkout-address" name="address" class="bg-gray-50 border border-gray-300 text-dark sm:text-sm rounded-lg block w-full p-2.5 " placeholder="Enter your address" required></textarea>
                </div>

                <div class="flex flex-col text-right items-end justify-end py-6">
                    <div class="px-6 ">
                        <h1 class="text-sm md:text-base lg:text-lg ">Total amount: </h1>
                        <h1 class="text-sm md:text-base lg:text-lg font-bold"> IDR <?php echo number_format($_SESSION['total'], 0, ',', '.'); ?></h1>
                    </div>
                    <button type="submit" id="checkout-btn" name="place_order" class="mt-4 w-full text-white bg-primary hover:bg-blue-500 focus:outline-none focus:bg-gray-400 font-bold rounded-lg text-sm md:text-base  px-6 py-2.5 text-center ">Place Order</button>
                </div>
            </form>
        </div>
    </section>
    <!-- checkout-end -->

    <?php include('layouts/footer.php') ?>

</body>

</html>