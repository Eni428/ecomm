<?php
    include 'connection.php';
    session_start();
    $user_id = $_SESSION['user_id'];
    if(!isset($user_id))  {
        header('location:login.php');
    }
    if (isset($_POST['logout'])) {
        session_destroy();
        header('location:login.php');
    }
?>

<!DOCTYPE html> 
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!------------bootstrap icon link------->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.9.1/font/bootstrap-icons.css">
    <link rel="stylesheet" href="main.css">
    <title>Veggen - Home Page</title>
</head>

<body>
     <?php include 'header.php';?>
     <div class="banner">
        <div class="detail">
            <h1>ABOUT OUR COMPANY</h1>
            <p>Welcome to Veggen Honey Company!</p>
        </div>
     </div>
     <!------------about us------->
     <div class="line2"></div>
     <div class="about-us">
        <div class="row">
            <div class="box">
                <p>Veggen is a company dedicated to producing and trading natural, high-quality honey. With an unwavering commitment to sustainable beekeeping, we ensure pure and healthy products gathered from the cleanest natural areas.</p>
                <p>Our team consists of experienced beekeepers and experts who are passionate about nature and quality. Every process, from caring for the hives to processing and packaging, is carried out with the utmost care to ensure the authenticity and nutritional value of the honey. Thanks to our dedicated work, we bring to your table a pure, safe product with a unique taste that reflects the richness of nature.</p>
            </div>
            <div class="img-box">
                <img src="img/staff.jpg" alt="Veggen Staff">
            </div>
        </div>
     </div>
     <!------------features------->
     <div class="line4"></div>
     <div class="features">
        <div class="title">
            <span>OUR BEST FEATURES</span>
        </div>
        <div class="row">
            <div class="box">
                <img src="img/icon2.png" alt="24/7 Support">
                <h4>24 x 7</h4>
                <p>Online support available at all times to ensure your needs are met at any moment. Our team is here to help you with any question or issue, day or night.</p>
            </div>
            <div class="box">
                <img src="img/icon1.png" alt="Money Back Guarantee">
                <h4>Money Back Guarantee</h4>
                <p>We offer a secure money-back guarantee, ensuring that your purchase is completely risk-free. If you're not satisfied, we'll refund your money with no issues.</p>
            </div>
            <div class="box">
                <img src="img/icon0.png" alt="Special Gift Cards">
                <h4>Special Gift Cards</h4>
                <p>Give the perfect gift for any occasion! Our gift cards are the ideal choice for friends and family, allowing them to choose and enjoy exactly what they want.</p>
            </div>
            <div class="box">
                <img src="img/icon.png" alt="International Shipping">
                <h4>International Shipping</h4>
                <p>Enjoy global shipping for orders over $100. No matter where you are, we'll ensure your order arrives safely and on time, bringing our products to your doorstep.</p>
            </div>
        </div>
     </div>

     <div class="line"></div>

     <?php include 'footer.php';?>
         <script type="text/javascript" src="script.js"></script>
</body>

</html>
