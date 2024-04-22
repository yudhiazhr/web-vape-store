<?php
session_start();
include("server/connection.php");

// Hitung jumlah total produk
$total_products = $conn->query("SELECT COUNT(*) as total FROM products")->fetch_assoc()['total'];

// Tentukan halaman saat ini
$current_page = isset($_GET['page']) && is_numeric($_GET['page']) ? $_GET['page'] : 1;

// Tentukan berapa banyak produk yang ingin ditampilkan per halaman
$products_per_page = 12;

// Hitung jumlah total halaman
$total_pages = ceil($total_products / $products_per_page);

// Hitung offset
$offset = ($current_page - 1) * $products_per_page;

// Query untuk membatasi hasil
$stmt = $conn->prepare("SELECT * FROM products LIMIT ?, ?");
$stmt->bind_param('ii', $offset, $products_per_page);
$stmt->execute();
$products = $stmt->get_result();
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

  <!-- Search -->
  <!-- <section id="search" class="my-5 py-5 ms-2">
        <div class="container mt-5 py-5">
          <p>Search products</p>
          <hr>
        </div>

        <form action="">
          <div class="row mx-auto container">
            <div class="col-lg-12 col-sm-12 col-sm-12">

              <p>Category</p>
              <div class="form-check">
                <input type="radio" name="category" id="category-one" class="form-check-input">
                <label form="flexRadioDefault1" class="form-check-label">
                  Liquid
                </label>
              </div>

              <div class="form-check">
                <input type="radio" name="category" id="category-two" class="form-check-input" checked>
                <label form="flexRadioDefault2" class="form-check-label">
                  MOD
                </label>
              </div>

            </div>
          </div>

          <div class="row mx-auto container mt-5">
            <div class="col-lg-12 col-md-12 col-sm-12">

                <p>Price</p>
                <input type="text" class="form-range w-50" min="0" max="5000000" id="customRage2">
                <div class="w-50">
                  <span style="float: left;">1</span>
                  <span style="float: right;">5.000.000/span>
                </div>
            </div>
          </div>

          <div class="form-group my-3 mx-3">
            <input type="submit" name="search" value="Search" class="btn btn-primary">
          </div>

        </form>

      </section> -->
  <!-- Search-end -->

  <!-- Shop -->
  <section id="featured" class="pt-24 pb-16 min-h-[87.8dvh]">
    <div class="container mt-5 py-5">
      <h4 class="font-semibold text-xl text-dark mb-2">Our Featured Products</h4>
      <hr class="mt-6 mb-6 w-1/3 border-t-2 border-gray-400">
      <p class="text-base mb-12">Here you can check out our featured products</p>
    </div>

    <!-- Product -->
    <div class="flex flex-wrap gap-12 container">
      <?php while ($row = $products->fetch_assoc()) { ?>
        <div class="text-center">
          <a href="<?php echo "single-product.php?product_id=" . $row['product_id']; ?>">
            <img class=" w-64 h-64 cursor-pointer transition ease-in-out duration-300 hover:opacity-70" src="/assets/products/<?php echo $row['product_image']; ?>" />
          </a>
          <h5 class="mt-4 text-base font-semibold"><?php echo $row['product_name']; ?></h5>
          <h4 class="mb-4 text-lg font-bold text-red-500">IDR <?php echo number_format($row['product_price'], 0, ',', '.'); ?></h4>
          <a href="<?php echo "single-product.php?product_id=", $row['product_id']; ?>"><button class="w-1/2 text-base font-semibold text-light bg-dark border border-transparent hover:bg-slate-700 py-3 px-5 rounded-full hover:shadow-lg transition duration-300 ease-in-out">Buy</button></a>
        </div>
      <?php } ?>
    </div>
    <!-- Product-End -->

    <!-- Pagination -->
    <div class="container">
      <h5 class="text-base text-gray-600 mt-12 mb-4">Page <?php echo "$current_page of $total_pages"; ?></h5>
      <nav class="flex " aria-label="Page navigation example">
        <ul class="flex gap-2">
          <!-- Previous Button -->
          <?php if ($current_page > 1) : ?>
            <li class="page-item">
              <a href="?page=<?php echo $current_page - 1; ?>" class=" bg-primary hover:bg-blue-500 text-white px-3 py-2 rounded-l-lg">Previous</a>
            </li>
          <?php endif; ?>

          <!-- Page Numbers -->
          <?php for ($page = 1; $page <= ceil($total_products / $products_per_page); $page++) : ?>
            <li class="page-item <?php echo $current_page == $page ? 'active' : ''; ?>">
              <a href="?page=<?php echo $page; ?>" class=" bg-primary hover:bg-blue-500 text-white px-3 py-2 <?php echo $current_page == $page ? 'rounded-lg' : 'rounded-md'; ?>"><?php echo $page; ?></a>
            </li>
          <?php endfor; ?>

          <!-- Next Button -->
          <?php if ($current_page < ceil($total_products / $products_per_page)) : ?>
            <li class="page-item">
              <a href="?page=<?php echo $current_page + 1; ?>" class=" bg-primary hover:bg-blue-500 text-white px-3 py-2 rounded-r-lg">Next</a>
            </li>
          <?php endif; ?>
        </ul>
      </nav>
    </div>
    <!-- Pagination-End -->
  </section>
  <!-- Shop-end -->

  <?php include('layouts/footer.php') ?>

</body>

</html>