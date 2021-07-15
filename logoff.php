<?php
//clean the cookie setting it to ""
    setcookie("auth_id","");
    setcookie("auth_email","");
?>
<!DOCTYPE HTML>

<html>

<head>
  <title>Logoff</title>
</head>

<body>
<!--Alert message when you logout and redirect to home page-->
        <script>
            window.alert("Logout Successful!")
            window.location.href='index.html';
        </script>
</body>

</html>