<?php

$host = "localhost";
$dbname ="login_db";
$username = "root";
$password = "Molly23";

$mysqli = new mysqli($host, $username, $password, $dbname);

if ($mysqli->connect_errno){
    die("Connection error: " . $mysqli->connect_error);
}

return $mysqli;
?>