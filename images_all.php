<!-- Written by Raj Makda SJSU ID: 010128222 -->

    <?php 
    include 'navigation.php';
    ?>
    <div style="margin-top: 7%" class="container-fluid">
   
    <!-- Written by Kumar Vaibhav SJSU ID: 010110295 -->
        <!-- Search form -->

    <form class="form-inline md-form form-sm mt-0 " action="search.php" method="POST" style="float:right">
        <i class="fa fa-search fa-lg mr-2 " aria-hidden="true" style="border:none" name="btnsearch" ></i>
        <input class="form-control form-control-sm w-75" name="searchstr" id="searchstr" type="text" placeholder="Search by labels" aria-label="Search" style="border-color:#263238;"required>
    </form>
   
     <p style="font-size:20px">Most Bought <span class="fab fa-hotjar fa-lg"></span> <small style="font-size:12px"><a href="hot.php">View All <i class="fas fa-external-link-alt"></i></a></small></p> 
      
     <div class="row text-center" style="display:flex; flex-wrap:wrap;"> 
  
    <?php
       
        $conn1 = new mysqli("localhost", "root","","Project3");
        $username = $_COOKIE['user'];
        $customerId = getUserIdFromUsername($conn1, $username);
        $imagesOfUser = getImagesOfLoggedInUser($conn1, $customerId);
        $userCredits = getCustomerCredits($conn, $username);
        displayAllImages1($conn1,$imagesOfUser, $userCredits);
        function displayAllImages1($conn, $imagesOfUser, $userCredits) {
            // Query to get all images from database with count of purchases
            $get_all_query = "SELECT Images.id, Images.category,Images.width, Images.height, Images.size, Images.source, Images.image_path, Images.price, COUNT(Transactions.customerId) AS purchased FROM Images LEFT JOIN Transactions ON Images.id=Transactions.imageId  GROUP BY Images.id ORDER BY purchased DESC;";
            $result = $conn->query($get_all_query);
            if (!$result) die("Database access failed: " . $conn->error);
            $columns = $result->field_count;
            $rows = $result->num_rows;
            for ($i = 0; $i < $rows; $i++) {
                $row = $result->fetch_array(MYSQLI_NUM);
                $sizeInKb = $row[4] / 1000;
                if ($row[8]<2) continue;
                $tags = explode(",", str_replace('"', "", $row[1]));
echo <<<_END
                <div class="col-sm-3 " >
                    <div class="img-thumbnail shadow-lg p-1 mb-5 bg-white rounded " style="position: relative;">
                        <img class="img-fluid" src="watermarked/$row[6]">
                        <div class="top-right text-white float-right" style="position:absolute;top: 4%;left: 85%;font-size: 1.5vw; "><i class="fas fa-dollar-sign"></i>$row[7]</div>
                        <div class="caption">
                            <h4>By $row[5]</h4>
                        </div>
                        <p>
_END;
                            for($j=0;$j<count($tags);$j++) {
                                echo '<span class="badge badge-pill badge-secondary">'.$tags[$j].'</span>';
                            }
echo <<<_END
                                <br>
                            Size: $row[2] * $row[3]<br>
                            File Size: $sizeInKb kB<br>
                            No of purchases: $row[8]<br>
                            <form method="POST" action="purchase.php">
                                <input type="hidden" id="image_id" name="image_id" value="$row[0]">
                                <input type="hidden" id="image_path" name="image_path" value="$row[6]">
                                <input type="hidden" id="image_price" name="image_price" value="$row[7]">
                                <input type="hidden" id="user_credits" name="user_credits" value="$userCredits">
_END;
                            if ($row[5]!=$_COOKIE['user']){
                            if (in_array($row[0],$imagesOfUser)) {
                                echo '<input type="submit" disabled class="btn btn-primary btn-sm" name="purchase" value="Purchased">';
                            } else if (!checkEnoughCredits($row[7], $userCredits)) {
                                    echo '<input type="submit" disabled class="btn btn-primary btn-sm" name="purchase" value="Not Enough Credits">';
                            } else {
                                echo '<input type="submit" class="btn btn-primary btn-sm" name="purchase" value="Purchase">';
                            }
                        }
echo <<<_END
                            </form>
                        </p>
                    </div>
                </div>
_END;
            }
        }

        if(isset($_POST["btnsearch"])){
           $searchString = mysql_entities_fix_string($conn1, $_POST["searchstr"]);

        }
        function mysql_entities_fix_string($connection, $string)
        {
            return htmlentities(mysql_fix_string($connection, $string));
        }
        function mysql_fix_string($connection, $string)
        {
            if (get_magic_quotes_gpc()) $string = stripslashes($string);
            return $connection->real_escape_string($string);
        }                
    ?>


     </div>
     <p style="font-size:24px">All Images</p>
    <!------------------------------------------------------------------------------------------------------------------>
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
            $userCredits = getCustomerCredits($conn, $username);
           
            displayAllImages($conn, $imagesOfUser, $userCredits);
            function displayAllImages($conn, $imagesOfUser, $userCredits) {
                // Query to get all images from database with count of purchases
                $get_all_query = "SELECT Images.id, Images.category,Images.width, Images.height, Images.size, Images.source, Images.image_path, Images.price, COUNT(Transactions.customerId) AS purchased FROM Images LEFT JOIN Transactions ON Images.id=Transactions.imageId  GROUP BY Images.id ORDER BY purchased DESC;";
                $result = $conn->query($get_all_query);
                if (!$result) die("Database access failed: " . $conn->error);
                $columns = $result->field_count;
                $rows = $result->num_rows;
                for ($i = 0; $i < $rows; $i++) {
                    $row = $result->fetch_array(MYSQLI_NUM);
                    $sizeInKb = $row[4] / 1000;
                    $tags = explode(",", str_replace('"',"",$row[1]));
echo <<<_END
                    <div class="col-sm-3">
                        <div class="img-thumbnail shadow-lg p-1 mb-5 bg-white rounded" style="position:relative">
                            <img class="img-fluid" src="watermarked/$row[6]">
                            <div class="top-right text-white" style="position:absolute;top: 4%;left: 85%;font-size: 1.5vw; "><i class="fas fa-dollar-sign"></i>$row[7]</div>
                        
                            <div class="caption">
                                <h4>By $row[5]</h4>
                            </div>
                            <p>
_END;
                            for($j=0;$j<count($tags);$j++) {
                                echo '<span class="badge badge-pill badge-secondary">'.$tags[$j].'</span>';
                            }
echo <<<_END
                                <br>
                                Size: $row[2] * $row[3]<br>
                                File Size: $sizeInKb kB<br>
                                No of purchases: $row[8]<br>
                                <form method="POST" action="purchase.php">
                                    <input type="hidden" id="image_id" name="image_id" value="$row[0]">
                                    <input type="hidden" id="image_path" name="image_path" value="$row[6]">
                                    <input type="hidden" id="image_price" name="image_price" value="$row[7]">
                                    <input type="hidden" id="user_credits" name="user_credits" value="$userCredits">
_END;
                                //username from userid ask raj the source is username
                                if ($row[5]!=$_COOKIE['user']){
                                if (in_array($row[0],$imagesOfUser)) {
                                    echo '<input type="submit" disabled class="btn btn-primary btn-sm" name="purchase" value="Purchased">';
                                } else if (!checkEnoughCredits($row[7], $userCredits)) {
                                    echo '<input type="submit" disabled class="btn btn-primary btn-sm" name="purchase" value="Not Enough Credits">';
                                } else {
                                    echo '<input type="submit" class="btn btn-primary btn-sm" name="purchase" value="Purchase">';
                                }
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
                if (!$resultOfImages) die("Connection Error!!!" . $conn->error);
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

            function getCustomerCredits($conn, $username) {
                $queryUser = "SELECT credits FROM Customers WHERE username='$username'";
                $result = $conn->query($queryUser);
                $row = $result->fetch_array(MYSQLI_NUM);
                $result->close();
                $credits = $row[0];
                return $credits;
            }

            function checkEnoughCredits($imagePrice, $userCredits) {
                if ($userCredits < $imagePrice) {
                    return false;
                } else {
                    return true;
                }
            }
        ?>
        </div>
    </div>
  