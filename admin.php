<!-- @author: Kumar Vaibhav ID: 010110295 -->
<?php
include 'navigation.php';
 ?>

    <div style="margin-top: 7%" class="container-fluid">
        

        <?php

         // Create connection to MySQL
         $conn = new mysqli("localhost", "root","","Project3");

         // Check connection
         if ($conn->connect_error) {
             die("Connection failed: " . $conn->connect_error);
         } 
       
     
       
//Displaying all the users to admin

         $query_showAllCustomers = "select id, FirstName, LastName, username from Customers";
         $result_allCustomers = $conn->query($query_showAllCustomers);
         if (!$result_allCustomers) die("Database access failed: " . $conn->error);
         $column_user = $result_allCustomers->field_count;
         $row_user = $result_allCustomers->num_rows;
         
         
   
         echo '
         <div class="container">
         <div class="row">
         <div class="col-8">
         <h4>Customers information</h4></div>
         <div class ="col-4">
         <form class="form-inline md-form form-sm mt-0 d-flex justify-content-center" action="admin.php" method="POST">
            <i class="fa fa-search fa-lg mr-2 " aria-hidden="true" style="border:none" name="btnsearch"></i>
            <input class="rounded form-control form-control-sm w-50 rounded-0 mb-2" name="searchstr" id="searchstr" type="text" placeholder="Search by customer id" aria-label="Search" style="border-color:#263238;"required>
        </form>
        </div>
        </div>
        </div>
         <br>
         <div class="container">
         <div class="row"> ';
        
  
        ;
         for($i=0;$i<$row_user;$i++){
            $rows_user = $result_allCustomers->fetch_array(MYSQLI_NUM);
            echo '
            <div class="col-sm-3 mb-2">
            <div class=" container bg-secondary text-white rounded justify-content-between align-items-center">'.$rows_user[1].' '.$rows_user[2].' @'.$rows_user[3]. ' 
            <span class="badge badge-dark badge-pill mt-1 float-right">ID: '.$rows_user[0].'</span></div></div>

            ';
            

          }

          echo '</div>
          </div>';

      

        //Display transactions of a particuar user
         if(isset($_POST["searchstr"])){
            $ID = mysql_entities_fix_string($conn, $_POST["searchstr"]);
            displayTransactions($conn, $ID);
         }


         function displayTransactions($conn, $uuid) {
            $query_getPurchased_byCustomer = "SELECT * FROM Transactions LEFT JOIN Images ON Transactions.imageId = Images.id WHERE Transactions.customerId = '$uuid'";
            $result = $conn->query($query_getPurchased_byCustomer);
            if (!$result) die("Database access failed: " . $conn->error);
            $columns = $result->field_count;
            $rows = $result->num_rows;
            //$row = $result->fetch_array(MYSQLI_NUM);
            if ($rows==0) {
                echo '<div class="container"><div class="jumbotron"><h2>No transactions</h2></div></div>';
            }

 echo <<<_END
<div class="container">
 <h4>Viewing Transactions</h4> <br>
<div class="row">

_END;

           
            for ($i = 0; $i < $rows; $i++) {
                $row = $result->fetch_array(MYSQLI_NUM);
                $sizeInKb = $row[8] / 1000;
                echo <<<_END
                    <div class="col-sm-3">
                        <div class="img-thumbnail mb-2">
                            <img class="img-fluid" src="$row[10]" >
                            
                            <div class="caption">
                                <h4>Source $row[9]</h4>
                            </div>
                            <p>
                                
                                Date of transaction:<br>
                                $row[3]
                            </p>
                        </div>
                    </div>
_END;
            }
            echo '</div></div>';

         }

        
        //Display all image information to the admin
        echo '
        <div class="container">
        <div class="row">
        <div class="col-8">
        <h4>Images information</h4></div>
        <div class ="col-4">
        <form class="form-inline md-form form-sm mt-0 d-flex justify-content-center" action="admin.php" method="POST">
           <i class="fa fa-search fa-lg mr-2 " aria-hidden="true" style="border:none" name="btnsearch"></i>
           <input class="rounded form-control form-control-sm w-50 rounded-0 mb-2" name="searchid" id="searchid" type="text" placeholder="Search by image id" aria-label="Search" style="border-color:#263238;"required>
       </form>
       </div>
       </div>
       </div>
        <br>
        <div class="container">
        <div class="row"> ';

        $query_displayImage = "select id, category, source from Images";
        $result_di = $conn->query($query_displayImage);
        if(!$result_di) die ("Database access failed: " . $conn->error);
        $column_id = $result_di->field_count;
        $row_id = $result_di->num_rows;

       
        for($i=0;$i<$row_id;$i++){
            $rows_id = $result_di->fetch_array(MYSQLI_NUM);

            echo '<div class="col-sm-2 mb-2 ">
            <div class="container bg-secondary text-white rounded justify-content-between align-items-center">By '.$rows_id[2]. '
            <span class="badge badge-dark badge-pill mt-1 float-right">ID: '.$rows_id[0].'</span></div></div>
            ';
 
           }

          //Display transactions of a particular image

          
          if(isset($_POST["searchid"])){
              $imgID = mysql_entities_fix_string($conn, $_POST["searchid"]);
              echo '<br><br><div class="container mt-8 mb-3"><h2>Viewing transactions<h2></div>';
              displayImgTransactions($conn, $imgID);
          }
         

          function displayImgTransactions($conn, $imgID){
              //$query_disImgTran = "SELECT * FROM Customers JOIN Transactions WHERE Transactions.imageId = '$imgID'";
              $query_disImg = "select customerId, date from Transactions where imageId = '$imgID'";
              $result_disImg = $conn->query($query_disImg);
              if(!$result_disImg) die ("Database access failed: " . $conn->error);
              $columnID = $result_disImg->field_count;
              $rowID = $result_disImg->num_rows;
              //$rowsID = $result_disImg->fetch_array(MYSQLI_NUM); 
              if ($rowID==0) {
                    echo '<div class="container"><div class="jumbotron"><h2>No transactions</h2></div></div>';
                }else {
                    $query2 = "select image_path, source from Images where id = '$imgID'";
              $result2 = $conn->query($query2);
              $columnID2 = $result2->field_count;
              $rowID2 = $result2->num_rows;
              $rowsID2 = $result2->fetch_array(MYSQLI_NUM);
              echo <<<_END
              <div class="container"> 
              <div class="row">
                <div class="col-4">
                    <img class="img-fluid" src="$rowsID2[0]" style=" height: auto;width: 300px;">   
                    <div class="caption">By $rowsID2[1]</div>
                </div>
                <div class="col-4">
_END;
                for($i=0;$i<$rowID;$i++){
                    $rowsID = $result_disImg->fetch_array(MYSQLI_NUM); 
                    userinfo($conn, $rowsID[0], $imgID, $rowsID);
                }
            }

            }
            function userinfo($conn,$userID, $imgID, $rowsID) {
              $queryuser = "select id, FirstName, LastName, username from Customers where id = '$userID'";
              $resultuser = $conn->query($queryuser);
              $col = $resultuser->field_count;
              $row = $resultuser->num_rows;
              $r = $resultuser->fetch_array(MYSQLI_NUM);

              $query2 = "select image_path from Images where id = '$imgID'";
              $result2 = $conn->query($query2);
              $columnID2 = $result2->field_count;
              $rowID2 = $result2->num_rows;
              //$rowsID2 = $result_disImg->fetch_array(MYSQLI_NUM); 

              
                  $row1 = $result2->fetch_array(MYSQLI_NUM);
                  echo '
                        <div class="row">Bought by</div>
                        <div class="row">'.$r[1].' '.$r[2].'</div>
                        <div class="row mb-2">on '.$rowsID[1].'</div>

                  
                  ';
        }

          
        

         function getUserIdFromUsername($conn, $username) {
            $queryUser = "SELECT * FROM Customers WHERE username='$username'";
            $resultOfUser = $conn->query($queryUser);
            $row = $resultOfUser->fetch_array(MYSQLI_NUM);
            $resultOfUser->close();
            $customerId = $row[0];
            return $customerId;
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
