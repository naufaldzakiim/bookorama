<?php 
session_start();

if (!isset($_SESSION['username'])) {
  header('Location: login.php');
  exit;
}
?>

<?php include("../header.php") ?>
<br>
<div class="card mt-3">
  <div class="card-header">Recap on Chart</div>
</div>
<div class="card mt-3">
  <div class="card-header">Recap on Table</div>
  <div class="card-body">
    <table class="table table-striped">
      <tr>
        <th>Category</th>
        <th>ISBN</th>
        <th>Title</th>
        <th>Author</th>
        <th>Price</th>
      </tr>
      <?php 
      require_once('../lib/db_login.php');
      $query = "SELECT b.isbn as isbn, b.author as author, b.title as title, c.name as category, b.price as price
                FROM books b, categories c
                WHERE b.categoryid = c.categoryid";

      $result = $db->query($query);
      if (!$result) {
        die("Could not query the database: <br />" . $db->error . '<br>Query: ' . $query);
      }

      $currentCategory = "";
      while ($row = $result->fetch_object()) {
        if ($currentCategory != $row->category) {
          // Start a new row for the category header.
          if ($currentCategory != "") {
            echo '</tr>';
          }
          echo '<tr>';
          echo '<td colspan="5"><strong>' . $row->category . '</strong></td>';
          echo '</tr>';
          $currentCategory = $row->category;
        }

        echo '<tr>';
        echo '<td></td>'; // Empty cell for category header row.
        echo '<td>' . $row->isbn . '</td>';
        echo '<td>' . $row->title . '</td>';
        echo '<td>' . $row->author . '</td>';
        echo '<td>$' . $row->price . '</td>';
        echo '</tr>';
      }
      echo '</table>';
      echo '<br />';
      echo 'Total Rows = ' . $result->num_rows;

      $result->free();
      $db->close();
      ?>
  </div>
</div>
<?php include("../footer.php") ?>