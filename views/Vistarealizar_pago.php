<?php
include_once __DIR__ . '/../config.php';

if (!isset($cliente)) $cliente = null;
if (!isset($error_message)) $error_message = "";
if (!isset($mensaje_pago)) $mensaje_pago = "";
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Realizar Pago</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Roboto&display=swap" rel="stylesheet">

    <style>
        body {
            font-family: 'Roboto', sans-serif;
            background: linear-gradient(135deg, #56ab2f, #fffc33);
            color: #333;
            display: flex;
            flex-direction: column;
            align-items: center;
            padding: 50px 15px;
            min-height: 100vh;
            margin: 0;
        }

        h2 {
            font-size: 3em;
            color: white;
            text-shadow: 3px 3px 10px rgba(0, 0, 0, 0.7);
            display: flex;
            align-items: center;
            gap: 10px;
            margin-bottom: 30px;
        }

        form, .card-body {
            background-color: rgba(255, 255, 255, 0.85);
            padding: 30px;
            border-radius: 20px;
            box-shadow: 0 0 30px rgba(0, 0, 0, 0.2);
            backdrop-filter: blur(5px);
            width: 100%;
            max-width: 500px;
            margin-bottom: 30px;
            animation: slideIn 0.8s ease-out;
        }

        label {
            font-weight: bold;
            font-size: 1.2em;
            margin-top: 15px;
            display: block;
        }

        input[type="text"],
        input[type="number"],
        textarea,
        select {
            width: 100%;
            padding: 14px;
            margin-top: 5px;
            border: none;
            border-radius: 10px;
            font-size: 1.1em;
            color: #333;
            background-color: #fff;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        input:focus,
        textarea:focus,
        select:focus {
            outline: none;
            box-shadow: 0 0 15px #56ab2f;
        }

        button {
            margin-top: 25px;
            background-color: #56ab2f;
            color: #fff;
            padding: 14px 20px;
            border: none;
            border-radius: 10px;
            cursor: pointer;
            font-size: 1.1em;
            font-weight: bold;
            transition: all 0.3s ease;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
        }

        button:hover {
            background-color: #a8e063;
            transform: scale(1.05);
            color: #333;
        }

        .alert {
            max-width: 500px;
            padding: 15px 20px;
            border-radius: 15px;
            margin: 10px auto;
            font-weight: bold;
            font-size: 1.1em;
        }

        .alert-success {
            background-color: #d4edda;
            color: #155724;
        }

        .alert-danger {
            background-color: #f8d7da;
            color: #721c24;
        }

        .boton-regresar {
            margin-top: 10px;
        }

        .boton-regresar a {
            text-decoration: none;
        }

        .boton-regresar a button {
            background-color: #00bcd4;
            color: #fff;
            font-size: 1.1em;
        }

        .boton-regresar a button:hover {
            background-color: #008c9e;
            transform: scale(1.05);
        }

        ul.list-group {
            padding-left: 0;
            list-style: none;
        }

        ul.list-group li {
            background: #fff;
            margin-bottom: 10px;
            border-radius: 10px;
            padding: 15px;
            box-shadow: 0 2px 5px rgba(0,0,0,0.1);
            font-size: 1.1em;
        }

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
    </style>
</head>
<body>

<h2><i class="fas fa-cash-register"></i> Realizar Pago</h2>

<form action="../controllers/PagoController.php" method="POST">
    <label for="cedula"><i class="fas fa-id-card"></i> Cédula del Cliente:</label>
    <input type="text" name="cedula" placeholder="Ingrese la cédula del cliente" required>
    <button type="submit"><i class="fas fa-search"></i> Buscar Cliente</button>
</form>

<?php if ($error_message): ?>
    <div class="alert alert-danger">
        <i class="fas fa-exclamation-triangle"></i> <?php echo $error_message; ?>
    </div>
<?php endif; ?>

<?php if ($cliente): ?>
    <div class="card-body">
        <h3><i class="fas fa-user"></i> Detalles del Cliente</h3>
        <ul class="list-group">
            <li><strong>Cédula:</strong> <?php echo $cliente['cedula']; ?></li>
            <li><strong>Nombre:</strong> <?php echo $cliente['nombre'] . ' ' . $cliente['apellidos']; ?></li>
            <li><strong>Fecha de Vencimiento:</strong> <?php echo $cliente['fecha_vencimiento']; ?></li>
        </ul>

        <h4><i class="fas fa-credit-card"></i> Realizar Pago</h4>
        <form action="../controllers/PagoController.php" method="POST">
            <input type="hidden" name="cedula" value="<?php echo $cliente['cedula']; ?>">

            <label for="monto"><i class="fas fa-dollar-sign"></i> Monto:</label>
            <input type="number" name="monto" step="0.01" required>

            <label for="metodo_pago"><i class="fas fa-money-bill-wave"></i> Método de Pago:</label>
            <select name="metodo_pago" required>
                <option value="tarjeta">Tarjeta</option>
                <option value="efectivo">Efectivo</option>
            </select>

            <label for="descripcion"><i class="fas fa-comment-alt"></i> Descripción:</label>
            <textarea name="descripcion" rows="3" required></textarea>

            <button type="submit"><i class="fas fa-check-circle"></i> Realizar Pago</button>
        </form>
    </div>
<?php endif; ?>

<?php if ($mensaje_pago): ?>
    <div class="alert alert-success">
        <i class="fas fa-check-circle"></i> <?php echo $mensaje_pago; ?>
    </div>
<?php endif; ?>

<div class="boton-regresar">
    <a href="<?php echo BASE_URL; ?>views/dashboard.php">
        <button><i class="fas fa-arrow-left"></i> Volver al Menú Principal</button>
    </a>
</div>

</body>
</html>
