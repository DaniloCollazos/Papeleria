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
    $select_price=$conn->prepare("SELECT * FROM products WHERE id=? LIMIT 2");
    $select_price->execute([$product_id]);
    $fetch_price = $select_price->fetch(PDO::FETCH_ASSOC);
    $insert_cart=$conn ->prepare("INSERT INTO cart (id,user_id, product_id,price,qty)VALUES(?,?,?,?,?)");
    $insert_cart->execute([$id,$user_id,$product_id,$fetch_price['price'], $qty]);
    $sucess_msg[]='Producto agregado al carrito';
  }
}
//Eliminar de la lista de favoritos

if (isset($_POST['delete_item'])) {
  $wishlist_id = $_POST['wishlist_id'];
  $wishlist_id = filter_var($wishlist_id, FILTER_SANITIZE_STRING);

  $varify_delete_items = $conn->prepare("SELECT * FROM wishlist WHERE id =?");
  $varify_delete_items->execute([$wishlist_id]);

  if($varify_delete_items->rowCount()>0){
    $delete_wishlist_id = $conn->prepare("DELETE FROM wishlist WHERE id=?");
    $delete_wishlist_id->execute([$wishlist_id]);
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

        // Obtener los productos de la lista de favoritos del usuario
        $select_wishlist = $conn->prepare("SELECT * FROM wishlist WHERE user_id=?");
        $select_wishlist->execute([$user_id]);

        if ($select_wishlist->rowCount() > 0) {
            while ($fetch_wishlist = $select_wishlist->fetch(PDO::FETCH_ASSOC)) {
                // Obtener los detalles del producto
                $select_products = $conn->prepare("SELECT * FROM products WHERE id=?");
                $select_products->execute([$fetch_wishlist['product_id']]);

                if ($select_products->rowCount() > 0) {
                    $fetch_products = $select_products->fetch(PDO::FETCH_ASSOC);
        ?>
                    <!-- Formulario para agregar al carrito, eliminar o ver más detalles -->
                    <form method="post" action="" class="box">
                        <input type="hidden" name="wishlist_id" value="<?=$fetch_wishlist['id'];?>">
                        <img src="<?= htmlspecialchars($fetch_products['image']); ?>" class="img" alt="Product Image">

                        <div class="button">
                            <!-- Botón para agregar al carrito -->
                            <button type="submit" name="add_to_cart"><i class="bx bx-cart"></i> Agregar al carrito</button>
                            
                            <!-- Enlace para ver detalles del producto -->
                            <a href="view_page.php?pid=<?php echo $fetch_products['id']; ?>" class="bx bx-show"> Ver detalles</a>
                            
                            <!-- Botón para eliminar el producto de la lista de favoritos -->
                            <button type="submit" name="delete_item" onclick="return confirm('¿Eliminar este elemento de favoritos?')"><i class="bx bx-x"></i> Eliminar</button>
                        </div>

                        <h3 class="name"><?= htmlspecialchars($fetch_products['name']); ?></h3>

                        <input type="hidden" name="product_id" value="<?= $fetch_products['id']; ?>">

                        <div class="flex">
                            <p class="price">Precio: $<?= number_format($fetch_products['price'], 2); ?></p>
                        </div>

                        <!-- Enlace para comprar ahora -->
                        <a href="checkout.php?get_id=<?= $fetch_products['id']; ?>" class="btn">Comprar Ahora</a>
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