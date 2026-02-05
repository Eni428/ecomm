<?php
include 'connection.php';
session_start();
$user_id = $_SESSION['user_id'];
if (!isset($user_id)) {
    header('location:login.php');
    exit();
}
if (isset($_POST['logout'])) {
    session_destroy();
    header('location: login.php');
    exit();
}
if (isset($_POST['order-btn'])) {
    $name = mysqli_real_escape_string($conn, $_POST['name']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $number = mysqli_real_escape_string($conn, $_POST['number']);
    $method = mysqli_real_escape_string($conn, $_POST['method']);
    $address = mysqli_real_escape_string($conn, $_POST['address']);
    $street = mysqli_real_escape_string($conn, $_POST['street']);
    $placed_on = date('d-M-Y');
    $cart_total = 0;
    $cart_product = [];

    $cart_query = mysqli_query($conn, "SELECT * FROM cart WHERE user_id='$user_id'") or die('query failed');
    if (mysqli_num_rows($cart_query) > 0) {
        while ($cart_item = mysqli_fetch_assoc($cart_query)) {
            $cart_product[] = $cart_item['name'] . '(' . $cart_item['quantity'] . ')';
            $sub_total = ($cart_item['price'] * $cart_item['quantity']);
            $cart_total += $sub_total;
        }
    }
    $total_products = implode(',', $cart_product);
    mysqli_query($conn, "INSERT INTO orders (user_id, name, email, method, number, address, total_products, total_price, placed_on) 
                         VALUES ('$user_id', '$name', '$email', '$method', '$number', '$address', '$total_products', '$cart_total', '$placed_on')");
    mysqli_query($conn, "DELETE FROM cart WHERE user_id='$user_id'");
    header('location:checkout.php');
    exit();
}
?>

<!DOCTYPE html>
<html lang="sq">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.9.1/font/bootstrap-icons.css">
    <link rel="stylesheet" href="main.css">
    <title>Veggen - Checkout</title>
</head>
<body>
    <?php include 'header.php'; ?>
    <div class="banner">
        <div class="detail">
            <h1>Order</h1>
        </div>
    </div>
    <div class="line"></div>
    <div class="checkout-form">
        <h1 class="title">Payment Process</h1>
        <div class="display-order">
            <div class="box_container">
                <?php
                $select_cart = mysqli_query($conn, "SELECT * FROM cart WHERE user_id='$user_id'") or die('query failed');
                $total = 0;
                $grand_total = 0;
                if (mysqli_num_rows($select_cart) > 0) {
                    while ($fetch_cart = mysqli_fetch_assoc($select_cart)) {
                        $total_price = ($fetch_cart['price'] * $fetch_cart['quantity']);
                        $grand_total = $total += $total_price;
                ?>
                        <div class="box">
                            <img src="image/<?php echo $fetch_cart['image']; ?>" class="product-image">
                            <span><?= $fetch_cart['name']; ?>(<?= $fetch_cart['quantity']; ?>)</span>
                        </div>
                <?php
                    }
                }
                ?>
            </div>
            <span class="grand_total">Total Amount Payable: $<?= $grand_total; ?></span>
        </div>
        <form method="post">
            <div class="input-field">
                <label>Your Name</label>
                <input type="text" name="name" placeholder="Enter your name" required>
            </div>
            <div class="input-field">
                <label>Your Number</label>
                <input type="text" name="number" placeholder="Enter your number" required>
            </div>
            <div class="input-field">
                <label>Your Email</label>
                <input type="email" name="email" placeholder="Enter your email" required>
            </div>
            <div class="input-field">
                <label>Select Payment Method</label>
                <select name="method" required>
                    <option value="" selected disabled>Select payment method</option>
                    <option value="cash on delivery">Cash on Delivery</option>
                    <option value="credit card">Credit Card</option>
                </select>
            </div>
            <div class="input-field">
                <label>City</label>
                <input type="text" name="address" placeholder="Enter your address" required>
            </div>
            <input type="submit" name="order-btn" value="Order Now">
        </form>
    </div>
    <?php include 'footer.php'; ?>
    <script type="text/javascript">
      document.addEventListener('DOMContentLoaded', function () {
    const images = document.querySelectorAll('.product-image');
    images.forEach(image => {
        image.style.width = '120px'; // Vendosni gjerësinë e dëshiruar
        image.style.height = '120px'; // Vendosni lartësinë e dëshiruar
        image.style.borderRadius = '10%'; // Ruaj formën e rrumbullakët
        image.style.objectFit = 'cover'; // Sigurohuni që fotot të mos shtrembërohen
    });
});
    </script>
</body>
</html>