<?php 
$db_host = '10.10.10.10';
$db_database = 'bookorama2';
$db_username = 'pbp';
$db_password = 'MENUGAS';

$db = new mysqli($db_host, $db_username, $db_password, $db_database);
if ($db->connect_errno) {
    die("Could not connect to the database: <br />" . $db->connect_error);
}

function test_input($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}
?>