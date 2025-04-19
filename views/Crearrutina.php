<?php
require_once '../controllers/RutinaController.php'; // Asegúrate de la ruta correcta al controlador

// Instanciamos el controlador
$controller = new RutinaController();

// Verificamos si el formulario fue enviado
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Recuperamos la cédula del cliente
    $cedula = $_POST['cedula'];

    // Llamamos al método para verificar si el cliente está inscrito
    $clienteInscrito = $controller->verificarClienteInscrito($cedula);

    if ($clienteInscrito) {
        // Si el cliente está inscrito, procedemos a guardar la rutina
        $controller->guardarRutina();
    } else {
        // Si el cliente no está inscrito, mostramos un mensaje de error
        $mensajeError = "El cliente con cédula $cedula no está inscrito.";
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Crear Rutina</title>
    <!-- Vinculamos Font Awesome para iconos -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <style>
        /* Estilo general del cuerpo */
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
            transition: background-color 0.3s ease, transform 0.2s ease-in-out;
            text-align: center;
            margin-right: 10px; /* Espacio entre los botones */
            cursor: pointer; /* Cambia el cursor al pasar por encima */
        }

        /* Estilo del botón "Guardar cambios" */
        .btn-custom {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            font-size: 16px;
            font-weight: bold;
            background-color: #43d74f;
            color: white;
            display: inline-block;
            width: auto;
        }

        /* Hover para el botón "Crear Rutina" */
        .btn-custom:hover {
            background-color: #34c34f;
            color: black;
            transform: scale(1.05); /* Efecto de expansión */
            box-shadow: 0px 4px 12px rgba(0, 0, 0, 0.2); /* Sombra */
        }

        /* Estilo del botón "Volver a la lista de Rutinas" */
        .btn-cancel {
            background-color: #3498db; /* Azul */
            color: white;
            display: inline-block;
            width: auto;
            text-decoration: none;
        }

        /* Hover para el botón "Volver a la lista" */
        .btn-cancel:hover {
            background-color: #2980b9;
            color: black;
            transform: scale(1.05); /* Efecto de expansión */
            box-shadow: 0px 4px 12px rgba(0, 0, 0, 0.2); /* Sombra */
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
                <i class="fas fa-dumbbell"></i> Crear Rutina
            </div>

            <div class="card-body">
                <!-- Mostrar el mensaje de error si el cliente no está inscrito -->
                <?php if (isset($mensajeError)): ?>
                    <div style="color: red; font-weight: bold;">
                        <?php echo $mensajeError; ?>
                    </div>
                <?php endif; ?>

                <form action="Crearrutina.php" method="POST">
                    <div class="form-group">
                        <label for="cedula" class="form-label"><i class="fas fa-id-card"></i> Cédula del Cliente:</label>
                        <input type="text" class="form-control" name="cedula" required>
                    </div>

                    <div class="form-group">
                        <label for="nomrutina" class="form-label"><i class="fas fa-cogs"></i> Nombre de la Rutina:</label>
                        <input type="text" class="form-control" name="nomrutina" required>
                    </div>

                    <div class="form-group">
                        <label for="cantidadsesiones" class="form-label"><i class="fas fa-calendar-check"></i> Cantidad de Sesiones:</label>
                        <input type="number" class="form-control" name="cantidadsesiones" required>
                    </div>

                    <button type="submit" class="btn btn-custom"><i class="fas fa-save"></i> Crear Rutina</button>
                    <a href="VistaRutinas.php" class="btn btn-cancel"><i class="fas fa-arrow-left"></i> Volver a la lista de Rutinas</a>
                </form>
            </div>
        </div>
    </div>

</body>
</html>
