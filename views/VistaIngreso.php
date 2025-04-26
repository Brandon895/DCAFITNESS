<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Registrar Ingreso</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <style>
        body {
            font-family: 'Roboto', sans-serif;
            background: linear-gradient(135deg, #56ab2f,#fffc33); /* Transición entre verde y amarillo */
            color: #fff;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            height: 100vh;
            margin: 0;
            overflow: hidden;
        }

        h2 {
            font-size: 3em;
            margin-bottom: 20px;
            text-shadow: 3px 3px 10px rgba(0, 0, 0, 0.7);
            color: #fff;
            letter-spacing: 2px;
            text-align: center;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        h2 i {
            font-size: 1.5em;
        }

        form {
            background-color: rgba(255, 255, 255, 0.1);
            padding: 40px;
            border-radius: 20px;
            box-shadow: 0 0 30px rgba(0, 0, 0, 0.6);
            backdrop-filter: blur(10px);
            width: 350px;
            text-align: center;
        }

        label {
            font-size: 1.2em;
            color: #fff;
            margin-bottom: 15px;
            display: block;
            font-weight: bold;
        }

        input[type="text"] {
            width: 100%;
            padding: 12px;
            border: none;
            border-radius: 10px;
            margin-bottom: 25px;
            font-size: 1.1em;
            color: #333;
            background-color: #fff;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.2);
            transition: all 0.3s ease;
        }

        input[type="text"]:focus {
            outline: none;
            box-shadow: 0 0 15px #56ab2f;
        }

        button {
            background-color: #56ab2f; /* Verde */
            color: #fff;
            padding: 12px 20px;
            border: none;
            border-radius: 10px;
            cursor: pointer;
            font-size: 1.2em;
            font-weight: bold;
            transition: all 0.3s ease;
        }

        button:hover {
            background-color: #a8e063; /* Amarillo */
            transform: scale(1.05);
        }

        #mensaje {
            margin-top: 20px;
            font-size: 1.2em;
            font-weight: bold;
        }

        /* Botón de regresar al menú principal */
        .boton-regresar {
            margin-top: 30px;
        }

        .boton-regresar a button {
            background-color: #00bcd4; 
            color: #fff;
            border-radius: 10px;
            padding: 12px 30px;
            font-size: 1.2em;
            font-weight: bold;
            border: none;
            transition: all 0.3s ease;
        }

        .boton-regresar a button:hover {
            background-color: #008c9e;
            transform: scale(1.05);
        }

        /* Animación de entrada */
        @keyframes slideIn {
            0% {
                transform: translateY(-100%);
                opacity: 0;
            }
            100% {
                transform: translateY(0);
                opacity: 1;
            }
        }

        form {
            animation: slideIn 0.8s ease-out;
        }
    </style>
</head>
<body>
    <h2><i class="fas fa-sign-in-alt"></i> Registrar Ingreso</h2>

    <form id="formIngreso">
        <label for="cedula"><i class="fas fa-id-card"></i> Cédula:</label>
        <input type="text" id="cedula" name="cedula" required>
        <button type="submit"><i class="fas fa-check-circle"></i> Registrar Ingreso</button>
    </form>

    <p id="mensaje" style="font-weight: bold;"></p>

    <!-- Botón para regresar al menú principal -->
    <div class="boton-regresar">
        <a href="dashboard.php">
            <button type="button"><i class="fas fa-home"></i> Regresar al Menú Principal</button>
        </a>
    </div>

    <script>
        document.getElementById("formIngreso").addEventListener("submit", function (e) {
            e.preventDefault();

            const cedula = document.getElementById("cedula").value;
            const mensaje = document.getElementById("mensaje");

            fetch("../controllers/accesoController.php?action=registrarIngreso", {
                method: "POST",
                headers: {
                    "Content-Type": "application/x-www-form-urlencoded",
                },
                body: `cedula=${encodeURIComponent(cedula)}`
            })
            .then(response => response.json())
            .then(data => {
                mensaje.textContent = data.mensaje;
                mensaje.style.color = data.status === "exito" ? "#4caf50" : "#f44336";
            })
            .catch(error => {
                console.error("Error:", error);
                mensaje.textContent = "Error de conexión con el servidor.";
                mensaje.style.color = "#f44336";
            });
        });
    </script>
</body>
</html>
