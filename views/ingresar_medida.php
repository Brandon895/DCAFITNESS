<?php 
// Incluir la clase o controlador para manejar la lógica de medidas
include($_SERVER['DOCUMENT_ROOT'] . '/mi_gimnasio/DCAFITNESS/Proyecto/controllers/MedidasController.php');

$medidasController = new MedidasController();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $cedula = $_POST['cedula'];
    $fecha_medicion = $_POST['fecha_medicion'];
    $peso = $_POST['peso'];
    $altura = $_POST['altura'];
    $imc = $_POST['imc'];
    $porcentaje_grasa = $_POST['porcentaje_grasa'];
    $circunferencia_cintura = $_POST['circunferencia_cintura'];
    $circunferencia_biceps = $_POST['circunferencia_biceps'];
    $circunferencia_triceps = $_POST['circunferencia_triceps'];
    $circunferencia_muslo = $_POST['circunferencia_muslo'];
    $circunferencia_pantorrilla = $_POST['circunferencia_pantorrilla'];

    if (empty($imc)) {
        $imc = $peso / (($altura / 100) * ($altura / 100));
    }

    $conexion = new mysqli("localhost", "root", "0895Gazuniga", "dcafitness");
    $query = "SELECT cedula FROM clientes WHERE cedula = '$cedula'";
    $resultado = $conexion->query($query);

    if ($resultado && $resultado->num_rows > 0) {
        $query_insert = "INSERT INTO medidas (cedula, fecha_medicion, peso, altura, imc, porcentaje_grasa, circunferencia_cintura, circunferencia_biceps, circunferencia_triceps, circunferencia_muslo, circunferencia_pantorrilla) 
                         VALUES ('$cedula', '$fecha_medicion', '$peso', '$altura', '$imc', '$porcentaje_grasa', '$circunferencia_cintura', '$circunferencia_biceps', '$circunferencia_triceps', '$circunferencia_muslo', '$circunferencia_pantorrilla')";
        
        if ($conexion->query($query_insert)) {
            header("Location: VistaMedidas.php?mensaje=Medida registrada correctamente&cedula=$cedula");
            exit();
        } else {
            echo "<p class='text-danger'>Error al registrar la medida: " . $conexion->error . "</p>";
        }
    } else {
        echo "<p class='text-danger'>Cliente no encontrado.</p>";
        exit();
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ingresar Medida</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
    <style>
        body {
            background: url('ruta-de-la-imagen-de-fondo.jpg') no-repeat center center fixed;
            background-size: cover;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            color: #333;
            display: flex;
            justify-content: center;
            align-items: flex-start;
            height: 100vh;
            margin: 0;
            padding-top: 50px;
        }

        .container {
            max-width: 800px;
            width: 100%;
            padding: 20px;
        }

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
            font-size: 36px;
            font-weight: bold;
            padding: 20px;
            text-transform: uppercase;
            letter-spacing: 1px;
        }

        .card-body {
            background-color: #ffffff;
            border-radius: 0 0 15px 15px;
            padding: 40px 30px;
        }

        .form-label {
            font-weight: bold;
            font-size: 16px;
        }

        .form-control {
            border-radius: 10px;
            border: 1px solid #ddd;
            padding: 12px;
            margin-bottom: 20px;
            width: 100%;
        }

        .form-control:focus {
            border-color: #43d74f;
            box-shadow: 0 0 5px rgba(67, 215, 79, 0.5);
        }

        .btn {
            font-weight: bold;
            border: none;
            padding: 12px 30px;
            border-radius: 10px;
            transition: all 0.3s ease;
            text-align: center;
            cursor: pointer;
            width: 220px;
        }

        .btn:hover {
            color: black;
            transform: scale(1.05);
            box-shadow: 0px 4px 12px rgba(0, 0, 0, 0.2);
        }

        .btn-save {
            background-color: #43d74f;
            color: white;
        }

        .btn-save:hover {
            background-color: #34c34f;
        }

        .btn-cancel {
            background-color: red;
            color: white;
            text-decoration: none;
        }

        .btn-cancel:hover {
            background-color: darkred;
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

<div class="container mt-5">
    <div class="card">
        <div class="card-header">
            <i class="bi bi-clipboard-check"></i> Ingresar Nueva Medida
        </div>
        <div class="card-body">
            <form method="POST">
                <div class="mb-3">
                    <label class="form-label"><i class="bi bi-person-vcard-fill"></i> Cédula</label>
                    <input type="text" name="cedula" class="form-control" required>
                </div>

                <div class="mb-3">
                    <label class="form-label"><i class="bi bi-calendar-date-fill"></i> Fecha de Medición</label>
                    <input type="date" name="fecha_medicion" class="form-control" required>
                </div>

                <div class="mb-3">
                    <label class="form-label"><i class="bi bi-scale"></i> Peso (kg)</label>
                    <input type="number" name="peso" class="form-control" required>
                </div>

                <div class="mb-3">
                    <label class="form-label"><i class="bi bi-arrows-collapse-vertical"></i> Altura (cm)</label>
                    <input type="number" name="altura" class="form-control" required>
                </div>

                <div class="mb-3">
                    <label class="form-label"><i class="bi bi-calculator"></i> IMC (kg/m²)</label>
                    <input type="number" name="imc" class="form-control">
                </div>

                <div class="mb-3">
                    <label class="form-label"><i class="bi bi-percent"></i> Porcentaje de Grasa (%)</label>
                    <input type="number" name="porcentaje_grasa" class="form-control" required>
                </div>

                <div class="mb-3">
                    <label class="form-label"><i class="bi bi-body-text"></i> Circunferencia Cintura (cm)</label>
                    <input type="number" name="circunferencia_cintura" class="form-control" required>
                </div>

                <div class="mb-3">
                    <label class="form-label"><i class="bi bi-body-text"></i> Circunferencia Bíceps (cm)</label>
                    <input type="number" name="circunferencia_biceps" class="form-control">
                </div>

                <div class="mb-3">
                    <label class="form-label"><i class="bi bi-body-text"></i> Circunferencia Tríceps (cm)</label>
                    <input type="number" name="circunferencia_triceps" class="form-control">
                </div>

                <div class="mb-3">
                    <label class="form-label"><i class="bi bi-body-text"></i> Circunferencia Muslo (cm)</label>
                    <input type="number" name="circunferencia_muslo" class="form-control">
                </div>

                <div class="mb-3">
                    <label class="form-label"><i class="bi bi-body-text"></i> Circunferencia Pantorrilla (cm)</label>
                    <input type="number" name="circunferencia_pantorrilla" class="form-control">
                </div>

                <div class="button-group">
                    <button type="submit" class="btn btn-save"><i class="bi bi-check-circle"></i> Guardar Medida</button>
                    <a href="VistaMedidas.php" class="btn btn-cancel"><i class="bi bi-x-circle"></i> Cancelar</a>
                </div>
            </form>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
