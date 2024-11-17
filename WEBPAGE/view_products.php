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
    <h1>Nuestra tienda</h1>
  </div>
  <div class="title2">
    <a href="home.php">home</a><span>/ Nuestra tienda </span>
  </div>

  <section class="products">
    <div class="box-container">
      <?php
      // Asumimos que $conn está correctamente configurado
      $select_products = $conn->prepare("SELECT * FROM products");
      $select_products->execute();
      
      // Verifica si hay productos disponibles
      if ($select_products->rowCount() > 0) {
        while ($fetch_products = $select_products->fetch(PDO::FETCH_ASSOC)) {
      ?>
        <form action="" method="post" class="box">
        <img src="<?= htmlspecialchars($fetch_products['image']); ?>" class="img" alt="Product Image">
        <div class = "button">
            <button type = "sumit" name="add_to_cart"><i class ="bx bx-cart"></i></button>
            <button type = "sumit" name="add_to_wishlist"><i class ="bx bx-heart"></i></button>
            <a href="view_page.php?pid=<?php echo $fetch_products['id']; ?>" class ="bx bx-show"></a>
          </div>
          <h3 class ="name"><?=$fetch_products['name'];?></h3>
          <input type="hidden" name="product_id" required min="1" value ="1" max ="99" maxlength="2">
          <div>
            <p class = "price"><?=$fetch_products['price'];?>/-</p>
            <input type="number" name="qty" required min="1" value ="1" max ="99" maxlength="2">
          </div>
          <a href="checkout.php?get_id=<?=$fetch_products['price'];?>" class = "btn"> Comprar Ahora</a>
        </form>
      <?php
        }
      }else{
        echo '<p class = "empty">no productos agregados</p>';
      }
      ?>
    </div>
  </section>
</div>


    <?php include 'components/footer.php' ; ?>

<script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js"></script>
<script src="script.js"></script>
<?php include 'components/alert.php'; ?>
</body>
</html>