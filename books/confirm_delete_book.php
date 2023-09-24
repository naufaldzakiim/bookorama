<?php
session_start();

if (!isset($_SESSION['username'])) {
  header('Location: login.php');
  exit;
}
require_once('./lib/db_login.php');

$id = $_GET['id'];

$query = 'SELECT b.isbn as isbn, b.author as author, b.title as title, c.name as category, b.price as price
                FROM books b, categories c
                WHERE b.categoryid = c.categoryid';
$result = $db->query($query);

if (!$result) {
  die("Could not query the database: <br />" . $db->error . '<br>Query: ' . $query);
} else {
  while ($row = $result->fetch_object()) {
    $id = $row->isbn;
    $author = $row->author;
    $title = $row->title;
    $category = $row->category;
    $price = $row->price;
  }
}
?>

<?php include('./header.php') ?>
<br>
<div class="card mt-4">
  <div class="card-header">Delete User Confirmation</div>
  <div class="card-body">
    <div>
      <h5>Are you sure want to delete this book?</h5>
      <label>ISBN: <?= $id; ?></label><br>
      <label>Author: <?= $author; ?></label><br>
      <label>Title: <?= $title; ?></label><br>
      <label>Category: <?= $category; ?></label><br>
      <label>Price: <?= $price; ?></label><br>
    </div>
    <div>
      <a class="btn btn-danger mb-4" href=<?php echo 'delete_book.php?id=' . $id ?>>Yes</a>
      <a class="btn btn-primary mb-4" href="view_books.php">Back</a>
    </div>
  </div>
</div>
<?php include('./footer.php') ?>
<?php
$db->close();
?>