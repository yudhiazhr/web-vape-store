
    <!-- navbar -->
    <nav class="navbar navbar-expand-lg bg-body-tertiary fixed-top">
        <div class="container-fluid ">
          <a class="navbar-brand" href="index.php"><span>V</span>APE STORE</a>
          <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
          </button>
          <div class="nav-buttons" id="navbarSupportedContent">
            <ul class="navbar-nav me-auto mb-2 mb-lg-0">

             <!-- Link -->
              <li class="nav-item">
                <a class="nav-link" href="index.php">Home</a>
              </li>

              <li class="nav-item">
                <a class="nav-link" href="shop-page.php">Shop</a>
              </li>

              <?php if (isset($_SESSION['logged_in']) && $_SESSION['logged_in']) : ?>
                  <li class="nav-item">
                      <a href="cart-page.php" class="nav-link">Cart</a>
                  </li>
              <?php else : ?>
                  <li class="nav-item">
                     
                  </li>
              <?php endif; ?>
             
              <li class="nav-item">
                <a class="nav-link" href="contact-us-page.php">Contact</a>
              </li>
              <li>
              <?php
                if (isset($_SESSION['logged_in']) && $_SESSION['logged_in']) {
                  $user_email = isset($_SESSION['user_email']) ? $_SESSION['user_email'] : '';
                  echo '<a href="my-account-page.php" class="btn btn-primary">' . (strlen($user_email) > 20 ? substr($user_email, 0, 20) . '...' : $user_email) . '</a>';
                } else {
                  echo '<a href="login.php" class="nav-link">Login</a>';
                }
                ?>
              </li>
            <!-- Link-end -->
            </ul>
          </div>
        </div>
      </nav>
    <!-- navbar-end -->
