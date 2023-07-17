<?php

$serverName = "localhost";
$userName = "root";
$password = "";
$dbName = "inventory";

$con = mysqli_connect($serverName, $userName, $password, $dbName);

if(mysqli_connect_errno()){
    echo "Failed to Connect!";
    exit();
}

?>