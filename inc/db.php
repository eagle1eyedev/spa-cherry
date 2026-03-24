<?php
$host = "localhost";
$user = "root";
$password = "";
$db = "cherry_spa";

$connect = mysqli_connect($host,$user,$password,$db);

if(!$connect)
{
    echo 'Грешка при свързване с базата!'.mysqli_connect_error(); 
}
