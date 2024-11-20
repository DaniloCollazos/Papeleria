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


// Agregar productos en la lista de favoritos
if (isset($_POST['add_to_wishlist'])) {
  $id = unique_id();
  $product_id = $_POST['product_id'];
  // Verificar si el producto ya está en la lista de deseos
  $varify_wishlist = $conn->prepare("SELECT * FROM wishlist WHERE user_id = ? AND product_id = ?");
  $varify_wishlist->execute([$user_id, $product_id]);
  // Verificar si el producto ya está en el carrito
  $cart_num = $conn->prepare("SELECT * FROM cart WHERE user_id = ? AND product_id = ?");
  $cart_num->execute([$user_id, $product_id]);
  if ($varify_wishlist->rowCount() > 0) {
    $warning_msg = 'Producto ya existe en tu lista de favoritos';
  } elseif ($cart_num->rowCount() > 0) {
    $warning_msg = 'Producto ya existe en tu carrito';
  } else {
    // Obtener el precio del producto
    $select_price = $conn->prepare("SELECT * FROM products WHERE id = ? LIMIT 1");
    $select_price->execute([$product_id]);
    $fetch_price = $select_price->fetch(PDO::FETCH_ASSOC);
    // Insertar el producto en la lista de deseos
    $insert_wishlist = $conn->prepare("INSERT INTO wishlist (id, user_id, product_id, price) VALUES (?, ?, ?, ?)");
    $insert_wishlist->execute([$id, $user_id, $product_id, $fetch_price['price']]);
    $success_msg[] = 'Producto agregado a la lista de favoritos';
  }
}


//agregar productos al carrito
if (isset($_POST['add_to_cart'])) {
  $id = unique_id();
  $product_id = $_POST['product_id'];
  $qty = $_POST['qty'];
  $qty = filter_var($qty, FILTER_SANITIZE_STRING);
  $varify_cart  = $conn->prepare("SELECT * FROM cart WHERE user_id =? AND product_id=?");
  $varify_cart ->execute([$user_id, $product_id]);

  $max_cart_items = $conn->prepare("SELECT * FROM cart WHERE user_id =? ");
  $max_cart_items ->execute([$user_id]);


  if ($varify_cart->rowCount()>0) {
    $warning_msg ='Producto ya existe en tu lista';
  }elseif($max_cart_items->rowCount()>20){
    $warning_msg ='Carrito lleno';
  }else {
    $select_price=$conn->prepare("SELECT * FROM products WHERE id=? LIMIT 1");
    $select_price->execute([$product_id]);
    $fetch_price = $select_price->fetch(PDO::FETCH_ASSOC);
    $insert_cart=$conn ->prepare("INSERT INTO cart (id,user_id, product_id,price,qty)VALUES(?,?,?,?,?)");
    $insert_cart->execute([$id,$user_id,$product_id,$fetch_price['price'], $qty]);
    $sucess_msg[]='Producto agregado al carrito';
  }
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
          <div class = "flex">
            <p class = "price">$<?=$fetch_products['price'];?>/-</p>
            <input type="number" name="qty" required min="1" value ="1" max ="99" maxlength="2" class = "qty">
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