<?php
session_start();
require 'db.php';  

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = htmlentities($conn->real_escape_string($_POST['username']));
    $password = htmlentities($conn->real_escape_string($_POST['password']));
    // to prevent SQL Injection
    $sql = "SELECT id, Password FROM Admins WHERE Username = ?";
    $stmt = $conn->prepare($sql);
    if (!$stmt) {
        header('Location: admin_login.html?error=' . urlencode("Error preparing statement."));
        exit();
    }
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $stmt->store_result();
    if ($stmt->num_rows == 1) {
        $stmt->bind_result($id, $hashed_password);
        $stmt->fetch();
        if (password_verify($password, $hashed_password)) {
            // Set session variables for a valid admin
            $_SESSION['admin_id'] = $id;
            $_SESSION['admin_user'] = $username;
            header('Location: admin.php');
            exit();
        } else {
            header('Location: admin_login.html?error=' . urlencode("Invalid username or password."));
            exit();
        }
    } else {
        header('Location: admin_login.html?error=' . urlencode("Invalid username or password."));
        exit();
    }
    $stmt->close();
    $conn->close();
} else {
    header('Location: admin_login.html');
    exit();
}

//Safe Version - Admin login 
