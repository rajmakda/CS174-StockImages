<?php
// Written by Raj Makda SJSU ID: 010128222
    require('image.php');
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
                $price = $_POST["price"];
                $insert_query = "INSERT INTO Images(category, width, height, size, source, image_path,price) VALUES ('".$category."','".$width."','".$height."','".$sizeOfFile."','".$source."','".$target_file."','".$price."');";
                $result = $conn->query($insert_query);
                if (!$result) die ("Database access failed: " . $conn->error);
                $logo = new Image('resources/logo.png');
                $im = new Image($target_file);
                $heightOffSet = ($height/2)-($logo->size[1]/2);
                $widthOffSet = ($width/2)-($logo->size[0]/2);
                $im->composite($logo, $widthOffSet,$heightOffSet, "watermarked/".$target_file);
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