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


//Eliminar de la lista de favoritos
if (isset($_POST['delete_item'])) {
  $cart_id = $_POST['cart_id'];
  $cart_id = filter_var($cart_id, FILTER_SANITIZE_STRING);

  $varify_delete_items = $conn->prepare("SELECT * FROM cart WHERE id =?");
  $varify_delete_items->execute([$cart_id]);

  if($varify_delete_items->rowCount()>0){
    $delete_cart_id = $conn->prepare("DELETE FROM cart WHERE id=?");
    $delete_cart_id->execute([$cart_id]);
    $success_msg[]= "Articulo eliminado";
  }else {
    $warning_msg[]= 'Ya esta eliminado';
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
            $cart_id = $_POST['cart_id'];
            $qty = filter_var($_POST['qty'], FILTER_VALIDATE_INT);  // Validar la cantidad

            if ($qty > 0) {
                // Actualizar la cantidad del producto en el carrito
                $update_cart = $conn->prepare("UPDATE cart SET qty = ? WHERE id = ?");
                $update_cart->execute([$qty, $cart_id]);
                $sucess_msg[] = 'Cantidad actualizada';
            } else {
                $warning_msg = 'Cantidad no válida';
            }
        }
        // Lógica para eliminar un producto del carrito
        if (isset($_POST['delete_item'])) {
            $cart_id = $_POST['cart_id'];

            // Eliminar el producto del carrito
            $delete_item = $conn->prepare("DELETE FROM cart WHERE id = ?");
            $delete_item->execute([$cart_id]);
            $sucess_msg[] = 'Producto eliminado del carrito';
        }
        // Obtener los productos del carrito
        $select_cart = $conn->prepare("SELECT * FROM cart WHERE user_id=?");
        $select_cart->execute([$user_id]);
        if ($select_cart->rowCount() > 0) {
            while ($fetch_cart = $select_cart->fetch(PDO::FETCH_ASSOC)) {
                $select_products = $conn->prepare("SELECT * FROM products WHERE id=?");
                $select_products->execute([$fetch_cart['product_id']]);
                if ($select_products->rowCount() > 0) {
                    $fetch_products = $select_products->fetch(PDO::FETCH_ASSOC);
    ?>
        <form method="post" action="" class="box">
            <input type="hidden" name="cart_id" value="<?=$fetch_cart['id'];?>">
            <img src="<?= htmlspecialchars($fetch_products['image']); ?>" class="img" alt="Product Image">
            <h3 class="name"><?=$fetch_products['name'];?></h3>
            <div class="flex">
                <p class="price">Precio $<?=$fetch_products['price'];?></p>
                <input type="number" name="qty" required min="1" value="<?=$fetch_cart['qty'];?>" max="99" maxlength="2" class="qty">
                <button type="submit" name="update_cart" class="bx bxs-edit fa-edit"></button>
            </div>
            <p class="sub_total">Sub total : <span>
            <?php 
            // Asegúrate de que los valores sean numéricos antes de hacer la operación
            $qty = (int) $fetch_cart['qty'];  // Convertir qty a número entero
            $price = preg_replace('/[^0-9\.]/', '', $fetch_cart['price']);  // Limpiar cualquier carácter no numérico de price
            $price = (float) $price;  // Convertir price a número flotante
            // Calcular el subtotal
            $sub_total = $qty * $price; 
            echo '$' . number_format($sub_total, 2); 
            ?></span></p>
            <button type="submit" name="delete_item" class="btn" onclick="return confirm('Eliminar este articulo')">Eliminar</button>
        </form>
    <?php
        $grand_total += $sub_total;
                } else {
                    echo '<p class="empty">Producto no encontrado</p>';
                }
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