<?php
session_start();

if(!isset($_SESSION['username'])){
    header('Location: login.php');
    exit;
}

include('../lib/db_login.php');

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
      header('Location: view.php');
    }
  }
}
?>

<?php include('../header.php') ?>
<br>
<div class="card mt-4">
  <div class="card-header">Add Book Data</div>
  <div class="card-body">
    <form method="POST" autocomplete="on">
      <div class="form-group">
        <label for="isbn">ISBN:</label>
        <input type="text" class="form-control" id="isbn" name="isbn" value=<?php if (isset($isbn)) echo $isbn; ?>>
        <div class="error text-danger"><?php if (isset($error_isbn)) echo $error_isbn ?></div>
      </div>
      <div class="form-group">
        <label for="author">Author:</label>
        <input type="text" class="form-control" id="author" name="author" value=<?php if (isset($author)) echo $author; ?>>
        <div class="error text-danger"><?php if (isset($error_author)) echo $error_author ?></div>
      </div>
      <div class="form-group">
        <label for="title">Title:</label>
        <input type="text" class="form-control" id="title" name="title" value=<?php if (isset($title)) echo $title; ?>>
        <div class="error text-danger"><?php if (isset($error_title)) echo $error_title ?></div>
      </div>
      <div class="form-group">
        <label for="category">Category:</label>
        <select name="category" id="category" class="form-control" required>
          <option value="none" <?php if (!isset($category)) echo 'selected' ?>>--Select a Category--</option>
          <option value="Technology" <?php if (isset($category) && $category == "Airport West") echo 'selected' ?>>Airport West</option>
          <option value="Box Hill" <?php if (isset($category) && $category == "Box Hill") echo 'selected' ?>>Box Hill</option>
          <option value="Yarraville" <?php if (isset($category) && $category == "Yarraville") echo 'selected' ?>>Yarraville</option>
        </select>
        <div class="error text-danger"><?php if (isset($error_category)) echo $error_category ?></div>
      </div>
      <br>
      <button type="submit" class="btn btn-primary" name="submit" value="submit">Submit</button>
      <a href="view.php" class="btn btn-secondary">Cancel</a>
    </form>
  </div>
</div>