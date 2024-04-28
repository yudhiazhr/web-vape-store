<?php
session_start();

include("../server/connection.php");

if (isset($_SESSION['admin_logged_in'])) {
  header('location: index.php');
  exit();
}

if (isset($_POST["login-btn"])) {

  $email = $_POST['email'];
  $password = md5($_POST['password']);

  $stmt = $conn->prepare('SELECT admin_id, admin_name, admin_email, admin_password FROM admins WHERE admin_email=? AND admin_password =? LIMIT 1');

  $stmt->bind_param('ss', $email, $password);

  if ($stmt->execute()) {
    $stmt->bind_result($admin_id, $admin_name, $admin_email, $admin_password);
    $stmt->store_result();

    if ($stmt->num_rows() == 1) {
      $stmt->fetch();

      $_SESSION['admin_id'] = $admin_id;
      $_SESSION['admin_name'] = $admin_name;
      $_SESSION['admin_email'] = $admin_email;
      $_SESSION['admin_logged_in'] = true;

      header('location: index.php?login-success=logged in successfully');
    } else {
      header('location: login.php?error=could not verify your account');
    }
  } else {

    header('location: login.php?error=something went wrong');
  }
}

?>

<!doctype html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Admin Vape Store</title>

  <!-- Custom styles for this template -->
  <link href="../css/output.css" rel="stylesheet">

</head>

<body>

  <!-- LOGIN -->
  <section class="pt-24 h-[88.7dvh]">
    <div class="container border border-gray-100 rounded-xl shadow-xl bg-white">
      <div class="flex flex-col md:flex-row gap-4 items-center">
        <div class="flex justify-center w-full">
        <img class="" src="https://cdni.iconscout.com/illustration/premium/thumb/admin-control-panel-4487949-3722637.png?f=webp" alt="">
        </div>
        <div class="px-6 py-6 w-full">
        <h2 class=" text-xl leading-tight  tracking-tight font-bold md:text-2xl ">Welcome back</h2>
        <h2 class=" text-xl leading-tight  tracking-tight font-bold md:text-2xl ">To the administrative system of arraxys👋</h2>
        <br>
          <form action="login.php" enctype="multipart/form-data" method="POST" id="login-form">
            <p class="text-base text-red-700"><?php if (isset($_GET['error'])) {
                                                echo $_GET['error'];
                                              } ?></p>

            <div>
              <label for="" class="block mb-2 text-sm font-medium text-gray-400">Email</label>
              <input type="email" name="email" id="login-email" class="bg-gray-50 border border-gray-300 text-dark sm:text-sm rounded-lg block w-full p-2.5 " placeholder="Enter your email" required>
            </div>

            <div>
              <label for="" class="block mb-2 text-sm font-medium text-gray-400">Password</label>
              <input   autocomplete="on" type="password" name="password" id="login-password" class="bg-gray-50 border border-gray-300 text-dark sm:text-sm rounded-lg block w-full p-2.5 " placeholder="Confirm your password" required>
            </div>
            <br>
            <button type="submit" id="login-btn" name="login-btn" class="w-full text-white bg-primary hover:bg-blue-500 focus:ring-4 focus:outline-none focus:ring-primary-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center ">Sign In</button>
          </form>
        </div>
      </div>
    </div>
  </section>

  <!-- <section class="login">
        <div class="text-center mt-3 pt-5">
            <h2 class="form-weight-bold">Login</h2>
            <hr class="mx-auto">
        </div>
        <div class=" container form-login">
            <form action="login.php" enctype="multipart/form-data" method="POST" id="login-form">

            <p style="color: red" class="text-center"><?php if (isset($_GET['error'])) {
                                                        echo $_GET['error'];
                                                      } ?></p>


                <div class="form-group">
                    <label >Email</label>
                    <input type="text" class="form-control" id="login-email" name="email" placeholder="Email" required>
                </div>

                <div class="form-group">
                    <label >Password</label>
                    <input type="password" class="form-control" id="login-password" name="password" placeholder="Password" required>
                </div>

                <div class="form-group">
                    <input type="submit" class="btn" id="login-btn" name="login-btn" value="Login">
                </div>
            </form>
        </div>
    </section> -->
  <!-- LOGIN-END -->



  <!-- <script src="js/bootstrap.bundle.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/feather-icons@4.28.0/dist/feather.min.js" integrity="sha384-uO3SXW5IuS1ZpFPKugNNWqTZRRglnUJK6UAZ/gxOX80nxEkN9NcGZTftn6RzhGWE" crossorigin="anonymous"></script>
  <script src="https://cdn.jsdelivr.net/npm/chart.js@2.9.4/dist/Chart.min.js" integrity="sha384-zNy6FEbO50N+Cg5wap8IKA4M/ZnLJgzc6w2NqACZaK0u0FXfOWRRJOnQtpZun8ha" crossorigin="anonymous"></script>
  <script src="js/dashboard.js"></script> -->

</body>

</html>