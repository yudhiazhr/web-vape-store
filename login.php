<?php

session_start();

include("server/connection.php");

if (isset($_SESSION['logged_in'])) {
  header('location: index.php');
  exit();
}

if (isset($_POST["login-btn"])) {

  $email = $_POST['email'];
  $password = md5($_POST['password']);

  $stmt = $conn->prepare('SELECT user_id, user_name, user_email, user_password FROM users WHERE user_email=? AND user_password =? LIMIT 1');

  $stmt->bind_param('ss', $email, $password);

  if ($stmt->execute()) {
    $stmt->bind_result($user_id, $user_name, $user_email, $user_password);
    $stmt->store_result();

    if ($stmt->num_rows() == 1) {
      $stmt->fetch();

      $_SESSION['user_id'] = $user_id;
      $_SESSION['user_name'] = $user_name;
      $_SESSION['user_email'] = $user_email;
      $_SESSION['logged_in'] = true;

      header('location: index.php?login-success=logged in successfully');
    } else {
      header('location: login.php?error=could not verify your account');
    }
  } else {

    header('location: login.php?error=something went wrong');
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

  <!-- Login -->
  <section class="pt-48 h-[88.7dvh]">

    <div class="container flex justify-center">
      <div class="px-6 py-8 w-full md:w-[70%] lg:w-[55%] xl:w-[40%] min-h-[44dvh] border border-gray-100 rounded-xl shadow-xl bg-white">
        <h2 class=" text-xl leading-tight  tracking-tight font-bold md:text-2xl ">Sign in to your account</h2>
        <form action="login.php" method="POST" id="login-form" class="space-y-4 md:space-y-6">
          <p class="text-base text-red-700"><?php if (isset($_GET['error'])) {
                                              echo $_GET['error'];
                                            } ?></p>

          <div>
            <label for="" class="block mb-2 text-sm font-medium text-gray-400">Email</label>
            <input type="email" name="email" id="login-email" class="bg-gray-50 border border-gray-300 text-dark sm:text-sm rounded-lg block w-full p-2.5 " placeholder="Enter your email" required>
          </div>

          <div>
            <label for="" class="block mb-2 text-sm font-medium text-gray-400">Password</label>
            <input type="password" name="password" id="login-password" class="bg-gray-50 border border-gray-300 text-dark sm:text-sm rounded-lg block w-full p-2.5 " placeholder="Confirm your password" required>
          </div>
          <br>
          <button type="submit" id="login-btn" name="login-btn" class="w-full text-white bg-primary hover:bg-blue-500 focus:ring-4 focus:outline-none focus:ring-primary-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center ">Sign In</button>

          <p class="text-sm font-light text-gray-400 ">
            Don't have an account? <a href="sign-up.php" class="font-medium text-primary hover:underline dark:text-primary">Sign up</a>
          </p>
        </form>
      </div>
    </div>

  </section>
  <!-- login-end -->

  <?php include('layouts/footer.php') ?>

</body>

</html>