<?php
require_once "config.php";

$link = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_DATABASE);
//initialize the cookies for the auth_id, auth_email, name, phone and pass variable
//it gets the information of the current user logged in saved in the cookie

if(isset($_COOKIE['auth_id'])){
    $id =  $_COOKIE['auth_id'];
}else{
    $id ="Not defined";
}
if(isset($_COOKIE['auth_email'])){
    $email = $_COOKIE['auth_email'];
}else{
    $email ="Not defined";
}

if(isset($_COOKIE['name'])){
    $name = $_COOKIE['name'];
}else{
    $name ="Not defined";
}

if(isset($_COOKIE['phone'])){
    $phone = $_COOKIE['phone'];
}else{
    $phone ="Not defined";
}
if(isset($_COOKIE['pass'])){
    $pass =  $_COOKIE['pass'];
}else{
    $pass ="Not defined";
}

$sql = "SELECT id FROM users WHERE id='$id' AND email='$email'";
$result = mysqli_query($link,$sql);

//user not logged in, alert an unauthorised access message
if (mysqli_num_rows($result)==0)
{
    ?>
    <script>
        window.alert("Unauthorised access!")
        window.location.href='index.html';
    </script>
    <?php
    exit;
}

//the code perform a query to change the current email
if(isset($_POST['submit_email'])){
    $email = $_POST['inputEmail'];
    $query = "UPDATE users SET email = '$email'
                      WHERE id = '$id'";
    $result = mysqli_query($link, $query);
}
else{
    $email = $_COOKIE['auth_email'];
}

//the code perform a query to change the password
if(isset($_POST['submit_pass'])){
    $new = $_POST['inputNew'];
    $query = "UPDATE users SET password = PASSWORD('$new')
                      WHERE id = '$id'";
    $result = mysqli_query($link, $query);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>Admin Page</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
    <script type="application/javascript" src="js/jquery-3.6.0.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.js"></script>
    <style>
        /* Remove the navbar's default margin-bottom and rounded borders */
        .navbar {
            margin-bottom: 0;
            border-radius: 0;
        }

        /* Add a gray background color and some padding to the footer */
        footer {
            background-color: #f2f2f2;
            padding: 25px;
            position: relative;
            left: 0;
            width: 100%;
            bottom: 0;
            text-align: center;
        }
        h1 {
            text-align: left;
        }
        .table td {
            text-align: justify;
        }

    </style>
</head>
<body>

<nav class="navbar navbar-inverse">
    <div class="container-fluid">
        <div class="navbar-header">
            <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#myNavbar">
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
        </div>
        <div class="collapse navbar-collapse" id="myNavbar">
            <ul class="nav navbar-nav">
                <li><a href="index.html">Dashboard</a></li>
                <li><a href="countries.html">Live Countries</a></li>
                <li class="active"><a href="admin.php">Admin</a></li>
            </ul>
            <ul class="nav navbar-nav navbar-right">
                <li><a href="login.php"><span class="glyphicon glyphicon-log-in"></span>Login</a></li>
            </ul>
        </div>
    </div>
</nav>

<br><br>
<div class="container-fluid bg-3 text-center">
    <div class="col-sm-12">
        <div class="well">
            <h2>Welcome <?php echo $_COOKIE['name'];?></h2>
            <h5 id="Date">
            </h5>
            <script> //get and show the current time and date
                const d = new Date();
                document.getElementById("Date").innerHTML = d;
            </script>
        </div>
        <a href="index.html">Home</a> | <a href="logoff.php">Logout</a>
        <br><br>
        <div class="container">
            <div class="col-md-4 col-md-offset-4">
                <div class="portlet light bordered">
                    <div class="portlet-title tabbable-line">
                        <div class="caption caption-md">
                            <i class="icon-globe theme-font hide"></i>
                        </div>
                    </div>
                    <div class="portlet-body">
                        <div>

                            <!-- Nav tabs for the admin menu-->
                            <ul class="nav nav-tabs" role="tablist">
                                <li role="presentation" class="active"><a href="#home" aria-controls="home" role="tab" data-toggle="tab">Profile</a></li>
                                <li role="presentation"><a href="#email" aria-controls="profile" role="tab" data-toggle="tab">Update Email</a></li>
                                <li role="presentation"><a href="#password" aria-controls="profile" role="tab" data-toggle="tab">Change Password</a></li>
                            </ul>

                            <!-- Tab panels -->
                            <div class="tab-content">
                                <div role="tabpanel" class="tab-pane active" id="home">
                                        <div class="form-group">
                                            <br><br>
                                            <label for="name">Name</label>
                                            <p><?php echo $name?></p>
                                            <label for="phone">Phone</label>
                                            <p><?php echo $phone?></p>
                                            <label for="phone">Email</label>
                                            <p><?php echo $email?></p>
                                        </div>
                                        <br><br>
                                </div>
                                <div role="tabpanel" class="tab-pane" id="email">
                                    <!-- form to change email and password -->
                                    <form method="POST" action="admin.php">
                                        <div class="form-group">
                                            <br><br>
                                            <label for="inputEmail">Email address</label>
                                            <input type="email" class="form-control" name="inputEmail" placeholder=<?php echo $email?> required>
                                        </div>
                                        <button type="submit" name = "submit_email" class="btn btn-default">Submit</button>
                                        <br><br>

                                    </form>
                                </div>
                                <div role="tabpanel" class="tab-pane" id="password">
                                    <form method="POST" action="admin.php">
                                        <div class="form-group">
                                            <br><br>
                                            <label for="inputPassword">Password</label>
                                            <input type="password" class="form-control" name="inputNew" placeholder="New Password" required>
                                        </div>
                                        <button type="submit" name="submit_pass" class="btn btn-default">Submit</button>
                                        <br><br>
                                    </form>

                                </div>
                                <div role="tabpanel" class="tab-pane" id="profile">
                                    <br>
                                    <div class="form-group">
                                        <label for="name">Name</label>
                                        <p><?php echo $name?></p>
                                        <label for="phone">Phone</label>
                                        <p><?php echo $phone?></p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
        <footer class="container-fluid text-center col-md-12">
            <p>Simone Susino</p>
        </footer>
</div>
</body>
</html>



