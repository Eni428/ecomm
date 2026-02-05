<?php
include 'connection.php';
session_start();

if (!isset($_SESSION['user_id'])) {
    header('location: login.php');
    exit();
}

$user_id = $_SESSION['user_id'];

if (isset($_POST['logout'])) {
    session_destroy();
    header('location: login.php');
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css">
    <link rel="stylesheet" href="main.css">
    <title>Veggen - My Orders</title>
</head>
<body>
    <?php include 'header.php'; ?>
    
    <div class="banner">
        <div class="detail">
            <h1>MY ORDERS</h1>
        </div>
    </div>

    <div class="line"></div> 

    <div class="order-section">
        <div class="box-container">
            <?php  //shfaq orders
            $select_orders = mysqli_query($conn, "SELECT * FROM orders WHERE user_id = '$user_id'") or die('Query failed');

            if (mysqli_num_rows($select_orders) > 0) {
                while ($fetch_orders = mysqli_fetch_assoc($select_orders)) {
            ?>
            <div class="box">
                <p>Date: <span><?php echo htmlspecialchars($fetch_orders['placed_on']); ?></span></p>
                <p>Name: <span><?php echo htmlspecialchars($fetch_orders['name']); ?></span></p>
                <p>Phone Number: <span><?php echo htmlspecialchars($fetch_orders['number']); ?></span></p>
                <p>Email: <span><?php echo htmlspecialchars($fetch_orders['email']); ?></span></p>
                <p>Address: <span><?php echo htmlspecialchars($fetch_orders['address']); ?></span></p>
                <p>Payment Method: <span><?php echo htmlspecialchars($fetch_orders['method']); ?></span></p>
                <p>Order Details: <span><?php echo htmlspecialchars($fetch_orders['total_products']); ?></span></p>
                <p>Total Price: <span>$<?php echo htmlspecialchars($fetch_orders['total_price']); ?></span></p>
                <p>Payment Status: <span><?php echo htmlspecialchars($fetch_orders['payment_status']); ?></span></p>
            </div>
            <?php
                }
            } else {
                echo '
                <div class="empty">
                    <p>No orders placed yet!</p>
                </div>';
            }
            ?>
        </div>
    </div>

    <?php include 'footer.php'; ?>
    <script type="text/javascript" src="script.js"></script>
</body>
</html>
