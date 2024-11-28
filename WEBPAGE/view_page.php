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

////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//AGREGAR AL CARRITO
if (isset($_POST['add_to_cart'])) {
  // Este condicional es para validar si esta logueado para asi tomar la ID del usuario.
  // Dado el caso no este logueado no puede agregar a favoritos porque necesitamos el ID
  if (isset($_SESSION['id_usuario'])) {
      $user_id = $_SESSION['id_usuario'];  
  } else {
      echo "Por favor, inicia sesión.";
      exit;
  }
  // Obtener el id del producto y la cantidad
  $product_id = $_POST['id_producto'];
  $qty = $_POST['cantidad'];
  $qty = filter_var($qty, FILTER_SANITIZE_STRING);

  // Verificar si el producto ya está en el carrito
  $varify_cart = $conn->prepare("SELECT * FROM cart WHERE id_usuario = ? AND id_producto = ?");
  $varify_cart->execute([$user_id, $product_id]);

  // Verificar si el usuario tiene más de 20 productos en su carrito
  $max_cart_items = $conn->prepare("SELECT * FROM cart WHERE id_usuario = ?");
  $max_cart_items->execute([$user_id]);

  if ($varify_cart->rowCount() > 0) {
      // Si el producto ya está en el carrito, actualizar la cantidad, es decir agregarle 1 mas
      $update_cart = $conn->prepare("UPDATE cart SET cantidad = cantidad + ? WHERE id_usuario = ? AND id_producto = ?");
      $update_cart->execute([$qty, $user_id, $product_id]);
      $sucess_msg[] = 'Cantidad actualizada en el carrito';
  } elseif ($max_cart_items->rowCount() > 20) {
      $warning_msg = 'Carrito lleno';
  } else {
      // Si no existe, agregar el producto al carrito
      $insert_cart = $conn->prepare("INSERT INTO cart (id_usuario, id_producto, cantidad) VALUES (?, ?, ?)");
      $insert_cart->execute([$user_id, $product_id, $qty]);
      $sucess_msg[] = 'Producto agregado al carrito';
  }
}
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
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
    <title>Bolifans - Detalles del producto</title>
</head>
<body>


<?php include 'components/header.php'; ?>
<div class="main">
  <div class="banner">
    <h1>Detalles del producto</h1>
  </div>
  <div class="title2">
    <a href="home.php">home</a><span>/ Detalles del producto </span>
  </div>

  <section class="view_page">
    <?php
      $fetch_products = $conn->prepare("SELECT p.id_producto, p.nombre_producto, p.descripcion, p.precio, f.url_foto 
      FROM productos p 
      LEFT JOIN fotos f ON p.id_foto = f.id_foto");
      $fetch_products->execute();
    
      if (isset($_GET['pid'])) {
        $pid = $_GET['pid'];
        
        // Consulta para obtener los detalles del producto, incluyendo la URL de la foto
        $select_products = $conn->prepare("
            SELECT p.id_producto, p.nombre_producto, p.descripcion, p.precio, f.url_foto
            FROM productos p
            LEFT JOIN fotos f ON p.id_foto = f.id_foto
            WHERE p.id_producto = :pid
        ");
        $select_products->bindParam(':pid', $pid, PDO::PARAM_INT);
        $select_products->execute();
    
        // Verificar si el producto existe
        if ($select_products->rowCount() > 0) {
            $fetch_products = $select_products->fetch(PDO::FETCH_ASSOC);
            $image_url = $fetch_products['url_foto'] ? $fetch_products['url_foto'] : 'default-image.jpg'; 
        } else {
            echo "Producto no encontrado.";
            exit;
        }
    }
    ?>
    <form method="post">
        <!-- Mostrar la imagen del producto -->
        <img src="<?= htmlspecialchars($image_url); ?>" class="img product-img" alt="Product Image" width="50" height="50">        <div class="detail">
            <div class="precio">$<?php echo $fetch_products['precio']; ?></div>
            <div class="nombre_producto"><?php echo $fetch_products['nombre_producto']; ?></div>
            <div class="descripcion"><?php echo $fetch_products['descripcion']; ?></div>
            <input type="hidden" name="id_producto" value="<?php echo $fetch_products['id_producto']; ?>">
            <div class="button">
                <button type="submit" name="add_to_wishlist" class="btn">Agregar a favoritos <i class="bx bx-heart"></i></button>
                <button type="submit" name="add_to_cart" class="btn">Agregar al carrito <i class="bx bx-cart"></i></button>
                <input type="number" name="cantidad" id="qty" value="1" class="quantity">
                
            </div>
        </div>
    </form>
  </section>
  



<section class="thumb">
  <div class="box-container">
    <?php
    // Assuming $product_id is the ID of the current product
    $product_id = $_GET['pid']; // Replace with the actual way to get the product ID

    $select_related_products = $conn->prepare("SELECT p.id_producto, p.nombre_producto, p.descripcion, p.precio, f.url_foto
                                               FROM productos p
                                               INNER JOIN fotos f ON p.id_foto = f.id_foto
                                               WHERE p.id_categoria = (
                                                SELECT c.id_categoria
                                                FROM productos p2
                                                INNER JOIN categoria c ON p2.id_categoria = c.id_categoria
                                                WHERE p2.id_producto = ?)AND p.id_producto != ? LIMIT 5");
    $select_related_products->execute([$product_id, $product_id]);

    if ($select_related_products->rowCount() > 0) {
        while ($related_product = $select_related_products->fetch(PDO::FETCH_ASSOC)) {

            ?>
            <div class="product">
            <img src="<?= $related_product['url_foto'] ?>" alt="<?= $related_product['nombre_producto'] ?>" width="200" height="200">                <h3><?= $related_product['nombre_producto'] ?></h3>
                <p>Precio: $<?= $related_product['precio'] ?></p>
                <a href="view_page.php?pid=<?= $related_product['id_producto'] ?>">Ver detalles</a>
            </div>
            <?php
        }
    } else {
        echo "<p>No hay productos relacionados.</p>";
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