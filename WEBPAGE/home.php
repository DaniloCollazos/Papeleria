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
   <section class="home-section">
    <div class="slider">
            <div class="slider__slider slide1">
                <div class="overlay"></div>
                <div class="hero-dec-top"></div>
                <div class="hero-dec-bottom"></div>
            </div>
            <!-- slide end -->
            <div class="slider__slider slide2">
                <div class="overlay"></div>
                <div class="hero-dec-top"></div>
                <div class="hero-dec-bottom"></div>
            </div>
            <!-- slide end -->
            <div class="slider__slider slide3">
                <div class="overlay"></div>
                <div class="hero-dec-top"></div>
                <div class="hero-dec-bottom"></div>
            </div>
            <!-- slide end -->
            <div class="slider__slider slide4">
                <div class="overlay"></div>
                <div class="hero-dec-top"></div>
                <div class="hero-dec-bottom"></div>
            </div>
            <!-- slide end -->
            <div class="slider__slider slide5">
                <div class="overlay"></div>
                <div class="hero-dec-top"></div>
                <div class="hero-dec-bottom"></div>
            </div>
            <!-- slide end -->
            <div class="left-arrow"><i class="bx bxs-left-arrow"></i></div>
            <div class="right-arrow"><i class="bx bxs-right-arrow"></i></div>
        </div>
   </section>

   <section class="thumb">
   <div class="box-container">
   <div class="box-container">
      <?php
      $select_products = $conn->prepare("SELECT * FROM productos");
      $select_products->execute();

      $select_products = $conn->prepare("SELECT p.id_producto, p.nombre_producto, p.descripcion, p.precio, f.url_foto, c.id_categoria
                                         FROM productos p 
                                         INNER JOIN fotos f ON p.id_foto = f.id_foto
                                         INNER JOIN categoria c ON c.id_categoria = p.id_categoria
                                         WHERE c.id_categoria = 3");
      $select_products->execute();

      
      // Verifica si hay productos disponibles
      if ($select_products->rowCount() > 0) {
        while ($fetch_products = $select_products->fetch(PDO::FETCH_ASSOC)) {
      ?>
        <form action="" method="post" class="box">
        <img src="<?= htmlspecialchars($fetch_products['url_foto']) ? htmlspecialchars($fetch_products['url_foto']) : 'default-image.jpg'; ?>" class="img product-img" alt="Product Image"  width="50">
        
        <link rel="stylesheet" href="styles.css">
        <div class = "button">
          </div>
          <h3 class ="nombre_producto"><?=$fetch_products['nombre_producto'];?></h3>
          <input type="hidden" name="id_producto" required min="1" value ="1" max ="4" maxlength="2">
          <div class = "flex">
            <p class = "precio">$<?=$fetch_products['precio'];?>/-</p>
          </div>
          <div class = "button">
          <a href="view_page.php?pid=<?php echo $fetch_products['id_producto']; ?>" class ="bx bx-show"></a>
          </div>
        </form>
      <?php
        }
      }else{
        echo '<p class = "empty"> No hay productos agregados</p>';
      }
      ?>
    </div>
  </div>




  <section class="container">
  <div class="box-container">
    <div class="box">
      <img src="https://i.ytimg.com/vi/KseVX4I8GbA/hq720.jpg?sqp=-oaymwEhCK4FEIIDSFryq4qpAxMIARUAAAAAGAElAADIQj0AgKJD&rs=AOn4CLDA9InWP6MCmf80Yzqr3_zLdOpPJA">
    </div>
    <div class="box">
      <img src="https://i.ytimg.com/vi/KseVX4I8GbA/hq720.jpg?sqp=-oaymwEhCK4FEIIDSFryq4qpAxMIARUAAAAAGAElAADIQj0AgKJD&rs=AOn4CLDA9InWP6MCmf80Yzqr3_zLdOpPJA">
      <span>Sharpie</span>
      <h1>save up to 58% off</h1>
      <p>Aprovecha los descuentos</p>
    </div>
  </div>
</section>
<section class="shop">
  <div class="title">
    <img src="">
    <h1>TENDENCIA!!!</h1>
  </div>
  <div class="row">
    <img src="https://http2.mlstatic.com/D_NQ_NP_874730-MLM51291927893_082022-O.webp">
    <div class="row-detail">
      <img src="https://newellbrands.imgix.net/2fb9cc27-da51-30d9-8844-35a95f947347/2fb9cc27-da51-30d9-8844-35a95f947347.jpg?fm=jpg" width ="900">
      <div class="top-footer">
        <h1>Agrega color y diversión a tus diseños</h1>
        <img src="https://vadevolada.com/cache/storage/2023/July/week4/657892_papermate_kilometrico_imagename-1200x630.png" width ="200">

      </div>
    </div>
  </div>



  <div class="box-container">
   <div class="box-container">
      <?php
      $select_products = $conn->prepare("SELECT * FROM productos");
      $select_products->execute();

      $select_products = $conn->prepare("SELECT p.id_producto, p.nombre_producto, p.descripcion, p.precio, f.url_foto, c.id_categoria
                                         FROM productos p 
                                         INNER JOIN fotos f ON p.id_foto = f.id_foto
                                         INNER JOIN categoria c ON c.id_categoria = p.id_categoria
                                         WHERE c.id_categoria = 1");
      $select_products->execute();

      
      // Verifica si hay productos disponibles
      if ($select_products->rowCount() > 0) {
        while ($fetch_products = $select_products->fetch(PDO::FETCH_ASSOC)) {
      ?>
        <form action="" method="post" class="box">
        <img src="<?= htmlspecialchars($fetch_products['url_foto']) ? htmlspecialchars($fetch_products['url_foto']) : 'default-image.jpg'; ?>" class="img product-img" alt="Product Image"  width="50">
        
        <link rel="stylesheet" href="styles.css">
        <div class = "button">
          </div>
          <h3 class ="nombre_producto"><?=$fetch_products['nombre_producto'];?></h3>
          <input type="hidden" name="id_producto" required min="1" value ="1" max ="4" maxlength="2">
          <div class = "flex">
            <p class = "precio">$<?=$fetch_products['precio'];?>/-</p>
          </div>
          <div class = "button">
          <a href="view_page.php?pid=<?php echo $fetch_products['id_producto']; ?>" class ="bx bx-show"></a>
          </div>
        </form>
      <?php
        }
      }else{
        echo '<p class = "empty"> No hay productos agregados</p>';
      }
      ?>
    </div>
  </div>
</section>




<section class="shop-category">
  <div class="box-container">
    <div class="box">
      <img src="https://cdn1.totalcommerce.cloud/normaco/product-thumb/es/kit-dias-eficientes-kiut-agenda-premium-%2B-cartuchera-%2B-fineliners-x-6-und-2.webp" width = "200">
      <div class="detail">
        <span>BIG OFFERS</span>
        <h1>Extra 15% off</h1>
        <a href="view_products.php" class="btn">shop now</a>
      </div>
    </div>
    <div class="box">
      <img src="https://cdn1.totalcommerce.cloud/normaco/product-thumb/es/kit-regreso-a-clases-cartuchera-%2B-pegante-%2B-lapices-%2B-caja-de-colores-norma-2.webp"width = "200">
      <div class="detail">
        <span>new in taste</span>
        <h1>coffee house</h1>
        <a href="view_products.php" class="btn">shop now</a>
      </div>
    </div>
  </div>
</section> 


<section class="services">
<div class="box-container">
   <div class="box-container">
      <?php
      $select_products = $conn->prepare("SELECT * FROM productos");
      $select_products->execute();

      $select_products = $conn->prepare("SELECT p.id_producto, p.nombre_producto, p.descripcion, p.precio, f.url_foto, c.id_categoria
                                         FROM productos p 
                                         INNER JOIN fotos f ON p.id_foto = f.id_foto
                                         INNER JOIN categoria c ON c.id_categoria = p.id_categoria
                                         WHERE c.id_categoria = 2");
      $select_products->execute();

      
      // Verifica si hay productos disponibles
      if ($select_products->rowCount() > 0) {
        while ($fetch_products = $select_products->fetch(PDO::FETCH_ASSOC)) {
      ?>
        <form action="" method="post" class="box">
        <img src="<?= htmlspecialchars($fetch_products['url_foto']) ? htmlspecialchars($fetch_products['url_foto']) : 'default-image.jpg'; ?>" class="img product-img" alt="Product Image"  width="50">
        
        <link rel="stylesheet" href="styles.css">
        <div class = "button">
          </div>
          <h3 class ="nombre_producto"><?=$fetch_products['nombre_producto'];?></h3>
          <input type="hidden" name="id_producto" required min="1" value ="1" max ="4" maxlength="2">
          <div class = "flex">
            <p class = "precio">$<?=$fetch_products['precio'];?>/-</p>
          </div>
          <div class = "button">
          <a href="view_page.php?pid=<?php echo $fetch_products['id_producto']; ?>" class ="bx bx-show"></a>
          </div>
        </form>
      <?php
        }
      }else{
        echo '<p class = "empty"> No hay productos agregados</p>';
      }
      ?>
    </div>
  </div>
</section>









    <?php include 'components/footer.php' ; ?>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js"></script>
    <script src="script.js"></script>
    <?php include 'components/alert.php'; ?>
</body>
</html>


