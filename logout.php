<?php
session_start(); // Start the session.

// Unset all of the session variables.
$_SESSION = array();

// If it's desired to kill the session, also delete the session cookie.
if (ini_get("session.use_cookies")) {
    $params = session_get_cookie_params();
    setcookie(session_name(), '', time() - 42000,
        $params["path"], $params["domain"],
        $params["secure"], $params["httponly"]
    );
}

// Finally, destroy the session.
session_destroy();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Logging Out</title>
    <!-- Copy styles from index.php -->
    <link href="assets/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,700,700i|Poppins:300,400,500,700" rel="stylesheet">
    <link href="assets/css/style.css" rel="stylesheet"> <!-- Ensure this path is correct -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <style>
        body {
            font-family: 'Open Sans', sans-serif;
            background-image: url('assets/img/tuwaiq.jpg'); /* Ensure this path is correct */
            background-size: cover;
            background-position: center;
            height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
        }
    </style>
</head>
<body>
    <script>
        // Clear local storage
        localStorage.clear();

        // Show logout alert
        Swal.fire({
            title: 'Logging Out',
            text: 'You have been logged out successfully.',
            icon: 'info',
            showConfirmButton: false,
            timer: 3000
        }).then(() => {
            // Redirect to the home page or login page after the alert
            window.location.href = 'index.php';
        });
    </script>
</body>
</html>
