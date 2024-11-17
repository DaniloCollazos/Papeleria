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
                <div class="slide-detail">
                    <h1>Plants To Welcome In Spring</h1>
                    <p>Bring home some lush greenery to celebrate the start of the season.</p>
                    <a href="view_products.php" class="btn">Shop now</a>
                </div>
                <div class="hero-dec-top"></div>
                <div class="hero-dec-bottom"></div>
            </div>
            <!-- slide end -->
            <div class="slider__slider slide2">
                <div class="overlay"></div>
                <div class="slide-detail">
                    <h1>Plants To Welcome In Spring</h1>
                    <p>Bring home some lush greenery to celebrate the start of the season.</p>
                    <a href="view_products.php" class="btn">Shop now</a>
                </div>
                <div class="hero-dec-top"></div>
                <div class="hero-dec-bottom"></div>
            </div>
            <!-- slide end -->
            <div class="slider__slider slide3">
                <div class="overlay"></div>
                <div class="slide-detail">
                    <h1>Plants To Welcome In Spring</h1>
                    <p>Bring home some lush greenery to celebrate the start of the season.</p>
                    <a href="view_products.php" class="btn">Shop now</a>
                </div>
                <div class="hero-dec-top"></div>
                <div class="hero-dec-bottom"></div>
            </div>
            <!-- slide end -->
            <div class="slider__slider slide4">
                <div class="overlay"></div>
                <div class="slide-detail">
                    <h1>Plants To Welcome In Spring</h1>
                    <p>Bring home some lush greenery to celebrate the start of the season.</p>
                    <a href="view_products.php" class="btn">Shop now</a>
                </div>
                <div class="hero-dec-top"></div>
                <div class="hero-dec-bottom"></div>
            </div>
            <!-- slide end -->
            <div class="slider__slider slide5">
                <div class="overlay"></div>
                <div class="slide-detail">
                    <h1>Plants To Welcome In Spring</h1>
                    <p>Bring home some lush greenery to celebrate the start of the season.</p>
                    <a href="view_products.php" class="btn">Shop now</a>
                </div>
                <div class="hero-dec-top"></div>
                <div class="hero-dec-bottom"></div>
            </div>
            <!-- slide end -->
            <div class="left-arrow"><i class="bx bxs-left-arrow"></i></div>
            <div class="right-arrow"><i class="bx bxs-right-arrow"></i></div>
        </div>
   </section>
   <!--  home slider end -->
   <section class="thumb">
   <div class="box-container">
    <div class="box">
    <img src="https://cdn1.totalcommerce.cloud/normaco/product-zoom/es/kit-desconectar-para-conectar-agenda-premium-%2B-resaltadores-pastel-1.webp" width="300" class="box-image" >
    <h3>Green tea</h3>
      <p>Lorem, ipsum dolor sit amet consectetur adipisicing elit.</p>
      <i class = "bx bx-chevron-right"></i>
    </div>
    <div class="box">
    <img src="https://cdn1.totalcommerce.cloud/normaco/product-zoom/es/cuaderno-cosido-100-hojas-linea-corriente-memes-_-tareas-1.webp"  width="300" class="box-image" >
    <h3>Green tea</h3>
      <p>Lorem, ipsum dolor sit amet consectetur adipisicing elit.</p>
      <i class = "bx bx-chevron-right"></i>
    </div>
    <div class="box">
    <img src="https://cdn1.totalcommerce.cloud/normaco/product-zoom/es/marcadores-norma-lavables-gigantes-x10-1.webp" width="300" class="box-image" >
    <h3>Green tea</h3>
      <p>Lorem, ipsum dolor sit amet consectetur adipisicing elit.</p>
      <i class = "bx bx-chevron-right"></i>
    </div>
    <div class="box">
    <img src="https://cdn1.totalcommerce.cloud/normaco/product-zoom/es/block-carta-linea-corriente-jean-book-clasico-claro-1.webp"width="300" class="box-image" >
    <h3>Green tea</h3>
      <p>Lorem, ipsum dolor sit amet consectetur adipisicing elit.</p>
      <i class = "bx bx-chevron-right"></i>
    </div>
  </div>

  <section class="container">
  <div class="box-container">
    <div class="box">
      <img src="https://i.ytimg.com/vi/KseVX4I8GbA/hq720.jpg?sqp=-oaymwEhCK4FEIIDSFryq4qpAxMIARUAAAAAGAElAADIQj0AgKJD&rs=AOn4CLDA9InWP6MCmf80Yzqr3_zLdOpPJA">
    </div>
    <div class="box">
      <img src="https://i.ytimg.com/vi/KseVX4I8GbA/hq720.jpg?sqp=-oaymwEhCK4FEIIDSFryq4qpAxMIARUAAAAAGAElAADIQj0AgKJD&rs=AOn4CLDA9InWP6MCmf80Yzqr3_zLdOpPJA">
      <span>healthy tea</span>
      <h1>save up to 58% off</h1>
      <p>Lorem ipsum dolor sit amet, consectetur adialiquip cincididunt ut labore et dolore</p>
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
    <div class="box">
    <img src="https://newellbrands.imgix.net/d4d0b531-415f-3f57-9a0a-6fe934536ea6/d4d0b531-415f-3f57-9a0a-6fe934536ea6.jpg?auto=format,compress&w=1188" width="100"class="box-image" >
    <a href="view_products.php"class = "btn">shop now</a>
    </div>
    <div class="box">
    <img src="https://newellbrands.imgix.net/6acc18b8-eac7-37ef-b016-ea25e91a7361/6acc18b8-eac7-37ef-b016-ea25e91a7361.tif?auto=format,compress&w=1188" width="100" class="box-image" >
    <a href="view_products.php"class = "btn">shop now</a>
    </div>
    <div class="box">
    <img src="https://newellbrands.imgix.net/57579c95-c08c-3ce8-9183-d565e0509671/57579c95-c08c-3ce8-9183-d565e0509671.tif?auto=format,compress&w=1188" width="100"class="box-image" >
    <a href="view_products.php"class = "btn">shop now</a>
    </div>
    <div class="box">
    <img src="https://newellbrands.imgix.net/57579c95-c08c-3ce8-9183-d565e0509671/57579c95-c08c-3ce8-9183-d565e0509671.tif?auto=format,compress&w=1188" width="50"class="box-image" >
    <a href="view_products.php"class = "btn">shop now</a>
    </div>
    <div class="box">
    <img src="https://newellbrands.imgix.net/91cb6e47-7926-3ffe-bc5b-0416aff1040e/91cb6e47-7926-3ffe-bc5b-0416aff1040e.tif?auto=format,compress&w=1188 "width="100" class="box-image" >
    <a href="view_products.php"class = "btn">shop now</a>
    </div>
    <div class="box">
      <img src="https://cdn1.totalcommerce.cloud/normaco/product-zoom/es/cuaderno-cosido-100-hojas-cuadriculado-memes-_-show-1.webp" width = "200" class="box-image">
      <a href="view_products.php"class = "btn">shop now</a>
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

/** 
<section class="services">
  <div class="box-container">
    <div class="box">
      <img src="img/icon2.png">
      <div class="detail">
        <h3>great savings</h3>
        <p>save big every order</p>
      </div>
    </div>
    <div class="box">
      <img src="img/icon2.png">
      <div class="detail">
        <h3>great savings</h3>
        <p>save big every order</p>
      </div>
    </div>
    <div class="box">
      <img src="img/icon2.png">
      <div class="detail">
        <h3>great savings</h3>
        <p>save big every order</p>
      </div>
    </div>
    <div class="box">
      <img src="img/icon2.png">
      <div class="detail">
        <h3>great savings</h3>
        <p>save big every order</p>
      </div>
    </div>
  </div>
</section>

*/







    <?php include 'components/footer.php' ; ?>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js"></script>
    <script src="script.js"></script>
    <?php include 'components/alert.php'; ?>
</body>
</html>


