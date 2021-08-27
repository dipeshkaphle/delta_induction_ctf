<?php
    setcookie('loggedin', '', time()-3600);
    setcookie('rollno', '', time()-3600);
    header('Location: index.php');
?>

<!-- source at /source/logout.php -->