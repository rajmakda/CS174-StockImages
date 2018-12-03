<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Image Upload</title>
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
      <li class="nav-item active">
        <a class="nav-link" href="upload.php">Upload <span class="sr-only">(current)</span></a>
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
    <div class="container-fluid">
        <br>
        <form method="POST" action="upload.php" enctype="multipart/form-data">

            <label for="fileToUpload">Select image to upload:</label>
            <input type="file" name="fileToUpload" id="fileToUpload" accept="image/*"><br>

            <label for="category">Enter a category for the image: </label>
            <input type="text" name="category" id="category" placeholder="Enter a category" required><br>

            <label for="source">Enter your name: </label>
            <input type="text" name="source" id="source" placeholder="Enter your name" required><br>

            <input class="btn btn-primary" type="submit" value="Upload Image" name="submit">
        </form>
    </div>
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>
</body>
</html>
<?php
    // Create connection to MySQL
    $conn = new mysqli("localhost", "root","","Project3");

    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    } 
    echo "Connected successfully to DB"."<br>";

    if ($_FILES) {
        $target_dir = "uploads/";
        $target_file = $target_dir . basename($_FILES["fileToUpload"]["name"]);
        // Check if file already exists
        if (!file_exists($target_file)) {
            if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) {
                $size = getimagesize($target_file);
                $width = $size[0];
                $height = $size[1];
                $sizeOfFile = $_FILES["fileToUpload"]["size"];
                $source = $_POST["source"];
                $category = $_POST["category"];
                $insert_query = "INSERT INTO Images(category, width, height, size, source, image_path) VALUES ('".$category."','".$width."','".$height."','".$sizeOfFile."','".$source."','".$target_file."');";
                $result = $conn->query($insert_query);
                if (!$result) die ("Database access failed: " . $conn->error);
                echo "The file ". basename( $_FILES["fileToUpload"]["name"]). " has been uploaded. <br>";
                echo "<img width=".($width/15)." height=".($height/15)." src=".$target_file."><br>";
            } else {
                echo "Sorry, there was an error uploading your file.";
            }
        } else if ($_FILES["fileToUpload"]["error"] == 4) {
            echo "Sorry, please provide a file.";
        } else {
            echo "Sorry, file already exists.";
        }
    }
?>
<a href="images_all.php">View all images in DB</a>