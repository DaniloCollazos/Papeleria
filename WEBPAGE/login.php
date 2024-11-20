<?php
// Incluye el archivo de conexión a la base de datos
include 'components/connection.php';

// Inicia una sesión
session_start();

// Verifica si ya existe una sesión activa
if (isset($_SESSION['user_id'])) {
    header('Location: home.php');  // Redirige al inicio si ya está logueado
    exit();
}

// Lógica de inicio de sesión
if (isset($_POST['submit'])) {
    $email = $_POST['email'];
    $email = filter_var($email, FILTER_SANITIZE_EMAIL);  // Sanitiza el correo
    $pass = $_POST['pass'];
    $pass = filter_var($pass, FILTER_SANITIZE_STRING);  // Sanitiza la contraseña

    if (empty($email) || empty($pass)) {
        $message[] = 'Por favor, ingresa tu correo y contraseña.';
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $message[] = 'Correo electrónico no válido.';
    } else {
        try {
            // Consulta para verificar si el email existe en la base de datos
            $select_user = $conn->prepare("SELECT * FROM users WHERE email = ?");
            $select_user->execute([$email]);

            if ($select_user->rowCount() > 0) {
                $row = $select_user->fetch(PDO::FETCH_ASSOC);

                // Verificar contraseña
                if (password_verify($pass, $row['password'])) {
                    // Si la contraseña es correcta, iniciar sesión
                    $_SESSION['user_id'] = $row['id'];
                    $_SESSION['user_name'] = $row['name'];
                    $_SESSION['user_email'] = $row['email'];
                    header('Location: home.php');  // Redirigir al home
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
<html lang="en">
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
                <input type="email" name="email" required placeholder="Tu correo" maxlength="50">
                <input type="password" name="pass" required placeholder="Tu contraseña" maxlength="50">
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
