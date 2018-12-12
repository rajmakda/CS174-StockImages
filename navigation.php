<?php

    if (!isset($_COOKIE['user'])) {
    echo "<script>alert(\"You must be logged in\");</script>";
    echo "<script>window.location = \"home.php\";</script>";
    exit;

}

?>

<?php 
    $username = $_COOKIE['user'];
    $conn = new mysqli("localhost", "root","","Project3");
    //if (!$result) die("Database access failed: " . $conn->error);
    $query_credits = "Select credits from Customers where username='$username'";
    $result_credits = $conn->query($query_credits);
    $col = $result_credits->field_count;
    $row = $result_credits->num_rows;
    $rows = $result_credits->fetch_array(MYSQLI_NUM);
    $credits = $rows[0];

?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>All Images</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.5.0/css/all.css" integrity="sha384-B4dIYHKNBt8Bc12p+WXckhzcICo0wtJAoU8YZTY5qE0Id1GSseTk6S+L3BlXeVIU" crossorigin="anonymous">
    <script src="https://code.jquery.com/jquery-3.3.1.min.js" integrity="sha256-FgpCb/KJQlLNfOu91ta32o/NMZxltwRo8QtmkMRdAu8=" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>
</head>
<body style="background-color:#B0BEC5;">
    <nav class="navbar fixed-top navbar-expand-lg navbar-light bg-dark">
  <a class="navbar-brand text-white" href="#">Pixi</a>
  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
  </button>

  <div class="collapse navbar-collapse" id="navbarSupportedContent">
       <?php
        if (!isset($_COOKIE["user"])) {
            echo <<<_END
        <ul class="navbar-nav mr-auto">
            <li class="nav-item active">
                <a class="nav-link" href="home.php"> <i class="fas fa-home fa-lg mr-1"></i>Home <span class="sr-only">(current)</span></a>
            </li>
        </ul>
        <ul class="navbar-nav flex-row ml-md-auto d-none d-md-flex">
            <li class="nav-item active">
                <a class="nav-link text-white" href="login.php">Login <span class="sr-only">(current)</span></a>
            </li>
            <li class="nav-item active">
                <a class="nav-link text-white" href="register.php">Register <span class="sr-only">(current)</span></a>
            </li>
        </ul>
_END;
        } else {
            echo <<<_END
        <ul class="navbar-nav mr-auto">
            <li class="nav-item active">
                <a class="nav-link text-white" href="home.php"> <i class="fas fa-home fa-lg mr-1"></i>Home <span class="sr-only">(current)</span></a>
            </li>
            <li class="nav-item active">
                <a class="nav-link text-white" href="images_all.php"><i class="fas fa-images mr-1 fa-lg"></i>Images <span class="sr-only">(current)</span></a>
            </li>
            <li class="nav-item active">
                <a class="nav-link text-white" style="cursor:pointer;" data-toggle="modal" data-target="#exampleModal"><i class="fas fa-upload mr-1 fa-lg"></i>Upload<span class="sr-only">(current)</span></a>
            </li>
                    
        </ul>
        <ul class="navbar-nav flex-row ml-md-auto d-none d-md-flex">
       
            <li class="nav-item active mr-1">
                <a class="nav-link text-white" > <i class="mr-1 mt-2 fas fa-coins fa-lg"></i>$credits <span class="sr-only">(current)</span></a>
            </li>
            <li class="nav-item dropdown">
                <a class=" text-white nav-item nav-link dropdown-toggle mr-md-2" href="#" id="bd-versions" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                <i class="fas fa-user-astronaut fa-2x text-white"></i>    
               
                </a>
                <div class="dropdown-menu dropdown-menu-right " aria-labelledby="bd-versions">
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
<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Sell your image</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form id="uploadForm" method="POST" action=<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?> enctype="multipart/form-data">
          <div class="form-group">
            <label for="fileToUpload" class="col-form-label">Select image to upload:</label>
            <input type="file" name="fileToUpload" id="fileToUpload" accept="image/*">
          </div>
          <div class="form-group">
            <label for="category" class="col-form-label">Enter a category for the image: </label>
            <input type="text" class="form-control" name="category" id="category" placeholder="Enter a category" required>
          </div>
          <div class="form-group">
            <label for="price" class="col-form-label">Enter a price for the image: </label>
            <input type="number" max="25" class="form-control" name="price" id="price" placeholder="Enter a price" required>
          </div>
          <div class="form-group">
              <label for="source" class="col-form-label">Enter your name: </label>
        <?php
        $username = $_COOKIE['user'];
        echo '<input type="text" class="form-control" name="source" id="source" placeholder="Enter your name" value="' . $username . '" required><br>';
        ?>
          </div>
        </form>
        <div id="formResult"></div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal" onclick="window.location.reload()">Close</button>
        <button type="button" id="submitUpload" class="btn btn-primary">Upload</button>
      </div>
    </div>
  </div>
</div>

<script>
        $("document").ready(function(){   
            $("#fileToUpload").change(function() {
                fetch('image_recognition.php', {
                    method: 'POST',
                    body: document.getElementById('fileToUpload').files[0]
                }).then(function(res) {
                    return res.text();
                }).catch(function(err) {
                    console.log(err);
                })
                .then(function(res) {
                    tags = res.substring(1, res.length-1)
                    document.getElementById('category').value = tags;
                }).catch(function(err) {
                    console.log(err);
                })
            });    
        });

        $('#submitUpload').click(function() {
            formData = new FormData();
            formData.append("fileToUpload", document.getElementById('fileToUpload').files[0]);
            formData.append("source", document.getElementById('source').value);
            formData.append("category", document.getElementById('category').value);
            formData.append("price", document.getElementById('price').value);
            fetch("upload.php", {
                method: 'POST',
                body: formData
            }).then(function(res) {
                return res.text();
            }).catch(function(err) {
                alert(err);
            }).then(function(res) {
                document.getElementById('formResult').innerHTML = res;
            })
        });
</script>