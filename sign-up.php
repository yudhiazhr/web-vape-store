<?php

session_start();

include("server/connection.php");

//if user has already sign-up then take user to account page
if (isset($_SESSION['logged_in'])) {
    header('location: my-account-page.php');
    exit;
}


if (isset($_POST["signup"])) {

    $name = $_POST['name'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $confirmPassword = $_POST['confirmPassword'];

    //if password dont match
    if ($password !== $confirmPassword) {
        header('location: sign-up.php?error=passwowrd dont match');
    } else if (strlen($password) < 6) {
        header('location: sign-up.php?error=password must be at least 6 characters');
    } else {
        //check whether there is a user with this email
        $stmt1 = $conn->prepare('SELECT count(*) FROM users where user_email=?');
        $stmt1->bind_param('s', $email);
        $stmt1->execute();
        $stmt1->bind_result($num_row);
        $stmt1->store_result();
        $stmt1->fetch();

        // if there is a user already registered with this email
        if ($num_row != 0) {
            header('location: sign-up.php?error=user with this email alreadey exists');
        } else {
            //create a new user
            $stmt = $conn->prepare('INSERT INTO users (user_name, user_email, user_password)
            VALUES (?,?,?)');

            $stmt->bind_param('sss', $name, $email, md5($password));

            if ($stmt->execute()) {
                $user_id = $stmt->insert_id;
                $_SESSION['user_id'] = $user_id;
                $_SESSION['user_email'] = $email;
                $_SESSION['user_name'] = $name;
                $_SESSION['logged_in'] = true;
                header('location: my-account-page.php?sign-up-success=You sign-up successfully');

                // account could not be created
            } else {
                header('location: sign-up.php?error=Could not create an account at the moment');
            }
        }
    }
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

    <!-- Sign up -->
    <section class="pt-32 h-[88.7dvh]">

        <div class="container flex justify-center">
            <div class="px-6 py-8 w-full md:w-[70%] lg:w-[55%] xl:w-[40%] min-h-[48dvh] border border-gray-100 rounded-xl shadow-xl bg-white">
                <h2 class=" text-xl leading-tight  tracking-tight font-bold md:text-2xl ">Sign up</h2>
                <form action="sign-up.php" method="POST" id="signup-form" class="space-y-4 md:space-y-6">
                    <p class="text-base text-red-700"><?php if (isset($_GET['error'])) {
                                                            echo $_GET['error'];
                                                        } ?></p>
                    <div>
                        <label for="" class="block mb-2 text-sm font-medium text-gray-400">Name</label>
                        <input type="text" name="name" id="signup-name" class="bg-gray-50 border border-gray-300 text-dark sm:text-sm rounded-lg block w-full p-2.5 " placeholder="Enter your name" required>
                    </div>

                    <div>
                        <label for="" class="block mb-2 text-sm font-medium text-gray-400">Email</label>
                        <input type="email" name="email" id="signup-email" class="bg-gray-50 border border-gray-300 text-dark sm:text-sm rounded-lg block w-full p-2.5 " placeholder="Enter your email" required>
                    </div>

                    <div>
                        <label for="" class="block mb-2 text-sm font-medium text-gray-400">Password</label>
                        <input type="password" name="password" id="signup-password" class="bg-gray-50 border border-gray-300 text-dark sm:text-sm rounded-lg block w-full p-2.5 " placeholder="Enter your password" required>
                    </div>

                    <div>
                        <label for="" class="block mb-2 text-sm font-medium text-gray-400">Confirm Password</label>
                        <input type="password" name="confirmPassword" id="signup-confirm-password" class="bg-gray-50 border border-gray-300 text-dark sm:text-sm rounded-lg block w-full p-2.5 " placeholder="Confirm your password" required>
                    </div>

                    <br>
                    <button type="submit" id="signup-btn" name="signup" class="w-full text-white bg-primary hover:bg-blue-500 focus:ring-4 focus:outline-none focus:ring-primary-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center ">Sign Up</button>

                    <p class="text-sm font-light text-gray-400 ">
                        Do you have an account? <a href="login.php" class="font-medium text-primary hover:underline dark:text-primary">Sign in</a>
                    </p>
                </form>
            </div>
        </div>
    </section>


    <!-- <section class="sign-up my-5 py-5">
        <div class="container text-center mt-3 pt-5">
            <h2 class="form-weight-bold">Sign up</h2>
            <hr class="mx-auto">
        </div>
        <div class="mx-auto container">
            <form action="sign-up.php" id="signup-form" method="POST">

            <p style="color: red"><?php if (isset($_GET['error'])) {
                                        echo $_GET['error'];
                                    } ?></p>
                
            <div class="form-group">
                    <label >Name</label>
                    <input type="text" class="form-control" id="signup-name" name="name" placeholder="Name" required>
                </div>

                <div class="form-group">
                    <label >Email</label>
                    <input type="text" class="form-control" id="signup-email" name="email" placeholder="Email" required>
                </div>

                <div class="form-group">
                    <label >Password</label>
                    <input type="password" class="form-control" id="signup-password" name="password" placeholder="Password" required>
                </div>

                <div class="form-group">
                    <label >Confirm Password</label>
                    <input type="password" class="form-control" id="signup-confirm-password" name="confirmPassword" placeholder="Confirm Password" required>
                </div>

                <div class="form-group">
                    <input type="submit" class="btn" id="signup-btn" name= "signup" value="Sign Up">
                </div>

                <div class="form-group">
                   <a id="login-url" href= "login.php" class="btn">Do you have account? Login</a>
                </div>

            </form>
        </div>
    </section> -->
    <!-- Sign up -end -->

    <?php include('layouts/footer.php') ?>

</body>

</html>