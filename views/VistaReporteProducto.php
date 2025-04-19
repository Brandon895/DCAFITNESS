<?php
// Incluir los archivos necesarios para la conexión a la base de datos y el controlador
require_once '../controllers/ProductController.php';
require_once('../libs/tcpdf/tcpdf.php');

// Instanciamos el controlador
$controller = new ProductController();

// Obtenemos todos los productos desde el controlador
$productos = $controller->obtenerProductos();

// Verificamos si se ha solicitado la descarga del PDF
if (isset($_GET['generar_pdf']) && $_GET['generar_pdf'] == 'true') {
    // Crear una nueva instancia de TCPDF
    $pdf = new TCPDF();

    // Establecer márgenes
    $pdf->SetMargins(15, 25, 15);
    $pdf->SetAutoPageBreak(TRUE, 25);

    // Agregar una página
    $pdf->AddPage();

    // Configurar el contenido del reporte
    $pdf->SetFont('helvetica', '', 12);

    // Cabecera de la tabla con el color verde para los títulos
    $html = '
    <h2 style="text-align: center;">Reporte de Productos</h2> <!-- Centrado en el PDF -->
    <table border="1" cellpadding="5">
        <thead>
            <tr style="background-color: #28a745; color: white;">
                <th><i class="fas fa-cogs"></i> ID Producto</th>
                <th><i class="fas fa-box"></i> Nombre</th>
                <th><i class="fas fa-tags"></i> Tipo</th>
                <th><i class="fas fa-copyright"></i> Marca</th>
                <th><i class="fas fa-archive"></i> Cantidad Disponible</th>
                <th><i class="fas fa-dollar-sign"></i> Precio Venta</th>
                <th><i class="fas fa-calendar-alt"></i> Fecha Ingreso</th>
                <th><i class="fas fa-info-circle"></i> Descripción</th>
            </tr>
        </thead>
        <tbody>';

    // Agregar productos al cuerpo de la tabla
    foreach ($productos as $producto) {
        $html .= '
        <tr>
            <td>' . $producto['idProducto'] . '</td>
            <td>' . $producto['nom_producto'] . '</td>
            <td>' . $producto['tipo'] . '</td>
            <td>' . $producto['marca'] . '</td>
            <td>' . $producto['cantidad_disponible'] . '</td>
            <td>' . $producto['precio_venta'] . '</td>
            <td>' . $producto['fecha_ingreso'] . '</td>
            <td>' . $producto['descripcion'] . '</td>
        </tr>';
    }

    $html .= '</tbody></table>';

    // Escribir el contenido en el PDF
    $pdf->writeHTML($html);

    // Descargar el PDF en lugar de mostrarlo en el navegador
    $pdf->Output('reporte_productos.pdf', 'D'); // 'D' para descarga
    exit; // Detener el script después de la salida del PDF
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reporte de Productos</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    <style>
        body {
            background: url('../assets/img/imgdcafitness.jpg.jpg') no-repeat center center fixed;
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
        }
        .table thead {
            background-color: #28a745; /* Verde para los títulos */
            color: white;
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

        .btn-custom {
            border-radius: 10px;
            padding: 12px 25px;
            font-size: 16px;
            transition: all 0.3s ease;
        }
        .btn-custom:hover {
            transform: scale(1.05);
        }
        .text-center {
            margin-top: 20px;
        }
    </style>
</head>
<body>

<div class="container">
    <h2 class="text-center"><i class="fas fa-cogs"></i> Reporte de Productos</h2>

    <div class="table-responsive">
        <table class="table table-bordered table-striped mt-3">
            <thead>
                <tr style="background-color: #28a745; color: white;">
                    <th><i class="fas fa-cogs"></i> ID Producto</th>
                    <th><i class="fas fa-box"></i> Nombre</th>
                    <th><i class="fas fa-tags"></i> Tipo</th>
                    <th><i class="fas fa-copyright"></i> Marca</th>
                    <th><i class="fas fa-archive"></i> Cantidad Disponible</th>
                    <th><i class="fas fa-dollar-sign"></i> Precio Venta</th>
                    <th><i class="fas fa-calendar-alt"></i> Fecha Ingreso</th>
                    <th><i class="fas fa-info-circle"></i> Descripción</th>
                </tr>
            </thead>
            <tbody>
                <?php if (!empty($productos)): ?>
                    <?php foreach ($productos as $producto): ?>
                        <tr>
                            <td><?php echo $producto['idProducto']; ?></td>
                            <td><?php echo $producto['nom_producto']; ?></td>
                            <td><?php echo $producto['tipo']; ?></td>
                            <td><?php echo $producto['marca']; ?></td>
                            <td><?php echo $producto['cantidad_disponible']; ?></td>
                            <td><?php echo $producto['precio_venta']; ?></td>
                            <td><?php echo $producto['fecha_ingreso']; ?></td>
                            <td><?php echo $producto['descripcion']; ?></td>
                        </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="8" class="text-center">No se encontraron productos.</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>

    <div class="text-center mt-4">
        <!-- Botón de Regresar -->
        <a href="vista_reportes.php" class="btn btn-success btn-custom">
            <i class="fas fa-arrow-left"></i> Regresar
        </a>
        <!-- Botón de Imprimir en PDF -->
        <a href="?generar_pdf=true" class="btn btn-danger btn-custom">
            <i class="fas fa-file-pdf"></i> Descargar PDF
        </a>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
