<?php 
session_start();

if (!isset($_SESSION['username'])) {
  header('Location: login.php');
  exit;
}

require_once('../lib/db_login.php');

$id = $_GET['id'];

$query = "SELECT b.isbn as isbn, b.author as author, b.title as title, c.name as category, b.price as price
          FROM books b, categories c
          WHERE b.categoryid = c.categoryid AND b.isbn = '$id'";

$result = $db->query($query);
if (!$result) {
  die("Could not query the database: <br />" . $db->error . '<br>Query: ' . $query);
}
?>

<?php include('../header.php') ?>
<div class="card mt-3">
  <div class="card-header">Book Details</div>
  <div class="card-body">

  </div>
</div>
<?php include('../footer.php') ?>