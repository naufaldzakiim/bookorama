<?php
	require_once('../lib/db_login.php');
	$name = $db->real_escape_string($_POST['name']);
	$email = $db->real_escape_string($_POST['email']);
	$address = $db->real_escape_string($_POST['address']);
	$city = $db->real_escape_string($_POST['city']);
	
	//Asign a query
	$query_email = " SELECT * FROM customers WHERE email='".$email."' ";
	$result_email = $db->query($query_email);
	if (!$result_email){
		die ("Could not query the database: <br>".$db->error.'<br>Query:'.$query_email);
	}else{
		if ($result_email->num_rows > 0){
			echo '<div class="alert alert-danger alert-dismissible">
					<strong>Error!</strong> Email already exists.<br>
				  </div>';
			exit;
		}
	}

	$query = " INSERT INTO customers (name, address, city, email) VALUES('".$name."','".$address."','".$city."','".$email."') ";
	$result = $db->query( $query );
	if (!$result){
		echo '<div class="alert alert-danger alert-dismissible">
				<strong>Error!</strong> Could not query the database<br>'.
				$db->error. '<br>query = '.$query.
			 '</div>';
	}else{
		echo '<div class="alert alert-success alert-dismissible">
				<strong>Success!</strong> Data has been added.<br>
				Name: '.$_POST['name'].'<br>
				Email: '.$_POST['email'].'<br>
				Address: '.$_POST['address'].'<br>
				City: '.$_POST['city'].'<br>
			  </div>';
	}
	//close db connection
	$db->close();
?>