<?php
    include 'connection.php';
    session_start();
    $user_id = $_SESSION['user_id'];
    if(!isset($user_id))  {
        header('location:login.php');
    }
    if (isset($_POST['logout'])) {
        session_destroy();
        header('location: login.php');
    }
if (isset($_POST['submit-btn'])) {
    $name = mysqli_real_escape_string($conn, $_POST['name']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $number = mysqli_real_escape_string($conn, $_POST['number']);
    $message = mysqli_real_escape_string($conn, $_POST['message']);

    // Kontrollo nëse mesazhi është dërguar më parë
    $select_message = mysqli_query($conn, "SELECT * FROM message WHERE name = '$name' AND email = '$email' AND number = '$number' AND message = '$message'") or die('Query failed');
    
    // Nëse mesazhi nuk ekziston, atëherë shto në databazë
    if (mysqli_num_rows($select_message) == 0) {
        mysqli_query($conn, "INSERT INTO message (user_id, name, email, number, message) VALUES ('$user_id', '$name', '$email', '$number', '$message')") or die('Query failed');
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.9.1/font/bootstrap-icons.css">
    <link rel="stylesheet" href="main.css">
    <title>Veggen - Home Page</title>
</head>
<body>
    <?php include 'header.php'; ?>
    <div class="banner">
        <div class="detail">
            <h1>CONTACT US</h1>
        </div>
    </div>
    <div class="services">
        <div class="row">
            <div class="box">
                <img src="img/0.png">
                <div>
                    <h1>Free and Fast Shipping</h1>
                    <p>We offer free shipping on all orders and ensure that they reach you as quickly as possible. Your products will arrive on time with no additional shipping cost.</p>
                </div>
            </div>
            <div class="box">
                <img src="img/1.png">
                <div>
                    <h1>Money-Back Guarantee</h1>
                    <p>We offer a money-back guarantee, so you can shop risk-free. If you're not satisfied with the product, you can return it and get a full refund.</p>
                </div>
            </div>
            <div class="box">
                <img src="img/2.png">
                <div>
                    <h1>24/7 Online Support</h1>
                    <p>Our support service is available 24 hours a day, 7 days a week. We're always here to help with any questions or issues you may have.</p>
                </div>
            </div>
        </div>
    </div>
    <div class="line4"></div>
    <div class="form-container">
        <h1 class="title">Leave a Message</h1>
        <form method="post">
            <div class="input-field">
                <label>Your Name</label><br>
                <input type="text" name="name">
            </div>
            <div class="input-field">
                <label>Your Email</label><br>
                <input type="text" name="email">
            </div>
            <div class="input-field">
                <label>Your Number</label><br>
                <input type="number" name="number">
            </div>
            <div class="input-field">
                <label>Your Message</label><br>
                <textarea name="message"></textarea>
            </div>
            <button type="submit" name="submit-btn">Send Message</button>
        </form>
    </div>
    <div class="line"></div>
    <div class="line2"></div>
    <div class="address">
        <h1 class="title">Our Contacts</h1>
        <div class="row">
            <div class="box">
                <i class="bi bi-map-fill"></i>
                <div>
                    <h4>Address</h4>
                    <p>Shkodër and Tirana, Albania</p>
                </div>
            </div>
            <div class="box">
                <i class="bi bi-telephone-fill"></i>
                <div>
                    <h4>Phone Number</h4>
                    <p>099756789</p>
                </div>
            </div>
            <div class="box">
                <i class="bi bi-envelope-fill"></i>
                <div>
                    <h4>Email</h4>
                    <p>contact@veggen.al</p>
                </div>
            </div>
        </div>
    </div>
    <div class="line3"></div>
    <?php include 'footer.php'; ?>
    <script type="text/javascript" src="script.js"></script>
</body>
</html>
