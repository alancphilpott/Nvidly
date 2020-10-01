<?php

$host = "db";
$user = "root";
$password = "root";
$db = "nvidly";

$connection = mysqli_connect($host,$user,$password,$db);

if ($connection->connect_error) {
    echo "OOOOOF - Connection Failed" . $connection->connect_error;
} else {
    echo "She's a Beaut M8 - Successfully Connected to MySQL";
}

?>