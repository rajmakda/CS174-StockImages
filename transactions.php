<?php
//Written by Kumar Vaibhav
//010110295
include 'navigation.php';
?>

<div style="margin-top: 7%" class="container-fluid">
<div class="row text-center" style="display:flex; flex-wrap:wrap;">

<?php

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
<div class="img-thumbnail shadow-lg p-1 mb-5 bg-white rounded"">
    <img class="img-fluid" src="$row1[10]">
    <div class="caption">
        <h4>By $row1[9]</h4>
    </div>
    <p>
        Category: $row1[5]<br>
        Size: $row1[6] * $row1[7]<br>
        <form method="POST" action="transactions.php">
            <input type="hidden" id="image_id" name="image_id" value="$row1[0]">
            <input type="hidden" id="image_path" name="image_path" value="$row1[6]">
            <input type="submit" class="btn btn-danger btn-sm" name="delete" value="Delete">
            <button class="btn btn-primary btn-sm"><a class="text-white" style="text-decoration:none" href="download.php?file=$row1[10]">Download</a></button>
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
    echo "<script>alert(\"Successfully Deleted from Database\");window.location.href='transactions.php';</script>";
}
?>
</div>
</div>
</body>
</html>