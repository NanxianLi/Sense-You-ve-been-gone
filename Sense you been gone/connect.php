<?php
    $server="localhost";
    $db_username="monitor";
    $db_password="password";
    $db = "ais_project";

    $con = mysqli_connect($server,$db_username,$db_password,$db);
    if(mysqli_connect_errno()){
        die("can't connect".mysqli_connect_errno());
    }
?>
