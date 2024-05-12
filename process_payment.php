<?php
session_start();
require 'db.php';

if (!isset($_SESSION['user'])) {
    echo '<script>
            alert("Please login to complete your order");
          </script>';
    header('Location: login.html');
    exit();
}

$username = $_SESSION['user'];
$cartData = $_POST['cartData'];
$totalAmount = (float)$_POST['totalAmount'];

$sql = "INSERT INTO orders (Username, TotalAmount, Details) VALUES (?, ?, ?)";
$stmt = $conn->prepare($sql);
if ($stmt === false) {
    die('Error preparing statement: ' . htmlspecialchars($conn->error));
}

$orderDetails = $cartData; // No need to encode/decode as it should be passed directly
$stmt->bind_param("sds", $username, $totalAmount, $orderDetails);
if ($stmt->execute()) {
    header('Location: orderConfirmation.php');
    exit();
} else {
    die('Error executing statement: ' . htmlspecialchars($stmt->error));
}

$stmt->close();
$conn->close();
