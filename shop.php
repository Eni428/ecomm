<?php
    include 'connection.php';
    session_start();
    $user_id = $_SESSION['user_id'];
    if(!isset($user_id)) {
        header('location:login.php');
    }
    if (isset($_POST['logout'])) {
        session_destroy();
        header('location: login.php');
    }
    
    // Adding products to wishlist
    if (isset($_POST['add_to_wishlist'])) {
        $product_id = $_POST['product_id'];
        $product_name = $_POST['product_name'];
        $product_price = $_POST['product_price'];
        $product_image = $_POST['product_image'];
        // Check if product is already in wishlist
        $wishlist_check = mysqli_query($conn, "SELECT * FROM wishlist WHERE pid = '$product_id' AND user_id = '$user_id'") or die('Query failed');
        if (mysqli_num_rows($wishlist_check) > 0) {
            $message[] = 'Product already exists in wishlist';
        } else {
            mysqli_query($conn, "INSERT INTO wishlist(user_id, pid, name, price, image) VALUES('$user_id', '$product_id', '$product_name', '$product_price', '$product_image')");
            $message[] = 'Product successfully added to your wishlist';
        }
    }

    // Adding products to cart
    if (isset($_POST['add_to_cart'])) {
        $product_id = $_POST['product_id'];
        $product_name = $_POST['product_name'];
        $product_price = $_POST['product_price'];
        $product_image = $_POST['product_image'];
        $product_quantity = $_POST['product_quantity'];
        // Check if product is already in cart
        $cart_check = mysqli_query($conn, "SELECT * FROM cart WHERE pid = '$product_id' AND user_id = '$user_id'") or die('Query failed');
        
        if (mysqli_num_rows($cart_check) > 0) {
            $message[] = 'Product already exists in cart';
        } else {
            mysqli_query($conn, "INSERT INTO cart(user_id, pid, name, price, quantity, image) VALUES('$user_id', '$product_id', '$product_name', '$product_price', '$product_quantity', '$product_image')");
            $message[] = 'Product successfully added to your cart';
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
        <h1>OUR PRODUCTS</h1>
        <p>Enjoy the richness and health benefits of honey with the highest industry standards.</p>
    </div>
  </div>
  <div class="line"></div>
  <section class="shop">
    <h1 class="title">OUR BESTSELLING PRODUCTS</h1>
  </section>
     <?php
   if (isset($message)) {
      foreach ($message as $message) {
         echo '
         <div class="message">
         <span>'.$message.'</span>
         <i class="bi bi-x-circle" onclick="this.parentElement.remove()"></i>
         </div>

         ';
         
      }
      
   }
?>
  <div class="box-container">
    <?php // Merr të gjithë produktet nga databaza
    $select_products = mysqli_query($conn, "SELECT * FROM products") or die('Query failed');
    if (mysqli_num_rows($select_products) > 0) {
        while ($fetch_products = mysqli_fetch_assoc($select_products)) {//Të dhënat kthehen si array
    ?>
            <form method="post" class="box">
                <img src="image/<?php echo $fetch_products['image']; ?>" alt="Product Image">
                <div class="price">$<?php echo $fetch_products['price']; ?>/-</div>
                <div class="name"><?php echo $fetch_products['name']; ?></div>
                <input type="hidden" name="product_id" value="<?php echo $fetch_products['id']; ?>">
                <input type="hidden" name="product_name" value="<?php echo $fetch_products['name']; ?>">
                <input type="hidden" name="product_price" value="<?php echo $fetch_products['price']; ?>">
                <input type="number" name="product_quantity" value="1" min="1">
                <input type="hidden" name="product_image" value="<?php echo $fetch_products['image']; ?>">
                <div class="icon">
                    <a href="view_page.php?pid=<?php echo $fetch_products['id']; ?>" class="bi bi-eye-fill"></a>
                    <button type="submit" name="add_to_wishlist" class="bi bi-heart"></button>
                    <button type="submit" name="add_to_cart" class="bi bi-cart"></button>
                </div>
            </form>
    <?php
        }
    } else {
        echo '<p class="empty">No products yet!</p>';
    }
    ?>

  </div>
</section>

<?php include 'footer.php'; ?>
<script type="text/javascript" src="script.js"></script>
</body>
</html>
