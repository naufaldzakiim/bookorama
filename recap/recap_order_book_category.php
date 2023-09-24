<?php
require_once('../lib/db_login.php');
// Simulasi pengambilan data dari PHP
$query_order_by_category = "SELECT count(b.isbn) as total, b.categoryid
                            from order_items oi
                            left join
                            books b
                            on b.isbn = oi.isbn
                            left join
                            categories c
                            on c.categoryid = b.categoryid
                            group by b.categoryid";

$result_order_by_category = $db->query($query_order_by_category);
if (!$result_order_by_category) {
  die("Could not query the database: <br />" . $db->error . '<br>Query: ' . $query_order_by_category);
}
$data_order_by_category = [];
while ($row = $result_order_by_category->fetch_object()) {
  $data_order_by_category[] = $row->total;
}

$query_category = "SELECT c.name as category_name, c.categoryid
                  from categories c
                  order by c.categoryid";

$result_category = $db->query($query_category);
if (!$result_category) {
  die("Could not query the database: <br />" . $db->error . '<br>Query: ' . $query_category);
}
$data_category = [];
while ($row = $result_category->fetch_object()) {
  $data_category[] = $row->category_name;
}
?>

<div class="card mt-3">
  <div class="card-header">Jumlah Order Buku berdasarkan kategori</div>
  <div class="card-body">
    <div>
      <canvas id="booksOrderChart"></canvas>
    </div>
  </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>
  const orderChart = document.getElementById('booksOrderChart');

  const dataOrder = <?php echo json_encode($data_order_by_category); ?>;

  const chartOrder = new Chart(orderChart, {
    type: 'bar',
    data: {
      labels: category,
      datasets: [{
        label: 'Order Buku Berdasarkan Kategori',
        data: dataOrder,
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
  chart1.config = {
    type: 'bar',
    data: chartOrder.data,
    options: {
      scales: {
        y: {
          beginAtZero: true
        }
      }
    },
  };
</script>