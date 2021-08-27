<?php
    
    if(!isset($_COOKIE['loggedin'])){
        header("Location: index.php");
    }
    if(!isset($_COOKIE['rollno'])){ 
        header("Location: logout.php");
    }
    require('db.php');
    $rollno = $_COOKIE['rollno'];
    $query = "SELECT * FROM `user` WHERE `rollno` = '$rollno'";
    $result = mysqli_query($conn, $query);
    $row = mysqli_fetch_all($result, MYSQLI_ASSOC);
    if(empty($row)){
        header("Location: logout.php");
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
    <h1>Lambda Placement Site </h1>

    <h3>Welcome <?php echo $row[0]['rollno']; ?></h1>
    <?php
        if($row[0]['isadmin'] !== '1'){
            echo "<p>You are not an admin. Cannot show upcoming companies.</p>";
        }
        else {
            require('companies.php');
            echo "<h3>Upcoming Companies</h3>";
            for($i = 0; $i < count($companies); $i++){
                echo "<p>".$companies[$i].": ". $desc[$i] . "<p>";
            }
        }
    ?>
    <a href="/logout.php"> <button>Logout</button> </a>
</body>
</html>

<!-- source at /source/dashboard.php -->