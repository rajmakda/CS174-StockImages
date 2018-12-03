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
echo <<<_END
        <ul class="navbar-nav flex-row ml-md-auto d-none d-md-flex">
            <li class="nav-item dropdown">
                <a class="nav-item nav-link dropdown-toggle mr-md-2" href="#" id="bd-versions" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    Account
                </a>
                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="bd-versions">
                    <a class="dropdown-item" href="transactions.php">My Purchases</a>
                    <a class="dropdown-item" href="logout.php">Logout</a>
                    <a class="dropdown-item" style="color:red" href="delete_account.php">Delete Account</a>
                </div>
            </li>
        </ul>
_END;
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
            
            $username = $_COOKIE['user'];
            $customerId = getUserIdFromUsername($conn, $username);
            $imagesOfUser = getImagesOfLoggedInUser($conn, $customerId);
            displayAllImages($conn, $imagesOfUser);

            function displayAllImages($conn, $imagesOfUser) {
                // Query to get all images from database with count of purchases
                $get_all_query = "SELECT Images.id, Images.category,Images.width, Images.height, Images.size, Images.source, Images.image_path, COUNT(Transactions.customerId) AS purchased FROM Images LEFT JOIN Transactions ON Images.id=Transactions.imageId  GROUP BY Images.id ORDER BY purchased DESC;";
                $result = $conn->query($get_all_query);
                if (!$result) die("Database access failed: " . $conn->error);
                $columns = $result->field_count;
                $rows = $result->num_rows;
                for ($i = 0; $i < $rows; $i++) {
                    $row = $result->fetch_array(MYSQLI_NUM);
                    $sizeInKb = $row[4] / 1000;
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
                                No of purchases: $row[7]<br>
                                <form method="POST" action="purchase.php">
                                    <input type="hidden" id="image_id" name="image_id" value="$row[0]">
                                    <input type="hidden" id="image_path" name="image_path" value="$row[6]">
_END;
                                if (in_array($row[0],$imagesOfUser)) {
                                    echo '<input type="submit" disabled class="btn btn-primary btn-sm" name="purchase" value="Purchased">';
                                } else {
                                    echo '<input type="submit" class="btn btn-primary btn-sm" name="purchase" value="Purchase">';
                                }
echo <<<_END
                                </form>
                            </p>
                        </div>
                    </div>
_END;
                }
            }

            function getImagesOfLoggedInUser($conn, $customerId) {
                // Get images of logged in user
                $queryUserBoughtImages = "SELECT imageId FROM Transactions LEFT JOIN Images ON Transactions.imageId = Images.id WHERE Transactions.customerId = $customerId;";
                $resultOfImages = $conn->query($queryUserBoughtImages);
                if (!$resultOfImages) die("Connection Error" . $conn->error);
                $x = $resultOfImages->num_rows;
                $imagesOfUser = array();
                for ($j = 0; $j < $x; $j++) {
                    array_push($imagesOfUser, $resultOfImages->fetch_array(MYSQLI_NUM)[0]);
                }
                return $imagesOfUser;
            }

            function getUserIdFromUsername($conn, $username) {
                $queryUser = "SELECT * FROM Customers WHERE username='$username'";
                $resultOfUser = $conn->query($queryUser);
                $row = $resultOfUser->fetch_array(MYSQLI_NUM);
                $resultOfUser->close();
                $customerId = $row[0];
                return $customerId;
            }
        ?>
        </div>
    </div>
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>
</body>
</html>