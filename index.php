<?php
include 'connection.php';
session_start();

if (!isset($_SESSION['user_id'])) {
    header('location:login.php');
    exit();
}

$user_id = $_SESSION['user_id'];

if (isset($_POST['logout'])) {
    session_destroy();
    header('location:login.php');
    exit();
}
?>

<!DOCTYPE html> 
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.9.1/font/bootstrap-icons.css">
    <link rel="stylesheet" type="text/css" href="slick.css">
    <link rel="stylesheet" href="main.css">
    <title>Veggen - Home Page</title>
</head>

<body>
    <?php include 'header.php';?>

   <div class="container-fluid">
    <div class="hero-slider">
        <div class="slider-item">
            <img src="img/slider2.png" alt="...">
            <div class="slider-caption">
            <h1> Veggen Honey – Premium Quality from Nature</h1>
             <p>Welcome to Veggan Honey, the sweetest gift from nature!</p>
            </div>
        </div>
        <div class="slider-item">
            <img src="img/slider.jpg" alt="...">
            <div class="slider-caption">
            <h1>Veggen Honey – Premium Quality from Nature</h1>
            <p>Enjoy sweet and aromatic honey, crafted with care using eco-friendly raw materials in the purest environment!</p>
            </div>
        </div>
    </div>
    <div class="controls">
        <i class="bi bi-chevron-left prev"></i>
        <i class="bi bi-chevron-right next"></i>  
    </div>
</div>
<div class="services">
    <div class="row">
        <div class="box">
            <img src="img/0.png">
            <div>
                <h1>Free & Fast Shipping</h1>
                <p>Enjoy free and fast shipping, ensuring your order arrives on time and safely, wherever you are.</p>
            </div>
        </div>
        <div class="box">
            <img src="img/1.png">
            <div>
                <h1>Money-Back Guarantee</h1>
                <p>We offer a secure money-back guarantee. If you're not satisfied, we'll refund your money without any hassle.</p>
            </div>
        </div>
        <div class="box">
            <img src="img/2.png">
            <div>
                <h1>24/7 Online Support</h1>
                <p>24/7 online support to assist you at any time. Our team is here to help with any questions or concerns you may have.</p>
            </div>
        </div>
    </div>
</div>
<div class="line2"></div>
<div class="story">
    <div class="row">
        <div class="box">
            <span>Our Story</span>
            <h1>Producing Natural Honey Since 1990</h1>
            <p>A passionate and dedicated history of producing natural honey. We pay attention to every detail to offer you a pure and healthy product straight from nature.</p>
            <a href="about.php" class="btn">about us</a>
        </div>
        <div class="box">
            <img src="img/8.png">
        </div>
    </div>
</div>
<div class="line3"></div>

<div class="line2"></div>
<div class="discover">
    <div class="detail">
        <h1 class="title">Organic Honey</h1>
        <p>Enjoy the health benefits of organic honey, carefully crafted with love from nature to bring a healthy and delicious product to your table.</p>
        <a href="shop.php" class="btn">shop now</a>
    </div>
        <div class="img-box">
            <img src="img/13.png">
        </div>
    </div>
    <?php include 'footer.php';?>
    <script src="jquery.js"></script>
    <script src="slick.js"></script>

    <script type="text/javascript">
        <?php include 'script2.js' ?>
    </script>
</body>

</html>
