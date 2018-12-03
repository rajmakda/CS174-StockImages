<?php

    if (!isset($_COOKIE['user'])) {
    echo "<script>alert(\"You must be logged in\");</script>";
    echo "<script>window.location = \"home.php\";</script>";
    exit;
}

?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>All Images</title>
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

    <div style="margin-top: 7%" class="container-fluid">
        <div class="row text-center" style="display:flex; flex-wrap:wrap;">
        <?php 
             // Create connection to MySQL
            $conn = new mysqli("localhost", "root","","Project3");

            // Check connection
            if ($conn->connect_error) {
                die("Connection failed: " . $conn->connect_error);
            } 
            
            // Query to get all images from database
            $get_all_query = "SELECT * FROM Images";
            $result = $conn->query($get_all_query);
            if (!$result) die ("Database access failed: " . $conn->error);
            $columns = $result->field_count;
            $rows = $result->num_rows;
            for ($i = 0; $i < $rows; $i++) {
                $row = $result->fetch_array(MYSQLI_NUM);
                $sizeInKb = $row[4]/1000;
echo <<<_END
                <div class="col-sm-3">
                    <div class="img-thumbnail">
                        <img class="img-fluid" src="$row[6]">
                        <div class="caption">
                            <h4>By $row[5]</h4>
                        </div>
                        <p>
                            Category: $row[1]<br>
                            Size: $row[2] * $row[3]<br>
                            File Size: $sizeInKb kB<br>
                            <form method="POST" action="images_all.php">
                                <input type="hidden" id="image_id" name="image_id" value="$row[0]">
                                <input type="hidden" id="image_path" name="image_path" value="$row[6]">
                                <input type="submit" class="btn btn-primary btn-sm" name="delete" value="Delete">
                            </form>
                        </p>
                    </div>
                </div>
_END;
            }

            // DELETE FROM DB AND DISK
            if (isset($_POST["delete"])) {
            $delete_query = "DELETE FROM Images WHERE id=".$_POST["image_id"];
            $result = $conn->query($delete_query);
            if (!$result) die ("Database access failed: " . $conn->error);
            unlink($_POST["image_path"]);
            echo "<script>alert(\"Successfully Deleted from Database\");</script>";
            header("Refresh:0; url=images_all.php");

    }
        ?>
        </div>
        <a href="index.php">Back</a>
    </div>
</body>
</html>