<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Your Cart - TUWAIQ</title>
    <link href="assets/img/favicon.png" rel="icon">
    <link href="assets/img/apple-touch-icon.png" rel="apple-touch-icon">
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,700,700i|Poppins:300,400,500,700" rel="stylesheet">
    <link href="assets/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <link href="assets/css/style.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <style>
        .cart-item {
            background: #fff;
            border-radius: 8px;
            margin-bottom: 15px;
            box-shadow: 0 2px 500px rgba(0,0,0,0.1);
            padding: 3px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        .total-amount, .tax-fee, .delivery-fee, .grand-total {
            justify-content: flex-start;
        }
        .logo img {
            max-width: 250px; /* smaller logo size */
        }
        .payment-button {
            text-align: left;
            margin-top: 20px;
        }
    </style>
</head>
<body>
<?php session_start(); ?>
<header id="header" class="fixed-top d-flex align-items-center">
    <div class="container d-flex justify-content-between">
        <div id="logo" class="logo">
            <a href="index.php"><img src="assets/img/logo.png" alt="TUWAIQ" class="img-fluid"></a>
        </div>
        <nav id="navbar" class="navbar">
            <ul>
                <li><a class="nav-link scrollto" href="index.php">Home</a></li>
                <li><a class="nav-link scrollto active" href="cart.php">Cart</a></li>
                <li><a class="nav-link scrollto" href="#contact">Contact</a></li>
                <?php if (isset($_SESSION['user'])): ?>
                    <li><a class="nav-link scrollto" href="logout.php">Logout</a></li>
                <?php else: ?>
                    <li><a class="nav-link scrollto" href="login.html">Login</a></li>
                <?php endif; ?>
            </ul>
        </nav>
    </div>
</header>

<div class="container mt-5 pt-5">
    <h1>Your Shopping Cart</h1>
    <div id="cart-items"></div>
    <div class="total-amount" id="total-amount"></div>
    <div class="tax-fee" id="tax-fee"></div>
    <div class="delivery-fee" id="delivery-fee"></div>
    <div class="grand-total" id="grand-total"></div>
    <div class="payment-button">
        <button id="proceedToPayment" type="button" class="btn btn-success">Proceed to Payment</button>
    </div>
</div>

<!-- Hidden form to submit cart data -->
<form id="cartForm" action="payment.php" method="POST" style="display: none;">
    <input type="hidden" name="cartData" id="cartData">
    <input type="hidden" name="totalAmount" id="totalAmount">
</form>

<script src="assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    const cart = JSON.parse(localStorage.getItem('cart') || '[]');
    const cartItemsContainer = document.getElementById('cart-items');
    const totalAmountElement = document.getElementById('total-amount');
    const taxFeeElement = document.getElementById('tax-fee');
    const deliveryFeeElement = document.getElementById('delivery-fee');
    const grandTotalElement = document.getElementById('grand-total');

    if (cart.length === 0) {
        Swal.fire({
            title: 'Empty Cart',
            text: '',
            icon: 'info',
            showConfirmButton: false,
            timer: 3000
        }).then(() => {
            window.location.href = 'index.php';
        });
    } else {
        let totalAmount = 0;
        cart.forEach(function(item, index) {
            const itemElement = document.createElement('div');
            itemElement.className = 'cart-item';
            itemElement.innerHTML = `<div>
                <h4>${item.name}</h4>
                <p>$${item.price}</p>
                <button onclick="removeFromCart(${index})" class="btn btn-danger btn-sm">Remove</button>
            </div>`;
            cartItemsContainer.appendChild(itemElement);
            totalAmount += parseFloat(item.price);
        });
        const tax = totalAmount * 0.15;
        const deliveryFee = 25;
        const grandTotal = totalAmount + tax + deliveryFee;

        totalAmountElement.innerHTML = `<div>Subtotal: $${totalAmount.toFixed(2)}</div>`;
        taxFeeElement.innerHTML = `<div>Tax (15%): $${tax.toFixed(2)}</div>`;
        deliveryFeeElement.innerHTML = `<div>Delivery Fee: $${deliveryFee.toFixed(2)}</div>`;
        grandTotalElement.innerHTML = `<div>Total: $${grandTotal.toFixed(2)}</div>`;

        document.getElementById('proceedToPayment').addEventListener('click', function() {
            document.getElementById('cartData').value = JSON.stringify(cart);
            document.getElementById('totalAmount').value = grandTotal.toFixed(2);
            document.getElementById('cartForm').submit();
        });
    }
});

function removeFromCart(index) {
    var cart = JSON.parse(localStorage.getItem('cart') || '[]');
    cart.splice(index, 1);
    localStorage.setItem('cart', JSON.stringify(cart));
    location.reload();
}
</script>

</body>
</html>
