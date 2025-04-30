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
        exit; // Salir para evitar que el código HTML se procese
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
        /* Aquí van tus estilos */
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
