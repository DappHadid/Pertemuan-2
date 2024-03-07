<?php
session_start();
include('server/connection.php');

if (isset($_SESSION['logged_in'])) {
  header("location: welcome.php");
  exit;
}

if (isset($_POST['login_btn'])) {
  $email = $_POST['user_email'];
  $password = $_POST['user_password'];

  $query = "SELECT * FROM users WHERE user_email = ? AND user_password = ? LIMIT 1";

  $stmt_login = $conn->prepare($query);
  $stmt_login->bind_param('ss', $email, $password);

  if ($stmt_login->execute()) {
    $stmt_login->bind_result(
      $user_id,
      $user_name,
      $user_email,
      $user_password,
      $user_phone,
      $user_address,
      $user_city,
      $user_photo
    );
    $stmt_login->store_result();

    if ($stmt_login->num_rows() == 1) {
      $stmt_login->fetch();

      $_SESSION['user_id'] = $user_id;
      $_SESSION['user_name'] = $user_name;
      $_SESSION['user_email'] = $user_email;
      $_SESSION['user_phone'] = $user_phone;
      $_SESSION['user_address'] = $user_address;
      $_SESSION['user_city'] = $user_city;
      $_SESSION['user_photo'] = $user_photo;
      $_SESSION['logged_in'] = true;

      header('locaton: welcome.php?message=logged in successfully');
    } else {
      header('location: index.php?error=cound not verify your account');
    }
  } else {
    header('location: index.php?error=something went wrong!');
  }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Document</title>
  <link rel="stylesheet" href="css/style.css" />
</head>


<body>
  <div class="wrapper">
    <div class="top">
      <img src="assets/robot (1).png" alt="Logo" />
      <h1>Welcome Back!</h1>
    </div>

    <form autocomplete="off" id="login-form" method="POST" action="index.php">
      <?php if (isset($_GET['error'])) ?>
      <div role="alert">
        <?php if (isset($_GET['error'])) {
          echo $_GET['error'];
        }
        ?>

      </div>
      <div class="bottom">
        <div class="form">
          <p>Log in to your account</p>
          <input autocomplete="new-email" type="email" name="user_email" placeholder="Email Address ">
          <input autocomplete="new-password" type="password" name="user_password" placeholder="Password">
        </div>
        <div class="button-login"></div>
        <!-- <button>Login</button> -->
        <input type="submit" id="login-btn" name="login_btn" value="Login">
      </div>
  </div>
  </form>
  <div class="footer">
    <a href="">Forgot your password?</a>
    <a href="">Don't have account</a>
  </div>
</body>

</html>