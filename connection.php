<?php

$connection = mysqli_connect("localhost:6001","root","","nvidly");

if(mysqli_connect_errno())
{
    echo "Failed To Connect To MySQL";
    exit();
}