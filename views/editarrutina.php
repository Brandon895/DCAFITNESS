<?php
require_once '../controllers/RutinaController.php';

$controller = new RutinaController();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id_rutina = $_POST['id_rutina'];
    $cedula = $_POST['cedula'];
    $nomrutina = $_POST['nomrutina'];
    $cantidadsesiones = $_POST['cantidadsesiones'];

    $controller->actualizarRutina($id_rutina, $cedula, $nomrutina, $cantidadsesiones);

    header("Location: VistaRutinas.php");
    exit();
}

if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    echo "<p style='color: red;'>❌ ID de rutina no válido.</p>";
    exit();
}

$id_rutina = (int) $_GET['id'];
$rutina = $controller->obtenerRutinaPorId($id_rutina);

if (!$rutina) {
    echo "<p style='color: red;'>❌ Rutina no encontrada.</p>";
    exit();
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Editar Rutina</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background: linear-gradient(135deg, #b0f52f, #0f9b0f);
            background-size: 200% 200%;
            animation: gradientBG 6s ease infinite;
            margin: 0;
            padding: 0;
        }

        @keyframes gradientBG {
            0% { background-position: 0% 50%; }
            50% { background-position: 100% 50%; }
            100% { background-position: 0% 50%; }
        }

        .container {
            width: 460px;
            margin: 60px auto;
            background-color: rgba(255, 255, 255, 0.95);
            padding: 30px;
            border-radius: 15px;
            box-shadow: 0 0 20px rgba(0, 0, 0, 0.25);
        }

        h1 {
            text-align: center;
            color: #0f6b0f;
            margin-bottom: 20px;
        }

        label {
            display: block;
            margin-top: 15px;
            color: #333;
            font-weight: bold;
        }

        input[type="text"], input[type="number"] {
            width: 100%;
            padding: 10px;
            margin-top: 5px;
            border: 2px solid #a5dc4b;
            border-radius: 8px;
            box-sizing: border-box;
            transition: 0.2s;
        }

        input[type="text"]:focus,
        input[type="number"]:focus {
            border-color: #57b846;
            outline: none;
            box-shadow: 0 0 5px #57b846aa;
        }

        .button-group {
            display: flex;
            justify-content: space-between;
            margin-top: 25px;
        }

        .btn {
            width: 48%;
            text-align: center;
            padding: 12px;
            border: none;
            border-radius: 8px;
            font-size: 16px;
            font-weight: bold;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        .btn-update {
            background: linear-gradient(90deg, #c6ff00, #00c853);
            color: white;
        }

        .btn-update:hover {
            background: linear-gradient(90deg, #00e676, #aeea00);
        }

        .btn-cancel {
            background-color: #d32f2f;
            color: white;
            text-decoration: none;
            display: inline-block;
        }

        .btn-cancel:hover {
            background-color: #b71c1c;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Editar Rutina</h1>
        <form method="POST">
            <input type="hidden" name="id_rutina" value="<?= $rutina['id_rutina']; ?>">

            <label for="cedula">Cédula:</label>
            <input type="text" name="cedula" value="<?= htmlspecialchars($rutina['cedula']); ?>" required>

            <label for="nomrutina">Nombre de la Rutina:</label>
            <input type="text" name="nomrutina" value="<?= htmlspecialchars($rutina['nomrutina']); ?>" required>

            <label for="cantidadsesiones">Cantidad de Sesiones:</label>
            <input type="number" name="cantidadsesiones" value="<?= htmlspecialchars($rutina['cantidadsesiones']); ?>" required>

            <div class="button-group">
                <button type="submit" class="btn btn-update">Actualizar Rutina</button>
                <a href="VistaRutinas.php" class="btn btn-cancel">Cancelar</a>
            </div>
        </form>
    </div>
</body>
</html>
