<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);

// Database info
$servername = "127.0.0.1"; //  localhost
$username = "hussain"; 
$password = "hussain"; 
$database = "Tuwaiq"; 


$conn = new mysqli($servername, $username, $password, $database);


if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$conn->set_charset("utf8");


?>

