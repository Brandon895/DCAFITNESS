<?php
include($_SERVER['DOCUMENT_ROOT'] . '/mi_gimnasio/DCAFITNESS/Proyecto/controllers/MedidasController.php');

$medidasController = new MedidasController();

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['eliminar_id'])) {
    $medidasController->eliminarMedida($_POST['eliminar_id']);
    header("Location: VistaMedidas.php");
    exit();
}

$medidas = $medidasController->obtenerMedidas() ?? []; 
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Medidas de los Clientes</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css">
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

        .btn-success, .btn-danger, .btn-warning, .btn-primary {
            border: none;
            border-radius: 10px;
            padding: 12px 25px;
            font-size: 16px;  
            transition: all 0.3s ease;
            color: white;
        }

        .btn-success:hover, .btn-danger:hover, .btn-warning:hover, .btn-primary:hover {
            background-color: #c82333;
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

        .btn-container a {
            margin-right: 10px;
        }

        .btn-sm {
            font-size: 16px; 
            min-width: 100px;  
        }

        .btn-container div {
            display: flex;
            gap: 10px; 
        }

        
        .btn-editar {
            background-color: #ffc107; 
            color: white;
        }

        .btn-editar:hover {
            background-color: #e0a800; 
        }

        .btn-crear {
            background-color: #28a745; 
            color: white;
        }

        .btn-crear:hover {
            background-color: #218838; 
        }

        .btn-eliminar {
            background-color: #dc3545; 
            color: white;
        }

        .btn-eliminar:hover {
            background-color: #c82333; 
        }

       
        .btn-regresar {
            background-color: #007bff; 
            color: white;
        }

        .btn-regresar:hover {
            background-color: #0056b3; 
            color: black; 
            transform: translateY(2px); 
        }

        .btn-crear:hover {
            color: black; 
            transform: translateY(2px); 
        }
    </style>
</head>
<body>

<div class="container mt-5">
    <h2 class="titulo-icono text-white mb-4"><i class="bi bi-person-lines-fill"></i> Medidas de los Clientes</h2>

    <div class="btn-container">
        <a href="dashboard.php" class="btn btn-regresar">
            <i class="bi bi-house-door-fill"></i> Regresar al Menú Principal
        </a>
        <a href="ingresar_medida.php" class="btn btn-crear">
            <i class="bi bi-file-earmark-plus"></i> Ingresar Medida
        </a>
    </div>

    <div class="table-responsive">
        <table class="table table-bordered table-striped">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Cédula</th>
                    <th>Fecha Medición</th>
                    <th>Peso (kg)</th>
                    <th>Altura (cm)</th>
                    <th>IMC</th>
                    <th>% Grasa</th>
                    <th>Cintura (cm)</th>
                    <th>Bíceps (cm)</th>
                    <th>Tríceps (cm)</th>
                    <th>Muslo (cm)</th>
                    <th>Pantorrilla (cm)</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                <?php if (!empty($medidas)): ?>
                    <?php foreach ($medidas as $medida): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($medida['id_medida']); ?></td>
                            <td><?php echo !empty($medida['cedula']) ? htmlspecialchars($medida['cedula']) : "-"; ?></td>
                            <td><?php echo htmlspecialchars($medida['fecha_medicion']); ?></td>
                            <td><?php echo htmlspecialchars($medida['peso']); ?></td>
                            <td><?php echo htmlspecialchars($medida['altura']); ?></td>
                            <td><?php echo htmlspecialchars($medida['imc']); ?></td>
                            <td><?php echo htmlspecialchars($medida['porcentaje_grasa']); ?></td>
                            <td><?php echo htmlspecialchars($medida['circunferencia_cintura']); ?></td>
                            <td><?php echo htmlspecialchars($medida['circunferencia_biceps']); ?></td>
                            <td><?php echo htmlspecialchars($medida['circunferencia_triceps']); ?></td>
                            <td><?php echo htmlspecialchars($medida['circunferencia_muslo']); ?></td>
                            <td><?php echo htmlspecialchars($medida['circunferencia_pantorrilla']); ?></td>
                            <td>
                                <div class="btn-container">
                                    <a href="editar_medida.php?id=<?php echo urlencode($medida['id_medida']); ?>" class="btn btn-editar btn-sm">
                                        <i class="bi bi-pencil-square"></i> Editar
                                    </a>
                                    <button class="btn btn-eliminar btn-sm" onclick="confirmarEliminar(<?php echo $medida['id_medida']; ?>)">
                                        <i class="bi bi-trash"></i> Eliminar
                                    </button>
                                </div>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="13" class="text-center text-danger">No hay medidas registradas.</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>

<!-- Formulario oculto para eliminar medidas con POST -->
<form id="formEliminar" method="POST" style="display: none;">
    <input type="hidden" name="eliminar_id" id="eliminar_id">
</form>

<script>
    function confirmarEliminar(id) {
        if (confirm('¿Estás seguro de que deseas eliminar esta medida?')) {
            document.getElementById('eliminar_id').value = id;
            document.getElementById('formEliminar').submit();
        }
    }
</script>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
