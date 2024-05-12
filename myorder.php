<?php
session_start();
require 'db.php'; // Ensure this file exists and handles database connection

if (!isset($_SESSION['user'])) {
    header('Location: login.html'); // Redirect to login if not logged in
    exit();
}

$username = $_SESSION['user']; // Username of the logged-in user

// Fetch user's orders from the database
$sql = "SELECT OrderID, TotalAmount, Details FROM orders WHERE Username = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $username);
$stmt->execute();
$result = $stmt->get_result();

$totalPaid = 0; // total paid amount
$num_orders = $result->num_rows; // number of orders


if ($result->num_rows == 0) {
    // No orders found, prepare to show alert and redirect
    echo '<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>';
    echo '<script>
            Swal.fire({
                title: "No Orders Found",
                text: "",
                icon: "info",
                showConfirmButton: false,
                timer: 3000
            }).then(() => {
                window.location.href = "index.php";
            });
          </script>';
    exit(); // Stop further execution if no orders
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <title>TUWAIQ - My Orders</title>
    <link href="assets/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <link href="assets/css/style.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <style>
        #navbar {
            background-color: #000000; 
        }
    </style>
</head>
<body>
<header id="header" class="fixed-top d-flex align-items-center header-transparent">
    <div class="container d-flex justify-content-between align-items-center">
        <div id="logo">
            <a href="index.php"><img src="assets/img/logo.png" alt="" width="200"></a>
        </div>
        <nav id="navbar" class="navbar">
            <ul>
                <li><a class="nav-link scrollto" href="index.php">Home</a></li>
                <li><a class="nav-link scrollto" href="cart.php">Cart</a></li>
                <li><a class="nav-link scrollto active" href="myorder.php">My Orders</a></li>
                <li><a class="nav-link scrollto" href="logout.php">Logout</a></li>
            </ul>
        </nav>
    </div>
</header>

<main id="main" class="main-page">
    <section class="container">
    <br><br><br><br><br><br>
    	        <h1 style="color: black;" >Welcome <?php echo htmlspecialchars($username); ?>, you have <?php echo $num_orders; ?> completed <?php echo $num_orders === 1 ?'order' : 'orders'; ?>.</h1>

        <h2>My Orders</h2>
        <div class="table-responsive">
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>Order ID</th>
                        <th>Total Amount</th>
                        <th>Details</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($row = $result->fetch_assoc()): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($row['OrderID']); ?></td>
                        <td><?php echo htmlspecialchars($row['TotalAmount']); ?></td>
                        <td>
                            <?php
                            // Decode the JSON details
                            $details = json_decode($row['Details'], true);
                            $names = array();
                            foreach ($details as $detail) {
                                $names[] = htmlspecialchars($detail['name']); // Extracting the name
                            }
                            echo implode(", ", $names); // Joining all names with a comma
                            ?>
                        </td>
                    </tr>
                    <?php $totalPaid += $row['TotalAmount']; // Accumulate the total paid ?>
                    <?php endwhile; ?>
                </tbody>
            </table>
            <div class="total-paid">
                <strong>Total Paid: </strong> <?php echo number_format($totalPaid, 2); ?> SAR
            </div>
        </div>
    </section>
</main>

<footer id="footer">
    <div class="container">
        <div class="copyright">
            &copy; Copyright <strong>Tuwaiq Team</strong>. All Rights Reserved
        </div>
        <div class="credits">
            <!-- Total paid amount displayed here, if needed outside the main content area -->
        </div>
    </div>
</footer>
<script src="assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
<script src="assets/js/main.js"></script>
</body>
</html>
<?php
$stmt->close();
$conn->close();
?>

