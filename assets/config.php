<?php

$dbhost = "localhost";
$dbuser = "root";
$dbpass = "";
$dbname = "atiga-db";


$conn = mysqli_connect($dbhost, $dbuser, $dbpass, $dbname);
if (mysqli_connect_errno()) {
    die("Connection error: " . mysqli_connect_errno());
}

return $conn;
