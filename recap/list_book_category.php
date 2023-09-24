<?php

if (!isset($_SESSION['username'])) {
  header('Location: ../login.php');
  exit;
}
require_once('../lib/db_login.php');
$query = "SELECT c.categoryid, c.name AS 'category_name',
                JSON_ARRAYAGG(
                  JSON_OBJECT('isbn', b.isbn, 'title', b.title, 'author', b.author, 'price', b.price)
                ) AS 'books'
              FROM categories c LEFT JOIN books b
              ON b.categoryid = c.categoryid
              GROUP BY c.categoryid, c.name;";

$result = $db->query($query);
if (!$result) {
  die("Could not query the database: <br />" . $db->error . '<br>Query: ' . $query);
}
?>

<div class="card mt-3">
  <div class="card-header">Rekap Seluruh Buku Berdasarkan Kategori</div>
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
      $currentCategory = "";
      while ($row = $result->fetch_object()) {
        echo '<tr>';
        $books = json_decode($row->books);
        echo '<th rowspan="' . count($books) . '">' . $row->category_name . '</td>';

        foreach ($books as $book) {
          if ($book != $books[0]) {
            echo '<tr>';
          }
          echo '<td>' . (isset($book->isbn) ? $book->isbn : '-')  . '</td>';
          echo '<td>' . (isset($book->title) ? $book->title : '-') . '</td>';
          echo '<td>' . (isset($book->author) ? $book->author : '-')  . '</td>';
          echo '<td>' . (isset($book->price) ? '$' . $book->price : '-') . '</td>';
          echo '</tr>';
        }
      }
      echo '</table>';
      echo '<br />';
      echo 'Total Rows = ' . $result->num_rows;

      $result->free();
      $db->close();
      ?>
  </div>
</div>