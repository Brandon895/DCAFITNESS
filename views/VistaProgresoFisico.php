<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Progreso Físico</title>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <style>
        body {
            font-family: Arial, sans-serif;
            background: linear-gradient(to right, #28a745, #ffc107); 
            color: white;
            text-align: center;
            margin: 0;
            padding: 20px;
        }

        h1 {
            padding: 15px;
            border-radius: 10px;
            display: inline-block;
            font-size: 2em;
        }

        form {
            background: #222;
            padding: 20px;
            border-radius: 10px;
            width: 50%;
            margin: 20px auto;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.5);
        }

        label {
            font-size: 1.2em;
        }

        input {
            padding: 10px;
            margin: 10px;
            border-radius: 5px;
            border: none;
            font-size: 1em;
        }

        button {
            padding: 10px 20px;
            font-size: 1em;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            margin: 10px;
        }

        button[type="submit"] {
            background: #ffc107; 
            color: white;
            font-weight: bold;
        }

        button[type="submit"]:hover {
            background: #ff9800; 
        }

        button[type="button"] {
            background: #dc3545; 
            color: white;
            font-weight: bold;
        }

        button[type="button"]:hover {
            background: #c82333; 
        }

        #resultados {
            margin-top: 20px;
            background: #333;
            padding: 20px;
            border-radius: 10px;
        }
    </style>
</head>
<body>
    <h1><i class="fas fa-chart-line"></i> Progreso Físico</h1>

    <form id="formBusqueda" onsubmit="return false;">
        <label for="cedula"><i class="fas fa-id-card"></i> Cédula:</label>
        <input type="text" id="cedula" name="cedula" required>
        
        <button type="submit"><i class="fas fa-search"></i> Buscar</button>
       
        <button type="button" onclick="window.location.href='dashboard.php'"><i class="fas fa-times-circle"></i> Cancelar</button>
    </form>

    <div id="resultados"></div>

    <script>
        $('#formBusqueda').on('submit', function() {
            var cedula = $('#cedula').val();
            if (cedula) {
                $.ajax({
                    url: '../controllers/ProgresoFisicoController.php',
                    method: 'POST',
                    data: { cedula: cedula },
                    success: function(response) {
                        $('#resultados').html(response);
                    },
                    error: function() {
                        alert("Hubo un error en la solicitud.");
                    }
                });
            } else {
                alert("Por favor, ingresa una cédula.");
            }
        });
    </script>
</body>
</html>
