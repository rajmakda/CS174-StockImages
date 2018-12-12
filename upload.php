<?php
    // Create connection to MySQL
    $conn = new mysqli("localhost", "root","","Project3");

    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    } 
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