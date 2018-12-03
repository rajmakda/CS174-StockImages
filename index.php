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
    <div class="container-fluid">
        <br>
        <form method="POST" action="index.php" enctype="multipart/form-data">

            <label for="fileToUpload">Select image to upload:</label>
            <input type="file" name="fileToUpload" id="fileToUpload" accept="image/*"><br>

            <label for="category">Enter a category for the image: </label>
            <input type="text" name="category" id="category" placeholder="Enter a category" required><br>

            <label for="source">Enter your name: </label>
            <input type="text" name="source" id="source" placeholder="Enter your name" required><br>

            <input class="btn btn-primary" type="submit" value="Upload Image" name="submit">
        </form>
    </div>
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