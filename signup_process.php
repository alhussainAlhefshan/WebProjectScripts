<?php
session_start();
require 'db.php';  

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $conn->real_escape_string($_POST['username']);
    $email = $conn->real_escape_string($_POST['email']);
    $password = $conn->real_escape_string($_POST['password']);
    $confirm_password = $conn->real_escape_string($_POST['confirm-password']);
    $birthday = $conn->real_escape_string($_POST['birthday']);

    // Validate password match
    if ($password !== $confirm_password) {
        $_SESSION['error'] = 'Passwords do not match.';
        header('Location: signup.html');  // Redirect back to the signup page
        exit();
    }

    // Hash the password
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

    // Insert the new user into the database
    $sql = "INSERT INTO Users (Username, Email, Password, Birthday) VALUES (?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    if ($stmt === false) {
        $_SESSION['error'] = 'Error preparing statement: ' . htmlspecialchars($conn->error);
        header('Location: signup.html');
        exit();
    }

    $stmt->bind_param("ssss", $username, $email, $hashed_password, $birthday);
    if ($stmt->execute()) {
        $_SESSION['message'] = 'Registration successful! You can now login.';
        header('Location: login.html');  // Redirect to the login page after successful registration
    } else {
        $_SESSION['error'] = 'Error executing statement: ' . htmlspecialchars($stmt->error);
        header('Location: signup.html');
    }

    $stmt->close();
    $conn->close();
} else {
    // Not a POST request, redirect to the signup form
    header('Location: signup.html');
}
?>
