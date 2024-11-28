
<header class="header">
    <div class="flex">
        <a href="home.php" class="logo">
            <img src="https://www.zarla.com/images/zarla-bolifans-1x1-2400x2400-20211206-td9rrt67ggxmwwjhh8f6.png?crop=1:1,smart&width=250&dpr=2" width="100">
        </a>
        <nav class="navbar">
            <a href="agregarproductos.php">Agregar Productos</a>
            <a href="view_clients.php">Ver clientes</a>
            <a href="view_user.php">Ver usuarios</a>
            <a href="about.php">About Us</a>
            <a href="contact.php">Contact Us</a>
        </nav>
        <div class="icons">
            <i class="bx bxs-user" id="user-btn"></i>
            
            <?php
            $count_wishlist_items = $conn->prepare("SELECT * FROM wishlist WHERE id_usuario=?");
            $count_wishlist_items->execute([$user_id]);
            $total_wishlist_items = $count_wishlist_items->rowCount();
            ?>
            <a href="wishlist.php" class="cart-btn"><i class="bx bx-heart"></i><sup><?=$total_wishlist_items?></sup></a>
            
            <?php
            $count_cart_items = $conn->prepare("SELECT * FROM cart WHERE id_usuario=?");
            $count_cart_items->execute([$user_id]);
            $total_cart_items = $count_cart_items->rowCount();
            ?>

            <a href="cart.php" class="cart-btn"><i class="bx bx-cart-download"></i><sup><?=$total_cart_items?></sup></a>
            <i class="bx bx-list-plus" id="menu-btn" style="font-size: 2rem;"></i>
        </div>
        <div class="user-btn">
            <?php if (isset($_SESSION['nombre']) && isset($_SESSION['correo'])): ?>
                <!-- Si el usuario está logueado, mostrar su información y el logout -->
                <p>username: <span><?php echo $_SESSION['nombre']; ?></span></p>
                <p>email: <span><?php echo $_SESSION['correo']; ?></span></p>
                <form method="post">
                    <button type="submit" name="logout" class="logout-btn">Cerrar sesión</button>
                </form>
            <?php else: ?>
                <!-- Si el usuario no está logueado, mostrar los botones de login y register -->
                <a href="login.php" class="btn">login</a>
                <a href="register.php" class="btn">register</a>
            <?php endif; ?>
        </div>
    </div>
</header>

<?php
// Si se hace clic en el botón de logout, destruir la sesión y redirigir
if (isset($_POST['logout'])) {
    session_unset(); // Elimina todas las variables de sesión
    session_destroy(); // Destruye la sesión
    header("Location: login.php"); // Redirige al login
    exit();
}
?>
