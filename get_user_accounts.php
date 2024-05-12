<?php
session_start();
require 'db.php'; // Make sure this includes your actual database connection settings

header('Content-Type: application/json');

if (!isset($_SESSION['admin_user'])) {
    echo json_encode(['error' => 'Unauthorized']);
    exit;
}

$result = $conn->query("SELECT id, Username, Email FROM Users");

$users = [];

while ($row = $result->fetch_assoc()) {
    $users[] = $row;
}

echo json_encode($users);

$conn->close();
?>

