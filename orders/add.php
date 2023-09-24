<?php
session_start();

if(!isset($_SESSION['username'])){
    header('Location: login.php');
    exit;
}

include('./lib/db_login.php');

if (isset($_POST["submit"])) {
  $valid = TRUE;

  $name = test_input($_POST['name']);
  if ($name == '') {
    $error_name = "Name is required";
    $valid = FALSE;
  } else if (!preg_match("/^[a-zA-Z ]*$/", $name)) {
    $error_name = "Only letters and white space allowed";
    $valid = FALSE;
  }

  $address = test_input($_POST['address']);
  if ($address == '') {
    $error_address = "Address is required";
    $valid = FALSE;
  }

  $city = $_POST['city'];
  if ($city == '' || $city == 'none') {
    $error_city = "City is required";
    $valid = FALSE;
  }

  if ($valid) {
    $address = $db->real_escape_string($address);
    $query = "INSERT INTO customers (name, address, city) VALUES ('" . $name . "', '" . $address . "', '" . $city . "')";
    $result = $db->query($query);
    if (!$result) {
      die("Could not query the database: <br />" . $db->error . '<br>Query: ' . $query);
    } else {
      $db->close();
      header('Location: view_customers.php');
    }
  }
}
?>

<?php include('./header.php') ?>
<br>
<div class="card mt-4">
  <div class="card-header">Add Customer Data</div>
  <div class="card-body">
    <form method="POST" autocomplete="on">
      <div class="form-group">
        <label for="name">Nama:</label>
        <input type="text" class="form-control" id="name" name="name" value=<?php if (isset($name)) echo $name; ?>>
        <div class="error text-danger"><?php if (isset($error_name)) echo $error_name ?></div>
      </div>
      <div class="form-group">
        <label for="name">Address:</label>
        <textarea class="form-control" name="address" id="address" rows="5"> <?php if (isset($address)) echo $address; ?>  </textarea>
        <div class="error text-danger"><?php if (isset($error_address)) echo $error_address ?></div>
      </div>
      <div class="form-group">
        <label for="city">City:</label>
        <select name="city" id="city" class="form-control" required>
          <option value="none" <?php if (!isset($city)) echo 'selected' ?>>--Select a city--</option>
          <option value="Airport West" <?php if (isset($city) && $city == "Airport West") echo 'selected' ?>>Airport West</option>
          <option value="Box Hill" <?php if (isset($city) && $city == "Box Hill") echo 'selected' ?>>Box Hill</option>
          <option value="Yarraville" <?php if (isset($city) && $city == "Yarraville") echo 'selected' ?>>Yarraville</option>
        </select>
        <div class="error text-danger"><?php if (isset($error_city)) echo $error_city ?></div>
      </div>
      <br>
      <button type="submit" class="btn btn-primary" name="submit" value="submit">Submit</button>
      <a href="view_customers.php" class="btn btn-secondary">Cancel</a>
    </form>
  </div>
</div>