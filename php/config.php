<?php

$servername = "127.0.0.1";
$database = "umrmms";
$username = "jiaxiong";
$password = "jiaxiong";

$conn = new mysqli($servername, $username, $password, $database);
if (mysqli_connect_errno()) {
    die("Database connection failed: " . mysqli_connect_error());
}
// echo "Database connnected successfully<br>";
