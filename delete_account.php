<?php
//Written by Kumar Vaibhav
//010110295

    if (!isset($_COOKIE['user'])) {
    echo "<script>alert(\"You must be logged in\");</script>";
    echo "<script>window.location = \"home.php\";</script>";
    exit;
}
$uname = $_COOKIE['user'];
$query = "Delete from Customers where username = '$uname'";
$conn = new mysqli("localhost", "root","","Project3");
$result = $conn->query($query);
setcookie("user", "", time() - 3600, '/');
    if (!$result) die ("Database access failed: " . $conn->error);
    echo "<script>alert(\"Successfully Deleted from Database\");</script>";
    header("Refresh:0; url=home.php");

?>

