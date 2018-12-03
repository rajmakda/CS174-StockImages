<?php
//Written by Kumar Vaibhav
//010110295
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Transactions</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
    <link rel="stylesheet" type="text/css" media="screen" href="main.css" />
    <script src="main.js"></script>
    
</head>
<body>
<nav class="navbar fixed-top navbar-expand-lg navbar-light bg-light">
  <a class="navbar-brand" href="#">Pixi</a>
  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
  </button>

  <div class="collapse navbar-collapse" id="navbarSupportedContent">
    <ul class="navbar-nav mr-auto">
      <li class="nav-item active">
        <a class="nav-link" href="home.php">Home <span class="sr-only">(current)</span></a>
      </li>
      <li class="nav-item active">
        <a class="nav-link" href="images_all.php">Images <span class="sr-only">(current)</span></a>
      </li>
    </ul>
    <?php
    $conn = new mysqli("localhost", "root","","Project3");
    if (!isset($_COOKIE["user"])) {
        echo '<a class="nav-link" href="login.php">Login</a>';
        echo '<a class="nav-link" href="register.php">Register</a>';
    } else {
        echo '<a class="nav-link" href="logout.php">Logout</a>';
        
    }
    ?>


  </div>
</nav>  

<div style="margin-top: 7%" class="container-fluid">
<div class="row text-center" style="display:flex; flex-wrap:wrap;">
<?php 



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
    
echo <<<_END
<div class="col-sm-3">
<div class="img-thumbnail">
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
            <input type="submit" class="btn btn-primary btn-sm" name="delete" value="Delete">
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

    $delete_query = "DELETE FROM Transactions WHERE id='$row1[0]'";
    $result_query = $conn->query($delete_query);
    if (!$result_query) die ("Database access failed: " . $conn->error);
    echo "<script>alert(\"Successfully Deleted from Database\");</script>";
    header("Refresh:0; url=transactions.php");
}

?>
</div>

</div>
</body>
</html>



