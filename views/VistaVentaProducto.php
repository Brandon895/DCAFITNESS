<?php if (isset($_GET['message'])): ?>
    <div style="background-color: #d4edda; color: #155724; padding: 10px; border: 1px solid #c3e6cb; margin-bottom: 10px;">
        <?php echo htmlspecialchars($_GET['message']); ?>
    </div>
<?php endif; ?>

<?php
include('../models/db.php');
$sql = "SELECT idVenta, nom_producto, cantidad, precio_venta, total, fecha_venta FROM ventas_productos";
$result = $conn->query($sql);
$conn->close();
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ventas de Productos</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

    <style>
        body {
            background: url('../assets/img/imgdcafitness.jpg.jpg') no-repeat center center fixed;
            background-size: cover;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            color: #ffffff;
        }

        .container {
            background: linear-gradient(45deg, #28a745, #ffc107);
            padding: 40px;
            border-radius: 20px;
            box-shadow: 0px 10px 30px rgba(0, 0, 0, 0.1);
            margin-top: 50px;
            transition: all 0.3s ease;
            max-width: 1200px;
            margin-left: auto;
            margin-right: auto;
        }

        .container:hover {
            transform: translateY(-10px);
            box-shadow: 0px 15px 50px rgba(0, 0, 0, 0.2);
        }

        .table {
            width: 100%;
            text-align: center;
            border-collapse: collapse;
            color: #000000;
        }

        .table thead {
            background-color: rgb(190, 208, 209);
            color: #000000;
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

        .table-bordered {
            border-radius: 15px;
            overflow: hidden;
        }

        .table-bordered th, .table-bordered td {
            border: 1px solid #ddd;
            padding: 12px 20px;
            text-align: center;
        }

        .btn {
            border: none;
            border-radius: 10px;
            padding: 12px 25px;
            font-size: 16px;
            transition: all 0.3s ease;
            color: white;
        }

        .btn-edit {
            background-color: #ffc107;
        }

        .btn-edit:hover {
            background-color: #e0a800;
            transform: scale(1.05);
        }

        .btn-danger {
            background-color: #dc3545;
        }

        .btn-danger:hover {
            background-color: #c82333;
            transform: scale(1.05);
        }

        .btn-info {
            background-color: #007bff;
        }

        .btn-info:hover {
            background-color: #0056b3;
            transform: scale(1.05);
        }

        .btn-success {
            background-color: #28a745;
        }

        .btn-success:hover {
            background-color: #218838;
            transform: scale(1.05);
        }

        h2, h5 {
            text-align: center;
            font-weight: bold;
            color: #ffffff;
        }

        .d-flex {
            display: flex;
            justify-content: space-between;
            margin-bottom: 25px;
            flex-wrap: wrap;
        }

        .btn i {
            margin-right: 8px;
        }

        .titulo-icono {
            display: flex;
            align-items: center;
            justify-content: center;
            margin-bottom: 30px;
        }

        .titulo-icono i {
            margin-right: 15px;
            font-size: 28px;
        }

        .titulo-icono h2 {
            font-size: 32px;
            margin: 0;
        }
    </style>
</head>
<body>

<div class="container">
    <div class="titulo-icono">
        <i class="fas fa-shopping-cart"></i>
        <h2>Listado de Ventas de Productos</h2>
    </div>

    <div class="d-flex">
        <a href="RegistrarVentaProducto.php">
            <button class="btn btn-success">
                <i class="fas fa-plus"></i> Registrar Venta
            </button>
        </a>

        <a href="dashboard.php">
            <button class="btn btn-info">
                <i class="fas fa-home"></i> Regresar al Menú Principal
            </button>
        </a>
    </div>

    <table class="table table-bordered">
        <thead>
        <tr>
            <th><i class="fas fa-receipt"></i> ID Venta</th>
            <th><i class="fas fa-box"></i> Producto</th>
            <th><i class="fas fa-sort-numeric-up"></i> Cantidad</th>
            <th><i class="fas fa-dollar-sign"></i> Precio</th>
            <th><i class="fas fa-money-bill-wave"></i> Total</th>
            <th><i class="fas fa-calendar-alt"></i> Fecha</th>
            <th><i class="fas fa-tools"></i> Acciones</th>
        </tr>
        </thead>
        <tbody>
        <?php if ($result->num_rows > 0): ?>
            <?php while($venta = $result->fetch_assoc()): ?>
                <tr>
                    <td><?php echo $venta['idVenta']; ?></td>
                    <td><?php echo $venta['nom_producto']; ?></td>
                    <td><?php echo $venta['cantidad']; ?></td>
                    <td><?php echo number_format($venta['precio_venta'], 2); ?></td>
                    <td><?php echo number_format($venta['total'], 2); ?></td>
                    <td><?php echo $venta['fecha_venta']; ?></td>
                    <td>
                        <a href="EditarVentaProducto.php?idVenta=<?php echo $venta['idVenta']; ?>">
                            <button class="btn btn-edit">
                                <i class="fas fa-edit"></i> Editar
                            </button>
                        </a>
                        <a href="EliminarVentaProducto.php?idVenta=<?php echo $venta['idVenta']; ?>" onclick="return confirm('¿Estás seguro de que quieres eliminar esta venta?')">
                            <button class="btn btn-danger">
                                <i class="fas fa-trash-alt"></i> Eliminar
                            </button>
                        </a>
                    </td>
                </tr>
            <?php endwhile; ?>
        <?php else: ?>
            <tr>
                <td colspan="7">No hay ventas registradas.</td>
            </tr>
        <?php endif; ?>
        </tbody>
    </table>
</div>

</body>
</html>
