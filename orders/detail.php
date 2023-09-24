<?php
session_start();

if (!isset($_SESSION['username'])) {
  header('Location: ../login.php');
  exit;
}
$id = $_GET['id'];
?>

<?php include('../header.php') ?>
<div class="card mt-3">
  <div class="card-header">Detail Order</div>
  <div class="card-body">
    <br>
    <table class="table table-striped">
      <tr>
        <th>No</th>
        <th>ISBN</th>
        <th>Nama Buku</th>
        <th>Jumlah Buku</th>
        <th>Harga</th>
        <th>Sub Total</th>
      </tr>
      <?php
      require_once('../lib/db_login.php');

      $query = "SELECT oi.orderid, b.isbn,b.title, oi.quantity,b.price, (b.price * oi.quantity) as sub_total  FROM order_items oi left join books b ON oi.isbn = b.isbn WHERE oi.orderid = $id ORDER BY oi.orderid ";
      $result = $db->query($query);
      if (!$result) {
        die("Could not query the database: <br />" . $db->error . '<br>Query: ' . $query);
      }

      $i = 1;
      $total = 0;
      while ($row = $result->fetch_object()) {
        echo '<tr>';
        echo '<td>' . $i . '</td>';
        echo '<td>' . $row->isbn . '</td>';
        echo '<td>' . $row->title . '</td>';
        echo '<td>' . $row->quantity . '</td>';
        echo '<td>' . $row->price . '</td>';
        echo '<td>' . $row->sub_total . '</td>';
        // echo '<td><a class="btn btn-primary btn-sm" href="detail.php?id=' . $row->orderid . '">View</a>&nbsp;&nbsp;';
        echo '</tr>';
        $total += $row->sub_total;
        $i++;
      }
      echo '<tr>';
      echo '<td colspan="5" class="text-center">Total</td>';
      echo '<td>' . $total . '</td>';
      echo '</tr>';

      echo '</table>';
      echo '<br>';
      echo 'Total Rows = ' . $result->num_rows;

      $result->free();
      $db->close();
      ?>
  </div>

</div>
<?php include('../footer.php') ?>