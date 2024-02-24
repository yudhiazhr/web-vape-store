<?php 

session_start();
include('server/connection.php');

if (!isset($_SESSION["logged_in"])) {
    header('location: login.php');
    exit();
}

if(isset($_GET['logout'])){
    if(isset($_SESSION['logged_in'])) {
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
    if($password !== $confirmPassword) {
        header('location: my-account-page.php?error=passwowrd dont match');
    }else if(strlen($password) < 6){
        header('location: my-account-page.php?error=password must be at least 6 characters');
    }else{
        $stmt = $conn-> prepare("UPDATE users SET user_password=? WHERE user_email=?");
        $stmt-> bind_param('ss', md5($password), $user_email);
        
        if ($stmt-> execute()){
            header('location: my-account-page.php?message=password has been updated successfully');
        } else{
            header('location: my-account-page.php?error=could not update password ');
        }

    }
}

// get orders
if (isset($_SESSION['logged_in'])){
    
    $user_id = $_SESSION['user_id'];
    $stmt = $conn->prepare("SELECT * FROM orders WHERE user_id=? ORDER BY order_id DESC");

    $stmt->bind_param('i', $user_id);

    $stmt->execute();
 
    $orders = $stmt->get_result();
 
}

?>


<!DOCTYPE html>
<html lang="en">
<head>
  
    <!-- required meta tags -->
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Vape Store</title>

    <!-- bootsrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">

    <!-- fontawesome cdn -->
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.15.4/css/all.css" integrity="sha384-DyZ88mC6Up2uqS4h/KRgHuoeGwBcD4Ng9SiP4dIRy0EXTlnuz47vAwmeGwVChigm" crossorigin="anonymous"/>

    <!-- css -->
    <link rel="stylesheet" href="css/my-account.css">

</head>
<body>

    <?php include('layouts/navbar.php')?>

    <!-- my account -->
    <section class="my-5 py-5">
        <div class="row container mx-auto">

        <?php if(isset($_GET['payment_message'])) { ?>
            <p class="mt-5 text-center" style="color:green"><?php echo $_GET['payment_message']; ?></p>
        <?php } ?>

        <p class="mt-5 text-center" style="color:green"><?php if(isset($_GET['order-status'])){echo $_GET['order-status'];}?></p> 


            <div class="text-center mt-3 pt-5 col-lg-6 col-md-12 col-sm-12">
            <p class="text-center" style="color:green"><?php if(isset($_GET['sign-up-success'])){echo $_GET['sign-up-success'];}?></p> 
            <p class="text-center" style="color:green"><?php if(isset($_GET['login-success'])){echo $_GET['login-success'];}?></p> 

            
            <h3 class="font-weight-bold">My account</h3>
                <hr class="mx-auto">
                <div class="my-account-info">
                    <p>Name : <span><?php if(isset($_SESSION['user_name'])) { echo $_SESSION['user_name']; }?></span></p>
                    <p>Email : <span><?php if(isset($_SESSION['user_email'])) { echo $_SESSION['user_email']; }?></span></p>
                    <p><a href="#my-orders" id="my-orders-btn" class="btn">My orders</a></p>
                    <p><a href="my-account-page.php?logout=1" id="logout-btn" class="btn">Logout</a></p>
                </div>
            </div>

            <div class="col-lg-6 col-md-12 col-sm-12">
                <form id="my-account-form" method ="POST" action="my-account-page.php">
                <p class="text-center" style="color:red"><?php if(isset($_GET['error'])){echo $_GET['error'];}?></p>    
                <p class="text-center" style="color:green"><?php if(isset($_GET['message'])){echo $_GET['message'];}?></p> 
                <h3>Change Password</h3>
                    <hr class="mx-auto">
                    
                    <div class="form-group">
                        <label >New password</label>
                        <input type="password" class="form-control" id="my-account-password" name="password" placeholder="Password" required>
                    </div>
    
                    <div class="form-group">
                        <label >Confirm new password</label>
                        <input type="password" class="form-control" id="my-account-confirm-password" name="confirm-password" placeholder="Confirm Password" required>
                    </div>
    
                    <div class="form-group">
                        <input type="submit" class="btn" name="change-password" id="change-pass-btn" value="Change Password">
                    </div>

                </form>
            </div>

        </div>
    </section>
    <!-- my account-end -->

    <!-- my orders -->
    <section id="my-orders" class="my-orders container my-2 py-3">
    <div class="container mt-5">
        <h2 class="font-weight-bold text-center">My orders</h2>
        <hr class="mx-auto">
    </div>
    
    <?php if ($orders->num_rows > 0) { ?>
        <table class="mt-5 pt-5">
            <tr>
                <th>Order id</th>
                <th>Order cost</th>
                <th>Order status</th>
                <th>Order date</th>
                <th>Order details</th>
            </tr>

            <?php while ($row = $orders->fetch_assoc()) { ?>
                <tr>
                    <td><span><?php echo $row['order_id']; ?></span></td>
                    <td><span><?php echo number_format($row['order_cost'], 0, ',', '.'); ?></span></td>
                    <td><span><?php echo $row['order_status']; ?></span></td>
                    <td><span><?php echo $row['order_date']; ?></span></td>
                    <td>
                        <form method="POST" action="order-details.php">
                            <input type="hidden" value="<?php echo $row['order_status']; ?>" name="order_status">
                            <input type="hidden" value="<?php echo $row['order_id']; ?>" name="order_id">
                            <input type="submit" class="btn order-details-btn" value="details" name="order-details-btn">
                        </form>
                    </td>
                </tr>
            <?php } ?>
        </table>
        <?php } else { ?>
            <table class="mt-5 pt-5">
            <tr>
                <th>Order id</th>
                <th>Order cost</th>
                <th>Order status</th>
                <th>Order date</th>
                <th>Order details</th>
            </tr>

        </table>
            <p class="text-center mt-1 pt-5">Anda belum memesan apapun.</p> 
        <?php } ?>
    </section>
    <!-- my orders-end -->

    <?php include('layouts/footer.php')?>

</body>
</html>