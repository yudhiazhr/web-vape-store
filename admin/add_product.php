
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

<?php include('layouts/navbar.php') ?>

<div class="container-fluid">
    <div class="row">

      <?php include('layouts/sidemenu.php');?>

      <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
        <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
          <h1 class="h2">Welcome <?php if(isset($_SESSION['admin_name'])) { echo $_SESSION['admin_name']; }?> 👋</h1>
        </div>

        <h2>Add new products</h2>
        <div class="table-responsive">
            <div class="create-product">
                <form id="create-product" enctype="multipart/form-data" method="POST" action="create_product.php">

                <p style="color: red" class="text-center"><?php if(isset($_GET['error'])){ echo $_GET ['error']; }?></p>

                

                        <div class="form-group mt-2">
                            <label >Product name</label>
                            <input type="text"  class="form-control" id="product-name" name="name" placeholder="" required>
                        </div>

                        
                        <div class="form-group mt-2">
                            <label >Product price</label>
                            <input type="text" class="form-control" id="product-price" name="price" placeholder="" required>
                        </div>

                        
                        <div class="form-group mt-2">
                            <label >Product offer/sale</label>
                            <input type="text" class="form-control" id="product-offer" name="offer" placeholder="" required>
                        </div>
                        
                        <div class="form-group mt-2">
                            <label >Product color/size</label>
                            <input type="text"  class="form-control" id="product-color" name="color" placeholder="" required>
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
                            <textarea type="text" class="form-control" id="product-description" name="description" placeholder="" required></textarea>
                        </div>

                        <div class="form-group mt-2">
                            <label >Product image 1</label>
                            <input type="file" class="form-control" id="image1" name="image1" placeholder="" required></input>
                        </div>
                        
                        <div class="form-group mt-2">
                            <label >Product image 2</label>
                            <input type="file" class="form-control" id="image2" name="image2" placeholder="" required></input>
                        </div>

                        <div class="form-group mt-2">
                            <label >Product image 3</label>
                            <input type="file" class="form-control" id="image3" name="image3" placeholder="" required></input>
                        </div>

                        <div class="form-group mt-2">
                            <label >Product image 4</label>
                            <input type="file" class="form-control" id="image4" name="image4" placeholder="" required></input>
                        </div>
        
                        <br>
                        <div class="form-group">
                            <input type="submit" class="btn btn-primary" id="create-btn" name="create_product" value="create">

                        </div>

        
                
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