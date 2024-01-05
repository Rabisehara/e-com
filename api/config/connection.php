<?php
$host = "localhost";
$user="root";
$password = "";
$db_name = "localhost_db";

$conn = mysqli_connect($host,$user,$password,$db_name);
$date = new DateTime('now', new DateTimeZone('Asia/Kolkata'));
?>