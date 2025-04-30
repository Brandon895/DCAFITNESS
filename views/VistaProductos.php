<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

$buscar = isset($_GET['buscar']) ? $_GET['buscar'] : '';

//include($_SERVER['DOCUMENT_ROOT'] . '/mi_gimnasio/DCAFITNESS/Proyecto/controllers/ProductController.php');
require_once('../controllers/ProductController.php');

$productController = new ProductController();
$productos = $productController->obtenerProductos($buscar); 
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Productos</title>
    <!-- Agregar Bootstrap y Font Awesome -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet"> 
    <style>
        body {
            background: url('../assets/img/imgdcafitness.jpg') no-repeat center center fixed;
            background-size: cover;
            color: #ffffff;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }

        .container {
            background: linear-gradient(45deg, #28a745, #ffc107);
            padding: 40px;
            border-radius: 20px;
            box-shadow: 0px 10px 30px rgba(0, 0, 0, 0.1);
            margin-top: 50px;
            transition: all 0.3s ease;
        }

        .container:hover {
            transform: translateY(-10px);
            box-shadow: 0px 15px 50px rgba(0, 0, 0, 0.2);
        }

        .table thead {
            background-color: #28a745; 
            color: white;
            border-radius: 10px;
        }

        .table tbody tr:nth-of-type(odd) {
            background-color: #e2f9e2; 
        }

        .table tbody tr:nth-of-type(even) {
            background-color: #fff; 
        }

        .table tbody tr:hover {
            background-color: #d3f5d3; 
        }

        .btn-success {
            background-color: #28a745;
            border: none;
            border-radius: 10px;
            padding: 12px 25px;
            font-size: 16px;
            transition: all 0.3s ease;
        }

        .btn-success:hover {
            background-color: #1e7e34;
            transform: scale(1.05);
        }

        .btn-danger {
            background-color: #dc3545;
            border: none;
            border-radius: 10px;
            padding: 12px 25px;
            font-size: 16px;
            transition: all 0.3s ease;
        }

        .btn-danger:hover {
            background-color: #c82333;
            transform: scale(1.05);
        }

        .btn-sm {
            padding: 10px 20px; 
        }

        h2, h5 {
            font-weight: bold;
            text-transform: uppercase;
            color: #ffffff;
        }

        .d-flex {
            justify-content: space-between;
            margin-bottom: 25px;
        }

        .badge {
            font-size: 14px;
        }

        .table-bordered {
            border-radius: 15px;
            overflow: hidden;
        }

        .table-bordered th, .table-bordered td {
            border: 1px solid #ddd;
            padding: 15px;
            text-align: center;
        }

        .table-responsive {
            margin-top: 30px;
        }

        .btn-container {
            display: flex;
            gap: 10px;
            justify-content: center;
        }

        .btn-container .btn {
            width: 140px; 
            font-size: 16px; 
        }

        .btn i {
            margin-right: 8px;
        }

        .form-search {
            width: 80%;
            margin: 0 auto;
        }

        .form-search input {
            width: 85%;
        }

        .form-search button {
            width: 12%;
        }

        .btn-warning {
            color: white; 
            border: none;
            border-radius: 10px; 
            
        }
        .btn-warning:hover {
            color: white; 
            transform: scale(1.05);
        }
    </style>
</head>
<body>

<div class="container mt-5">
    <h2 class="text-center mb-4"><i class="fas fa-box-open"></i>Listado de Productos</h2>

    <!-- Formulario de búsqueda ajustado -->
    <form action="" method="get" class="form-search mb-4">
    <div class="d-flex justify-content-between">
        <input type="text" name="buscar" class="form-control" placeholder="Buscar por nombre o marca" value="<?= isset($_GET['buscar']) ? htmlspecialchars($_GET['buscar']) : '' ?>">
        <button type="submit" class="btn btn-warning ms-2"><i class="fas fa-search"></i> Buscar</button>
    </div>
</form>

    <!-- Tabla de productos -->
    <div class="table-responsive">
        <table class="table table-bordered table-striped table-hover">
            <thead class="table-success">
                <tr>
                    <th><i class="fas fa-id-badge"></i> ID</th>
                    <th><i class="fas fa-cogs"></i> Nombre</th>
                    <th><i class="fas fa-cogs"></i> Tipo</th>
                    <th><i class="fas fa-cogs"></i> Marca</th>
                    <th><i class="fas fa-cogs"></i> Cantidad Disponible</th>
                    <th><i class="fas fa-dollar-sign"></i> Precio</th>
                    <th><i class="fas fa-calendar-alt"></i> Fecha Ingreso</th>
                    <th><i class="fas fa-info-circle"></i> Descripción</th>
                    <th><i class="fas fa-cogs"></i> Acciones</th>
                </tr>
            </thead>
            <tbody>
                <?php if (count($productos) > 0): ?>
                    <?php foreach ($productos as $producto): ?>
                        <tr>
                            <td><?= htmlspecialchars($producto['idProducto']) ?></td>
                            <td><?= htmlspecialchars($producto['nom_producto']) ?></td>
                            <td><?= htmlspecialchars($producto['tipo']) ?></td>
                            <td><?= htmlspecialchars($producto['marca']) ?></td>
                            <td><?= htmlspecialchars($producto['cantidad_disponible']) ?></td>
                            <td>₡<?= number_format($producto['precio_venta'], 3) ?></td>
                            <td><?= htmlspecialchars($producto['fecha_ingreso']) ?></td>
                            <td><?= htmlspecialchars($producto['descripcion']) ?></td>

                            <td>
                                <div class="btn-container">
                                    <a href="editar_producto.php?id=<?= $producto['idProducto'] ?>" class="btn btn-warning btn-sm">
                                        <i class="fas fa-edit"></i> Editar
                                    </a>
                                    <form action="eliminar_producto.php" method="POST" style="display:inline;">
                                        <input type="hidden" name="idProducto" value="<?= $producto['idProducto'] ?>">
                                        <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('¿Estás seguro de que deseas eliminar este producto?');">
                                            <i class="fas fa-trash-alt"></i> Eliminar
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="8">No hay productos registrados.</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>

    <div class="d-flex justify-content-between mb-4">
        <a href="crearproducto.php" class="btn btn-success btn-lg"><i class="fas fa-plus-circle"></i> Agregar Nuevo Producto</a>
        <a href="dashboard.php" class="btn btn-primary btn-lg"><i class="fas fa-home"></i> Regresar al Menú Principal</a>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>
