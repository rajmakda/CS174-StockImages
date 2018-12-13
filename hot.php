<!-- Written by Kumar Vaibhav SJSU ID: 010110295 -->
<?php

include 'navigation.php';

echo '<div style="margin-top: 7%" class="container-fluid">

<form class="form-inline md-form form-sm mt-0 " action="search.php" method="POST" style="float:right">
<i class="fa fa-search fa-lg mr-2 " aria-hidden="true" style="border:none" name="btnsearch" ></i>
<input class="form-control form-control-sm w-75" name="searchstr" id="searchstr" type="text" placeholder="Search by labels" aria-label="Search" style="border-color:#263238;"required>
</form>

<p style="font-size:20px">Most Bought <span class="fab fa-hotjar fa-lg"></span></p> 
<div class="row text-center" style="display:flex; flex-wrap:wrap;"> 
';

    $conn1 = new mysqli("localhost", "root","","Project3");
    $username = $_COOKIE['user'];
    $customerId = getUserIdFromUsername($conn1, $username);
    $imagesOfUser = getImagesOfLoggedInUser($conn1, $customerId);

    displayAllImages1($conn1,$imagesOfUser);

function displayAllImages1($conn, $imagesOfUser) {
            // Query to get all images from database with count of purchases
            $get_all_query = "SELECT Images.id, Images.category,Images.width, Images.height, Images.size, Images.source, Images.image_path, Images.price, COUNT(Transactions.customerId) AS purchased FROM Images LEFT JOIN Transactions ON Images.id=Transactions.imageId  GROUP BY Images.id ORDER BY purchased DESC;";
            $result = $conn->query($get_all_query);
            if (!$result) die("Database access failed: " . $conn->error);
            $columns = $result->field_count;
            $rows = $result->num_rows;
            for ($i = 0; $i < $rows; $i++) {
                $row = $result->fetch_array(MYSQLI_NUM);
                $sizeInKb = $row[4] / 1000;
                if ($row[7]<2) continue;

echo <<<_END
                <div class="col-sm-3 " >
                    <div class="img-thumbnail shadow-lg p-3 mb-5 bg-white rounded ">
                        <img class="img-fluid" src="$row[6]">
                        <div class="top-right text-white" style="position:absolute;top: 14px;left: 290px;font-size: 20px; "><i class="fas fa-dollar-sign"></i>$row[7]</div>

                        <div class="caption">
                            <h4>By $row[5]</h4>
                        </div>
                        <p>
                            Category: $row[1]<br>
                            Size: $row[2] * $row[3]<br>
                            File Size: $sizeInKb kB<br>
                            No of purchases: $row[8]<br>
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