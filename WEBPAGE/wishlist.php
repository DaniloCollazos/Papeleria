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
    exit();
}

////////////////////////////////////////////////////////////////////////////////////////////////////////////////

//ELIMINAR DE FAVORITOS FUNCION
/*if (isset($_POST['delete_item'])) {
    $wishlist_id = $_POST['id_favorito'];
    $wishlist_id = filter_var($wishlist_id, FILTER_SANITIZE_STRING);
    $user_id = $_SESSION['user_id'];

    // Consulta con subconsulta para eliminar el producto si está en el carrito
    $delete_query = "DELETE FROM wishlist 
                     WHERE id_favorito = ? 
                     AND NOT EXISTS (
                         SELECT 1 FROM cart 
                         WHERE id_producto = ? AND id_usuario = ?
                     )";

    $delete_stmt = $conn->prepare($delete_query);
    $delete_stmt->execute([$wishlist_id, $wishlist_id, $user_id]);

    if ($delete_stmt->rowCount() > 0) {
        $success_msg[] = "Artículo eliminado de la lista de deseos";
    } else {
        $warning_msg[] = "El artículo no está en la lista de deseos o ya ha sido eliminado";
    }
}*/




if (isset($_POST['delete_item'])) {
    $wishlist_id = $_POST['id_favorito'];
    $wishlist_id = filter_var($wishlist_id, FILTER_SANITIZE_STRING);
    $varify_delete_items = $conn->prepare("SELECT * FROM wishlist WHERE id_favorito =?");
    $varify_delete_items->execute([$wishlist_id]);
    if($varify_delete_items->rowCount()>0){
      $delete_wishlist_id = $conn->prepare("DELETE FROM wishlist WHERE id_favorito =?");
      $delete_wishlist_id->execute([$wishlist_id]);
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
    <h1>Mis Favoritos</h1>
  </div>
  <div class="title2">
    <a href="home.php">home</a><span>/ Mis Favoritos </span>
  </div>

  <section class="products">
    <h1 class="title">Mi lista de favoritos</h1>
    <div class="box-container">
        <?php
        $grand_total = 0;
        // Traer los productos de la lista de favoritos
        $select_wishlist = $conn->prepare("SELECT * FROM wishlist WHERE id_usuario  =?");
        $select_wishlist->execute([$user_id]);
        if ($select_wishlist->rowCount() > 0) {
            while ($fetch_wishlist = $select_wishlist->fetch(PDO::FETCH_ASSOC)) {
                $select_products = $conn->prepare("SELECT p.id_producto, p.nombre_producto, p.descripcion, p.precio, f.url_foto FROM productos p LEFT JOIN fotos f ON p.id_foto = f.id_foto WHERE p.id_producto =?");
                $select_products->execute([$fetch_wishlist['id_producto']]);  // Corregir el nombre del campo 'id_producto'
                    if ($select_products->rowCount() > 0) {
                        $fetch_products = $select_products->fetch(PDO::FETCH_ASSOC);
        
        ?>
        <!-- Formulario para agregar al carrito, eliminar o ver más detalles -->
        <form method="post" action="" class="box">
            <input type="hidden" name="id_favorito" value="<?=$fetch_wishlist['id_favorito'];?>">
            <img src="<?= htmlspecialchars($fetch_products['url_foto']); ?>" class="img product-img" alt="Product Image" width="50">
            <h3 class="nombre_producto"><?=$fetch_products['nombre_producto'];?></h3>

        <div class="button">
            <!-- Enlace para ver detalles del producto -->
            <a href="view_page.php?pid=<?php echo $fetch_products['id_producto']; ?>" class="bx bx-show"> Ver detalles</a>
            <!-- Botón para eliminar el producto de la lista de favoritos -->
            <button type="submit" name="delete_item" onclick="return confirm('¿Eliminar este elemento de favoritos?')"><i class="bx bx-x"></i> Eliminar</button>
        </div>
            <input type="hidden" name="id_producto" value="<?= $fetch_products['id_producto']; ?>">

            <div class="flex">
                <p class="precio">Precio: $<?= number_format($fetch_products['precio'], 2); ?></p>
            </div>
                </form>       
        <?php
                }
            }
        } else {
            echo '<p class="empty">No tienes productos en tu lista de favoritos</p>';
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