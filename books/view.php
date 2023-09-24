<?php
session_start();

if (!isset($_SESSION['username'])) {
  header('Location: login.php');
  exit;
}

require_once('../lib/db_login.php');

if (isset($_GET['submit'])) {
  $search = $_GET['search'];
  if (gettype($search) == 'string') {
    $search = strtoupper($search);
  }
  $query = "SELECT b.isbn as isbn, b.author as author, b.title as title, c.name as category, b.price as price
            FROM books b, categories c
            WHERE b.categoryid = c.categoryid AND
            (b.isbn LIKE '%$search%' OR
            b.author LIKE '%$search%' OR
            b.title LIKE '%$search%' OR
            c.name LIKE '%$search%' OR
            b.price LIKE '%$search%')";
} else {
  $query = "SELECT b.isbn as isbn, b.author as author, b.title as title, c.name as category, b.price as price
            FROM books b, categories c
            WHERE b.categoryid = c.categoryid";
}

$result = $db->query($query);
if (!$result) {
  die("Could not query the database: <br />" . $db->error . '<br>Query: ' . $query);
}

?>

<?php include('../header.php') ?>
<div class="card mt-3">
  <div class="card-header">Books Data</div>
  <div class="card-body">
    <div class="mb-3 d-flex justify-content-between">
      <a href="add.php" class="btn btn-primary">+ Add New Book</a>
      <form action="" class="d-flex" method="GET">
        <input id="search" class="form-control me-2" name="search" type="text" placeholder="Search book">
        <button class="btn btn-outline-primary" name="submit" type="submit" value="submit">Search</button>
      </form>
    </div>
    <table class="table table-striped">
      <tr>
        <th>ISBN</th>
        <th>Author</th>
        <th>Title</th>
        <th>Category</th>
        <th>Price</th>
        <th>Action</th>
      </tr>
      <?php
      $i = 1;
      while ($row = $result->fetch_object()) {
        echo '<tr>';
        echo '<td>' . $row->isbn . '</td>';
        echo '<td>' . $row->author . '</td>';
        echo '<td>' . $row->title . '</td>';
        echo '<td>' . $row->category . '</td>';
        echo '<td>$' . $row->price . '</td>';
        echo '<td><a class="btn btn-warning btn-sm" href="edit.php?id=' . $row->isbn . '">Edit</a>' . '&nbsp;&nbsp;';
        echo '<a class="btn btn-danger btn-sm" href="confirm_delete.php?id=' . $row->isbn . '">Delete</a></td>';
        echo '</tr>';
        $i++;
      }
      echo '</table>';
      echo '<br />';
      echo 'Total Rows = ' . $result->num_rows;

      $result->free();
      $db->close();
      ?>
  </div>
</div>
<?php include('../footer.php') ?>