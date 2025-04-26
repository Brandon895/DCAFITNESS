<?php
include($_SERVER['DOCUMENT_ROOT'] . '/mi_gimnasio/DCAFITNESS/Proyecto/controllers/ClienteController.php');

$clienteController = new ClienteController();

$searchQuery = isset($_GET['buscar']) ? $_GET['buscar'] : '';

$clientes = $clienteController->buscarClientes($searchQuery); 

if (empty($clientes)) {
    echo "No hay clientes registrados.";
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Clientes</title>
    <!-- Agregar Bootstrap y FontAwesome para iconos -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
    <style>
        body {
            background: url('../assets/img/imgdcafitness.jpg') no-repeat center center fixed;
            background-size: cover;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            color: #ffffff;
        }

        .container {
            background: linear-gradient(45deg, #28a745, #ffc107); 
            padding: 40px;
            border-radius: 20px;
            box-shadow: 0px 10px 30px rgba(0, 0, 0, 0.1);
            margin-top: 50px;
            transition: all 0.3s ease;
        }

        .container:hover {
            transform: translateY(-10px);
            box-shadow: 0px 15px 50px rgba(0, 0, 0, 0.2);
        }

        .table thead {
            background-color: #28a745; 
            color: white;
            text-align: center;
            border-radius: 15px;
        }

        .table tbody tr:nth-of-type(odd) {
            background-color: #e2f9e2; 
        }

        .table tbody tr:nth-of-type(even) {
            background-color: #fff; 
        }

        .table tbody tr:hover {
            background-color: #d3f5d3; 
        }

        .btn-success {
            background-color: #28a745; 
            border: none;
            border-radius: 10px;
            padding: 12px 25px;
            font-size: 16px;
            transition: all 0.3s ease;
            color: white;
        }

        .btn-success:hover {
            background-color: #1e7e34;
            transform: scale(1.05);
        }

        .btn-danger {
            background-color: #dc3545; 
            border: none;
            border-radius: 10px;
            padding: 12px 25px;
            font-size: 16px;
            transition: all 0.3s ease;
            color: white;
        }

        .btn-danger:hover {
            background-color: #c82333;
            transform: scale(1.05);
        }

        .btn-info {
            background-color: #007bff; 
            border: none;
            border-radius: 10px;
            padding: 12px 25px;
            font-size: 16px;
            transition: all 0.3s ease;
            color: white;
        }

        .btn-info:hover {
            background-color: #0056b3;
            transform: scale(1.05);
        }

        .btn-container {
            display: flex;
            justify-content: space-between; 
            margin-top: 20px;
        }

        .form-search {
            width: 80%;
            margin: 20px auto;
        }

        .form-search input {
            width: 85%;
            padding: 10px;
            border-radius: 10px; 
            font-size: 16px;
        }

        .form-search button {
            width: 12%;
            padding: 10px;
            border-radius: 10px; 
            background-color: #ffc107; 
            color: white;
            border: none;
            font-size: 16px;
            transition: background-color 0.3s;
        }

        .form-search button:hover {
            background-color: #e0a800;
        }

        h2, h5 {
            text-align: center;
            font-weight: bold;
            color: #ffffff;
        }

        .table-bordered {
            border-radius: 15px;
            overflow: hidden;
        }

        .table-bordered th, .table-bordered td {
            border: 1px solid #ddd;
            padding: 15px;
            text-align: center;
        }

        .table-responsive {
            margin-top: 30px;
        }

        .d-flex {
            justify-content: space-between;
            margin-bottom: 25px;
        }

        /* Iconos de los botones */
        .btn i {
            margin-right: 8px;
        }

        /* Estilos para los títulos con iconos */
        .titulo-icono {
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .titulo-icono i {
            margin-right: 10px;
        }

        /* Estilo para los iconos en los títulos de la tabla */
        .table th i {
            margin-right: 10px;
        }

        /* Separación de botones */
        .btn-container a {
            margin-right: 10px;
        }

    </style>
</head>
<body>

<div class="container">
    <!-- Bloque de mensajes (éxito o error) -->
    <?php if (isset($_GET['mensaje'])): ?>
        <div class="alert alert-success">
            <?= htmlspecialchars($_GET['mensaje']) ?>
        </div>
    <?php elseif (isset($_GET['error'])): ?>
        <div class="alert alert-danger">
            <?= htmlspecialchars($_GET['error']) ?>
        </div>
    <?php endif; ?>

    <div class="titulo-icono">
        <h2><i class="fas fa-users"></i> Listado de Clientes</h2>
    </div>

    <!-- Formulario de búsqueda -->
    <div class="form-search">
        <form action="" method="get" class="mb-4">
            <div class="d-flex justify-content-between">
                <input type="text" name="buscar" class="form-control w-75" placeholder="Buscar por cédula o nombre" value="<?= htmlspecialchars($searchQuery) ?>">
                <button type="submit" class="btn btn-warning ms-2">
                    <i class="fas fa-search"></i> Buscar
                </button>
            </div>
        </form>
    </div>

    <!-- Tabla de clientes -->
    <div class="table-responsive">
        <table class="table table-bordered table-striped table-hover">
            <thead class="table-success">
                <tr>
                    <th><i class="fas fa-id-badge"></i>ID</th>
                    <th><i class="fas fa-address-card"></i>Cédula</th>
                    <th><i class="fas fa-user"></i>Nombre</th>
                    <th><i class="fas fa-users"></i>Apellidos</th>
                    <th><i class="fas fa-home"></i>Dirección</th>
                    <th><i class="fas fa-phone-alt"></i>Teléfono</th>
                    <th><i class="fas fa-envelope"></i>Correo Electrónico</th>
                    <th><i class="fas fa-calendar-alt"></i>Fecha de Nacimiento</th>
                    <th><i class="fas fa-image"></i>Foto Perfil</th>
                    <th><i class="fas fa-cogs"></i>Estado Membresía</th>
                    <th><i class="fas fa-cogs"></i>Tipo Membresía</th>
                    <th><i class="fas fa-calendar-day"></i>Fecha Vencimiento</th>
                    <th><i class="fas fa-calendar-plus"></i>Fecha Registro</th>
                    <th><i class="fas fa-cogs"></i>Acciones</th>
                </tr>
            </thead>
            <tbody>
                <?php if (count($clientes) > 0): ?>
                    <?php foreach ($clientes as $cliente): ?>
                        <tr>
                            <td><?= htmlspecialchars($cliente['id_cliente']) ?></td>
                            <td><?= htmlspecialchars($cliente['cedula']) ?></td>
                            <td><?= htmlspecialchars($cliente['nombre']) ?></td>
                            <td><?= htmlspecialchars($cliente['apellidos']) ?></td>
                            <td><?= htmlspecialchars($cliente['direccion']) ?></td>
                            <td><?= htmlspecialchars($cliente['telefono']) ?></td>
                            <td><?= htmlspecialchars($cliente['correo_electronico']) ?></td>
                            <td><?= htmlspecialchars($cliente['fecha_nacimiento']) ?></td>
                            <td>
                                <?php if ($cliente['foto_perfil']): ?>
                                    <img src="<?= htmlspecialchars($cliente['foto_perfil']) ?>" alt="Foto de perfil" width="50">
                                <?php else: ?>
                                    No disponible
                                <?php endif; ?>
                            </td>
                            <td><?= htmlspecialchars($cliente['estado_membresia']) ?></td>
                            <td><?= htmlspecialchars($cliente['tipo_membresia']) ?></td>
                            <td><?= htmlspecialchars($cliente['fecha_vencimiento']) ?></td>
                            <td><?= htmlspecialchars($cliente['fecha_registro']) ?></td>
                            <td>
                                <!-- Botones Editar y Eliminar con separación -->
                                <div class="btn-container">
                                <a href="editar_cliente.php?id=<?= $cliente['id_cliente'] ?>" class="btn btn-warning btn-lg" style="color: white; font-size: 18px; padding: 15px 30px;">
                                    <i class="fas fa-edit"></i> Editar
                                </a>

                                    <a href="eliminar_cliente.php?id=<?= $cliente['id_cliente'] ?>" class="btn btn-danger btn-sm">
                                        <i class="fas fa-trash-alt"></i> Eliminar
                                    </a>
                                </div>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="14">No hay clientes registrados.</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>

    <!-- Botones para agregar nuevo cliente y regresar al menú -->
    <div class="btn-container d-flex justify-content-between">
        <a href="agregar_cliente.php" class="btn btn-success">
            <i class="fas fa-plus"></i> Agregar Nuevo Cliente
        </a>
        <a href="dashboard.php" class="btn btn-info">
            <i class="fas fa-arrow-left"></i> Regresar al Menú Principal
        </a>
    </div>
</div>

<!-- Incluir archivos JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://kit.fontawesome.com/a076d05399.js"></script>

</body>
</html>
