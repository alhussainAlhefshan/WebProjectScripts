login_process.php
<?php
session_start();
require 'db.php'; 

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $username = htmlentities($conn->real_escape_string($_POST['username']));
    $password = htmlentities($conn->real_escape_string($_POST['password']));

    $sql = "SELECT Password FROM Users WHERE Username = ?";
    $stmt = $conn->prepare($sql);
    if ($stmt === false) {
        $_SESSION['error'] = 'Error preparing statement: ' . htmlspecialchars($conn->error);
        header('Location: login.html');  
        exit();
    }

    $stmt->bind_param("s", $username);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows == 1) {
        $stmt->bind_result($hashed_password);
        $stmt->fetch();
        if (password_verify($password, $hashed_password)) {
            $_SESSION['user'] = $username;  
            header('Location: index.php');  
        } else {
            $_SESSION['error'] = 'Invalid username or password.';
            header('Location: login.html');
        }
    } else {
        $_SESSION['error'] = 'Invalid username or password.';
        header('Location: login.html');
    }
    $stmt->close();
    $conn->close();
}
?>
//Safe Version - login Page
