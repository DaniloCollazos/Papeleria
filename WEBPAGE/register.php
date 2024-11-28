<?php
// Incluye el archivo de conexión a la base de datos
include 'components/connection.php';

// Definir el arreglo de mensajes
$message = [];

// Lógica de registro de usuario
if (isset($_POST['submit'])) {
    // Capturar los valores de los campos del formulario
    $name = $_POST['nombre'];
    $direccion = $_POST['direccion'];
    $telefono = $_POST['telefono'];
    // Sanitizar y validar el correo electrónico
    if (isset($_POST['correo'])) {
        $email = filter_var($_POST['correo'], FILTER_SANITIZE_EMAIL);  // Sanitizar el correo
    } else {
        $message[] = 'El correo no ha sido enviado.';
    }
    // Validar el correo electrónico
    if (empty($email)) {
        $message[] = 'Por favor, ingresa tu correo electrónico.';
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $message[] = 'Correo electrónico no válido.';
    }
    
    
    // Validar las contraseñas
    $pass = $_POST['contrasena'];
    $cpass = $_POST['ccontrasena'];

    if (empty($name) || empty($email) || empty($pass) || empty($cpass)) {
        $message[] = 'Por favor, ingresa todos los campos.';
    } elseif ($pass !== $cpass) {
        $message[] = 'Las contraseñas no coinciden.';
    } else {
        try {
            // Verificar si el correo ya está registrado
            $select_user = $conn->prepare("SELECT * FROM users WHERE correo = ?");
            $select_user->execute([$email]);
            if ($select_user->rowCount() > 0) {
                $message[] = 'El correo electrónico ya está registrado.';
            } else {
                // Hashear la contraseña
                $hashed_pass = password_hash($pass, PASSWORD_DEFAULT);

                // Insertar nuevo usuario
                $insert_user = $conn->prepare("INSERT INTO users (nombre, correo, contrasena, telefono, direccion) VALUES (?, ?, ?, ?, ?)");
                $insert_user->execute([$name, $email, $hashed_pass, $telefono, $direccion]);
                $message[] = 'Usuario registrado correctamente. Ahora puedes iniciar sesión.';
            }
        } catch (PDOException $e) {
            $message[] = 'Error al registrar: ' . $e->getMessage();
        }
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bolifans - Registrarse</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="main-container">
        <section class="form-container">
            <h1>Registrarse</h1>
            <p>Crea una cuenta para disfrutar de todos nuestros beneficios.</p>
            <form action="" method="POST">
                <input type="text" name="nombre" required placeholder="Tu nombre" maxlength="50">
                <input type="text" name="direccion" required placeholder="Tu dirección" maxlength="50">
                <input type="text" name="telefono" required placeholder="Tu teléfono" maxlength="50">
                <input type="email" name="correo" required placeholder="Tu correo" maxlength="50">
                <input type="password" name="contrasena" required placeholder="Tu contraseña" maxlength="50">
                <input type="password" name="ccontrasena" required placeholder="Confirmar contraseña" maxlength="50">
                <input type="submit" name="submit" value="Registrarse ahora" class="btn">
                <p>¿Ya tienes una cuenta? <a href="login.php">Inicia sesión aquí</a></p>
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
    </div>
</body>
</html>
