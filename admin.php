<!-- @author: Kumar Vaibhav ID: 010110295 -->
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
    <link rel="stylesheet" href="random.css">
    
</head>
<body>
    <nav class="navbar fixed-top navbar-expand-lg navbar-light bg-light">
  <a class="navbar-brand" href="#">Pixi</a>
  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
  </button>

  <div class="collapse navbar-collapse" id="navbarSupportedContent">
       <?php

        if (!isset($_COOKIE["user"])) {
            echo <<<_END
        <ul class="navbar-nav mr-auto">
            <li class="nav-item active">
                <a class="nav-link" href="home.php">Home <span class="sr-only">(current)</span></a>
            </li>
        </ul>
        <ul class="navbar-nav flex-row ml-md-auto d-none d-md-flex">
            <li class="nav-item active">
                <a class="nav-link" href="login.php">Login <span class="sr-only">(current)</span></a>
            </li>
            <li class="nav-item active">
                <a class="nav-link" href="register.php">Register <span class="sr-only">(current)</span></a>
            </li>
        </ul>
_END;
        } else {
            echo <<<_END
        <ul class="navbar-nav mr-auto">
            <li class="nav-item active">
                <a class="nav-link" href="home.php">Home <span class="sr-only">(current)</span></a>
            </li>
            <li class="nav-item active">
                <a class="nav-link" href="images_all.php">Images <span class="sr-only">(current)</span></a>
            </li>
            <li class="nav-item active">
                <a class="nav-link" href="upload.php">Upload <span class="sr-only">(current)</span></a>
            </li>
        </ul>
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
        

        <?php

         // Create connection to MySQL
         $conn = new mysqli("localhost", "root","","Project3");

         // Check connection
         if ($conn->connect_error) {
             die("Connection failed: " . $conn->connect_error);
         } 
         //Enter id of all the users displayed 
         //create a form inout a id and display the images purchased by that id 
         //enter image id and display all the users who bught that image

         //echo '<h4>All users with their ID</h4>';

         //Implementing search
         echo '<div class=container>
         
         <div class="column">
          ';

         echo '  <!-- Search form -->
         <div class="col">
         <form action="/hms/accommodations" method="GET"> 
  <div class="row">
    <div class="col-xs-6 col-md-4">
      <div class="input-group">
        <input type="text" class="form-control" placeholder="Search" id="txtSearch"/>
        <div class="input-group-btn">
          <button class="btn btn-primary" type="submit">
            <span class="glyphicon glyphicon-search"></span>
          </button>
        </div>
      </div>
    </div>
  </div>
</form>
<br>
</div>
 ';
       
//Displaying all the users to admin

         $query_showAllCustomers = "select id, FirstName, LastName, username from Customers";
         $result_allCustomers = $conn->query($query_showAllCustomers);
         if (!$result_allCustomers) die("Database access failed: " . $conn->error);
         $column_user = $result_allCustomers->field_count;
         $row_user = $result_allCustomers->num_rows;
         
         
    //      echo '<table style="width:20%">
    // <tr>
    //     <th>Name</th>
    //     <th>ID </th>
    //     <th>Username</th>
    // </tr>';
         
        // echo '<div class=col-6">';
         for($i=0;$i<$row_user;$i++){
            $rows_user = $result_allCustomers->fetch_array(MYSQLI_NUM);
            echo '
            <ul class="list-group">
            
            <li class="list-group-item d-flex justify-content-between align-items-center w-25 border border-info" >
            '.$rows_user[1].' '.$rows_user[2].' @'.$rows_user[3]. '
            
              <span class="badge badge-primary badge-pill">ID: '.$rows_user[0].'</span>
              
            </li>
            
            </a>
          </ul>';

         
             // echo ''.$rows_user[1].' '.$rows_user[2]. '';

        //     echo '<div class="list-group">
        //     <a href="#" class="list-group-item w-50 h-25 list-group-item-action flex-md-column align-items-start " style="background-color: #EEEEEE;border-top: 1px solid #0091b5;
        //     border-left-color: #fff;
        //     border-right-color: #fff;">
        //     <span class="glyphicon glyphicon-user"></span>
        //     <div class="d-flex w-100 justify-content-between" >
            
        //     <h6 class="mb-1">'.$rows_user[1].' '.$rows_user[2]. '</h6>
        //     <small>ID: '.$rows_user[0].'</small>
        //     </div>
            
        //     <small>@'.$rows_user[3].'</small>
        //     </a>
        //     <br>
        //   </div>';
            

        //     echo '
        //     <tr>
        //         <td>'.$rows_user[1].' '.$rows_user[2]. '</td>
        //         <td>'.$rows_user[0].'</td>
        //         <td>'.$rows_user[3].'</td>
        //     </tr>';


          }
          //echo '</div>';
          //</div>
        //</div>';
         
//          echo <<<_END

//          <form action=admin.php method="post">
//   Enter ID:<br>
//   <input type="text" name = "submitUserID" id= "submitUserID" id="id_user">
  
//   <input type="submit"  value="Submit"><br>
//   <br>
// </form>


// _END;

//Display transactions of a particuar user
         if(isset($_POST["submitUserID"])){
            $ID = mysql_entities_fix_string($conn, $_POST["submitUserID"]);
            displayTransactions($conn, $ID);
         }


         function displayTransactions($conn, $uuid) {
            $query_getPurchased_byCustomer = "SELECT * FROM Transactions LEFT JOIN Images ON Transactions.imageId = Images.id WHERE Transactions.customerId = '$uuid'";
            $result = $conn->query($query_getPurchased_byCustomer);
            if (!$result) die("Database access failed: " . $conn->error);
            $columns = $result->field_count;
            $rows = $result->num_rows;
            //$row = $result->fetch_array(MYSQLI_NUM);

 echo <<<_END

 Viewing Transactions <br>
 <br>
   <div class="row text-center" style="display:flex; flex-wrap:wrap;">


_END;

           
            //var_dump($rows);
            //$imageData = $result->fetch_array(MYSQLI_NUM);
            //displayImage($imageData);
            for ($i = 0; $i < $rows; $i++) {
                $row = $result->fetch_array(MYSQLI_NUM);
                $sizeInKb = $row[8] / 1000;
                echo <<<_END
                    <div class="col-sm-3">
                        <div class="img-thumbnail">
                            <img class="img-fluid" src="$row[10]">
                            <div class="caption">
                                <h4>Source $row[9]</h4>
                            </div>
                            <p>
                                
                                Date of transaction:$row[3]<br>
                                File Size: $sizeInKb kB<br>
                            </p>
                        </div>
                    </div>
_END;
            }

         }

        
        //Display all image information to the admin
         echo '
         
         <h4>All images with their ID</h4>';

        $query_displayImage = "select id, category, source from Images";
        $result_di = $conn->query($query_displayImage);
        if(!$result_di) die ("Database access failed: " . $conn->error);
        $column_id = $result_di->field_count;
        $row_id = $result_di->num_rows;

        // echo '<table style="width:20%">
        // <tr>
        //     <th>ID</th>
        //     <th>Category </th>
        //     <th>Taken By</th>
        // </tr>';
        for($i=0;$i<$row_id;$i++){
            $rows_id = $result_di->fetch_array(MYSQLI_NUM);
            echo '<ul class="list-group ">
            
            <li class=" list-group-item d-flex justify-content-between align-items-center w-50">
            '.$rows_id[1].' By '.$rows_id[2]. '
            
              <span class="badge badge-primary badge-pill">ID: '.$rows_id[0].'</span>
              
            </li>
            </a>
          </ul>';

        //     echo '
        //     <tr>
        //         <td>'.$rows_id[0].'</td>
        //         <td>'.$rows_id[1].'</td>
        //         <td>'.$rows_id[2].'</td>
        //     </tr>';      
           }
        //   echo '
        //   </table>';
                   
//             echo <<<_END
          
//             <form action=admin.php method="post">
//             Enter ID:<br>
//             <input type="text" name = "submitImageId" id= "submitImageId" id="id_image">
            
//             <input type="submit"  value="Submit"><br>
//             <br>
//           </form>
          
          
// _END;

          //Display transactions of a particular image
          if(isset($_POST["submitImageId"])){
              $imgID = mysql_entities_fix_string($conn, $_POST["submitImageId"]);
              displayImgTransactions($conn, $imgID);
          }

          function displayImgTransactions($conn, $imgID){
              $query_disImgTran = "SELECT * FROM Customers JOIN Transactions WHERE Transactions.imageId = '$imgID'";
              $result_disImg = $conn->query($query_disImgTran);
              if(!$result_disImg) die ("Database access failed: " . $conn->error);
              $columnID = $result_disImg->field_count;
              $rowID = $result_disImg->num_rows;

              for($i=0;$i<$rowID;$i++){
                  $rowsID = $result_disImg->fetch_array(MYSQLI_NUM);
                  echo <<<_END
                  <div class="col-sm-3">
                  <div class="img-thumbnail">
                      <img class="img-fluid" src="$row[10]">
                      <div class="caption">
                          <h4>Source $row[9]</h4>
                      </div>
                      <p>
                          
                          Date of transaction:$row[3]<br>
                          File Size: $sizeInKb kB<br>
                      </p>
                  </div>
              </div>
             
_END;
              }
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
<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>
</body>
</html>