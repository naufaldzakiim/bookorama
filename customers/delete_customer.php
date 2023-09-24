<?php
session_start();

if (!isset($_SESSION['username'])) {
  header('Location: login.php');
  exit;
}
require_once('./lib/db_login.php');

$id = $_GET['id'];

$query = "DELETE FROM customers WHERE customerid = '" . $id . "'";
  $result = $db->query($query);
  if (!$result) {
    die("Could not query the database: <br />" . $db->error);
  } else {
    $db->close();
    header('Location: view_customers.php');
  }
?>