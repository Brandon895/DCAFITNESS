<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

$controllerPath = '../controllers/RutinaController.php';
if (!file_exists($controllerPath)) {
    die("Error: No se encontró el archivo RutinaController.php");
}

require_once $controllerPath;

$controller = new RutinaController();

$rutinas = $controller->listarRutinas();
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Listado de Rutinas</title>
    <!-- Agregar Font Awesome para los iconos -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <style>
        body {
            background: url('../assets/img/imgdcafitness.jpg.jpg') no-repeat center center fixed;
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
            width: 80%;
            margin: 50px auto;
        }

        .container:hover {
            transform: translateY(-10px);
            box-shadow: 0px 15px 50px rgba(0, 0, 0, 0.2);
        }

        .table {
            width: 100%;
            margin: 0 auto;
        }

        .table thead {
            background-color: rgb(197, 215, 221);
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

        .table th, .table td {
            color: #000000;
            padding: 15px;
            text-align: center;
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
            background-color: #00bcd4;
            border: none;
            border-radius: 10px;
            padding: 12px 25px;
            font-size: 16px;
            transition: all 0.3s ease;
            color: white;
        }

        .btn-danger:hover {
            background-color: #008c99;
            transform: scale(1.05);
        }

        .btn-editar, .btn-eliminar {
            padding: 12px 20px;
            border: none;
            border-radius: 10px;
            color: white;
            font-size: 18px;
            transition: all 0.3s ease;
            margin: 0 5px;
        }

        .btn-editar {
            background-color: orange;
        }

        .btn-editar:hover {
            background-color: orange;
            transform: scale(1.05);
        }

        .btn-eliminar {
            background-color: #dc3545;
        }

        .btn-eliminar:hover {
            background-color: #a71d2a;
            transform: scale(1.05);
        }

        .btn-container {
            display: flex;
            justify-content: space-around;
            margin-top: 20px;
        }

        h2 {
            font-size: 35px;
            font-weight: bold;
            color: #ffffff;
            text-align: center;
            text-transform: uppercase;
            margin-bottom: 20px;
        }

        .table th {
            font-size: 18px;
            font-weight: bold;
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

        .btn-container a {
            margin-right: 10px;
        }

        .titulo-icono h2 {
            font-size: 72px;
            font-weight: bold;
            text-transform: uppercase;
            color: #ffffff;
        }
    </style>
</head>
<body>

    <div class="container">
        <h2 class="titulo-icono">
            <i class="fas fa-dumbbell"></i>Listado de Rutinas
        </h2>

        <table class="table table-bordered table-responsive">
            <thead>
                <tr>
                    <th><i class="fas fa-id-card"></i> ID</th>
                    <th><i class="fas fa-id-card-alt"></i> Cédula</th>
                    <th><i class="fas fa-cogs"></i> Nombre de Rutina</th>
                    <th><i class="fas fa-calendar-day"></i> Cantidad de Sesiones</th>
                    <th><i class="fas fa-tools"></i> Acciones</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($rutinas as $rutina): ?>
                    <tr>
                        <td><?= htmlspecialchars($rutina['id_rutina']); ?></td>
                        <td><?= htmlspecialchars($rutina['cedula']); ?></td>
                        <td><?= htmlspecialchars($rutina['nomrutina']); ?></td>
                        <td><?= htmlspecialchars($rutina['cantidadsesiones']); ?></td>
                        <td>
                            <a href="editarrutina.php?id=<?= $rutina['id_rutina']; ?>">
                                <button class="btn-editar"><i class="fas fa-edit"></i> Editar</button>
                            </a>
                            <a href="Eliminarrutina.php?id=<?= $rutina['id_rutina']; ?>" onclick="return confirm('¿Estás seguro de que deseas eliminar esta rutina?');">
                                <button class="btn-eliminar"><i class="fas fa-trash-alt"></i> Eliminar</button>
                            </a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>

        <div class="btn-container">
            <a href="Crearrutina.php">
                <button class="btn-success"><i class="fas fa-plus-circle"></i> Crear Nueva Rutina</button>
            </a>
            <a href="Vistaejercisio.php">
                <button class="btn-success"><i class="fas fa-dumbbell"></i> Crear Ejercicio</button>
            </a>
            <a href="dashboard.php">
                <button class="btn-danger"><i class="fas fa-arrow-left"></i> Regresar al Menú Principal</button>
            </a>
        </div>
    </div>

</body>
</html>
