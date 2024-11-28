<?php
include 'components/connection.php';
session_start();
if (isset($_SESSION['user_id'])) {
  // Si existe, asigna el ID del usuario a una variable
  $user_id = $_SESSION[''];
} else {
  // Si no existe, asigna un valor vacío al ID del usuario
  $user_id = '';
}
if(isset($_POST['logout'])){
  session_destroy();
  header("location: login.php");
}
?>

<style  type = "text/css">
    <?php include 'style.css'; ?>
</style>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css" rel="stylesheet">
    <title>Bolifans - Home</title>
</head>
<body>
    <?php include 'components/header.php'; ?>
    <div class="main">
  <div class="banner">
    <h1>about us</h1>
  </div>
  <div class="title2">
    <a href="home.php">home</a><span>/ about</span>
  </div>
  <div class="about-category">
    <div class="box">
      <img src="img/3.webp">
      <div class="detail">
        <span>coffee</span>
        <h1>lemon green</h1>
        <a href="view_products.php" class="btn">shop now</a>
      </div>
    </div>
    <div class="box">
      <img src="img/3.webp">
      <div class="detail">
        <span>coffee</span>
        <h1>lemon green</h1>
        <a href="view_products.php" class="btn">shop now</a>
      </div>
    </div>
    <div class="box">
      <img src="img/3.webp">
      <div class="detail">
        <span>coffee</span>
        <h1>lemon green</h1>
        <a href="view_products.php" class="btn">shop now</a>
      </div>
    </div>
    <div class="box">
      <img src="img/3.webp">
      <div class="detail">
        <span>coffee</span>
        <h1>lemon green</h1>
        <a href="view_products.php" class="btn">shop now</a>
      </div>
    </div>
  </div>
</div>
    <?php include 'components/footer.php' ; ?>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js"></script>
    <script src="script.js"></script>
    <?php include 'components/alert.php'; ?>
    </body>
    </html>