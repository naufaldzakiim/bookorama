<?php
$dirname = dirname(__FILE__);
$qa_path = $dirname;
$qa_path = explode("\\", $qa_path);
$qa_path = $qa_path[count($qa_path) - 1];
$base_url = "http://localhost/" . $qa_path;

?>
<nav class="navbar navbar-expand-lg sticky-top bg-white">
  <div class="container">
    <a class="navbar-brand" href="#">Bookorama</a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarTogglerDemo02" aria-controls="navbarTogglerDemo02" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"><img src="./assets/hamburger-menu.png" alt="hamburger-menu" width="32px"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarTogglerDemo02">
      <ul class="navbar-nav me-auto mb-2 mb-lg-0">
        <li class="nav-item">
          <a class="nav-link" href="<?php echo $base_url . '/books/view.php' ?>">Books</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="<?php echo $base_url . '/customers/view.php' ?>">Customers</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="<?php echo $base_url . '/orders/view.php' ?>">Orders</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="<?php echo $base_url . '/recap/view.php' ?>">Recap</a>
        </li>
      </ul>
      <a class="btn btn-sm btn-danger" href="logout.php">Logout</a>
    </div>
  </div>
</nav>