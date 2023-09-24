<?php
session_start();

if (!isset($_SESSION['username'])) {
  header('Location: login.php');
  exit;
}

include('../lib/db_login.php');

if (isset($_POST["submit"])) {
  $valid = TRUE;

  $isbn = test_input($_POST['isbn']);
  if ($isbn == '') {
    $error_isbn = "ISBN is required";
    $valid = FALSE;
  } else if (!preg_match('/^\d{1}-\d{3}-\d{5}-\d{1}$/', $isbn)) {
    $error_isbn = "Invalid ISBN format (X-XXX-XXXXX-X)";
    $valid = FALSE;
  }

  $author = test_input($_POST['author']);
  if ($author == '') {
    $error_author = "Author is required";
    $valid = FALSE;
  } else if (!preg_match("/^[a-zA-Z ]*$/", $author)) {
    $error_author = "Only letters and white space allowed";
    $valid = FALSE;
  }

  $title = test_input($_POST['title']);
  if ($title == '') {
    $error_title = "Title is required";
    $valid = FALSE;
  }

  $category = $_POST['category'];
  if ($category == '' || $category == 'none') {
    $error_category = "Category is required";
    $valid = FALSE;
  }

  $price = test_input($_POST['price']);
  if ($price == '') {
    $error_price = "Price is required";
    $valid = FALSE;
  } else if (!is_numeric($price)) {
    $error_price = "Only numeric values allowed";
    $valid = FALSE;
  } else if (!filter_var($price, FILTER_VALIDATE_FLOAT)) {
    $error_price = "Invalid float format";
    $valid = FALSE;
  }

  if ($valid) {
    $address = $db->real_escape_string($address);
    $query = "INSERT INTO books (isbn, author, title, categoryid, price) VALUES ('$isbn', '$author', '$title', '$category', '$price')";
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
          <?php
          $query = "SELECT * FROM categories";
          $result = $db->query($query);
          if (!$result) {
            die("Could not query the database: <br />" . $db->error . '<br>Query: ' . $query);
          }
          while ($row = $result->fetch_object()) {
            echo '<option value="' . $row->categoryid . '"';
            if (isset($category) && $category == $row->categoryid) {
              echo 'selected';
            }
            echo '>' . $row->name . '</option>';
          }
          ?>
        </select>
        <div class="error text-danger"><?php if (isset($error_category)) echo $error_category ?></div>
      </div>
      <div class="form-group">
        <label for="price">Price:</label>
        <input type="text" class="form-control" id="price" name="price" value=<?php if (isset($price)) echo $price; ?>>
        <div class="error text-danger"><?php if (isset($error_price)) echo $error_price ?></div>
      </div>
      <br>
      <button type="submit" class="btn btn-primary" name="submit" value="submit">Submit</button>
      <a href="view.php" class="btn btn-secondary">Cancel</a>
    </form>
  </div>
</div>