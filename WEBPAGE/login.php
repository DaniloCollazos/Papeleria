<?php
include 'components/connection.php';
session_start();
// Verifica si ya existe una sesión activa
if (isset($_SESSION['id_usuario'])) {
    header('Location: home.php');  // Redirige al inicio si ya está logueado
    exit();
}
if (isset($_POST['submit'])) {
    // Capturar y sanitizar los campos del formulario
    $email = filter_input(INPUT_POST, 'correo', FILTER_SANITIZE_EMAIL); // Sanitizar el correo
    $pass = $_POST['contrasena']; // La contraseña no necesita ser sanitizada

    // Validación de los campos
    if (empty($email) || empty($pass)) {
        $message[] = 'Por favor, ingresa tu correo y contraseña.';
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $message[] = 'Correo electrónico no válido.';
    } else {
        try {
            // Consulta para verificar si el email existe en la base de datos
            $select_user = $conn->prepare("SELECT * FROM users WHERE correo = ?");
            $select_user->execute([$email]);

            if ($select_user->rowCount() > 0) {
                $row = $select_user->fetch(PDO::FETCH_ASSOC);

                // Verificar si la contraseña ingresada coincide con el hash almacenado en la base de datos
                if (password_verify($pass, $row['contrasena'])) {
                    // Iniciar sesión
                    $_SESSION['id_usuario'] = $row['id_usuario'];
                    $_SESSION['nombre'] = $row['nombre'];
                    $_SESSION['correo'] = $row['correo'];
                    $_SESSION['id_rol'] = $row['id_rol']; // Agregar el rol del usuario a la sesión

                    // Redirigir según el rol del usuario
                    if ($row['id_rol'] == 1) { // 1 es Administrador
                        header('Location: admin.php');
                    } else { // 2 es Cliente
                        header('Location: home.php');
                    }
                    exit();
                } else {
                    $message[] = 'Usuario o contraseña incorrecta.';
                }
            } else {
                $message[] = 'Usuario o contraseña incorrecta.';
            }
        } catch (PDOException $e) {
            $message[] = 'Error al iniciar sesión: ' . $e->getMessage();
        }
    }
}



?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bolifans - Iniciar Sesión</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="main-container">
        <section class="form-container">
            <h1>Iniciar sesión</h1>
            <p>Ingresa tus credenciales para acceder a tu cuenta.</p>
            <form action="" method="post">
                <input type="email" name="correo" required placeholder="Tu correo" maxlength="50">
                <input type="password" name="contrasena" required placeholder="Tu contraseña" maxlength="50">
                <input type="submit" name="submit" value="Iniciar sesión" class="btn">
                <p>¿No tienes una cuenta? <a href="register.php">Registrarse aquí</a></p>
            </form>
            <?php
            if (isset($message)) {
                foreach ($message as $msg) {
                    echo '<p class="error-message">' . $msg . '</p>';
                }
            }
            ?>
        </section>
    </div>
</body>
</html>
