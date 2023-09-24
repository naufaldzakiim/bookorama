<?php include('./header.php') ?>
<div class="card mt-3">
  <div class="card-header">Books Data</div>
  <div class="card-body">
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
      require_once('./lib/db_login.php');

      $query = "SELECT b.isbn as isbn, b.author as author, b.title as title, c.name as category, b.price as price FROM books b LEFT JOIN categories c on b.categoryid = c.categoryid";
      $result = $db->query($query);
      if (!$result) {
        die("Could not query the database: <br />" . $db->error . '<br>Query: ' . $query);
      }

      $i = 1;
      while ($row = $result->fetch_object()) {
        echo '<tr>';
        echo '<td>' . $row->isbn . '</td>';
        echo '<td>' . $row->title . '</td>';
        echo '<td>' . $row->category . '</td>';
        echo '<td>' . $row->author . '</td>';
        echo '<td>$' . $row->price . '</td>';
        echo '<td><a class="btn btn-warning btn-sm" href="edit_book.php?id=' . $row->isbn . '">Edit</a>&nbsp;&nbsp;';
        echo '<a class="btn btn-danger btn-sm" href="delete_book.php?id=' . $row->isbn . '">Delete</a></td>';
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
<?php include('./footer.php') ?>