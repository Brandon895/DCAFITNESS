<?php
// Incluir el archivo de conexión a la base de datos
include('../models/db.php');

// Verificar si se ha pasado el parámetro idVenta por la URL
if (isset($_GET['idVenta'])) {
    $idVenta = $_GET['idVenta'];

    // Consultar los detalles de la venta a editar
    $sql = "SELECT idVenta, nom_producto, cantidad, precio_venta, total, fecha_venta FROM ventas_productos WHERE idVenta = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('i', $idVenta);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $venta = $result->fetch_assoc();
    } else {
        echo "Venta no encontrada.";
        exit;
    }
} elseif ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Obtener los datos del formulario para actualizar
    $idVenta = $_POST['idVenta'];
    $nom_producto = $_POST['nom_producto'];
    $cantidad = $_POST['cantidad'];
    $precio_venta = $_POST['precio_venta'];
    $fecha_venta = $_POST['fecha_venta'];

    // Consulta para actualizar la venta, eliminando la columna 'total' porque es calculada automáticamente
    $sql = "UPDATE ventas_productos SET nom_producto = ?, cantidad = ?, precio_venta = ?, fecha_venta = ? WHERE idVenta = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('siisi', $nom_producto, $cantidad, $precio_venta, $fecha_venta, $idVenta);

    // Ejecutar la consulta de actualización
    if ($stmt->execute()) {
        // Redirigir a la página de ventas con mensaje de éxito
        header("Location: VistaVentaProducto.php?message=Venta actualizada con éxito");
        exit(); // Aseguramos que el script no continúe ejecutándose
    } else {
        echo "Error al actualizar la venta: " . $conn->error;
    }
}

// Cerrar la conexión después de usarla
$conn->close();
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Venta de Producto</title>

    <!-- Cargar los iconos de Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">

    <style>
        /* Estilo general del cuerpo */
        body {
            background-image: url('https://via.placeholder.com/1920x1080'); /* Aquí pon la URL de la imagen de fondo */
            background-size: cover;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            color: #333;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
        }

        .container {
            max-width: 700px;
            width: 100%;
            z-index: 1;
        }

        .card {
            border: none;
            border-radius: 15px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
            background: linear-gradient(135deg, #f5b500, #43d74f);
            animation: fadeIn 1s ease-in-out;
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
            padding: 20px 60px;
            font-size: 18px;
            border-radius: 12px;
            transition: background-color 0.3s ease;
            text-align: center;
            display: inline-block;
            margin: 15px;
        }

        .btn-custom {
            background-color: #43d74f;
            color: white;
        }

        .btn-custom:hover {
            background-color: #34c34f;
        }

        .btn-cancel {
            background-color: #e74c3c;
            color: white;
            text-decoration: none;
        }

        .btn-cancel:hover {
            background-color: #c0392b;
        }

        @keyframes fadeIn {
            0% { opacity: 0; transform: translateY(30px); }
            100% { opacity: 1; transform: translateY(0); }
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="card">
            <div class="card-header">Editar Venta de Producto</div>
            <div class="card-body">
                <form action="EditarVentaProducto.php" method="POST">
                    <input type="hidden" name="idVenta" value="<?php echo $venta['idVenta']; ?>">

                    <label class="form-label" for="nom_producto">Nombre del Producto:</label>
                    <input type="text" name="nom_producto" value="<?php echo $venta['nom_producto']; ?>" class="form-control" required><br>

                    <label class="form-label" for="cantidad">Cantidad:</label>
                    <input type="number" name="cantidad" value="<?php echo $venta['cantidad']; ?>" class="form-control" required><br>

                    <label class="form-label" for="precio_venta">Precio de Venta:</label>
                    <input type="number" step="0.01" name="precio_venta" value="<?php echo $venta['precio_venta']; ?>" class="form-control" required><br>

                    <label class="form-label" for="fecha_venta">Fecha de Venta:</label>
                    <input type="datetime-local" name="fecha_venta" value="<?php echo date('Y-m-d\TH:i', strtotime($venta['fecha_venta'])); ?>" class="form-control" required><br>

                    <button type="submit" class="btn btn-custom">
                        <i class="fas fa-check-circle"></i> Actualizar Venta
                    </button>
                    <a href="VistaVentaProducto.php" class="btn btn-cancel">
                        <i class="fas fa-times-circle"></i> Regresar a Ventas
                    </a>
                </form>
            </div>
        </div>
    </div>
</body>
</html>
