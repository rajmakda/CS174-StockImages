<!-- Written by Raj Makda SJSU ID: 010128222 -->


<?php
// Create connection to MySQL
$conn = new mysqli("localhost", "root", "", "Project3");
// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
$username = $_COOKIE['user'];
$image_price = $_POST["image_price"];
$user_credits = $_POST["user_credits"];
$remainder = $user_credits - $image_price;
$updateCreditsQuery = "UPDATE Customers SET credits=$remainder WHERE username='$username'";
$update_result = $conn->query($updateCreditsQuery);

include 'navigation.php';

if (isset($_POST['purchase'])) {
    $imageId = $_POST["image_id"];
    $queryUser = "SELECT * FROM Customers WHERE username='$username'";
    $result = $conn->query($queryUser);
    if ($result->num_rows) {
        $row = $result->fetch_array(MYSQLI_NUM);
        $result->close();
        $customerId = $row[0];
        $query = "INSERT INTO Transactions(customerId, imageId) VALUES($customerId, $imageId);";
        $result = $conn->query($query);
        if (!$result) die($conn->error);
        $queryImage = "SELECT * FROM Images WHERE id='$imageId'";
        $result = $conn->query($queryImage);
        $imageData = $result->fetch_array(MYSQLI_NUM);
        displayImage($imageData);
    }
} else {
    echo '<div style="margin-top:7%">No image selected</div>';
}



function displayImage($row) {
    $sizeInKb = $row[4] / 1000;
echo <<<_END
    <div style="position:absolute;left:0;right:0;top:10%;bottom:0;margin:auto;text-align: center">
        
        <h3 style="text-align: center">Thank you for purchasing the image</h3>
        <p style="text-align: center"><a href="download.php?file=$row[6]">Download</a></p>
        
        <div class="col-sm-5" style="position:relative; margin:auto">
            <div class="img-thumbnail">
                <img class="img-fluid" src="$row[6]">
                <div class="caption">
                    <h4>By $row[5]</h4>
                </div>
                <p>
                    Category: $row[1]<br>
                    Size: $row[2] * $row[3]<br>
                    File Size: $sizeInKb kB<br>
                </p>
            </div>
        </div>
    </div>
_END;
}
?>

</body>
</html>