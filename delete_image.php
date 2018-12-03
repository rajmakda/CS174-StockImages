 <div style="margin-top: 7%" class="container-fluid">
        <div class="row text-center" style="display:flex; flex-wrap:wrap;">
        <?php 
             // Create connection to MySQL
        $conn = new mysqli("localhost", "root", "", "Project3");

            // Check connection
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        } 
            
            // Query to get all images from database
        $get_all_query = "SELECT * FROM Images";
        $result = $conn->query($get_all_query);
        if (!$result) die("Database access failed: " . $conn->error);
        $columns = $result->field_count;
        $rows = $result->num_rows;
        for ($i = 0; $i < $rows; $i++) {
            $row = $result->fetch_array(MYSQLI_NUM);
            $sizeInKb = $row[4] / 1000;
            echo <<<_END
                <div class="col-sm-3">
                    <div class="img-thumbnail">
                        <img class="img-fluid" src="$row[6]">
                        <div class="caption">
                            <h4>By $row[5]</h4>
                        </div>
                        <p>
                            Category: $row[1]<br>
                            Size: $row[2] * $row[3]<br>
                            File Size: $sizeInKb kB<br>
                            <form method="POST" action="images_all.php">
                                <input type="hidden" id="image_id" name="image_id" value="$row[0]">
                                <input type="hidden" id="image_path" name="image_path" value="$row[6]">
                                <input type="submit" class="btn btn-primary btn-sm" name="delete" value="Delete">
                            </form>
                        </p>
                    </div>
                </div>
_END;
        }

            // DELETE FROM DB AND DISK
        if (isset($_POST["delete"])) {
            $delete_query = "DELETE FROM Images WHERE id=" . $_POST["image_id"];
            $result = $conn->query($delete_query);
            if (!$result) die("Database access failed: " . $conn->error);
            unlink($_POST["image_path"]);
            echo "<script>alert(\"Successfully Deleted from Database\");</script>";
            header("Refresh:0; url=images_all.php");

        }
        ?>
        </div>
        <a href="index.php">Back</a>
    </div>