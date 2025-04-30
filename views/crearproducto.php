<?php
// Asegúrate de que la ruta al controlador sea correcta
include('../controllers/ProductController.php'); // Asegúrate de que esta ruta sea correcta

$productController = new ProductController();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Capturar los datos del formulario
    $nom_producto = $_POST['nom_producto'];
    $tipo = $_POST['tipo'];
    $marca = $_POST['marca'];
    $cantidad_disponible = $_POST['cantidad_disponible'];
    $precio_venta = $_POST['precio_venta'];
    $fecha_ingreso = $_POST['fecha_ingreso'];
    $descripcion = $_POST['descripcion'];

    // Verificar que los campos obligatorios no estén vacíos
    if (empty($nom_producto) || empty($tipo) || empty($marca) || empty($cantidad_disponible) || empty($precio_venta) || empty($fecha_ingreso)) {
        echo "<script>alert('Todos los campos obligatorios deben ser completados.');</script>";
    } else {
        // Insertar en la base de datos
        $insertado = $productController->crearProducto($nom_producto, $tipo, $marca, $cantidad_disponible, $precio_venta, $fecha_ingreso, $descripcion);

        if ($insertado) {
            echo "<script>alert('Producto agregado exitosamente'); window.location.href='VistaProductos.php';</script>";
        } else {
            echo "<script>alert('Error al agregar el producto');</script>";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Agregar Producto</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
    <style>
        /* Estilo general del cuerpo */
        body {
            background-color: #f9f9f9;
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
            width: 100%;
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
            width: 100%;
        }

        .form-control:focus {
            border-color: #43d74f;
            box-shadow: 0 0 5px rgba(67, 215, 79, 0.5);
        }

        /* Estilo de los botones */
        .btn {
            font-weight: bold;
            padding: 20px 60px;
            font-size: 18px; 
            border-radius: 12px; 
            transition: background-color 0.3s ease; 
            text-align: center; 
            display: inline-block; 
            margin: 15px; 
        }

        /* Estilo del botón "Guardar Producto" */
        .btn-success {
            background-color: #43d74f;
            color: white;
        }

        .btn-success:hover {
            background-color: #34c34f;
        }

        /* Estilo del botón "Cancelar" */
        .btn-secondary {
            background-color: #e74c3c;
            color: white;
            display: inline-block;
            width: auto;
            text-decoration: none;
        }

        .btn-secondary:hover {
            background-color: #c0392b;
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

<div class="container mt-5">
    <div class="card">
        <div class="card-header">
            <i class="fas fa-plus-circle"></i> Agregar Nuevo Producto
        </div>
        <div class="card-body">
            <!-- Formulario de agregar producto -->
            <form method="POST">
                <div class="mb-3">
                    <label for="nom_producto" class="form-label">Nombre del Producto:</label>
                    <input type="text" name="nom_producto" class="form-control" required>
                </div>
                <div class="mb-3">
                    <label for="tipo" class="form-label">Tipo:</label>
                    <input type="text" name="tipo" class="form-control" required>
                </div>
                <div class="mb-3">
                    <label for="marca" class="form-label">Marca:</label>
                    <input type="text" name="marca" class="form-control" required>
                </div>
                <div class="mb-3">
                    <label for="cantidad_disponible" class="form-label">Cantidad Disponible:</label>
                    <input type="number" name="cantidad_disponible" class="form-control" required>
                </div>
                <div class="mb-3">
                    <label for="precio_venta" class="form-label">Precio de Venta:</label>
                    <input type="number" step="0.01" name="precio_venta" class="form-control" required>
                </div>
                <div class="mb-3">
                    <label for="fecha_ingreso" class="form-label">Fecha de Ingreso:</label>
                    <input type="date" name="fecha_ingreso" class="form-control" required>
                </div>
                <div class="mb-3">
                    <label for="descripcion" class="form-label">Descripción:</label>
                    <textarea name="descripcion" class="form-control"></textarea>
                </div>
                <button type="submit" class="btn btn-success">
                    <i class="fas fa-save"></i> Guardar Producto
                </button>
                <a href="VistaProductos.php" class="btn btn-secondary">
                    <i class="fas fa-times"></i> Cancelar
                </a>
            </form>
        </div>
    </div>
</div>

<!-- Agregar Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>
