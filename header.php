<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- Box icons link -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.9.1/font/bootstrap-icons.css">
    <title>User Header</title>
</head>
<body>
  <header class="header">
    <div class="flex">
        <a href="index.php" class="logo"><img src="img/logo.png" alt="Logo"></a>
        <nav class="navbar">
            <a href="index.php">Home</a>
            <a href="about.php">About Us</a>
            <a href="shop.php">Shop</a>
            <a href="order.php">Orders</a>
            <a href="contact.php">Contact</a>
        </nav>
        <div class="icons">
            <i class="bi bi-person" id="user-btn"></i>
            <?php   //afishimin e numrit 
                $select_wishlist = mysqli_query($conn, "SELECT * FROM wishlist WHERE user_id='$user_id'") or die('Query failed');
                $wishlist_num_rows = mysqli_num_rows($select_wishlist);
            ?>
            <a href="wishlist.php"><i class="bi bi-heart"></i><sup><?php echo $wishlist_num_rows; ?></sup></a>
            <?php
                $select_cart= mysqli_query($conn, "SELECT * FROM cart WHERE user_id='$user_id'") or die('Query failed');
                $cart_num_rows = mysqli_num_rows($select_cart);
            ?>
            <a href="cart.php"><i class="bi bi-cart"></i><sup><?php echo $cart_num_rows; ?></sup></a>
            <i class="bi bi-list" id="menu-btn"></i>
        </div>
        <div class="user-box">
            <p>User: <span><?php echo $_SESSION['user_name']; ?></span></p>
            <p>Email: <span><?php echo $_SESSION['user_email']; ?></span></p>
           <form method="post">
            <button type="submit" name="logout" class="logout-btn">Log out</button>
           </form>

           <?php
           if(isset($_POST['logout'])) {
               session_destroy();
               header('Location: register.php');
               exit();
           }
           ?>
        </div>  
    </div>
  </header>

</body>
</html>
