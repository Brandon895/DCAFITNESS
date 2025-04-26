<?php
include($_SERVER['DOCUMENT_ROOT'] . '/mi_gimnasio/DCAFITNESS/Proyecto/controllers/MedidasController.php');

$medidasController = new MedidasController();

$id = isset($_GET['id']) ? $_GET['id'] : null;
$medida = null;

if ($id) {
    $medida = $medidasController->obtenerMedidaPorId($id);
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Capturar los datos enviados en el formulario
    $peso = $_POST['peso'];
    $altura = $_POST['altura'];
    $imc = $_POST['imc'];
    $porcentaje_grasa = $_POST['porcentaje_grasa'];
    $circunferencia_cintura = $_POST['circunferencia_cintura'];
    $circunferencia_biceps = $_POST['circunferencia_biceps'];
    $circunferencia_triceps = $_POST['circunferencia_triceps'];
    $circunferencia_muslo = $_POST['circunferencia_muslo'];
    $circunferencia_pantorrilla = $_POST['circunferencia_pantorrilla'];

    $cedula = isset($medida['cedula']) ? $medida['cedula'] : null; 
    $fecha_medicion = isset($medida['fecha_medicion']) ? $medida['fecha_medicion'] : null; 
   
    if ($id) {
        // Actualizar la medida en la base de datos con el ID
        $resultado = $medidasController->actualizarMedida($id, $cedula, $fecha_medicion, $peso, $altura, $porcentaje_grasa, $circunferencia_cintura, $circunferencia_biceps, $circunferencia_triceps, $circunferencia_muslo, $circunferencia_pantorrilla);
        
        // Redirigir a la página de medidas después de actualizar
        if ($resultado) {
            header('Location: VistaMedidas.php');
            exit();
        } else {
            echo "Hubo un problema al actualizar la medida.";
        }
    } else {
        echo "No se encontró la medida para actualizar.";
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Medida</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css"> 
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
            <i class="fas fa-pencil-alt"></i> Editar Medida
        </div>
        <div class="card-body">
            <?php if ($medida): ?>
                <form method="POST">
                    <div class="mb-3">
                        <label for="peso" class="form-label"><i class="fas fa-weight-hanging"></i> Peso (kg)</label>
                        <input type="number" class="form-control" id="peso" name="peso" value="<?php echo htmlspecialchars($medida['peso']); ?>" required>
                    </div>

                    <div class="mb-3">
                        <label for="altura" class="form-label"><i class="fas fa-ruler-vertical"></i> Altura (cm)</label>
                        <input type="number" class="form-control" id="altura" name="altura" value="<?php echo htmlspecialchars($medida['altura']); ?>" required>
                    </div>

                    <div class="mb-3">
                        <label for="imc" class="form-label"><i class="fas fa-heartbeat"></i> IMC</label>
                        <input type="number" class="form-control" id="imc" name="imc" value="<?php echo htmlspecialchars($medida['imc']); ?>" required>
                    </div>

                    <div class="mb-3">
                        <label for="porcentaje_grasa" class="form-label"><i class="fas fa-tint"></i> % Grasa</label>
                        <input type="number" class="form-control" id="porcentaje_grasa" name="porcentaje_grasa" value="<?php echo htmlspecialchars($medida['porcentaje_grasa']); ?>" required>
                    </div>

                    <div class="mb-3">
                        <label for="circunferencia_cintura" class="form-label"><i class="fas fa-tape"></i> Cintura (cm)</label>
                        <input type="number" class="form-control" id="circunferencia_cintura" name="circunferencia_cintura" value="<?php echo htmlspecialchars($medida['circunferencia_cintura']); ?>" required>
                    </div>

                    <div class="mb-3">
                        <label for="circunferencia_biceps" class="form-label"><i class="fas fa-tape"></i> Bíceps (cm)</label>
                        <input type="number" class="form-control" id="circunferencia_biceps" name="circunferencia_biceps" value="<?php echo htmlspecialchars($medida['circunferencia_biceps']); ?>" required>
                    </div>

                    <div class="mb-3">
                        <label for="circunferencia_triceps" class="form-label"><i class="fas fa-tape"></i> Tríceps (cm)</label>
                        <input type="number" class="form-control" id="circunferencia_triceps" name="circunferencia_triceps" value="<?php echo htmlspecialchars($medida['circunferencia_triceps']); ?>" required>
                    </div>

                    <div class="mb-3">
                        <label for="circunferencia_muslo" class="form-label"><i class="fas fa-tape"></i> Muslo (cm)</label>
                        <input type="number" class="form-control" id="circunferencia_muslo" name="circunferencia_muslo" value="<?php echo htmlspecialchars($medida['circunferencia_muslo']); ?>" required>
                    </div>

                    <div class="mb-3">
                        <label for="circunferencia_pantorrilla" class="form-label"><i class="fas fa-tape"></i> Pantorrilla (cm)</label>
                        <input type="number" class="form-control" id="circunferencia_pantorrilla" name="circunferencia_pantorrilla" value="<?php echo htmlspecialchars($medida['circunferencia_pantorrilla']); ?>" required>
                    </div>

                    <div class="button-group">
                        <button type="submit" class="btn btn-save"><i class="fas fa-save"></i> Guardar</button>
                        <a href="VistaMedidas.php" class="btn btn-cancel"><i class="fas fa-times"></i> Cancelar</a>
                    </div>
                </form>
            <?php else: ?>
                <p>No se encontró la medida para editar.</p>
            <?php endif; ?>
        </div>
    </div>
</div>

</body>
</html>
