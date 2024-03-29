<!-- Written by Raj Makda SJSU ID: 010128222 -->

<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Register</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
    <link rel="stylesheet" type="text/css" media="screen" href="auth.css" />
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.5.0/css/all.css" integrity="sha384-B4dIYHKNBt8Bc12p+WXckhzcICo0wtJAoU8YZTY5qE0Id1GSseTk6S+L3BlXeVIU" crossorigin="anonymous">

</head>
<body class="text-center">
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
            <a class="nav-link text-white" href="home.php"> <i class="fas fa-home fa-lg mr-1"></i>Home <span class="sr-only">(current)</span></a>
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

<div style="background-image: url('https://i.pinimg.com/originals/03/10/b8/0310b82f8ade9a5172ab00ea53bb45b3.png'); background-size: cover; height:100vh; width:100%">
    <div style="margin:auto; text-align: center; position: relative; top: 30%;color: white; ">
        <form class="form-signin" action="register.php" method="POST">
            <h1 class="h3 mb-3 font-weight-normal">Please sign up</h1>
            <label for="inputFirstName" class="sr-only">First Name</label>
            <input type="text" name="inputFirstName" id="inputFirstName" class="form-control" placeholder="First Name" required autofocus>
            <label for="inputLastName" class="sr-only">Last Name</label>
            <input type="text" name="inputLastName" id="inputLastName" class="form-control" placeholder="Last Name" required autofocus>
            <label for="inputUsername" class="sr-only">Username</label>
            <input type="text" name="inputUsername" id="inputUsername" class="form-control" placeholder="Username" required autofocus>
            <label for="inputPassword" class="sr-only">Password</label>
            <input type="password" name="inputPassword" id="inputPassword" class="form-control" placeholder="Password" required>
            <button class="btn btn-lg btn-dark btn-block" name="submitSignup" type="submit">Sign up</button>
            </form>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>

</body>
</html>

<?php

// Create connection to MySQL
$conn = new mysqli("localhost", "root", "", "Project3");

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if (isset($_POST["submitSignup"])) {
    $firstName = $_POST["inputFirstName"];
    $lastName = $_POST["inputLastName"];
    $username = mysql_entities_fix_string($conn, $_POST["inputUsername"]);
    $password = mysql_entities_fix_string($conn, $_POST["inputPassword"]);
    $salt1 = "qm&h*";
    $salt2 = "pg!@";
    $token = hash('ripemd128', "$salt1$password$salt2$username");
    saveUser($conn, $firstName, $lastName, $username, $token);
}

function saveUser($conn, $firstName, $lastName, $username, $token) {
    $query = "INSERT INTO Customers(FirstName, LastName, username, password) VALUES('$firstName', '$lastName', '$username', '$token')";
    $result = $conn->query($query);
    if (!$result) {
echo <<<_END
        <script>alert("$conn->error")</script>
_END;
    } else {
        $cookie_name = "user";
        $cookie_value = $username;
        setcookie($cookie_name, $cookie_value, time() + (86400), "/");
echo <<<_END
        <script>
            alert("Successfully registered");
            window.location = "images_all.php";
        </script>
_END;
    }
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