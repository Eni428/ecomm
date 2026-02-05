<?php
include 'connection.php';
session_start();
$admin_id = $_SESSION['admin_name'];

if (!isset($admin_id)) {
   header('location:login.php');
}

if(isset($_POST['logout'])) {
   session_destroy();
   header('location:login.php');
}
//adding products to database
if (isset($_POST['add_product'])) {
   $product_name = mysqli_real_escape_string($conn, $_POST['name']);
   $product_price = mysqli_real_escape_string($conn, $_POST['price']);
   $product_detail = mysqli_real_escape_string($conn, $_POST['detail']);
   $image = $_FILES['image']['name'];
   $image_size = $_FILES['image']['size'];
   $image_tmp_name = $_FILES['image']['tmp_name'];
   $image_folder = 'image/'.$image;

//kontrollon nese emri i produktit ekziston ne databse
   $select_product_name = mysqli_query($conn, "SELECT name FROM products WHERE name = '$product_name'") or die('query failed');
   if (mysqli_num_rows($select_product_name)>0){
      $message[] = 'product name already exist';
   }else{
      $insert_product = mysqli_query($conn, "INSERT INTO products (name, price, product_detail, image) VALUES  ('$product_name','$product_price','$product_detail','$image')") or die('query failed');//shton produktin
      if ($insert_product) {
         if ($image_size > 2000000) {//kontrollon madhesine e skedarit
            $message[] = 'image size is too large';
         }else{
            move_uploaded_file($image_tmp_name, $image_folder);
            $message[] = 'product added succesfully';//vendos imazhin ne folder image/
         }
      }
   }
}

   //delete products from database
   if (isset($_GET['delete'])) {
      $delete_id = $_GET['delete'];
      $select_delete_image = mysqli_query($conn, "SELECT image FROM products WHERE id = '$delete_id'") or die('query failed');
     $fetch_delete_image = mysqli_fetch_assoc($select_delete_image);  // Merr imazhin e produktit që do të fshihet
     unlink('image/'.$fetch_delete_image['image']);  // Fshin imazhin nga dosja lokale

      mysqli_query($conn, "DELETE FROM products WHERE id = '$delete_id'") or die('query failed');
      mysqli_query($conn, "DELETE FROM cart WHERE pid = '$delete_id'") or die('query failed');
      mysqli_query($conn, "DELETE FROM wishlist WHERE pid = '$delete_id'") or die('query failed');

      header('location:admin_product.php');
   }

//update product
if (isset($_POST['update_product'])) {
    $update_id = $_POST['update_id'];
    $update_name = mysqli_real_escape_string($conn, $_POST['update_name']);
    $update_price = mysqli_real_escape_string($conn, $_POST['update_price']);
    $update_detail = mysqli_real_escape_string($conn, $_POST['update_detail']);

    // Marrim imazhin e ri nëse është i ngarkuar
    $update_image = $_FILES['update_image']['name'];
    $update_image_tmp_name = $_FILES['update_image']['tmp_name'];
    $update_image_folder = 'image/' . $update_image;

    // Marrim imazhin aktual nga databaza
    $select_old_image = mysqli_query($conn, "SELECT image FROM products WHERE id = '$update_id'");
    $fetch_old_image = mysqli_fetch_assoc($select_old_image);
    $old_image = $fetch_old_image['image'];

    // Nëse nuk është zgjedhur imazh i ri, ruaj imazhin ekzistues
    if (empty($update_image)) {
        $update_image = $old_image;
    }

    // Përditëso të dhënat
    $update_query = mysqli_query($conn, "UPDATE `products` SET `name` = '$update_name', `price` = '$update_price', `product_detail` = '$update_detail', `image` = '$update_image' WHERE `id` = '$update_id'") or die('query failed');

    if ($update_query) {
        // Nëse është zgjedhur një imazh i ri, fshi imazhin e vjetër dhe ngarko të riun
        if (!empty($_FILES['update_image']['name'])) {
            unlink('image/' . $old_image); // Fshin imazhin e vjetër
            move_uploaded_file($update_image_tmp_name, $update_image_folder);
        }
        header('location:admin_product.php');
    }
}


?>
<!DOCTYPE html>
<html lang="sq">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
     <!--box icone link-->
    <link rel="" =https://cdn.jsdelivr.net/npm/bootstrap-icons@1.9.1/font/bootstrapt-icons.css>
    <link rel="stylesheet" type="text/css" href="style.css">
    <title>admin pannel</title>
</head>
<body>
   <?php include 'admin_header.php'; ?>
   <div class="line2"></div>
   <section class="add-products form-container">
      <form method="POST" action="" enctype="multipart/form-data"><!-- imazhin-->
         <div class="input-field">
            <label>product name</label>
            <input type="text" name="name" required>
         </div>
         <div class="input-field">
            <label>product price</label>
            <input type="text" name="price" required>
         </div>
         <div class="input-field">
            <label>product detail</label>
            <textarea name="detail" required></textarea>
         </div>
         <div class="input-field">
            <label>product image</label>
            <input type="file" name="image" accept="image/jpg, image/jpeg, image/png, image/webp"  required>
         </div>
         <input type="submit" name="add_product" value="add product" class="btn">
      </form>
   </section>
   <div class="line3"></div>
   <div class="line4"></div>
   <section class="show-products">
      <div class="box-container">
         <?php
         $select_products = mysqli_query($conn, "SELECT * FROM products") or die('query failed');
         if (mysqli_num_rows($select_products)>0) {
            while ($fetch_products = mysqli_fetch_assoc($select_products)) {
               ?>
               <div class="box">
                  <img src="image/<?php echo $fetch_products['image']; ?>">
                  <p>Price : $<?php echo $fetch_products['price']; ?> </p>
                  <h4><?php echo $fetch_products['name']; ?> </h4>
                  <details><?php echo $fetch_products['product_detail']; ?></details>
                  <a href="admin_product.php?edit=<?php echo $fetch_products['id']; ?>" class="edit">edit</a>
                  <a href="admin_product.php?delete=<?php echo $fetch_products['id']; ?>" class="delete" onclick="return confirm('Want to delete this product');">delete</a>
               </div>
               <?php
            }
         }else{
            echo ' 
            <div class="empty">
            <p> no products added yet!</p>
            </div>
            ';
         }
         ?>
      </div>
   </section>
   <!--edit page -->
   <div class="line"></div>
   <section class="update-container">
      <?php
      if (isset($_GET['edit'])) {
          $edit_id = $_GET['edit'];
          $edit_query = mysqli_query($conn, "SELECT * FROM products WHERE id = '$edit_id'") or die('query failed');
          if (mysqli_num_rows($edit_query)>0) {
            while ($fetch_edit = mysqli_fetch_assoc($edit_query)){
            ?>
         <form method="POST" enctype="multipart/form-data">
            <img src="image/<?php echo $fetch_edit['image']; ?>">
            <input type="hidden" name="update_id" value="<?php echo $fetch_edit['id']; ?>">
            <input type="text" name="update_name" value="<?php echo $fetch_edit['name']; ?>">
            <input type="number" name="update_price" min="0" value="<?php echo $fetch_edit['price']; ?>">
            <textarea name="update_detail"><?php echo $fetch_edit['product_detail']; ?></textarea>
            <input type="file" name="update_image" accept="image/jpg, image/jpeg, image/png, image/webp"> 
            <input type="submit" name="update_product" value="update" class="edit">
            <input type="reset" name="" value="cancle" class="option-btn btn" id="close-form">
         </form>
         <?php 

            }
          }
          echo "<script>document.querySelector('.update-container').style.display='block'</script>";// forma e përditësimit (update-container) do te shfaqet automatikisht kur një admin klikon për të edituar një produkt
      }
      ?>
   </section>
   <script type="text/javascript" src="script.js"></script>
</body>
</html>