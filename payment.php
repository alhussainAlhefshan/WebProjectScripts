<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Secure Payment - TUWAIQ</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

  <!-- Template Main JS File -->
  <script src="assets/js/main.js"></script>
    <style>
    #footer {
    position: fixed;
    bottom: 0;
    width: 100%;
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
    background-image: url('assets/img/tuwaiq2.jpg');
    background-size: cover;
    background-position: center;
    height: 100vh; /* Ensure body takes full viewport height */
    margin: 0;
    padding: 0;
}
        .container, .header {
            filter: blur(0);
        }
        .logo-container {
            text-align: center;
            margin-bottom: 30px;
        }
        .logo-container img {
            max-width: 200px;
            height: auto;
            filter: invert(1) brightness(2) contrast(1%);
        }
        .payment-form {
            max-width: 400px;
            margin: 100px auto 20px;
            padding: 20px;
            background-color: #fff;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        .payment-form h2 {
            text-align: center;
            margin-bottom: 20px;
        }
        input[type="text"], input[type="password"] {
            width: 100%;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 5px;
            margin-bottom: 20px;
        }
        button {
            background-color: #007bff;
            color: #fff;
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            width: 100%;
        }
        button:hover {
            background-color: #0056b3;
        }
    </style>
</head>
<body>
    <header class="header">
        <div class="logo-container">
            <img src="assets/img/logo.png" alt="logo">
        </div>
    </header>
    <div class="container">
        <div class="payment-form">
            <h2>Secure Payment</h2>
            <form action="process_payment.php" method="post" id="paymentForm">
                <?php
                $cartData = isset($_POST['cartData']) ? $_POST['cartData'] : '';
                $totalAmount = isset($_POST['totalAmount']) ? $_POST['totalAmount'] : '';
                if (!$cartData || !$totalAmount) {
                    echo "<p>Error: Cart data missing. Please go back and try again.</p>";
                } else {
                    echo '<input type="hidden" name="cartData" value="' . htmlspecialchars($cartData) . '">';
                    echo '<input type="hidden" name="totalAmount" value="' . htmlspecialchars($totalAmount) . '">';
                    echo '<input type="text" name="cardNumber" id="cardNumber" placeholder="Card Number" required pattern="\\d{4} \\d{4} \\d{4} \\d{4}" title="Card number must be 16 digits formatted as xxxx xxxx xxxx xxxx"><br>';
                    echo '<input type="text" name="nameOnCard" id="nameOnCard" placeholder="Name on Card" required pattern="\\w+\\s\\w+" title="Enter the First and Last name"><br>';
                    echo '<input type="text" name="expDate" id="expDate" placeholder="Expiration Date (MM/YY)" required title="Enter a valid expiration date, e.g., 05/24"><br>';
                    echo '<input type="text" name="cvv" id="cvv" placeholder="CVV" required pattern="\\d{3}" title="CVV must be 3 digits"><br>';
                    echo '<button type="submit" class="btn btn-primary btn-block">Pay Now</button>';
                }
                ?>
            </form>
        </div>
    </div>

    <script>
        document.getElementById('cardNumber').addEventListener('input', function (e) {
            e.target.value = e.target.value.replace(/[^\dA-Z]/g, '').replace(/(.{4})/g, '$1 ').trim();
        });

        document.getElementById('paymentForm').addEventListener('submit', function(e) {
            const expInput = document.getElementById('expDate');
            const expValue = expInput.value.split('/');
            const expYear = parseInt(expValue[1], 10) + 2000;
            const expMonth = parseInt(expValue[0], 10);

            // Check if the expiration date is before May 2024
            if (expYear < 2024 || (expYear === 2024 && expMonth < 5)) {
                e.preventDefault(); // Prevent form submission
                Swal.fire({
            	title: 'Expired Cards Not Accepted',
            	text: '',
            	icon: 'info',
            	showConfirmButton: false,
            	timer: 3000
       			 });
                expInput.focus(); // Focus on the expiration date input
            }
        });
    </script>
</body>
 <footer id="footer">
    <div class="container">
        <div class="copyright">
            &copy; Copyright <strong>Tuwaiq Team</strong>. All Rights Reserved 
        </div>
    </div>
</footer>


</html>
