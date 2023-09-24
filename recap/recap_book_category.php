<?php
require_once('../lib/db_login.php');
// Simulasi pengambilan data dari PHP
$query_total_by_category = "SELECT count(b.isbn) as total, b.categoryid, c.name as category_name
                            from categories c 
                            left join
                            books b
                            on c.categoryid = b.categoryid
                            group by c.categoryid,c.name
                            order by c.categoryid asc";

$result_total_by_category = $db->query($query_total_by_category);
if (!$result_total_by_category) {
    die("Could not query the database: <br />" . $db->error . '<br>Query: ' . $query_total_by_category);
}
$data_total_by_category = [];
$data_category = [];
while ($row = $result_total_by_category->fetch_object()) {
    $data_category[] = $row->category_name;
    $data_total_by_category[] = $row->total;
}
?>

<div class="card mt-3">
    <div class="card-header">Rekap Jumlah Buku Berdasarkan Kategori</div>
    <div class="card-body">
        <div>
            <canvas id="booksTotalChart"></canvas>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>
    const totalChart = document.getElementById('booksTotalChart');

    const dataTotal = <?php echo json_encode($data_total_by_category); ?>;

    const category = <?php echo json_encode($data_category); ?>;
    const chartTotal = new Chart(totalChart, {
        type: 'bar',
        data: {
            labels: category,
            datasets: [{
                label: 'Jumlah Buku Berdasarkan Kategori',
                data: dataTotal,
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

    chartTotal.config = {
        type: 'bar',
        data: chartTotal.data,
        options: {
            scales: {
                y: {
                    beginAtZero: true
                }
            }
        },
    };
</script>