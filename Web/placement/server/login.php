<?php
    if(isset($_COOKIE['loggedin']) && $_COOKIE['loggedin'] == true){
        header("location: dashboard.php");
    }
    
    if(isset($_POST['submit'])) {
        require('db.php');
        $rollno = mysqli_real_escape_string($conn,$_POST['rollno']);
        $password=mysqli_real_escape_string($conn,$_POST['password']);
        $query = "SELECT * FROM `user` WHERE `rollno` = '$rollno'";
        $result = mysqli_query($conn,$query);
        $row = mysqli_fetch_all($result,MYSQLI_ASSOC);
        
        if(empty($row)) {
            
            header("location: index.php?error=invalidcreds");
        }
        
        else if ($row[0]['password'] === $password) {
            setcookie('loggedin', true, time() + (86400 * 30));
            setcookie('rollno', $rollno, time() + (86400 * 30));
            header("location: dashboard.php");
        } 
        else {
            header("location: index.php?error=passwordwrong");
        }
    }
?>


<!-- source at /source/login.php -->