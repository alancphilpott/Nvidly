<?php

$connection = mysqli_connect("localhost","root","","store");

if(mysqli_connect_errno())
{
    echo "Failed To Connect To MySQL";
    exit();
}