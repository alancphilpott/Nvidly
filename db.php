<?php

$host = "db";
$user = "root";
$password = "root";
$db = "nvidly";

$db = mysqli_connect($host,$user,$password,$db);

if (mysqli_connect_errno()) {
    printf("connection failed: %s\n", mysqli_connect_error());
    exit();
}

?>