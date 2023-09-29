<!--File		: view_customer.php
	Deskripsi	: menampilkan data customers
-->
<?php include('../header.html') ?>
<br>
<div class="card">
<div class="card-header">Customers Data</div>
<div class="card-body">
<br>
<p>Contoh SQL Transaction</p>

<?php
// Include our login information
require_once('../lib/db_login.php');

//start transaction
$db->autocommit(FALSE);
$db->begin_transaction();
$query_ok = TRUE;

//cek query
$customerid = 1;
$amount = 300;
$date= '2022-06-01';
$orderid = 1002;
$books = array('0-672-31697-8' => 1, 
	'0-672-31769-9' => 2, 
	'0-672-31509-2' => 3);

$query1 = "INSERT INTO orders VALUES (".$orderid.", ".$customerid.", ".$amount.", '".$date."')";
if( !$db->query($query1)){
	$query_ok = FALSE;
	die ("Could not query the database: <br />". $db->error. "<br>Query: ". $query1);
}

foreach($books as $isbn => $qty){
	$query2 = "INSERT INTO order_items VALUES (".$orderid.", '".$isbn."', ".$qty.")";
	if( !$db->query($query2)){
		$query_ok = FALSE;
		die ("Could not query the database: <br />". $db->error. "<br>Query: ". $query2);
	}
}

//commit the query
if($query_ok){
	$db->commit();
	echo "Eksekusi berhasil!!!";
}else{
	$db->rollback();
	echo "Eksekusi Gagal!!!";
}

//close connection
$db->close();
?>
</div>
</div>
<?php include('../footer.html') ?>
