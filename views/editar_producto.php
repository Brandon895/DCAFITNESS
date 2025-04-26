<?php
error_reporting(E_ALL);  
ini_set('display_errors', 1);  

// Incluir controlador que maneja la lógica de negocio
require($_SERVER['DOCUMENT_ROOT'] . '/mi_gimnasio/DCAFITNESS/Proyecto/controllers/ProductController.php');

if (isset($_GET['id'])) {
    $idProducto = $_GET['id'];

    $productController = new ProductController();
    $producto = $productController->obtenerProductoPorId($idProducto);

    // Verificar si el producto fue encontrado
    if (!$producto) {
        echo "Producto no encontrado.";
        die();  // Detener la ejecución si el producto no se encuentra
    }
} else {
    // Si no se recibió un id, redirigir al listado de productos
    header('Location: productos.php');
    exit; 
}

// Comprobar si el formulario ha sido enviado para editar el producto
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Recibir los valores del formulario
    $nombre = $_POST['nombre'];
    $tipo = $_POST['tipo'];
    $marca = $_POST['marca'];
    $cantidad = $_POST['cantidad'];
    $precio = $_POST['precio'];
    $descripcion = $_POST['descripcion'];

    $updateSuccess = $productController->actualizarProducto($idProducto, $nombre, $tipo, $marca, $cantidad, $precio, $descripcion);

    if ($updateSuccess) {
        header('Location: VistaProductos.php');
        exit; 
    } else {
       
        echo "Hubo un error al actualizar el producto.";
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Producto</title>
    <!-- Agregar Bootstrap y Font Awesome -->
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
    padding: 20px 60px; 
    font-size: 18px; 
    border-radius: 12px; 
    transition: background-color 0.3s ease; 
    text-align: center; 
    display: inline-block; 
    margin: 15px; 
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

        .btn-custom:hover {
            background-color: #34c34f;
        }

        /* Estilo del botón "Cancelar" */
        .btn-cancel {
            background-color: #e74c3c;
            color: white;
            display: inline-block;
            width: auto;
            text-decoration: none;
        }

        .btn-cancel:hover {
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
            <i class="fas fa-edit"></i> Editar Producto
        </div>
        <div class="card-body">
            <!-- Formulario de edición de producto -->
            <form action="editar_producto.php?id=<?= $producto['idProducto'] ?>" method="POST">
                <div class="mb-3">
                    <label for="nombre" class="form-label">Nombre del Producto</label>
                    <input type="text" class="form-control" id="nombre" name="nombre" value="<?= htmlspecialchars($producto['nom_producto']) ?>" required>
                </div>

                <div class="mb-3">
                    <label for="tipo" class="form-label">Tipo</label>
                    <input type="text" class="form-control" id="tipo" name="tipo" value="<?= htmlspecialchars($producto['tipo']) ?>" required>
                </div>

                <div class="mb-3">
                    <label for="marca" class="form-label">Marca</label>
                    <input type="text" class="form-control" id="marca" name="marca" value="<?= htmlspecialchars($producto['marca']) ?>" required>
                </div>

                <div class="mb-3">
                    <label for="cantidad" class="form-label">Cantidad Disponible</label>
                    <input type="number" class="form-control" id="cantidad" name="cantidad" value="<?= htmlspecialchars($producto['cantidad_disponible']) ?>" required>
                </div>

                <div class="mb-3">
                    <label for="precio" class="form-label">Precio</label>
                    <input type="number" step="0.01" class="form-control" id="precio" name="precio" value="<?= htmlspecialchars($producto['precio_venta']) ?>" required>
                </div>

                <div class="mb-3">
                    <label for="descripcion" class="form-label">Descripción</label>
                    <textarea class="form-control" id="descripcion" name="descripcion" rows="3"><?= htmlspecialchars($producto['descripcion']) ?></textarea>
                </div>

                <button type="submit" class="btn btn-custom">
                    <i class="fas fa-save"></i> Actualizar Producto
                </button>
                <a href="VistaProductos.php" class="btn btn-cancel">
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
