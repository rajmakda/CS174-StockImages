<!-- Written by Raj Makda SJSU ID: 010128222 -->

<?php
include 'navigation.php';
?>


    <div style="margin-top:7%" class="container-fluid">
        <br>
        <form method="POST" action="upload.php" enctype="multipart/form-data">

            <label for="fileToUpload">Select image to upload:</label>
            <input type="file" name="fileToUpload" id="fileToUpload" accept="image/*"><br>

            <label for="category">Enter a category for the image: </label>
            <input type="text" name="category" id="category" placeholder="Enter a category" required><br>

            <label for="source">Enter your name: </label>
        <?php
        $username = $_COOKIE['user'];
        echo '<input type="text" name="source" id="source" placeholder="Enter your name" value="'.$username.'" required><br>';
        ?>

            <input class="btn btn-primary" type="submit" value="Upload Image" name="submit">
        </form>
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
    </script>

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