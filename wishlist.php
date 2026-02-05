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

    // Adding products to cart
    if (isset($_POST['add_to_cart'])) {
        $product_id = $_POST['product_id'];
        $product_name = $_POST['product_name'];
        $product_price = $_POST['product_price'];
        $product_image = $_POST['product_image'];
        $product_quantity = 1;
         // Kontrollo nëse produkti është tashmë në karrocë
        $cart_num = mysqli_query($conn, "SELECT * FROM cart WHERE name = '$product_name' AND user_id = '$user_id'") or die ('query failed');
        if (mysqli_num_rows($cart_num) > 0) {
            $message[] = 'Product already exists in cart';
        } else {
            // Nëse produkti nuk është në karrocë, shtohet në të
            mysqli_query($conn, "INSERT INTO cart(user_id, pid, name, price, quantity, image) VALUES('$user_id', '$product_id', '$product_name', '$product_price', '$product_quantity', '$product_image')");
            $message[] = 'Product successfully added to your cart';
        }
    }

    // Delete product from wishlist
    if (isset($_GET['delete'])) {
        $delete_id = $_GET['delete'];
        mysqli_query($conn, "DELETE FROM wishlist WHERE id = '$delete_id'") or die('query failed');
        header('location:wishlist.php?message=product+deleted');
    }

    // Delete all products from wishlist
    if (isset($_GET['delete_all'])) {
        mysqli_query($conn, "DELETE FROM wishlist WHERE user_id='$user_id'") or die('query failed');
        header('location:wishlist.php');
    }
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdeliver.net/npm/bootstrap-icons@1.9.1/font/bootstrap-icons.css">
    <link rel="stylesheet" href="main.css">
    <title>Veggen - Home Page</title>
</head>
<body>
     <?php include 'header.php';?>
     <div class="banner">
        <div class="detail">
            <h1>My Wishlist</h1>
        </div>
    </div>
    <div class="line"></div> 

    <section class="shop">
        <h1 class="title">Products Added to Wishlist</h1>

        <?php
        if (isset($message)){
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
            <?php
                $grand_total = 0;
                $select_wishlist = mysqli_query($conn, "SELECT * FROM wishlist") or die('query failed');
                if(mysqli_num_rows($select_wishlist) > 0) {
                      // Shfaq produktet në wishlist
                    while($fetch_wishlist = mysqli_fetch_assoc($select_wishlist)){
            ?>
            <form method="post" class="box">
                <img src="image/<?php echo $fetch_wishlist['image']; ?>" alt="<?php echo $fetch_wishlist['name']; ?>">
                <div class="price">$<?php echo $fetch_wishlist['price']; ?>/-</div>
                <div class="name"><?php echo $fetch_wishlist['name']; ?></div>

                <!-- Hidden Inputs for Product Details -->
                <input type="hidden" name="product_id" value="<?php echo $fetch_wishlist['id']; ?>">
                <input type="hidden" name="product_name" value="<?php echo $fetch_wishlist['name']; ?>">
                <input type="hidden" name="product_price" value="<?php echo $fetch_wishlist['price']; ?>">
                <input type="hidden" name="product_image" value="<?php echo $fetch_wishlist['image']; ?>">

                <div class="icon">
                    <a href="wishlist.php?delete=<?php echo $fetch_wishlist['id']; ?>" class="bi bi-x"  onclick="return confirm('Do you want to delete this product from your wishlist?')"></a>
                    <button type="submit" name="add_to_cart" class="bi bi-cart" title="Add to Cart"></button>
                </div>
            </form>
            <?php
                $grand_total += (float)$fetch_wishlist['price'];
                }
            } else {
                echo '<p class="empty">No products yet!</p>';
            }
            ?>
        </div>
        <div class="wishlist_total">
            <p>Total Amount: <span>$<?php echo $grand_total;?>/-</span></p>
            <a href="shop.php" class="btn">Continue Shopping</a>
            <a href="wishlist.php?delete_all" class="btn" <?php echo ($grand_total > 0) ? '' : 'style="pointer-events: none; opacity: 0.5;"'; ?> onclick="return confirm('Do you want to delete all items in your wishlist?')">Delete All</a>
        </div>
    </section>

    <?php include 'footer.php';?>
    <script type="text/javascript" src="script.js"></script>
</body>

</html>
