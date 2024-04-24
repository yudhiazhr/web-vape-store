<?php

session_start();
include('server/connection.php');

if (!isset($_SESSION["logged_in"])) {
    header('location: login.php');
    exit();
}

if (isset($_GET['logout'])) {
    if (isset($_SESSION['logged_in'])) {
        unset($_SESSION['logged_in']);
        unset($_SESSION['user_name']);
        unset($_SESSION['user_email']);
        header('location: index.php');
        exit();
    }
}

if (isset($_POST['change-password'])) {

    $password = $_POST['password'];
    $confirmPassword = $_POST['confirm-password'];
    $user_email = $_SESSION['user_email'];


    //if password dont match
    if ($password !== $confirmPassword) {
        header('location: my-account-page.php?error=passwowrd dont match');
    } else if (strlen($password) < 6) {
        header('location: my-account-page.php?error=password must be at least 6 characters');
    } else {
        $stmt = $conn->prepare("UPDATE users SET user_password=? WHERE user_email=?");
        $stmt->bind_param('ss', md5($password), $user_email);

        if ($stmt->execute()) {
            header('location: my-account-page.php?message=password has been updated successfully');
        } else {
            header('location: my-account-page.php?error=could not update password ');
        }
    }
}

// get orders
if (isset($_SESSION['logged_in'])) {

    $user_id = $_SESSION['user_id'];
    $stmt = $conn->prepare("SELECT * FROM orders WHERE user_id=? ORDER BY order_id DESC");

    $stmt->bind_param('i', $user_id);

    $stmt->execute();

    $orders = $stmt->get_result();
}

?>


<!DOCTYPE html>
<html lang="en" class="scroll-smooth">

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

    <!-- my account -->
    <section class="pt-36 pb-16">
        <div class="container">
            <div class="text-center mb-6">

                <?php if (isset($_GET['payment_message'])) { ?>
                    <p class="mt-5 text-center" style="color:green"><?php echo $_GET['payment_message']; ?></p>
                <?php } ?>

                <p class="mt-5 text-center" style="color:green"><?php if (isset($_GET['order-status'])) {
                                                                    echo $_GET['order-status'];
                                                                } ?></p>

                <p class="text-center" style="color:red"><?php if (isset($_GET['error'])) {
                                                                echo $_GET['error'];
                                                            } ?></p>
                <p class="text-center" style="color:green"><?php if (isset($_GET['message'])) {
                                                                echo $_GET['message'];
                                                            } ?></p>
                <p class="text-center" style="color:green"><?php if (isset($_GET['sign-up-success'])) {
                                                                echo $_GET['sign-up-success'];
                                                            } ?></p>
                <p class="text-center" style="color:green"><?php if (isset($_GET['login-success'])) {
                                                                echo $_GET['login-success'];
                                                            } ?></p>

            </div>
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 border border-gray-200 rounded-xl shadow-xl  bg-white p-8">
                <div class="flex flex-col w-full justify-between ">
                    <div>
                        <h3 class="font-bold text-base">My Account</h3>
                        <hr class="mt-2 mb-2 w-1/4 border-t-2 border-gray-400">

                        <div class="flex gap-10 ">
                            <div>
                                <h1 class="text-base  text-gray-500">Name </h1>
                                <h1 class="text-base  text-gray-500">Email </h1>
                            </div>
                            <div class="mb-6">
                                <h1 class="text-base font-medium text-dark">: <?php if (isset($_SESSION['user_name'])) {
                                                                                    echo $_SESSION['user_name'];
                                                                                } ?></h1>
                                <h1 class="text-base font-medium text-dark">
                                    : <?php if (isset($_SESSION['user_email'])) {
                                            echo $_SESSION['user_email'];
                                        } ?>
                                </h1>
                            </div>
                        </div>


                    </div>
                    <div>
                        <button onclick="window.location.href='#my-orders'" class="mb-2 w-full text-white bg-primary hover:bg-blue-500 focus:outline-none focus:bg-gray-400 font-medium rounded-lg text-sm px-5 py-2.5 text-center ">My Orders</button>

                        <button onclick="window.location.href='my-account-page.php?logout=1'" id="logout-btn" class="w-full text-white bg-dark hover:bg-gray-700 focus:outline-none focus:bg-gray-400 font-medium rounded-lg text-sm px-5 py-2.5 text-center ">Logout</button>
                    </div>
                </div>


                <div>
                    <form id="my-account-form" method="POST" action="my-account-page.php">

                        <h3 class="font-bold text-base">Change Password</h3>
                        <hr class="mt-2 mb-2 w-1/4 border-t-2 border-gray-400">


                        <div class="form-group">
                            <label for="" class="block mb-2 text-base font-medium text-gray-400">New Password</label>
                            <input type="password" class="mb-4 bg-gray-50 border border-gray-300 text-dark sm:text-sm rounded-lg block w-full p-2.5" id="my-account-password" name="password" placeholder="Password" required>
                        </div>

                        <div class="form-group">
                            <label for="" class="block mb-2 text-base font-medium text-gray-400">Confirm Password</label>
                            <input type="password" class="mb-4 bg-gray-50 border border-gray-300 text-dark sm:text-sm rounded-lg block w-full p-2.5" id="my-account-confirm-password" name="confirm-password" placeholder="Confirm Password" required>
                        </div>

                        <button type="submit" name="change-password" id="change-pass-btn" class="w-full text-white bg-primary hover:bg-blue-500 focus:outline-none font-medium rounded-lg text-sm px-5 py-2.5 text-center ">Change Password</button>


                    </form>

                </div>

            </div>
        </div>
        </div>
    </section>
    <!-- my account-end -->

    <!-- my orders -->
    <section id="my-orders" class="mt-6 mb-16">
        <div class="container text-center mt-5 py-5">
            <h4 class="font-semibold text-xl md:text-2xl text-dark mb-2">My Orders</h4>
            <hr class="mt-6 mb-6  border-t-2 border-gray-400">

            <?php if ($orders->num_rows > 0) { ?>
                <div class="overflow-x-auto">
                    <table class="w-full text-sm md:text-base  text-dark rounded-xl">
                        <tr class="bg-primary text-light">
                            <th scope="col" class="px-6 py-3">
                                Order id
                            </th>
                            <th scope="col" class="px-6 py-3">
                                Order cost
                            </th>
                            <th scope="col" class="px-6 py-3">
                                Order status
                            </th>
                            <th scope="col" class="px-6 py-3">
                                Order date
                            </th>
                            <th scope="col" class="px-6 py-3">
                                Order details
                            </th>
                        </tr>

                        <?php while ($row = $orders->fetch_assoc()) { ?>
                            <tr class="even:bg-white odd:dark:bg-gray-200 text-center">
                                <td class="px-4 py-4"><span><?php echo $row['order_id']; ?></span></td>
                                <td><span><?php echo number_format($row['order_cost'], 0, ',', '.'); ?></span></td>
                                <td><span><?php echo $row['order_status']; ?></span></td>
                                <td><span><?php echo $row['order_date']; ?></span></td>
                                <td class="text-center">
                                    <form method="POST" action="order-details.php">
                                        <input type="hidden" value="<?php echo $row['order_status']; ?>" name="order_status">
                                        <input type="hidden" value="<?php echo $row['order_id']; ?>" name="order_id">
                                        <button type="submit" name="order-details-btn" onclick="window.location.href='#my-orders'" class="w-[80%] lg:w-1/2 text-white bg-gray-700 hover:bg-gray-500 focus:outline-none focus:bg-gray-400 font-bold rounded-lg text-sm px-2 py-2 text-center ">Detail</button>
                                    </form>
                                </td>
                            </tr>

                        <?php } ?>
                    </table>
                </div>
            <?php } else { ?>
                <div class="overflow-x-auto">
                    <table class="w-full text-sm text-left rtl:text-right text-dark ">
                        <tr class="bg-primary text-light">
                            <th scope="col" class="px-6 py-3">
                                Order id
                            </th>
                            <th scope="col" class="px-6 py-3">
                                Order cost
                            </th>
                            <th scope="col" class="px-6 py-3">
                                Order status
                            </th>
                            <th scope="col" class="px-6 py-3">
                                Order date
                            </th>
                            <th scope="col" class="px-6 py-3">
                                Order details
                            </th>
                        </tr>

                    </table>
                    <p class="text-center mt-1 pt-5">You haven't ordered anything yet</p>
                </div>
            <?php } ?>
        </div>

    </section>
    <!-- my orders-end -->

    <?php include('layouts/footer.php') ?>

</body>

</html>