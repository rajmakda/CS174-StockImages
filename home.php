<?php
//Written by Kumar Vaibhav
//010110295
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Welcome to Pixi</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
    <link rel="stylesheet" type="text/css" media="screen" href="main.css" />
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.5.0/css/all.css" integrity="sha384-B4dIYHKNBt8Bc12p+WXckhzcICo0wtJAoU8YZTY5qE0Id1GSseTk6S+L3BlXeVIU" crossorigin="anonymous">
    <script src="main.js"></script>
</head>
<body>
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
            <a class="nav-link text-white" href="home.php"> <i class="fas fa-home fa-lg mr-1"></i>Home <span class="sr-only">(current)</span></a>            </li>
        </ul>
        <ul class="navbar-nav flex-row ml-md-auto d-none d-md-flex">
            <li class="nav-item active">
                <a class="nav-link text-white" href="login.php">Login <span class="sr-only">(current)</span></a>
            </li>
            <li class="nav-item active" ">
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
                <a class="nav-link text-white" > <i class="mr-1 mt-2 fas fa-coins fa-lg"></i> 10 <span class="sr-only">(current)</span></a>
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
<div class="jumbotron" style="background-image: url('resources/landing.jpeg'); background-size: cover; height:100vh">
    <div style="margin:auto; text-align: center; position: relative; top: 50%;color: white; ">
        <h1 style="font-size:52px">Welcome to Pixi</h1>
        <h4>Buy and sell your images</h4>
    </div>
</div>
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>
</body>
</html>
