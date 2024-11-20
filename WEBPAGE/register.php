<?php
// Incluye el archivo de conexión a la base de datos
include 'components/connection.php';
// Lógica de registro de usuario
if (isset($_POST['submit'])) {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $email = filter_var($email, FILTER_SANITIZE_EMAIL);  // Sanitiza el correo
    $pass = $_POST['pass'];
    $cpass = $_POST['cpass'];
    $pass = filter_var($pass, FILTER_SANITIZE_STRING);  // Sanitiza la contraseña
    // Validar los campos
    if (empty($name) || empty($email) || empty($pass) || empty($cpass)) {
        $message[] = 'Por favor, ingresa todos los campos.';
    } elseif ($pass !== $cpass) {
        $message[] = 'Las contraseñas no coinciden.';
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $message[] = 'Correo electrónico no válido.';
    } else {
        try {
            // Verificar si el correo ya está registrado
            $select_user = $conn->prepare("SELECT * FROM users WHERE email = ?");
            $select_user->execute([$email]);
            if ($select_user->rowCount() > 0) {
                $message[] = 'El correo electrónico ya está registrado.';
            } else {
                // Hash de la contraseña
                $hashed_pass = password_hash($pass, PASSWORD_DEFAULT);
                // Insertar nuevo usuario
                $insert_user = $conn->prepare("INSERT INTO users (name, email, password) VALUES (?, ?, ?)");
                $insert_user->execute([$name, $email, $hashed_pass]);
                $message[] = 'Usuario registrado correctamente. Ahora puedes iniciar sesión.';
            }
        } catch (PDOException $e) {
            $message[] = 'Error al registrar: ' . $e->getMessage();
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
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
                <input type="text" name="name" required placeholder="Tu nombre" maxlength="50">
                <input type="email" name="email" required placeholder="Tu correo" maxlength="50">
                <input type="password" name="pass" required placeholder="Tu contraseña" maxlength="50">
                <input type="password" name="cpass" required placeholder="Confirmar contraseña" maxlength="50">
                <input type="submit" name="submit" value="Registrarse ahora" class="btn">
                <p>¿Ya tienes una cuenta? <a href="login.php">Inicia sesión aquí</a></p>
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
