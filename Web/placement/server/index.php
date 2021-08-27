<?php
    session_start();
    if(isset($_COOKIE['loggedin']) && $_COOKIE['loggedin'] == true){
        header("Location: dashboard.php");
    }

?>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lambda</title>
</head>

<body>
    <h1>Lambda Placement Site</h1>
    <form action="/login.php" method='POST'>
        <input type="text" name="rollno" placeholder="Roll Number" required>
        <br>
        <input type="password" name="password" required>
        <br>
        <input type="submit" name='submit' value="Login">
    </form>
</body>

</html>


<!-- source at /source/index.php -->