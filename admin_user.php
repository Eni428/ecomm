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

   //delete user database
   if (isset($_GET['delete'])) {
      $delete_id = $_GET['delete'];
   
      mysqli_query($conn, "DELETE FROM users WHERE id = '$delete_id'") or die('query failed');
      $message[]='user removed successfuly.';

      header('location:admin_user.php');
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
   <div class="line4"></div>
  <section class="message-container">
    <h1 class="title">TOTAL USER ACCOUNT</h1>
    <div class="box-container">
      <?php 
     $select_users = mysqli_query($conn, "SELECT * FROM users") or die('query failed');
      if (mysqli_num_rows($select_users)> 0 ) {
          while ($fetch_users=mysqli_fetch_assoc($select_users)) {
           
           ?>
        <div class="box">
          <p>user id:<span><?php echo $fetch_users['id']?></span></p>
          <p>name:<span><?php echo $fetch_users['name']?></span></p>
          <p>email:<span><?php echo $fetch_users['email']?></span></p>
          <p>user type: 
    <span style="color: <?php echo ($fetch_users['user_type'] == 'admin') ? 'orange' : 'black'; ?>">
        <?php echo $fetch_users['user_type']; ?>
    </span>
</p>
           <?php echo $fetch_users['user_type'];?></span></p>
           <a href="admin_user.php?delete= <?php echo $fetch_users['id'];?>" onclick="return confirm('delete this user');">delete</a>
        </div>
        <?php
             }
            }else{
              echo '
              <div class="empty">
              <p>no users added yet ! </p>
              </div>
              ';
         }  
         
         ?>  
    </div>
  </section>
   <script type="text/javascript" src="script.js"></script>
</body>
</html>