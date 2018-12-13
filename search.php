<!-- Written by Kumar Vaibhav SJSU ID: 010110295 -->


<?php  

    include 'navigation.php';  
    echo '<div style="margin-top: 7%" class="container-fluid" >
    <form class="form-inline md-form form-sm mt-0 d-flex justify-content-center" action="search.php" method="POST">
            <i class="fa fa-search fa-lg mr-2 " aria-hidden="true" style="border:none" name="btnsearch"></i>
            <input class="rounded form-control form-control-sm w-50 rounded-0" name="searchstr" id="searchstr" type="text" placeholder="Search by labels or names" aria-label="Search" style="border-color:#263238;"required>
    </form>
    <div class="row text-center mt-5 " style="display:flex; flex-wrap:wrap;">
    ';

    $conn = new mysqli("localhost", "root","","Project3");
    $search = $_POST["searchstr"];
    $username = $_COOKIE['user'];
    $customerId = getUserIdFromUsername($conn, $username);
    $imagesOfUser = getImagesOfLoggedInUser($conn, $customerId);
    searchResults($conn,$search,$imagesOfUser);

    function searchResults($conn, $search, $imagesOfUser){
        $flag=false;
        $get_all_query = "SELECT Images.id, Images.category, Images.width, Images.height, Images.size, Images.source, Images.image_path, COUNT(Transactions.customerId) AS purchased FROM Images LEFT JOIN Transactions ON Images.id=Transactions.imageId  GROUP BY Images.id ORDER BY purchased DESC;";
        $result = $conn->query($get_all_query);
        if (!$result) die("Database access failed: " . $conn->error);
        $columns = $result->field_count;
        $rows = $result->num_rows;
        for ($i = 0; $i < $rows; $i++) {
            $row = $result->fetch_array(MYSQLI_NUM);

            if(strtolower($row[1])==$search or strtolower($row[5])==$search){
                $flag=true;
                $sizeInKb = $row[4] / 1000;
                echo <<<_END
                <div class="col-sm-3" >
                <div class="img-thumbnail shadow-lg p-3 mb-5 bg-white rounded" style="background-color:transparent">
                <div class="top-right text-white" style="position:absolute;top: 14px;left: 290px;font-size: 20px; "><i class="fas fa-dollar-sign"></i>$row[7]</div>

                <img class="img-fluid" src="watermarked/$row[6]" >
                <div class="caption" >
                <h4>By $row[5]</h4>
                </div>
                <p >
                Category: $row[1]<br>
                Size: $row[2] * $row[3]<br>
                File Size: $sizeInKb kB<br>
                No of purchases: $row[7]<br>
                <form method="POST" action="purchase.php">
                <input type="hidden" id="image_id" name="image_id" value="$row[0]">
                <input type="hidden" id="image_path" name="image_path" value="$row[6]">
_END;
        if ($row[5]!=$_COOKIE['user']){
        if (in_array($row[0],$imagesOfUser)) {
            echo '<input type="submit" disabled class="btn btn-primary btn-sm" name="purchase" value="Purchased">';
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
   if($flag==false){
       echo '
       </div>
       <div class="jumbotron" ><center> <h1><i class="fas fa-eye-slash"></i>   Couldnt find what you looking for
           </h1></center> </div>';
   }

}
    
    

//     function searchResults($conn, $search, $imagesOfUser) {
//         $query = "Select category, width, height, size, source, image_path from Images where category='$search' or source='$search'";
//         //SELECT Images.id, Images.category,Images.width, Images.height, Images.size, Images.source, Images.image_path, COUNT(Transactions.customerId) AS purchased FROM Images LEFT JOIN Transactions ON Images.id=Transactions.imageId  GROUP BY Images.id ORDER BY purchased DESC;
//         $result = $conn->query($query);
//         $col = $result->field_count;
//         $row = $result->num_rows;
        
//         if ($row<1) {
//             echo '<div class="jumbotron">
//                   <h1>404 your search could not find any result</h1>
//                   Try searching for labels like nature, abstract, potrait...
//                   </div>
//                   <form class="form-inline md-form form-sm mt-0 d-flex justify-content-center" action="search.php" method="POST">
//                     <button class="fa fa-search fa-lg" aria-hidden="true" style="border:none" name="btnsearch"></button>
//                     <input class="form-control form-control-sm w-75" name="searchstr" id="searchstr" type="text" placeholder="Search by labels or names" aria-label="Search" required>
//                 </form>
//             ';
//         }
        
//         else {
//             echo '<div class="row text-center" style="display:flex; flex-wrap:wrap;">';
//             $querys = "SELECT Images.id, Images.category,Images.width, Images.height, Images.size, Images.source, Images.image_path, COUNT(Transactions.customerId) AS purchased FROM Images LEFT JOIN Transactions ON Images.id=Transactions.imageId  GROUP BY Images.id ORDER BY purchased DESC;";
//             $results = $conn->query($querys);
//             $column = $results->field_count;
//             $row1 = $results->num_rows;
//             for ($i = 0; $i < $row1; $i++) {
//                 $rows=$result->fetch_array(MYSQLI_NUM);
//                 $sizeInKb = $rows[3]/1000;
//                 var_dump($rows);
//                 echo <<<_END
//                 <div class="col-sm-3">
//                     <div class="img-thumbnail">
//                         <img class="img-fluid" src="$rows[5]">
//                         <div class="caption">
//                             <h4>By $row[5]</h4>
//                         </div>
//                         <p>
//                             Category: $row[1]<br>
//                             Size: $row[2] * $row[3]<br>
//                             File Size: $sizeInKb kB<br>
//                             No of purchases: $row[7]<br>
//                             <form method="POST" action="purchase.php">
//                                 <input type="hidden" id="image_id" name="image_id" value="$rows[0]">
//                                 <input type="hidden" id="image_path" name="image_path" value="$rows[6]">
// _END;
//                             if (in_array($row[0],$imagesOfUser)) {
//                                 echo '<input type="submit" disabled class="btn btn-primary btn-sm" name="purchase" value="Purchased">';
//                             } else {
//                                 echo '<input type="submit" class="btn btn-primary btn-sm" name="purchase" value="Purchase">';
//                             }
// echo <<<_END
//                             </form>
//                         </p>
//                     </div>
//                 </div>
// _END;
//             }
//         }


//     }


    echo '</div>';

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