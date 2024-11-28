<?php
include 'components/connection.php';
session_start();
if (isset($_SESSION['id_usuario'])) {
    // Si existe, asigna el ID del usuario a una variable
    $user_id = $_SESSION['id_usuario'];
} else {
    // Si no existe, asigna un valor vacío al ID del usuario
    $user_id = '';
}
if (isset($_POST['logout'])) {
    session_destroy();
    header("Location: login.php");
    exit();  // Es importante usar exit() después de header para detener la ejecución del script
}


////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// AGREGAR A FAVORITOS
if (isset($_POST['add_to_wishlist'])) {
  // Este condicional es para validar si esta logueado para asi tomar la ID del usuario.
  // Dado el caso no este logueado no puede agregar a favoritos porque necesitamos el ID
  if (isset($_SESSION['id_usuario'])) {
      $user_id = $_SESSION['id_usuario'];  
  } else {
      echo "Por favor, inicia sesión.";
      exit;
  }
  // Obtener el id del producto
  $product_id = $_POST['id_producto'];
  // Verificar si el producto ya está en los favoritos
  $varify_favorites = $conn->prepare("SELECT * FROM wishlist WHERE id_usuario = ? AND id_producto = ?");
  $varify_favorites->execute([$user_id, $product_id]);

  if ($varify_favorites->rowCount() > 0) {
      // Si el producto ya está en los favoritos, mostrar un mensaje
      $sucess_msg[] = 'Este producto ya está en tus favoritos';
  } else {
      // Si no está, agregar el producto a los favoritos
      $insert_favorites = $conn->prepare("INSERT INTO wishlist (id_usuario, id_producto) VALUES (?, ?)");
      $insert_favorites->execute([$user_id, $product_id]);
      $sucess_msg[] = 'Producto agregado a tus favoritos';
  }
}
////////////////////////////////////////////////////////////////////////////////////////////////////////////////






//agregar productos al carrito
if (isset($_POST['add_to_cart'])) {
  $id = unique_id();
  $product_id = $_POST['id_producto'];
  $qty = $_POST['cantidad'];
  $qty = filter_var($qty, FILTER_SANITIZE_STRING);
  $varify_cart  = $conn->prepare("SELECT * FROM cart WHERE id_usuario =? AND id_producto=?");
  $varify_cart ->execute([$user_id, $product_id]);
  $max_cart_items = $conn->prepare("SELECT * FROM cart WHERE id_usuario =? ");
  $max_cart_items ->execute([$user_id]);
  if ($varify_cart->rowCount()>0) {
    $warning_msg ='Producto ya existe en tu lista';
  }elseif($max_cart_items->rowCount()>20){
    $warning_msg ='Carrito lleno';
  }else {
    $select_price=$conn->prepare("SELECT * FROM products WHERE id_producto=? LIMIT 1");
    $select_price->execute([$product_id]);
    $fetch_price = $select_price->fetch(PDO::FETCH_ASSOC);
    $insert_cart=$conn ->prepare("INSERT INTO cart (id_usuario, id_producto,cantidad)VALUES(?,?,?)");
    $insert_cart->execute([$user_id,$product_id, $qty]);
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
  <div class="title2">


  <form method="GET" >
        <input type="text" name="q" placeholder="Buscar..." required>
        <button type="submit">Buscar</button>
    </form>
  </div>


  <section class="products">
    <div class="box-container">
      <?php

      
      // Asumimos que $conn está correctamente configurado
      $select_products = $conn->prepare("SELECT * FROM productos");
      $select_products->execute();



      $select_products = $conn->prepare("SELECT p.id_producto, p.nombre_producto, p.descripcion, p.precio, f.url_foto 
                                         FROM productos p 
                                         LEFT JOIN fotos f ON p.id_foto = f.id_foto");
      $select_products->execute();
      
      // Verifica si hay productos disponibles
      $select_products = $conn->prepare(" SELECT p.id_producto, p.nombre_producto, p.descripcion, p.precio, f.url_foto 
                                          FROM productos p 
                                          LEFT JOIN fotos f ON p.id_foto = f.id_foto
                                          ORDER BY p.precio DESC");
     $select_products->execute();
     
     if ($select_products->rowCount() > 0) {
      while ($fetch_products = $select_products->fetch(PDO::FETCH_ASSOC)) {
          ?>
        <form action="" method="post" class="box">
        <img src="<?= htmlspecialchars($fetch_products['url_foto']) ? htmlspecialchars($fetch_products['url_foto']) : 'default-image.jpg'; ?>" class="img product-img" alt="Product Image"  width="50">
        
        <link rel="stylesheet" href="styles.css">
        <div class = "button">
            <a href="view_page.php?pid=<?php echo $fetch_products['id_producto']; ?>" class ="bx bx-show"></a>
          </div>
          <h3 class ="nombre_producto"><?=$fetch_products['nombre_producto'];?></h3>
          <input type="hidden" name="id_producto" required min="1" value ="1" max ="99" maxlength="2">
          <div class = "flex">
            <p class = "precio">$<?=$fetch_products['precio'];?>/-</p>
          </div>
          <a href="checkout.php?get_id=<?=$fetch_products['precio'];?>" class = "btn"> Comprar Ahora</a>
          <input type="number" name="cantidad" id="qty" value="1" class="quantity">
          
        </form>
      <?php
        }
      }else{
        echo '<p class = "empty"> No hay productos agregados</p>';
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