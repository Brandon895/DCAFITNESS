<?php
session_start();
if (isset($_SESSION['usuario'])) {
    header("Location: dashboard.php"); // Si el usuario ya está logueado, lo redirigimos
    // Login exitoso (ejemplo)
$_SESSION['id_usuario'] = $id;
$_SESSION['nombreusuario'] = $usuario;

BitacoraAccesosModel::registrarAcceso($id, $usuario, 'Inicio de sesión');

    exit();
}

$error = isset($_GET['error']) ? $_GET['error'] : '';
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Mi Gimnasio</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">

    <style>
        body {
            background-image: url('../assets/img/imgdcafitness.jpg.jpg');
            background-size: cover;
            background-position: center;
            height: 100vh;
            margin: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            font-family: 'Roboto', sans-serif;
            overflow: hidden;
        }

        .overlay {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.5);
            z-index: 1;
        }

        .login-form {
            background-color: rgba(0, 0, 0, 0.7);
            padding: 30px;
            border-radius: 15px;
            box-shadow: 0px 4px 15px rgba(0, 0, 0, 0.3);
            max-width: 400px;
            width: 100%;
            z-index: 2;
            position: relative;
        }

        h2 {
            color: #FFDD00;
            font-size: 2.5rem;
            text-align: center;
            margin-bottom: 30px;
        }

        .form-control {
            background-color: #333;
            border-color: #00FF00;
            color: #fff;
            border-radius: 10px;
            margin-bottom: 20px;
            padding: 12px;
            font-size: 1rem;
        }

        .form-control:focus {
            background-color: #444;
            border-color: #FFDD00;
            box-shadow: 0 0 5px rgba(255, 221, 0, 0.7);
        }

        .btn-primary {
            background-color: #FFDD00;
            border-color: #FFDD00;
            color: #000;
            padding: 12px;
            font-size: 1.1rem;
            width: 100%;
            border-radius: 10px;
            transition: background-color 0.3s ease, border-color 0.3s ease;
        }

        .btn-primary:hover {
            background-color: #00FF00;
            border-color: #00FF00;
        }

        .text-danger {
            color: #FF0000;
            font-weight: bold;
            text-align: center;
            margin-top: 10px;
        }

        .text-center {
            text-align: center;
        }

        .text-center a {
            color: #00FF00;
            text-decoration: none;
        }

        .text-center a:hover {
            color: #FFDD00;
            text-decoration: underline;
        }
    </style>
</head>
<body>
    <div class="overlay"></div>

    <div class="login-form">
        <h2>Iniciar Sesión</h2>

        <?php if (!empty($error)) echo "<p class='text-danger'>$error</p>"; ?>

        <form action="../controllers/LoginController.php" method="POST" autocomplete="off">
            <div class="mb-3">
                <label for="username" class="form-label">Usuario:</label>
                <input type="text" name="username" class="form-control" autocomplete="off" required>
            </div>

            <div class="mb-3">
                <label for="password" class="form-label">Contraseña:</label>
                <input type="password" name="password" class="form-control" autocomplete="new-password" required>
            </div>

            <button type="submit" class="btn btn-primary">Ingresar</button>
        </form>
    </div>
</body>
</html>
