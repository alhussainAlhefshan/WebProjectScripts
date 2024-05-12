<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);

// Database credentials
$servername = "127.0.0.1"; // Typically localhost, change if necessary
$username = "hussain"; // Your MySQL username
$password = "hussain"; // Your MySQL password
$database = "Tuwaiq"; // Your database name

// Create a MySQLi object instance for database connection
$conn = new mysqli($servername, $username, $password, $database);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Set the character set to UTF-8 for internationalization support
$conn->set_charset("utf8");

// This connection object $conn will be used in other scripts that include db.php
?>

