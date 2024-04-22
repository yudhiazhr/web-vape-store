    <header class="bg-white absolute top-0 left-0 w-full flex items-center z-10">
      <div class="container">
        <div class="flex items-center justify-between relative">
          <div class="px-0">
            <a href="index.php" class="font-bold italic text-xl block py-6 lg:text-2xl"><span class="text-primary font-bold text-xl lg:text-3xl">V</span>apeStore</a>
          </div>
          <div class="flex items-center px-4">
            <button id="hamburger" name="hamburger" type="button" class="block absolute right-4 lg:hidden">
              <span class="hamburger-line transition duration-300 ease-in-out  origin-top-left"></span>
              <span class="hamburger-line transition duration-300 ease-in-out"></span>
              <span class="hamburger-line transition duration-300 ease-in-out  origin-bottom-left"></span>
            </button>
            <nav id="nav-menu" class="hidden absolute py-5 bg-white shadow-lg rounded-lg max-w-[250px] w-full right-0 top-full lg:block lg:static lg:bg-transparent lg:max-w-full lg:shadow-none lg:rounded-none">
              <ul class="block lg:flex">
                <li class="group">
                  <a href="index.php" class="text-base text-dark py-2 mx-8 flex group-hover:text-primary">Home</a>
                </li>
                <li class="group">
                  <a href="shop-page.php" class="text-base text-dark py-2 mx-8 flex group-hover:text-primary">Shop</a>
                </li>

                <?php if (isset($_SESSION['logged_in']) && $_SESSION['logged_in']) : ?>
                  <li class="group">
                    <a href="cart-page.php" class="text-base text-dark py-2 mx-8 flex group-hover:text-primary">Cart</a>
                  </li>
                <?php else : ?>
                  <li class="group">
                    <a href="login.php" class="text-base text-dark py-2 mx-8 flex group-hover:text-primary">Cart</a>
                  </li>
                <?php endif; ?>

                <li class="group">
                  <?php
                  if (isset($_SESSION['logged_in']) && $_SESSION['logged_in']) {
                    $user_email = isset($_SESSION['user_email']) ? $_SESSION['user_email'] : '';
                    echo '<a href="my-account-page.php" class="text-base text-dark py-2 mx-8 flex group-hover:text-primary">' . $user_email . '</a>';
                  } else {
                    echo '<a href="login.php" class="text-base text-dark py-2 mx-8 flex group-hover:text-primary">Login</a>';
                  }
                  ?>
                </li>
              </ul>
            </nav>
          </div>
        </div>
      </div>
    </header>

    <script src="js/navbar.js"></script>