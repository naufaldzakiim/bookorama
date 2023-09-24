<?php
session_start();

if (!isset($_SESSION['username'])) {
  header('Location: ../login.php');
  exit;
}
require_once('../lib/db_login.php');
?>

<?php include("../header.php") ?>
<?php include("./recap_book_category.php") ?>
<?php include("./recap_order_book_category.php") ?>
<?php include("./list_book_category.php") ?>
<?php include("../footer.php") ?>