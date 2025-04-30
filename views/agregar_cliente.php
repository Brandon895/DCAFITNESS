<?php
require_once '../controllers/ClienteController.php';

$clienteController = new ClienteController();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Recibir y sanitizar los datos del formulario
    $data = [
        'cedula'             => $_POST['cedula'],
        'nombre'             => $_POST['nombre'],
        'apellidos'          => $_POST['apellidos'],
        'direccion'          => $_POST['direccion'],
        'telefono'           => $_POST['telefono'],
        'correo_electronico' => $_POST['correo_electronico'],
        'fecha_nacimiento'   => $_POST['fecha_nacimiento'],
        'estado_membresia'   => $_POST['estado_membresia'],
        'tipo_membresia'     => $_POST['tipo_membresia'],
        'fecha_vencimiento'  => $_POST['fecha_vencimiento']
    ];

    // Verificar si los datos son válidos
    if (empty($data['cedula']) || empty($data['nombre'])) {
        $mensaje = "Por favor, complete todos los campos obligatorios.";
    } else {
        // Intentar guardar el cliente
        $resultado = $clienteController->agregarCliente($data);

        if ($resultado) {
            // Si se guarda correctamente, redirigir
            header("Location: clientes.php?mensaje=Cliente agregado correctamente");
            exit();
        } else {
            // Si hubo un error en la base de datos
            $mensaje = "Error al guardar cliente. Por favor, inténtelo de nuevo.";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Agregar Nuevo Cliente</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet">
    <style>
        body {
            background: linear-gradient(135deg, rgb(44, 241, 9), rgb(247, 251, 21));
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            min-height: 100vh;
        }

        .form-container {
            background-color: #ffffff;
            border-radius: 20px;
            padding: 40px;
            max-width: 700px;
            margin: 80px auto;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.2);
        }

        h2 {
            font-weight: bold;
            color: #2f8f2f;
            text-align: center;
            margin-bottom: 30px;
        }

        .form-label {
            font-weight: 600;
        }

        .btn-primary {
            background-color: #28a745;
            border: none;
            font-size: 18px;
            padding: 10px 25px;
        }

        .btn-danger {
            background-color: rgb(232, 13, 13);
            border: none;
            color: #fff;
            font-size: 18px;
            padding: 10px 25px;
        }

        .button-group {
            display: flex;
            justify-content: center;
            gap: 20px;
            margin-top: 30px;
        }
    </style>
</head>
<body>
    <div class="form-container">
        <h2><i class="fas fa-user-plus"></i> Agregar Nuevo Cliente</h2>
        <?php if (isset($mensaje)) { echo '<div class="alert alert-danger">' . $mensaje . '</div>'; } ?>
        <form method="POST" action="agregar_cliente.php">
            <div class="mb-3">
                <label class="form-label" for="cedula">Cédula</label>
                <input type="text" id="cedula" name="cedula" class="form-control" required>
            </div>
            <div class="mb-3">
                <label class="form-label" for="nombre">Nombre</label>
                <input type="text" id="nombre" name="nombre" class="form-control" required>
            </div>
            <div class="mb-3">
                <label class="form-label" for="apellidos">Apellidos</label>
                <input type="text" id="apellidos" name="apellidos" class="form-control" required>
            </div>
            <div class="mb-3">
                <label class="form-label" for="direccion">Dirección</label>
                <input type="text" id="direccion" name="direccion" class="form-control">
            </div>
            <div class="mb-3">
                <label class="form-label" for="telefono">Teléfono</label>
                <input type="text" id="telefono" name="telefono" class="form-control">
            </div>
            <div class="mb-3">
                <label class="form-label" for="correo_electronico">Correo Electrónico</label>
                <input type="email" id="correo_electronico" name="correo_electronico" class="form-control" required>
            </div>
            <div class="mb-3">
                <label class="form-label" for="fecha_nacimiento">Fecha de Nacimiento</label>
                <input type="date" id="fecha_nacimiento" name="fecha_nacimiento" class="form-control">
            </div>
            <div class="mb-3">
                <label class="form-label" for="estado_membresia">Estado Membresía</label>
                <select id="estado_membresia" name="estado_membresia" class="form-select">
                    <option value="Activa">Activa</option>
                    <option value="Inactiva">Inactiva</option>
                </select>
            </div>
            <div class="mb-3">
                <label class="form-label" for="tipo_membresia">Tipo de Membresía</label>
                <input type="text" id="tipo_membresia" name="tipo_membresia" class="form-control">
            </div>
            <div class="mb-3">
                <label class="form-label" for="fecha_vencimiento">Fecha de Vencimiento</label>
                <input type="date" id="fecha_vencimiento" name="fecha_vencimiento" class="form-control">
            </div>
            <div class="button-group">
                <button type="submit" class="btn btn-primary">
                    <i class="fas fa-save"></i> Guardar Cliente
                </button>
                <a href="clientes.php" class="btn btn-danger">
                    <i class="fas fa-times"></i> Cancelar
                </a>
            </div>
        </form>
    </div>
</body>
</html>
