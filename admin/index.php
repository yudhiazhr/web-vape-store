<?php include('layouts/navbar.php') ?>

<!-- secure navigation if user not login first, user cant direct to index/dashboard -->
<?php 
  if(!isset($_SESSION['admin_logged_in'])) {
    header('location: login.php');
    exit();
  }

?>

<?php 
    if(isset($_GET['page_no']) && $_GET['page_no']!=""){
      $page_no = $_GET['page_no'];
    } else {
      $page_no = 1;
    }

    $stmt1 = $conn->prepare("SELECT COUNT(*) As total_records FROM orders");
    $stmt1 -> execute();
    $stmt1 -> bind_result($total_records);
    $stmt1 -> store_result();
    $stmt1 -> fetch();

    $total_records_per_page = 10;

    $offset = ($page_no-1) * $total_records_per_page;

    $previous_page = $page_no - 1;
    $next_page = $page_no + 1;

    $adjacents = "2";

    $total_no_of_pages = ceil($total_records/$total_records_per_page);

  // get all product
    $stmt2 = $conn -> prepare("SELECT * FROM orders LIMIT $offset, $total_records_per_page");
    $stmt2 -> execute();
    $orders = $stmt2-> get_result();


?>


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
    
  <div class="container-fluid">
    <div class="row">

      <?php include('layouts/sidemenu.php');?>

      <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
        <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
          <h1 class="h2">Welcome <?php if(isset($_SESSION['admin_name'])) { echo $_SESSION['admin_name']; }?> 👋</h1>
        </div>

        <h2>Orders</h2>

        <!-- edit -->
        <?php if(isset($_GET['order_updated'])) {?>
          <p class="text-center" style="color: green;"><?php echo $_GET['order_updated']; ?></p>
        <?php } ?>

        <?php if(isset($_GET['order_failed'])) {?>
          <p class="text-center" style="color: red;"><?php echo $_GET['order_failed']; ?></p>
        <?php } ?>
        <!-- edit-end -->

        <div class="table-responsive">
          <table class="table table-striped table-sm">
            <thead>
              <tr>
                <th scope="col">#</th>
                <th scope="col">Order id</th>
                <th scope="col">Order status</th>
                <th scope="col">Order price</th>
                <th scope="col">User id</th>
                <th scope="col">Order date</th>
                <th scope="col">User phone</th>
                <th scope="col">User address</th>
                <th scope="col">Edit</th>
                <th scope="col">Delete</th>
              </tr>
            </thead>
            <tbody>
            <?php
            $count = 1;
            foreach ($orders as $order) {
            ?>
                <tr>
                    <td><?php echo $count; ?>. </td>
                    <td><?php echo $order['order_id'] ?></td>
                    <td><?php echo $order['order_status'] ?></td>
                    <td>IDR. <?php echo $order['order_cost'] ?></td>
                    <td><?php echo $order['user_id'] ?></td>
                    <td><?php echo $order['order_date'] ?></td>
                    <td><?php echo $order['user_phone'] ?></td>
                    <td><?php echo $order['user_address'] ?></td>
                    <td><a class="btn btn-primary" href="edit_order.php?order_id=<?php echo $order['order_id']; ?>">Edit</a></td>
                    <td><a class="btn btn-danger" href="">Delete</a></td>
                </tr>
            <?php
                $count++;
            } ?>
            </tbody>
          </table>

          <!-- pagination -->
          <nav aria-label="Page navigation example">
            <ul class="pagination mt-5">
              <li class="page-item"><a href="#" class="page-link">Previous</a></li>
              <li class="page-item"><a href="#" class="page-link">1</a></li>
              <li class="page-item"><a href="#" class="page-link">2</a></li>
              <li class="page-item"><a href="#" class="page-link">Next</a></li>
                  
            </ul>
          </nav>
          <!-- pagination-end -->

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
