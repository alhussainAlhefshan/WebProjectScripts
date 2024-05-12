<?php
session_start();
require 'db.php'; // Ensure this file exists and contains your database connection details

// Fetch products from the database
$sql = "SELECT id, name, image, price FROM items"; // Adjust SQL according to your database schema
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <title>TUWAIQ</title>
    <meta content="" name="description">
    <meta content="" name="keywords">

    <!-- Favicons -->
    <link href="assets/img/favicon.png" rel="icon">
    <link href="assets/img/apple-touch-icon.png" rel="apple-touch-icon">

    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,700,700i|Poppins:300,400,500,700" rel="stylesheet">

    <!-- Vendor CSS Files -->
    <link href="assets/vendor/aos/aos.css" rel="stylesheet">
    <link href="assets/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <link href="assets/vendor/bootstrap-icons/bootstrap-icons.css" rel="stylesheet">
    <link href="assets/vendor/boxicons/css/boxicons.min.css" rel="stylesheet">
    <link href="assets/vendor/glightbox/css/glightbox.min.css" rel="stylesheet">
    <link href="assets/vendor/swiper/swiper-bundle.min.css" rel="stylesheet">

    <!-- Template Main CSS File -->
    <link href="assets/css/style.css" rel="stylesheet">

    <!-- SweetAlert2 CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11">

    <style>
        .add-to-cart-option button {
            background-color: #D2B48C; /* Tan */
            border: none;
            color: white;
            padding: 10px 20px;
            text-align: center;
            text-decoration: none;
            display: inline-block;
            font-size: 16px;
            margin: 4px 2px;
            cursor: pointer;
            border-radius: 4px;
            transition: background-color 0.3s;
        }

        .add-to-cart-option button:hover {
            background-color: #DEB887; /* Darker tan */
            color: black;
            transform: scale(1.1);
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.3);
        }
    </style>
</head>
<body>
<!-- Header -->
<header id="header" class="fixed-top d-flex align-items-center header-transparent">
    <div class="container d-flex justify-content-between align-items-center">
        <div id="logo">
            <a href="index.php"><img src="assets/img/logo.png" alt="" width="200"></a>
        </div>
        <nav id="navbar" class="navbar">
            <ul>
                <li><a class="nav-link scrollto active" href="#hero">Home</a></li>
                <li><a class="nav-link scrollto" href="cart.php">Cart<span id="cart-count">0</span></a></li>
                <li><a class="nav-link scrollto" href="#portfolio">Products</a></li>
                <li><a class="nav-link scrollto" href="#contact">Contact</a></li>
                <?php if (isset($_SESSION['user'])): ?>
                    <li><a class="nav-link scrollto" href="myorder.php">My Orders</a></li>
                    <li><a class="nav-link scrollto" href="logout.php">Logout</a></li>
                    
                <?php else: ?>
                    <li><a class="nav-link scrollto" href="login.html">Login</a></li>
                <?php endif; ?>
            </ul>
            <i class="bi bi-list mobile-nav-toggle"></i>
        </nav><!-- .navbar -->
    </div>
</header><!-- End Header -->

<!-- Hero Section -->
<section id="hero">
    <div class="hero-container" data-aos="zoom-in" data-aos-delay="100">
        <h1>Welcome to TUWAIQ</h1>
        <h2>Reach new heights in style with TUWAIQ, your ultimate shopping destination!</h2>
        <a href="#main" class="btn-get-started">Get Started</a>
    </div>
</section><!-- End Hero Section -->

<!-- Main Section -->
<main id="main">
    <section class="tuwaiq-products">
        <div class="container">
            <h2 class="title">Tuwaiq Products</h2>
            <div class="row">
                <?php if ($result->num_rows > 0): ?>
                    <?php while($row = $result->fetch_assoc()): ?>
                        <div class="col-md-4">
                            <div class="product-card" id="product-<?php echo $row['id']; ?>">
                                <img src="<?php echo htmlspecialchars($row['image']); ?>" alt="<?php echo htmlspecialchars($row['name']); ?>">
                                <h3><?php echo htmlspecialchars($row['name']); ?></h3>
                                <p class="price"><?php echo number_format($row['price'], 2); ?> SAR</p>
                                <div class="add-to-cart-option">
                                    <button onclick="addToCart(<?php echo $row['id']; ?>)">Add to Cart</button>
                                </div>
                            </div>
                        </div>
                    <?php endwhile; ?>
                <?php else: ?>
                    <p>No products found.</p>
                <?php endif; ?>
            </div>
        </div>
    </section>
    <!-- Additional sections can be added here -->
</main>

<section id="contact">
    <div class="container">
      <div class="section-header">
        <h3 class="section-title">Contact</h3>
        <p class="section-description">We would love to hear from you! If you have any questions, feedback, or simply want to get in touch, please don't hesitate to reach out to us.  </p>
      </div>
    </div>


    <div class="container mt-5">
      <div class="row justify-content-center">

        <div class="col-lg-3 col-md-4">

          <div class="info">
            <div>
              <i class="bi bi-envelope"></i>
              <p>info@TUWAIQ.com</p>
            </div>

           
          </div>

         

        </div>

        <div class="col-lg-5 col-md-8">
          <div class="form">
            <form action="forms/contact.php" method="post" role="form" class="php-email-form">
              <div class="form-group">
                <input type="text" name="name" class="form-control" id="name" placeholder="Your Name" required>
              </div>
              <div class="form-group mt-3">
                <input type="email" class="form-control" name="email" id="email" placeholder="Your Email" required>
              </div>
              <div class="form-group mt-3">
                <input type="text" class="form-control" name="subject" id="subject" placeholder="Subject" required>
              </div>
              <div class="form-group mt-3">
                <textarea class="form-control" name="message" rows="5" placeholder="Message" required></textarea>
              </div>
              <div class="my-3">
                <div class="loading">Loading</div>
                <div class="error-message"></div>
                <div class="sent-message">Your message has been sent. Thank you!</div>
              </div>
              <div class="text-center"><button type="submit">Send Message</button></div><!-- send Messages is not handle yet  -->
            </form>
          </div>
        </div>

      </div>

    </div>
  </section>

<!-- Footer -->
<footer id="footer">
    <div class="container">
        <div class="copyright">
            &copy; Copyright <strong>Tuwaiq Team</strong>. All Rights Reserved 
        </div>
    </div>
</footer>

<a href="#" class="back-to-top d-flex align-items-center justify-content-center"><i class="bi bi-arrow-up-short"></i></a>

<!-- Vendor JS Files -->
<script src="assets/vendor/purecounter/purecounter_vanilla.js"></script>
<script src="assets/vendor/aos/aos.js"></script>
<script src="assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
<script src="assets/vendor/glightbox/js/glightbox.min.js"></script>
<script src="assets/vendor/isotope-layout/isotope.pkgd.min.js"></script>
<script src="assets/vendor/swiper/swiper-bundle.min.js"></script>
<script src="assets/vendor/php-email-form/validate.js"></script>
<!-- Template Main JS File -->
<script src="assets/js/main.js"></script>

<!-- SweetAlert-->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
function addToCart(productId) {
    // Fetch product details from the product card
    var productCard = document.querySelector('#product-' + productId);
    var productName = productCard.querySelector('h3').textContent;
    var price = productCard.querySelector('.price').textContent.replace(/[^0-9\.]+/g, "");

    // Example: Using localStorage to simulate adding to cart
    var cart = JSON.parse(localStorage.getItem('cart') || '[]');
    cart.push({
        id: productId,
        name: productName,
        price: parseFloat(price)
    });
    localStorage.setItem('cart', JSON.stringify(cart));
    Swal.fire({
        title: 'Added to Cart',
        text: productName + ' has been added to your cart.',
        icon: 'success',
        confirmButtonText: 'Ok'
    });
    updateCartCount();
}

function updateCartCount() {
    var cart = JSON.parse(localStorage.getItem('cart') || '[]');
    var cartCount = cart.length;
    document.getElementById('cart-count').textContent = cartCount;
}

document.addEventListener('DOMContentLoaded', function() {
    updateCartCount();
});
</script>

</body>
</html>

<?php
$conn->close();
?>
