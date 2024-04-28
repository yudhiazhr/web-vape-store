<?php 
session_start();
include('../server/connection.php');
?>
<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="Mark Otto, Jacob Thornton, and Bootstrap contributors">
    <meta name="generator" content="Hugo 0.88.1">
    <title>Admin Vape Store</title>


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

<?php include('layouts/navbar.php'); ?>

<?php 

    if(isset($_GET['product_id'])){
        $product_id = $_GET['product_id'];

        $stmt = $conn -> prepare("SELECT * FROM products WHERE product_id=?");
        $stmt -> bind_param('i', $product_id);
        $stmt -> execute();
        $products = $stmt-> get_result();

    } else if (isset($_POST['edit_btn'])){

        $product_id = $_POST['product_id'];
        $name = $_POST['name'];
        $price = $_POST['price'];
        $offer = $_POST['offer'];
        $color = $_POST['color'];
        $category = $_POST['category'];
        $description = $_POST['description'];

       
        $stmt = $conn-> prepare("UPDATE products SET product_name=?, product_price=?, product_spesial_offer=?, 
                                                     product_color=?, product_category=?, product_description=? WHERE product_id=?");
        $stmt-> bind_param('ssssssi', $name, $price, $offer, $color, $category, $description, $product_id);

       if ($stmt-> execute()){
            header('location: products.php?edit_success_message=Product has been updated successfully');
        } else {
             header('location: products.php?edit_failure_message=Error occured, try again');
        }
    } else {
        header('products.php');
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

        <h2>Edit products</h2>
        <div class="table-responsive">
            <div class="form-edit-product">
                <form id="edit-form" method="POST" action="edit_product.php">

                <p style="color: red" class="text-center"><?php if(isset($_GET['error'])){ echo $_GET ['error']; }?></p>

                <?php foreach($products as $product) { ?>

                        <div class="form-group mt-2">

                        <input type="hidden" name= "product_id" value="<?php echo $product['product_id']; ?>" >

                            <label >Product name</label>
                            <input type="text"  value="<?php echo $product['product_name'] ?>" class="form-control" id="product-name" name="name" placeholder="" required>
                        </div>

                        
                        <div class="form-group mt-2">
                            <label >Product price</label>
                            <input type="text" value="<?php echo $product['product_price'] ?>"class="form-control" id="product-price" name="price" placeholder="" required>
                        </div>

                        
                        <div class="form-group mt-2">
                            <label >Product offer/sale</label>
                            <input type="text" value="<?php echo $product['product_spesial_offer'] ?>" class="form-control" id="product-offer" name="offer" placeholder="" required>
                        </div>
                        
                        <div class="form-group mt-2">
                            <label >Product color/size</label>
                            <input type="text" value="<?php echo $product['product_color'] ?>" class="form-control" id="product-color" name="color" placeholder="" required>
                        </div>

                        <div class="form-group mt-2">
                            <label>Category</label>
                            <select required name="category" class="form-select">
                                <option value="Box Mod">Box Mod</option>
                                <option value="Liquid">Liquid</option>
                            </select>
                        </div>

                        <div class="form-group mt-2">
                            <label >Product description</label>
                            <textarea type="text" class="form-control" id="product-description" name="description" placeholder="" required><?php echo $product['product_description'] ?></textarea>
                        </div>
        
                        <br>
                        <div class="form-group">
                            <input type="submit" class="btn btn-primary" id="edit-btn" name="edit_btn" value="edit">

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