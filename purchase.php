<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Purchase Confirmation</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
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
    if (!isset($_COOKIE["user"])) {
        echo '<a class="nav-link" href="login.php">Login</a>';
        echo '<a class="nav-link" href="register.php">Register</a>';
    } else {
        echo '<a class="nav-link" href="logout.php">Logout</a>';
    }
    ?>
  </div>
</nav>
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>
</body>
</html>
<?php

if (!isset($_COOKIE['user'])) {
    echo "<script>alert(\"You must be logged in\");</script>";
    echo "<script>window.location = \"home.php\";</script>";
    exit;
} else {
    $username = $_COOKIE['user'];
    if (isset($_POST['purchase'])) {
        $imageId = $_POST["image_id"];
     // Create connection to MySQL
        $conn = new mysqli("localhost", "root", "", "Project3");

    // Check connection
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }
        $queryUser = "SELECT * FROM Customers WHERE username='$username'";
        $result = $conn->query($queryUser);
        if ($result->num_rows) {
            $row = $result->fetch_array(MYSQLI_NUM);
            $result->close();
            $customerId = $row[0];
            $query = "INSERT INTO Transactions(customerId, imageId) VALUES($customerId, $imageId);";
            $result = $conn->query($query);
            if (!$result) die($conn->error);
            $queryImage = "SELECT * FROM Images WHERE id='$imageId'";
            $result = $conn->query($queryImage);
            $imageData = $result->fetch_array(MYSQLI_NUM);
            displayImage($imageData);
        }
    } else {
        echo "No image selected";
    }

}


function displayImage($row) {
    $sizeInKb = $row[4] / 1000;
echo <<<_END
    <div style="position:absolute;left:0;right:0;top:10%;bottom:0;margin:auto;text-align: center">
        
        <h3 style="text-align: center">Thank you for purchasing the image</h3>
        <p style="text-align: center"><a href="#">Download</a></p>
        
        <div class="col-sm-5" style="position:relative; margin:auto">
            <div class="img-thumbnail">
                <img class="img-fluid" src="$row[6]">
                <div class="caption">
                    <h4>By $row[5]</h4>
                </div>
                <p>
                    Category: $row[1]<br>
                    Size: $row[2] * $row[3]<br>
                    File Size: $sizeInKb kB<br>
                </p>
            </div>
        </div>
    </div>
_END;
}
?>
