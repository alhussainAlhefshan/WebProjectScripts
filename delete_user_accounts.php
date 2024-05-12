<?php
session_start();
require 'db.php';  // Ensure your db.php file is correctly set up to connect to the database

header('Content-Type: application/json');  // Ensures the output is treated as JSON

if (!isset($_SESSION['admin_user'])) {
    http_response_code(403);  // Proper HTTP response for unauthorized access
    echo json_encode(['message' => 'Unauthorized access.']);
    exit;
}

if ($_SERVER['REQUEST_METHOD'] == 'DELETE') {
    parse_str(file_get_contents("php://input"), $_DELETE);

    $userId = $conn->real_escape_string($_DELETE['id']);
    
    if ($stmt = $conn->prepare("DELETE FROM Users WHERE id = ?")) {
        $stmt->bind_param("i", $userId);
        $stmt->execute();
        if ($stmt->affected_rows) {
            echo json_encode(['message' => 'User deleted successfully']);
        } else {
            echo json_encode(['message' => 'No user was deleted, check the provided ID']);
        }
        $stmt->close();
    } else {
        echo json_encode(['message' => 'Error: ' . $conn->error]);
    }
    $conn->close();
} else {
    http_response_code(405);  // Method Not Allowed
    echo json_encode(['message' => 'Invalid request method.']);
}
?>
