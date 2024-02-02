

<!doctype html>
<html lang="en">
  <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="description" content="">
        <meta name="author" content="Mark Otto, Jacob Thornton, and Bootstrap contributors">
        <meta name="generator" content="Hugo 0.88.1">
        <title>Dashboard Template · Bootstrap v5.1</title>

        <link rel="canonical" href="https://getbootstrap.com/docs/5.1/examples/dashboard/">

        

        <!-- Bootstrap core CSS -->
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">

        <style>
        .bd-placeholder-img {
            font-size: 1.125rem;
            text-anchor: middle;
            -webkit-user-select: none;
            -moz-user-select: none;
            user-select: none;
        }

        @media (min-width: 768px) {
            .bd-placeholder-img-lg {
            font-size: 3.5rem;
            }
        }
        </style>

        
        <!-- Custom styles for this template -->
        <link href="css/dashboard.css" rel="stylesheet">
  </head>

    <body>

    <?php include('layouts/navbar.php');?>

    <?php 

    if(isset($_GET['order_id'])){

        $order_id = $_GET['order_id'];
        $stmt = $conn->prepare("SELECT * FROM orders WHERE order_id=?");
        $stmt -> bind_param('i', $order_id);
        $stmt -> execute();
        $order = $stmt->get_result();

    } else if (isset($_POST['edit_order'])){
        
        $order_status = $_POST['order_status'];
        $order_id = $_POST['order_id'];

        $stmt = $conn -> prepare("UPDATE orders SET order_status=? WHERE order_id=?");
        $stmt -> bind_param ('si', $order_status, $order_id);
    
        if ($stmt-> execute()){
            header('location: index.php?order_updated=Order has been updated successfully');
        } else {
            header('location: index.php?order_failed=Error occured, try again');
        }
    } else {
        header('index.php');
        exit();
    }

    ?>


        <div class="container-fluid">
            <div class="row">

            <?php include('layouts/sidemenu.php');?>

            <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
                <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
                <h1 class="h2">Welcome <?php if(isset($_SESSION['admin_name'])) { echo $_SESSION['admin_name']; }?> 👋</h1>
                </div>

                <h2>Edit order</h2>
                <div class="table-responsive">
                    <div class="form-edit-order">
                        <form id="edit-order-form" method="POST" action="edit_order.php">
                        
                            
                            <p style="color: red" class="text-center"><?php if(isset($_GET['error'])){ echo $_GET ['error']; }?></p>
                            
                            <?php foreach($order as $odr) { ?>

                                <div class="form-group my-3">
                                    <input type="hidden" name= "order_id" value="<?php echo $odr['order_id']; ?>" >

                                    <label >Order id</label>
                                    <input type="text"  value="<?php echo $odr['order_id']?>" class="form-control" id="order_id" name="order_id"readonly>
                                </div>

                                <div class="form-group mt-2">
                                    <label >Order price</label>
                                    <input type="text" value="IDR. <?php echo $odr['order_cost']?>" class="form-control" readonly>
                                </div>

                                <div class="form-group mt-2">
                                    <label>Order status</label>
                                    <select required name="order_status" class="form-select">
                                        <option value="not paid" <?php if($odr['order_status'] == 'not paid') {echo "selected";} ?> >Not Paid</option>
                                        <option value="paid" <?php if($odr['order_status'] == 'paid') {echo "selected";} ?> >Paid</option>
                                        <option value="shipped" <?php if($odr['order_status'] == 'shipped') {echo "selected";} ?>>Shipped</option>
                                        <option value="delivered" <?php if($odr['order_status'] == 'delivery') {echo "selected";} ?>>Delivered</option>
                                    </select>
                                </div>

                                <div class="form-group mt-2">
                                    <label >Order date</label>
                                    <textarea type="text" class="form-control" readonly><?php echo $odr['order_date']?></textarea>
                                </div>
                
                                <br>
                                <div class="form-group">
                                    <input type="submit" class="btn btn-primary" id="edit-btn" name="edit_order" value="edit">

                                </div>

                        <?php } ?>
                        </form>
                    </div>
                </div>
            </main>
            </div>
        </div>
        
            <script src="js/bootstrap.bundle.min.js"></script>
            <script src="https://cdn.jsdelivr.net/npm/feather-icons@4.28.0/dist/feather.min.js" integrity="sha384-uO3SXW5IuS1ZpFPKugNNWqTZRRglnUJK6UAZ/gxOX80nxEkN9NcGZTftn6RzhGWE" crossorigin="anonymous"></script>
            <script src="https://cdn.jsdelivr.net/npm/chart.js@2.9.4/dist/Chart.min.js" integrity="sha384-zNy6FEbO50N+Cg5wap8IKA4M/ZnLJgzc6w2NqACZaK0u0FXfOWRRJOnQtpZun8ha" crossorigin="anonymous"></script>
            <script src="js/dashboard.js"></script>
    </body>
</html>