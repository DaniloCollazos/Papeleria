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
//ELIMINAR DEL CARRITO FUNCION
if (isset($_POST['delete_item'])) {
  $cart_id = $_POST['id_carrito'];
  $cart_id = filter_var($cart_id, FILTER_SANITIZE_STRING);
  $varify_delete_items = $conn->prepare("SELECT * FROM cart WHERE id_carrito  =?");
  $varify_delete_items->execute([$cart_id]);
  if($varify_delete_items->rowCount()>0){
    $delete_cart_id = $conn->prepare("DELETE FROM cart WHERE id_carrito=?");
    $delete_cart_id->execute([$cart_id]);
    $success_msg[]= "Articulo eliminado";
  }else {
    $warning_msg[]= 'Ya esta eliminado';
  }
}
////////////////////////////////////////////////////////////////////////////////////////////////////////////////
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
    <title>Bolifans - Mis Favoritos</title>
</head>
<body>
<?php include 'components/header.php'; ?>
<div class="main">
  <div class="banner">
    <h1>Carrito</h1>
  </div>
  <div class="title2">
    <a href="home.php">home</a><span>/ Carrito </span>
  </div>

  <section class="products">
    <h1 class="title">Mis Productos</h1>
    <div class="box-container">
    <?php
        $grand_total = 0;

        // Lógica para actualizar la cantidad del producto
        if (isset($_POST['update_cart'])) {
            $cart_id = $_POST['id_carrito']; 
            $qty = filter_var($_POST['cantidad'], FILTER_VALIDATE_INT);  // Validar la cantidad

            if ($qty > 0) {
                // Actualizar la cantidad del producto en el carrito
                $update_cart = $conn->prepare("UPDATE cart SET cantidad = ? WHERE id_carrito = ?");
                $update_cart->execute([$qty, $cart_id]);
                $success_msg[] = 'Cantidad actualizada';
            } else {
                $warning_msg = 'Cantidad no válida';
            }
        }
        // Casos
        $select_cart = $conn->prepare("SELECT p.id_producto, p.nombre_producto, p.descripcion, p.precio, c.cantidad,c.id_carrito,f.url_foto, cat.nombre_categoria,
        /*Para nuestro primer caso usamos descuentos por tener agregado a favoritos*/
        CASE 
            WHEN w.id_producto IS NOT NULL THEN p.precio * 0.90 
            ELSE p.precio
        END AS precio_con_descuento,
        /*Para nuestro segundo caso usamos descuentos por productos que esten en la categoria Papeleria*/
        CASE 
            WHEN cat.nombre_categoria = 'Papelería' THEN 
                CASE 
                    WHEN w.id_producto IS NOT NULL THEN p.precio * 0.90 * 0.90  
                    ELSE p.precio * 0.90 
                END
            ELSE 
            /*Para nuestro ultimo caso no tienen descuentos sino cumplen las otras consultas*/
                CASE 
                    WHEN w.id_producto IS NOT NULL THEN p.precio * 0.90 
                    ELSE p.precio 
                END
        END AS precio_final
    FROM 
        productos p
    LEFT JOIN 
        cart c ON p.id_producto = c.id_producto AND c.id_usuario = :usuario_id
    LEFT JOIN 
        wishlist w ON p.id_producto = w.id_producto AND w.id_usuario = :usuario_id
    LEFT JOIN 
        categoria cat ON p.id_categoria = cat.id_categoria
    LEFT JOIN 
        fotos f ON p.id_foto = f.id_foto
    WHERE 
        c.id_usuario = :usuario_id");


$select_cart->execute([':usuario_id' => $user_id]);

        if ($select_cart->rowCount() > 0) {
            while ($fetch_cart = $select_cart->fetch(PDO::FETCH_ASSOC)) {
                // Calcular el subtotal con descuento si aplica
                $qty = (int) $fetch_cart['cantidad'];
                $price = (float) $fetch_cart['precio_final'];  // Utiliza el precio final con descuento
                $category = $fetch_cart['nombre_categoria'];

                $sub_total = $qty * $price; // Calcular subtotal
    ?>
        <form method="post" action="" class="box">
            <input type="hidden" name="id_carrito" value="<?=$fetch_cart['id_carrito'];?>">
            <img src="<?= htmlspecialchars($fetch_cart['url_foto']); ?>" class="img product-img" alt="Product Image" width="50">
            <h3 class="nombre_producto"><?= htmlspecialchars($fetch_cart['nombre_producto']); ?></h3>
            <div class="flex">
                <p class="precio"> Precio $<?= htmlspecialchars($fetch_cart['precio']); ?></p>
                <input type="cantidad" name="cantidad" required min="1" value="<?=$qty;?>" max="99" maxlength="2" class="qty">
                <button type="submit" name="update_cart" class="bx bxs-edit fa-edit">Actualizar</button>
            </div>
            <p class="sub_total">Sub total : <span>
            <?= '$' . number_format($sub_total, 2); ?>
            </span></p>
            <button type="submit" name="delete_item" class="btn" onclick="return confirm('¿Eliminar este artículo?')">Eliminar</button>
        </form>
    <?php
                $grand_total += $sub_total; // Sumar al total general
            }
        } else {
            echo '<p class="empty">No hay productos en tu carrito</p>';
        }
    ?>
    </div>
    
    <div class="total">
        <p>Total: $<?= number_format($grand_total, 2); ?></p>
        <button class="checkout-btn">Pagar</button>
    </div>
</section>
</div>

<?php include 'components/footer.php' ; ?>
<script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js"></script>
<script src="script.js"></script>
<?php include 'components/alert.php'; ?>
</body>
</html>