<?php
session_start();
require 'db.php';  // DB connection

if (!isset($_SESSION['admin_user'])) {
    header('Location: admin_login.html?error=1'); 
    exit();
}

$orderQuery = "SELECT OrderID, Username, TotalAmount, Details, OrderDate FROM orders";
$orderResult = $conn->query($orderQuery);
if ($orderResult === false) {
    die('Error fetching orders: ' . $conn->error);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <title>TUWAIQ - Admin Panel</title>
    <link href="assets/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <link href="assets/css/style.css" rel="stylesheet">
    <script src="assets/js/main.js"></script>
    <style>
        #footer {
            background: #343b40;
            padding: 30px 0;
            color: #fff;
            font-size: 14px;
        }
        #footer .credits {
            padding-top: 10px;
            text-align: center;
            font-size: 13px;
            color: #ccc;
        }
        #footer .copyright {
            text-align: center;
        }
        body {
            font-family: 'Open Sans', sans-serif;
            background-image: url('assets/img/tuwaiq.jpg');
            background-size: cover;
            background-position: center;
            color: #fff;
        }
        .container {
            max-width: 800px;
            margin: 50px auto;
            padding: 20px;
            background-color: rgba(0, 0, 0, 0.6);
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.5);
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
            color: #fff;
        }
        th, td {
            padding: 12px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }
        th {
            background-color: rgba(255, 255, 255, 0.1);
        }
        button {
            background-color: #007bff;
            color: white;
            border: none;
            padding: 5px 10px;
            border-radius: 5px;
            cursor: pointer;
        }
        button:hover {
            background-color: #0056b3;
        }
        h1, h2 {
            color: #fff;
            text-align: center;
        }
        #logo img {
            width: 100px;
        }
        #logo {
            margin-right: auto;
        }
        #main {
            padding: 50px 0;
            background-color: #fff;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.5);
        }
        #userList, #orderList {
            margin-top: 30px;
        }
        #footer {
            background-color: #666;
            padding: 20px 0;
            color: #fff;
            text-align: center;
        }
        #footer p {
            font-size: 12px;
            margin-bottom: 0;
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
                <li><a class="nav-link scrollto active" href="index.php">Home</a></li>
            </ul>
            <i class="bi bi-list mobile-nav-toggle"></i>
        </nav>
    </div>
</header><!-- End Header -->

<!-- Hero Section -->
<section id="hero">
    <div class="hero-container" data-aos="zoom-in" data-aos-delay="100">
        <h1>Welcome to TUWAIQ Admin Panel</h1>
        <h2>Climb to the top to see all users</h2>
        <a href="#main" class="btn-get-started">Get Started</a>
    </div>
</section><!-- End Hero Section -->

<main id="main">
    <div class="container">
        <h2>Users</h2>
        <table>
            <thead>
                <tr>
                    <th>Username</th>
                    <th>Email</th>
                    <th>Birthday</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody id="userList">
                <!-- User list dynamically -->
            </tbody>
        </table>

        <h2>Orders</h2>
        <table>
            <thead>
                <tr>
                    <th>Order ID</th>
                    <th>Username</th>
                    <th>Total</th>
                    <th>Order Details</th>
                    <th>Subtotal</th>
                    <th>Order Date</th>
                </tr>
            </thead>
            <?php while ($order = $orderResult->fetch_assoc()): ?>
                <tr>
                    <td><?php echo htmlspecialchars($order['OrderID']); ?></td>
                    <td><?php echo htmlspecialchars($order['Username']); ?></td>
                    <td><?php echo htmlspecialchars($order['TotalAmount']); ?></td>
                    <td>
                        <?php
                        $details = json_decode($order['Details'], true);
                        $itemNames = array_column($details, 'name');  // Extract only the name fields
                        echo implode("<br>", $itemNames);  
                        ?>
                    </td>
                    <td>
                        <?php
                        $totalPrice = 0;
                        foreach ($details as $item) {
                            $totalPrice += $item['price'];
                        }
                        echo $totalPrice;  
                        ?>
                    </td>
                    <td><?php echo htmlspecialchars($order['OrderDate']); ?></td>
                </tr>
                <?php endwhile; ?>
        </table>
    </div>
</main>

<!-- Footer -->
<footer id="footer">
    <div class="container">
        <div class="copyright">
            &copy; Copyright <strong>Tuwaiq Team</strong>. All Rights Reserved
        </div>
    </div>
</footer>

<a href="#" class="back-to-top d-flex align-items-center justify-content-center"><i class="bi bi-arrow-up-short"></i></a>

<script src="assets/vendor/purecounter/purecounter_vanilla.js"></script>
<script src="assets/vendor/aos/aos.js"></script>
<script src="assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
<script src="assets/vendor/glightbox/js/glightbox.min.js"></script>
<script src="assets/vendor/isotope-layout/isotope.pkgd.min.js"></script>
<script src="assets/vendor/swiper/swiper-bundle.min.js"></script>
<script src="assets/vendor/php-email-form/validate.js"></script>

<script>
// Fetch all user accounts and display them
fetch('get_user_accounts.php')
.then(response => response.json())
.then(data => {
    const userList = document.getElementById('userList');
    let html = '';
    data.forEach(user => {
        html += `
            <tr>
                <td>${user.Username}</td>
                <td>${user.Email}</td>
                <td>${user.Birthday}</td>
                <td><button onclick="deleteUser(${user.id})">Delete</button></td>
            </tr>
        `;
    });
    userList.innerHTML = html;
})
.catch(err => {
    console.error('Error fetching users:', err);
    alert('Failed to fetch user data.');
});


// Function to delete a user by their ID
function deleteUser(userId) {
    if (confirm('Are you sure you want to delete this user?')) {
        fetch(`delete_user_account.php?id=${userId}`, {
            method: 'DELETE'
        })
        .then(response => response.json())
        .then(data => {
            alert(data.message);
            location.reload();
        })
        .catch(error => {
            console.error('Error deleting user:', error);
            alert('Error deleting user: ' + error.message);
        });
    }
}
</script>
</body>
</html>
