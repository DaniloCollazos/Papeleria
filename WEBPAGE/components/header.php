
<header class="header">
    <div class="flex">
        <a href="home.php" class="logo">
            <img src="https://www.zarla.com/images/zarla-bolifans-1x1-2400x2400-20211206-td9rrt67ggxmwwjhh8f6.png?crop=1:1,smart&width=250&dpr=2" width="100">
        </a>
        <nav class="navbar">
            <a href="home.php">Home</a>
            <a href="view_products.php">Products</a>
            <a href="order.php">Orders</a>
            <a href="about.php">About Us</a>
            <a href="contact.php">Contact Us</a>
        </nav>
        <div class="icons">
            <i class="bx bxs-user" id="user-btn"></i>
            <a href="wishlist.php" class="cart-btn"><i class="bx bx-heart"></i><sup>0</sup></a>
            <a href="cart.php" class="cart-btn"><i class="bx bx-cart-download"></i><sup>0</sup></a>
            <i class="bx bx-list-plus" id="menu-btn" style="font-size: 2rem;"></i>
        </div>
        <div class="user-btn">
            <?php if (isset($_SESSION['user_name']) && isset($_SESSION['user_email'])): ?>
                <!-- Si el usuario está logueado, mostrar su información y el logout -->
                <p>username: <span><?php echo $_SESSION['user_name']; ?></span></p>
                <p>email: <span><?php echo $_SESSION['user_email']; ?></span></p>
                <form method="post">
                    <button type="submit" name="logout" class="logout-btn">log out</button>
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
