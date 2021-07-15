<?php
require_once "config.php";

//connect to the db using the file saved in the config.php
$link = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_DATABASE);
$failed = "";

//declaring the variables
if(isset($_POST['lgn'])){
    $lgn =$_POST['lgn'];
}else{
    $lgn ="Not defined";
}
if(isset($_POST['email'])){
    $email = $_POST['email'];
}else{
    $email = "Not defined";
}
if(isset($_POST['pass'])){
    $pass = $_POST['pass'];
}else{
    $pass = "Not defined";
}

// if lgn is equal to login, the select query code will be executed
// lgn is the name in the form's hidden input, executed when the login button is clicked

if ($lgn == "login") {
    $sql = "SELECT id,name, phone FROM users WHERE email='$email' AND PASSWORD('$pass') = password";
    $result = mysqli_query($link, $sql);

    // login failed
    if (mysqli_num_rows($result) == 0) {
        //echo "Nothing found";
        $failed = 1;
    } // success login
    else {
        //echo "Login done!";
        $row = $result->fetch_row();

        $db_id = $row[0];
        $db_name = $row[1];
        $db_phone = $row[2];
        // setting the cookies with the values fetched from the db to keep the user logged in
        setcookie("auth_id", "$db_id");
        setcookie("auth_email", "$email");
        setcookie("name", $db_name);
        setcookie("phone", $db_phone);

        //echo "Success! Cookie: " . $_COOKIE['auth_id'];
        header("Location:admin.php");

        exit;
    }

}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>Login</title>
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
            position: fixed;
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
            <h2>Admin Page</h2>
            <h5 id="Date">
            </h5>
            <script> //get and show the current time and date
                const d = new Date();
                document.getElementById("Date").innerHTML = d;
            </script>
        </div>

        <br><br>
        <div class="container p-3 col-md-4 col-md-offset-4">
            <!-- login error message  -->
            <?php
            if ($failed == 1) {
                ?>
                <div class="panel panel-danger">
                    <div class="panel-heading">Login error</div>
                    <div class="panel-body">Wrong email or password</div>
                </div>

                <?php
            }
            ?>

            <div class="panel panel-default">
                <div class="panel-heading">Login page</div>
                <div class="panel-body">
                    <!-- login form that post to the same php page -->
                    <form method=POST action=login.php>

                        <div class="form-group">
                            <label>Email:</label>
                            <input type="text" class="form-control" autocomplete=off required name="email"/>
                        </div>

                        <div class="form-group">
                            <label>Password:</label>
                            <input type="password" class="form-control" required name="pass"/>
                        </div>


                        <div class="form-group">
                            <label></label>
                            <input type="submit" class="btn btn-primary" value="Login"/>
                        </div>

                        <input type="hidden" name="lgn" value="login"/>

                    </form>
                </div>
            </div>
        </div>
            <div class="container-fluid bg-3 text-center">

            </div>
            <br><br>

            <footer class="container-fluid text-center">
                <p>Simone Susino</p>
            </footer>
        </div>
    </div>
</body>
</html>
