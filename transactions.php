<?php
//Written by Kumar Vaibhav
//010110295
include 'navigation.php';

echo '<div style="margin-top: 7%" class="container-fluid">
<div class="row text-center" style="display:flex; flex-wrap:wrap;">';



 // Create connection to MySQL
$conn = new mysqli("localhost", "root", "", "Project3");
$uname = $_COOKIE['user'];

$query = "select id from Customers where username='$uname'";
$result = $conn->query($query);
if (!$result) die ("Database access failed: " . $conn->error);
if($result->num_rows) {
    $row = $result->fetch_array(MYSQLI_NUM);
    $result->close();
    $uuid = $row[0];
}

//Query to find the images bought by a user 
$queryT = "SELECT * FROM Transactions LEFT JOIN Images ON Transactions.imageId = Images.id WHERE Transactions.customerId = '$uuid'";
$resultT = $conn->query($queryT);
$rows = $resultT->num_rows;
for ($i = 0; $i < $rows; $i++) {
    $row1 = $resultT->fetch_array(MYSQLI_NUM);
    // var_dump($row1);
echo <<<_END
<div class="col-sm-3">
<div class="img-thumbnail shadow-lg p-3 mb-5 bg-white rounded"">
    <img class="img-fluid" src="$row1[10]">
    <div class="caption">
        <h4>By $row1[5]</h4>
    </div>
    <p>
        Category: $row1[5]<br>
        Size: $row1[6] * $row1[7]<br>
        <form method="POST" action="transactions.php">
            <input type="hidden" id="image_id" name="image_id" value="$row1[0]">
            <input type="hidden" id="image_path" name="image_path" value="$row1[6]">
            <input type="submit" class="btn btn-danger btn-sm" name="delete" value="Delete">
            <button class="btn btn-primary btn-sm">Download</button>
        </form>
    </p>
</div>
</div>

_END;
}
function get_post($conn, $var)
{
  return $conn->real_escape_string($_POST[$var]);
}
if (isset($_POST["delete"])) {
    deleteTransaction($conn, $_POST['image_id']);
}
function deleteTransaction($conn, $transactionid) {
    $delete_query = "DELETE FROM Transactions WHERE id='$transactionid'";
    $result_query = $conn->query($delete_query);
    if (!$result_query) die("Database access failed: " . $conn->error);
    echo "<script>alert(\"Successfully Deleted from Database\");</script>";
    header("Refresh:0; url=transactions.php");
}


?>
</div>
</div>
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>
</body>
</html>



