<?php
include 'components/connection.php';
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
    <h1>contact us</h1>
  </div>
  <div class="title2">
    <a href="home.php">home</a><span>/ contact</span>
  </div>

  <div class = "form-container">
    <form method = "post">
        <div class = "title">
            <img src = "https://www.zarla.com/images/zarla-bolifans-1x1-2400x2400-20211206-td9rrt67ggxmwwjhh8f6.png?crop=1:1,smart&width=250&dpr=2" width="100" class = "logo">
            <h1>leave a message</h1>
        </div>
        <div class ="input-field">
            <p>your name <sup>*</sup></p>
            <input type = "text" name ="name">
        </div>
        <div class ="input-field">
            <p>your email <sup>*</sup></p>
            <input type = "email" name ="email">
        </div>
        <div class ="input-field">
            <p>your number <sup>*</sup></p>
            <input type = "text" name ="number">
        </div>
        <div class ="input-field">
            <p>your message <sup>*</sup></p>
            <textarea name = "message"></textarea>
        </div>
        <button type="submit" name = "submit" class="btn">send message </button>
    </form>
   
  </div>



    <?php include 'components/footer.php' ; ?>

<script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js"></script>
<script src="script.js"></script>
<?php include 'components/alert.php'; ?>
</body>
</html>