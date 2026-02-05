<?php
include 'connection.php';
session_start();

if (isset($_POST['submit-btn'])) {

    $filter_email = filter_var($_POST['email'], FILTER_SANITIZE_STRING);
    $email = mysqli_real_escape_string($conn, $filter_email);

    $filter_password = filter_var($_POST['password'], FILTER_SANITIZE_STRING);
    $password = mysqli_real_escape_string($conn, $filter_password);

    // Kontrollo nëse emaili ekziston në databazë
    $select_user = mysqli_query($conn, "SELECT * FROM users WHERE email = '$email'") or die('query failed');

    if (mysqli_num_rows($select_user) > 0) {
        $row = mysqli_fetch_assoc($select_user);

        // Kontrollo nëse passwordi është i saktë dhe nese po , vendos a eshte admin apo user
        if ($row['password'] === $password) { 
            if ($row['user_type'] == 'admin') {
                $_SESSION['admin_name'] = $row['name'];
                $_SESSION['admin_email'] = $row['email'];
                $_SESSION['admin_id'] = $row['id'];
                header('location:admin_pannel.php');
                exit();
            } else if ($row['user_type'] == 'user') {
                $_SESSION['user_name'] = $row['name'];
                $_SESSION['user_email'] = $row['email'];
                $_SESSION['user_id'] = $row['id'];
                header('location:index.php');
                exit();
            } else {
                $message[] = 'User type not recognized!';
            }
        } else {
            $message[] = 'Email or password is incorrect!';
        }
    } else {
        $message[] = 'Email does not exist!';
    }
}
?>

<!DOCTYPE html>
<html lang="sq">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- Lidhja me Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css">
    <link rel="stylesheet" type="text/css" href="style.css">
    <title>Login Page</title>
</head>
<body>
    <section class="form-container">
        <?php
        if (isset($message)) {
            foreach ($message as $msg) {
                echo '
                    <div class="message">
                        <span>' . $msg . '</span>
                        <i class="bi bi-x-circle" onclick="this.parentElement.remove()"></i>
                    </div>
                ';
            }
        }
        ?>
        <form method="post">
            <h1>Login Now</h1>
            <div class="input-field">
                <label>Your Email</label><br>
              <input type="email" name="email" placeholder="Enter your email" required> <!-- required ,nuk i lejon fushat te jene bosh -->
            </div>

            <div class="input-field">
                <label>Your Password</label><br>
                <input type="password" name="password" placeholder="Enter your password" required>
            </div>
            <input type="submit" name="submit-btn" value="Login Now" class="btn">
            <p>Don't have an account? <a href="register.php">Register now</a></p>
        </form>    
    </section>
</body>
</html>
