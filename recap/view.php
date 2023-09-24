<?php
session_start();

if (!isset($_SESSION['username'])) {
  header('Location: login.php');
  exit;
}
require_once('../lib/db_login.php');
// Simulasi pengambilan data dari PHP
$query_total_by_category = "SELECT count(b.isbn) as total, b.categoryid
            from books b
            group by b.categoryid
            order by b.categoryid
            ";

$result_total_by_category = $db->query($query_total_by_category);
if (!$result_total_by_category) {
  die("Could not query the database: <br />" . $db->error . '<br>Query: ' . $query_total_by_category);
}
$data_total_by_category = [];
while ($row = $result_total_by_category->fetch_object()) {
  $data_total_by_category[] = $row->total;
}

$query_category = "SELECT c.name as category_name, c.categoryid
            from categories c
            order by c.categoryid
            ";

$result_category = $db->query($query_category);
if (!$result_category) {
  die("Could not query the database: <br />" . $db->error . '<br>Query: ' . $query_category);
}
$data_category = [];
while ($row = $result_category->fetch_object()) {
  $data_category[] = $row->category_name;
}
?>

<?php include("../header.php") ?>
<div class="card mt-3">
  <div class="card-header">Recap on Chart</div>
  <div class="card-body">
    <div>
      <canvas id="booksTotalChart"></canvas>
    </div>
  </div>
</div>

<div class="card mt-3">
  <div class="card-header">Recap on Chart</div>
  <div class="card-body">
    <div>
      <canvas id="booksTotalChart"></canvas>
    </div>
  </div>
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

      $query = "SELECT c.categoryid, c.name AS 'category_name',
                JSON_ARRAYAGG(
                  JSON_OBJECT('isbn', b.isbn, 'title', b.title, 'author', b.author, 'price', b.price)
                ) AS 'books'
              FROM books b LEFT JOIN categories c
              ON b.categoryid = c.categoryid
              GROUP BY c.categoryid, c.name;";

      $result = $db->query($query);
      if (!$result) {
        die("Could not query the database: <br />" . $db->error . '<br>Query: ' . $query);
      }

      $currentCategory = "";
      while ($row = $result->fetch_object()) {
        echo '<tr>';
        $books = json_decode($row->books);
        echo '<th rowspan="' . count($books) . '">' . $row->category_name . '</td>';

        foreach ($books as $book) {
          if ($book != $books[0]) {
            echo '<tr>';
          }
          echo '<td>' . $book->isbn . '</td>';
          echo '<td>' . $book->title . '</td>';
          echo '<td>' . $book->author . '</td>';
          echo '<td>$' . $book->price . '</td>';
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

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>
  const ctx = document.getElementById('booksTotalChart');

  const dataFromPHP = <?php echo json_encode($data_total_by_category); ?>;

  const category = <?php echo json_encode($data_category); ?>;
  new Chart(ctx, {
    type: 'bar',
    data: {
      labels: category,
      datasets: [{
        label: 'Jumlah Buku Berdasarkan Kategori',
        data: dataFromPHP,
        borderWidth: 1
      }]
    },
    options: {
      scales: {
        y: {
          beginAtZero: true
        }
      }
    }
  });

  const config = {
    type: 'bar',
    data: data,
    options: {
      scales: {
        y: {
          beginAtZero: true
        }
      }
    },
  };
</script>
<?php include("../footer.php") ?>