<?php
session_start();

if (!isset($_SESSION['username'])) {
  header('Location: login.php');
  exit;
}

include('./header.php');
?>
<br>
<div class="card">
  <div class="card-header">Admin Page</div>
  <div class="card-body">
    <p>Welcome...</p>
    <p>You are logged in as <b><?= $_SESSION['username']; ?></b></p>
  </div>
</div>
<?php include('./footer.php') ?>