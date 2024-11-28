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

if (isset($_POST['submit'])) {
    $nombre_producto = $_POST['nombre_producto'];
    $descripcion = $_POST['descripcion'];
    $precio = $_POST['precio'];
    $id_foto = $_POST['id_foto'];
    $categoria = $_POST['categoria'];

    // Prepare the SQL statement
    $insert_product = $conn->prepare("INSERT INTO productos (nombre_producto, descripcion, precio, id_categoria, id_foto,)
                                      VALUES (?, ?, ?, ?, ?)");
    // Check if the statement was prepared successfully
    if ($insert_product) {
        // Bind parameters
        $insert_product->bind_param("ssssd", $nombre_producto, $descripcion, $precio, $categoria, $id_foto);

        // Execute the statement
        if ($insert_product->execute()) {
            $message[] = "Producto agregado correctamente.";
        } else {
            $message[] = "Error al agregar el producto: " . $insert_product->error;
        }
        $insert_product->close();
    } else {
        // Handle error if the statement could not be prepared
        $message[] = "Error al preparar la sentencia: " . $conn->error;
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
    <title>Bolifans - Panel Admin</title>
</head>
<body>
<?php include 'components/headeradmin.php'; ?>
<div class="main">
  <div class="banner">
    <h1>Carrito</h1>
  </div>
  <section class="form-container">
            <h1>Agregar producto</h1>
            <form action="" method="POST">
                <input type="text" name="nombre_producto" required placeholder="nombre del producto" maxlength="50">
                <input type="text" name="descripcion" required placeholder="descripcion del producto" maxlength="50">
                <input type="text" name="precio" required placeholder="precio" maxlength="50">
                <input type="text" name="id_foto" required placeholder="URL" maxlength="50">
                <input type="text" name="categoria" required placeholder="Categoria" maxlength="50">
                <input type="submit" name="submit" value="Enviar" class="btn">
            </form>
            <?php
            // Mostrar los mensajes
            if (isset($message)) {
                foreach ($message as $msg) {
                    echo '<p class="error-message">' . $msg . '</p>';
                }
            }
            ?>
        </section>
<?php include 'components/footer.php' ; ?>
<script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js"></script>
<script src="script.js"></script>
<?php include 'components/alert.php'; ?>
</body>
</html>