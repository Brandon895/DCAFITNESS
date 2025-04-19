<?php
// views/editarUsuario.php
require_once('../controllers/UsuarioController.php');

$controller = new UsuarioController();
$id = $_GET['id'];
$usuarios = $controller->obtenerUsuarios();

$usuario = null;
foreach ($usuarios as $u) {
    if ($u['id'] == $id) {
        $usuario = $u;
        break;
    }
}

if (!$usuario) {
    echo "Usuario no encontrado.";
    exit;
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nombre = $_POST['nombre'];
    $nombreusuario = $_POST['nombreusuario'];
    $password = $_POST['password'];
    $rol = $_POST['rol'];

    $controller->editarUsuario($id, $nombre, $nombreusuario, $password, $rol);

    header('Location: vistaUsuarios.php');
    exit;
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Usuario</title>
    <style>
        /* Estilo general del cuerpo */
        body {
            background-color: #f9f9f9;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            color: #333;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
        }

        /* Contenedor principal */
        .container {
            max-width: 700px;
            width: 100%; /* Asegura que el contenedor ocupe todo el espacio necesario */
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
            width: 100%; /* Asegura que el campo de formulario ocupe el ancho completo */
        }

        .form-control:focus {
            border-color: #43d74f;
            box-shadow: 0 0 5px rgba(67, 215, 79, 0.5);
        }

        /* Estilo de los botones */
        .btn {
            font-weight: bold;
            border: none;
            padding: 12px 20px;
            border-radius: 10px;
            transition: background-color 0.3s ease;
            text-align: center;
        }

        /* Estilo del botón "Guardar cambios" */
        .btn-custom {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; /* Asegura la misma fuente en todos los botones */
            font-size: 16px; /* Asegura que el tamaño de la letra sea el mismo */
            font-weight: bold; /* Asegura que el peso de la letra sea el mismo */
            background-color: #43d74f;
            color: white;
            display: inline-block;
            width: auto;
            
        }

        .btn-custom:hover {
            background-color: #34c34f;
        }

        /* Estilo del botón "Cancelar" */
        .btn-cancel {
            background-color: #e74c3c; /* Rojo */
            color: white;
            display: inline-block;
            width: auto;
            text-decoration: none; /* Quitar subrayado */
        }

        .btn-cancel:hover {
            background-color: #c0392b;
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
        <div class="card-header">
            Editar Usuario
        </div>
        <div class="card-body">
            <form method="POST">
                <div class="form-group">
                    <label for="nombre" class="form-label">Nombre Completo:</label>
                    <input type="text" class="form-control" name="nombre" value="<?php echo isset($usuario['nombre']) ? $usuario['nombre'] : ''; ?>" required>
                </div>

                <div class="form-group">
                    <label for="nombreusuario" class="form-label">Nombre de Usuario:</label>
                    <input type="text" class="form-control" name="nombreusuario" value="<?php echo isset($usuario['nombreusuario']) ? $usuario['nombreusuario'] : ''; ?>" required>
                </div>

                <div class="form-group">
                    <label for="password" class="form-label">Contraseña:</label>
                    <input type="password" class="form-control" name="password" value="<?php echo isset($usuario['password']) ? $usuario['password'] : ''; ?>" required>
                </div>

                <div class="form-group">
                    <label for="rol" class="form-label">Rol del usuario:</label>
                    <input type="text" class="form-control" name="rol" value="<?php echo isset($usuario['rol']) ? $usuario['rol'] : ''; ?>" required>
                </div>

                <!-- Botones centrados con más espacio entre ellos -->
                <div style="display: flex; justify-content: space-between; gap: 10px;">
                    <button type="submit" class="btn btn-custom" style="width: 48%;">Guardar cambios</button>
                    <a href="vistaUsuarios.php" class="btn btn-cancel" style="width: 48%;">Cancelar</a>
                </div>
            </form>
        </div>
    </div>
</div>

</body>
</html>
