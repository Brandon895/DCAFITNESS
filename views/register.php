<?php
$error = isset($_GET['error']) ? $_GET['error'] : '';
$success = isset($_GET['success']) ? $_GET['success'] : '';
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Registro - Mi Gimnasio</title>
</head>
<body>
    <h2>Registro de Usuario</h2>

    <?php if (!empty($error)) echo "<p style='color:red;'>$error</p>"; ?>
    <?php if (!empty($success)) echo "<p style='color:green;'>$success</p>"; ?>

    <form action="../controllers/registerController.php" method="POST" autocomplete="off">
        <label for="username">Usuario:</label>
        <input type="text" name="username" autocomplete="off" required><br>

        <label for="password">Contraseña:</label>
        <input type="password" name="password" autocomplete="new-password" required><br>

        <button type="submit">Registrarse</button>
    </form>

    <p>¿Ya tienes una cuenta? <a href="loguin.php">Inicia sesión aquí</a></p>
</body>
</html>
