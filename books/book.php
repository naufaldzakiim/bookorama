<?php 
session_start();

if (!isset($_SESSION['username'])) {
  header('Location: login.php');
  exit;
}

require_once('../lib/db_login.php');

$id = $_GET['id'];

$query = "SELECT b.isbn as isbn, b.author as author, b.title as title, c.name as category, b.price as price
          FROM books b, categories c
          WHERE b.categoryid = c.categoryid AND b.isbn = '$id'";

$result = $db->query($query);
if (!$result) {
  die("Could not query the database: <br />" . $db->error . '<br>Query: ' . $query);
}

if (isset($_POST['submit'])) {
  $review = $_POST['review'];
  $query = "INSERT INTO book_reviews (isbn, review) VALUES ('$id', '$review')";
  $result = $db->query($query);
  if (!$result) {
    die("Could not query the database: <br />" . $db->error . '<br>Query: ' . $query);
  }
  header('Location: book.php?id=' . $id);
  exit;
}
?>

<?php include('../header.php') ?>
<div class="card mt-3">
  <div class="card-header">Book Details</div>
  <div class="card-body">
    <?php
    echo '<table>';
    while ($row = $result->fetch_object()) {
      echo '<tr><td><strong>ISBN:</strong> '. $row->isbn .'</td></tr>';
      echo '<tr><td><strong>Author:</strong> '. $row->author .'</td></tr>';
      echo '<tr><td><strong>Title:</strong> '. $row->title .'</td></tr>';
      echo '<tr><td><strong>Category:</strong> '. $row->category .'</td></tr>';
      echo '<tr><td><strong>Price:</strong> '. $row->price .'</td></tr>';
    }
    echo '</table>'
    ?>
  </div>
</div>

<div class="card mt-3">
  <div class="card-header">Book Reviews</div>
  <div class="card-body">
    <?php 
    $query = "SELECT * FROM book_reviews WHERE isbn = '$id'";
    $result = $db->query($query);
    if (!$result) {
      die("Could not query the database: <br />" . $db->error . '<br>Query: ' . $query);
    }

    if ($result->num_rows > 0) {
      while ($row = $result->fetch_object()) {
        echo '<p class="card-text">' . $row->review . '</p>';
      }
    } else {
      echo '<p class="card-text">No reviews yet.</p>';
    }

    ?>
  </div>
</div>

<div class="card mt-3">
  <div class="card-header">Add a Review</div>
  <div class="card-body">
    <form action="" method="POST">
      <textarea name="review" class="form-control" rows="5" placeholder="Leave a review here" id="floatingTextarea"></textarea>
      <button class="btn btn-primary mt-3" type="submit" name="submit">Submit</button>
    </form>
  </div>
</div>
<?php include('../footer.php') ?>