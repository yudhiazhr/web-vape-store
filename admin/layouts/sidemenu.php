<nav id="sidebarMenu" class="col-md-3 col-lg-2 d-md-block bg-light sidebar collapse">
      <div class="position-sticky pt-3">
        <ul class="nav flex-column">
          <li class="nav-item">
            <a class="nav-link" aria-current="page" href="index.php">
              <span data-feather="home"></span>
              Dashboard
            </a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="products.php">
              <span data-feather="file"></span>
              Products
            </a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="add_product.php">
              <span data-feather="file"></span>
              Add new product
            </a>
          </li>
        </ul>
      </div>
    </nav>

    <script>
    var currentUrl = window.location.href;

    var navLinks = document.querySelectorAll('.nav-link');

    navLinks.forEach(function(link) {
        if (currentUrl.indexOf(link.getAttribute('href')) !== -1) {
            link.classList.add('active');
        }
    });
</script>
