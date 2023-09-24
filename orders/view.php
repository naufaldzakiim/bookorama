<?php
session_start();

if (!isset($_SESSION['username'])) {
  header('Location: login.php');
  exit;
}

require_once('../lib/db_login.php');

if (isset($_GET['submit'])) {
  $start_date = $_GET['start_date'];
  $end_date = $_GET['end_date'];
  $query = "SELECT o.orderid, c.name,o.amount, o.date  FROM orders o left join customers c ON o.customerid = c.customerid WHERE o.date BETWEEN '$start_date' AND '$end_date' ORDER BY o.orderid";
} else {
  $query = "SELECT o.orderid, c.name,o.amount, o.date  FROM orders o left join customers c ON o.customerid = c.customerid ORDER BY o.orderid";
}

$result = $db->query($query);
if (!$result) {
  die("Could not query the database: <br />" . $db->error . '<br>Query: ' . $query);
}

?>

<?php include('../header.php') ?>
<div class="card mt-3">
  <div class="card-header">Order Data</div>
  <div class="card-body">
    <form action="" method="GET" class="mb-3">
      <div class="d-flex flex-column">
        <label for="start_date">Start Date:</label>
        <input class="form-control" type="date" name="start_date" id="start_date">
        <br>
        <label for="end_date">End Date:</label>
        <input class="form-control" type="date" name="end_date" id="end_date">
        <br>
      </div>
      <button class="btn btn-outline-primary" name="submit" type="submit" value="submit">Filter</button>
    </form>
    <table class="table table-striped">
      <tr>
        <th>No</th>
        <th>Nama Customer</th>
        <th>Jumlah Order</th>
        <th>Tanggal</th>
        <th>Action</th>
      </tr>
      <?php
      $i = 1;
      while ($row = $result->fetch_object()) {
        echo '<tr>';
        echo '<td>' . $i . '</td>';
        echo '<td>' . $row->name . '</td>';
        echo '<td>' . $row->amount . '</td>';
        echo '<td>' . $row->date . '</td>';
        echo '<td><a class="btn btn-primary btn-sm" href="detail.php?id=' . $row->orderid . '">View</a>&nbsp;&nbsp;';
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
<?php include('../footer.php') ?>