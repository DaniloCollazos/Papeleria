<?php
// Incluye el archivo de conexión a la base de datos
include 'components/connection.php';
// Inicia una sesión
session_start();
// Verifica si existe una sesión de usuario
if (isset($_SESSION['user_id'])) {
    // Si existe, asigna el ID del usuario a una variable
    $user_id = $_SESSION['user_id'];
} else {
    // Si no existe, asigna un valor vacío al ID del usuario
    $user_id = '';
}
// Sección para iniciar sesión
if (isset($_POST['submit'])) {
    // Obtiene los datos del formulario (email y contraseña) y los sanitiza
    $email = $_POST['email'];
    $email = filter_var($email, FILTER_SANITIZE_EMAIL);  // Sanitiza el correo
    $pass = $_POST['pass'];
    $pass = filter_var($pass, FILTER_SANITIZE_STRING);  // Sanitiza la contraseña

    // Validar los campos
    if (empty($email) || empty($pass)) {
        $message[] = 'Por favor, ingresa tu correo y contraseña.';
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $message[] = 'Correo electrónico no válido.';
    } else {
        // Preparar la consulta para verificar si el email existe en la base de datos
        $select_user = $conn->prepare("SELECT * FROM users WHERE email = ?");
        $select_user->execute([$email]);

        if ($select_user->rowCount() > 0) {
            // Si existe un usuario con ese correo, obtenemos los datos
            $row = $select_user->fetch(PDO::FETCH_ASSOC);

            // Verificar si la contraseña ingresada es correcta usando password_verify
            if (password_verify($pass, $row['password'])) {
                // Si la contraseña es correcta, iniciamos sesión
                $_SESSION['user_id'] = $row['id'];
                $_SESSION['user_name'] = $row['name'];
                $_SESSION['user_email'] = $row['email'];
                header('Location: home.php');  // Redirigir al inicio
                exit();  // Detener el flujo después de redirigir
            } else {
                $message[] = 'Usuario o contraseña incorrecta.';
            }
        } else {
            $message[] = 'Usuario o contraseña incorrecta.';
        }
    }
}

?>


<style type="text/css">
    <?php include 'style.css'; ?>
</style>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bolifans - Registrarse</title>
</head>
<body>
    <div class="main-container">
        <section class="form-container">
            <div class="title">
                <img src="">
                <h1>Registrarse</h1>
                <p>Lorem ipsum, dolor sit amet consectetur adipisicing elit.</p>
            </div>
            <form action="" method="post">
                <div class="input-field">
                    <p>Tu nombre <sup>*</sup></p>
                    <input type="text" name="name" required placeholder="Ingrese su nombre" maxlength="50">
                </div>
                <div class="input-field">
                    <p>Tu correo <sup>*</sup></p>
                    <input type="email" name="email" required placeholder="Ingrese su correo" maxlength="50"
                        oninput="this.value = this.value.replace(/\s/g, '')">
                </div>
                <div class="input-field">
                    <p>Tu contraseña <sup>*</sup></p>
                    <input type="password" name="pass" required placeholder="Ingrese su contraseña" maxlength="50"
                        oninput="this.value = this.value.replace(/\s/g,'')">
                </div>
                <div class="input-field">
                    <p>Confirmar contraseña <sup>*</sup></p>
                    <input type="cpassword" name="cpass" required placeholder="Confirme su contraseña" maxlength="50"
                        oninput="this.value = this.value.replace(/\s/g, '')">
                </div>
                <input type="submit" name="submit" value="Registrarse ahora" class="btn">
                <p>Ya tienes una cuenta? <a href="login.php">Iniciar sesión</a></p>
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
</
