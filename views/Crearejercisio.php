<?php
require_once '../controllers/EjercisioController.php';

$controller = new EjercicioController();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $cedula = $_POST['cedula'];
    $ejercicios_data = [];

    $dias = ['Lunes', 'Martes', 'Miércoles', 'Jueves', 'Viernes', 'Sábado', 'Domingo'];
    foreach ($dias as $dia) {
        $musculo = $_POST["musculo_$dia"] ?? '';
        $ejercicio = $_POST["ejercicio_$dia"] ?? '';
        $series = $_POST["series_$dia"] ?? '';
        $repeticiones = $_POST["repeticiones_$dia"] ?? '';
        $descanso = $_POST["descanso_$dia"] ?? '';

        if ($musculo && $ejercicio) {
            $ejercicios_data[$dia] = [
                'musculo' => $musculo,
                'ejercicio' => $ejercicio,
                'series' => $series,
                'repeticiones' => $repeticiones,
                'descanso' => $descanso
            ];
        }
    }

    if ($controller->crearEjercicio($cedula, $ejercicios_data)) {
        echo "<p>Ejercicio registrado correctamente.</p>";
    } else {
        echo "<p>Error al registrar el ejercicio.</p>";
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Crear Ejercicio</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <style>
        body {
            background: linear-gradient(135deg, rgb(44, 241, 9), rgb(247, 251, 21));
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            color: #333;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
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
            padding: 30px;
            text-transform: uppercase;
            letter-spacing: 1px;
        }

        .card-header i {
            margin-right: 10px;
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

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        th, td {
            padding: 10px;
            text-align: center;
            border: 1px solid #ddd;
        }

        input[type="text"] {
            width: 100%;
            padding: 5px;
            margin: 5px;
            border-radius: 10px;
            border: 1px solid #ddd;
        }

        /* Botones */
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
            background-color: #3498db;
            color: white;
            text-decoration: none;
        }

        .btn-cancel:hover {
            background-color: #2980b9;
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

<div class="container">
    <div class="card">
        <div class="card-header">
            <i class="fas fa-dumbbell"></i> Crear Nuevo Ejercicio
        </div>

        <div class="card-body">
            <form method="POST">
                <div class="form-group">
                    <label for="cedula" class="form-label"><i class="fas fa-id-card"></i> Cédula del Cliente:</label>
                    <input type="text" class="form-control" name="cedula" required>
                </div>

                <h3>Ejercicios Semanales</h3>

                <table>
                    <thead>
                        <tr>
                            <th>Día</th>
                            <th>Músculo</th>
                            <th>Ejercicio</th>
                            <th>Series</th>
                            <th>Repeticiones</th>
                            <th>Descanso (segundos)</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $dias = ['Lunes', 'Martes', 'Miércoles', 'Jueves', 'Viernes', 'Sábado', 'Domingo'];
                        foreach ($dias as $dia) {
                            ?>
                            <tr>
                                <td><?= $dia ?></td>
                                <td><input type="text" name="musculo_<?= $dia ?>" placeholder="Ejemplo: Pecho"></td>
                                <td><input type="text" name="ejercicio_<?= $dia ?>" placeholder="Ejemplo: Press de banca"></td>
                                <td><input type="text" name="series_<?= $dia ?>" placeholder="Ejemplo: 3"></td>
                                <td><input type="text" name="repeticiones_<?= $dia ?>" placeholder="Ejemplo: 10"></td>
                                <td><input type="text" name="descanso_<?= $dia ?>" placeholder="Ejemplo: 60"></td>
                            </tr>
                            <?php
                        }
                        ?>
                    </tbody>
                </table>

                <div class="button-group">
                    <button type="submit" class="btn btn-save"><i class="fas fa-save"></i> Guardar Ejercicio</button>
                    <a href="Vistaejercisio.php" class="btn btn-cancel"><i class="fas fa-arrow-left"></i> Volver</a>
                </div>
            </form>
        </div>
    </div>
</div>

</body>
</html>
