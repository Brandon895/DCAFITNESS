<?php
// views/registrarUsuario.php
require_once('../controllers/UsuarioController.php');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Validar los campos antes de procesar
    $nombre = trim($_POST['nombre']);
    $usuario = trim($_POST['usuario']);
    $password = $_POST['password'];
    $rol = trim($_POST['rol']);

    if (empty($nombre) || empty($usuario) || empty($password) || empty($rol)) {
        $error = "Todos los campos son obligatorios.";
    } else {
        $controller = new UsuarioController();
        // Procesar el registro del usuario
        $controller->registrarUsuario($nombre, $usuario, $password, $rol);
        header('Location: vistaUsuarios.php');
        exit;
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registrar Usuario</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        /* Estilo general del cuerpo */
        body {
            background-color: #f9f9f9;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            color: #333;
        }

        /* Contenedor principal */
        .container {
            max-width: 700px;
            margin-top: 80px;
        }

        /* Estilo de la tarjeta */
        .card {
            border: none;
            border-radius: 15px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
            background: linear-gradient(135deg, #f5b500, #43d74f);
        }

        .card-header {
            background-color: transparent;
            color: white;
            text-align: center;
            font-size: 24px;
            font-weight: bold;
            padding: 30px;
            text-transform: uppercase;
            letter-spacing: 1px;
        }

        .card-body {
            background-color: #ffffff;
            border-radius: 0 0 15px 15px;
            padding: 40px 30px;
        }

        /* Estilo de los campos de formulario */
        .form-label {
            font-weight: bold;
            font-size: 16px;
        }

        .form-control {
            border-radius: 10px;
            border: 1px solid #ddd;
            box-shadow: none;
            padding: 12px;
            margin-bottom: 20px;
        }

        .form-control:focus {
            border-color: #43d74f;
            box-shadow: 0 0 5px rgba(67, 215, 79, 0.5);
        }

        /* Botón de registro */
        .btn-custom {
            background-color: #43d74f;
            color: white;
            font-weight: bold;
            border: none;
            padding: 12px;
            border-radius: 8px;
            transition: background-color 0.3s ease;
        }

        .btn-custom:hover {
            background-color: #34c34f;
        }

        /* Animación de entrada para la tarjeta */
        .card {
            animation: fadeIn 1s ease-in-out;
        }

        @keyframes fadeIn {
            0% {
                opacity: 0;
                transform: translateY(30px);
            }
            100% {
                opacity: 1;
                transform: translateY(0);
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="card">
            <div class="card-header">Registrar Nuevo Usuario</div>
            <div class="card-body">
                <form method="POST" autocomplete="off">
                    <!-- Mostrar error si existe -->
                    <?php if (isset($error)) { ?>
                        <div class="alert alert-danger"><?php echo $error; ?></div>
                    <?php } ?>

                    <div class="mb-4">
                        <label for="nombre" class="form-label">Nombre Completo:</label>
                        <input type="text" class="form-control" name="nombre" required value="" autocomplete="off">
                    </div>
                   
                    <div class="mb-4">
                        <label for="usuario" class="form-label">Nombre Usuario:</label>
                        <input type="text" class="form-control" name="usuario" required value="" autocomplete="off">
                    </div>

                    <div class="mb-4">
                        <label for="password" class="form-label">Contraseña:</label>
                        <input type="password" class="form-control" name="password" required value="" autocomplete="off">
                    </div>

                    <div class="mb-4">
                        <label for="rol" class="form-label">Rol del Usuario:</label>
                        <input type="text" class="form-control" name="rol" required value="" autocomplete="off">
                    </div>

                    <button type="submit" class="btn btn-custom w-100">Registrar Usuario</button>
                </form>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
