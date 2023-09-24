<?php
session_start();

if (!isset($_SESSION['username'])) {
  header('Location: login.php');
  exit;
}
?>

<?php include('../header.php') ?>
<div class="card mt-3">
  <div class="card-header">Customers Data</div>
  <div class="card-body">
    <a href="add_customer.php" class="btn btn-primary mb-4">+ Add Customer Data</a>
    <br>
    <table class="table table-striped">
      <tr>
        <th>No</th>
        <th>ISBN</th>
        <th>Nama Buku</th>
        <th>Jumlah Buku</th>
        <th>Action</th>
      </tr>
      <?php
      require_once('../lib/db_login.php');

      $query = "SELECT oi.orderid, b.isbn,b.title, oi.quantity  FROM order_items oi left join books b ON oi.isbn = b.isbn ORDER BY oi.orderid";
      $result = $db->query($query);
      if (!$result) {
        die("Could not query the database: <br />" . $db->error . '<br>Query: ' . $query);
      }

      $i = 1;
      while ($row = $result->fetch_object()) {
        echo '<tr>';
        echo '<td>' . $i . '</td>';
        echo '<td>' . $row->isbn . '</td>';
        echo '<td>' . $row->title . '</td>';
        echo '<td>' . $row->quantity . '</td>';
        // echo '<td><a class="btn btn-primary btn-sm" href="detail.php?id=' . $row->orderid . '">View</a>&nbsp;&nbsp;';
        echo '</tr>';
        $i++;
      }

      echo '</table>';
      echo '<br>';
      echo 'Total Rows = ' . $result->num_rows;

      $result->free();
      $db->close();
      ?>
  </div>
</div>
<?php include('./footer.php') ?>