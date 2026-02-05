<?php
    include 'connection.php';
    session_start();
    $user_id = $_SESSION['user_id'];
    if(!isset($user_id)) {
        header('location:login.php');
        exit();
    }

    if (isset($_POST['logout'])) {
        session_destroy();
        header('location: login.php');
        exit();
    }

    // Updating quantity
    if (isset($_POST['update_qty_btn'])) {
        $update_qty_id = $_POST['update_qty_id'];
        $update_value = $_POST['update_qty'];

        $update_query = mysqli_query($conn, "UPDATE cart SET quantity='$update_value' WHERE id='$update_qty_id'") or die('query failed');
        if ($update_query) {
            header('location:cart.php');
            exit();
        }
    }

    // Delete product from cart
    if (isset($_GET['delete'])) {
        $delete_id = $_GET['delete'];
        mysqli_query($conn, "DELETE FROM cart WHERE id = '$delete_id'") or die('query failed');
        header('location:cart.php?message=product+deleted');
        exit();
    }

    // Delete all products from cart
    if (isset($_GET['delete_all'])) {
        mysqli_query($conn, "DELETE FROM cart WHERE user_id='$user_id'") or die('query failed');
        header('location:cart.php');
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
    <link rel="stylesheet" href="main.css">
    <title>Veggen - Home Page</title>
</head>
<body>
     <?php include 'header.php';?>

     <div class="banner">
        <div class="detail">
            <h1>My Shopping Cart</h1>
        </div>
     </div>

     <div class="line"></div> 

     <section class="shop">
         <h1 class="title">Products Added to the Shopping Cart</h1>
         <div class="box-container">
              <?php
               $grand_total = 0;
               $select_cart = mysqli_query($conn, "SELECT * FROM cart WHERE user_id = '$user_id'") or die('query failed');
               if (mysqli_num_rows($select_cart) > 0) {
                   while ($fetch_cart = mysqli_fetch_assoc($select_cart)) {
              ?>
              <div class="box">
                  <div class="icon">
                      <a href="cart.php?delete=<?php echo $fetch_cart['id']; ?>" class="bi bi-x" onclick="return confirm('Do you want to delete this product from your cart?')"></a>
                  </div>
                  <img src="image/<?php echo $fetch_cart['image']; ?>" alt="<?php echo $fetch_cart['name']; ?>">
                  <div class="price">$<?php echo $fetch_cart['price']; ?>/-</div>
                  <div class="name"><?php echo $fetch_cart['name']; ?></div>
                  <form method="post">
                      <input type="hidden" name="update_qty_id" value="<?php echo $fetch_cart['id']; ?>">
                      <div class="qty">
                          <input type="number" min="1" name="update_qty" value="<?php echo $fetch_cart['quantity']; ?>">
                          <input type="submit" name="update_qty_btn" value="Update">
                      </div>
                  </form>
                  <div class="total-amt">
                      Total amount: <span>$<?php echo $total_amt = ($fetch_cart['price'] * $fetch_cart['quantity']); ?></span>
                  </div>
              </div>
              <?php
              $grand_total += $total_amt;
                   }
               } else {
                   echo '<p class="empty">There are no products in your shopping cart!</p>';
               }
              ?>
         </div>

         <div class="dlt">
            <a href="cart.php?delete_all" class="btn2" onclick="return confirm('Do you want to delete all items from your cart?')">Delete All</a>
         </div>

         <div class="wishlist_total">
            <p>Total amount to pay: <span>$<?php echo $grand_total; ?>/-</span></p>
            <a href="shop.php" class="btn">Continue Shopping</a>
            <a href="checkout.php" class="btn <?php echo ($grand_total > 1) ? '' : 'disable'; ?>" onclick="return confirm('Do you want to proceed to checkout?')">Complete Purchase</a>
         </div>
     </section>

     <?php include 'footer.php';?>
     <script type="text/javascript" src="script.js"></script>
</body>
</html>
