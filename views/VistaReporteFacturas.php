<?php
require_once('../libs/TCPDF/tcpdf.php');

// Conexión a la base de datos
$conexion = new mysqli("localhost", "root", "0895Gazuniga", "dcafitness");

// Verifica la conexión
if ($conexion->connect_error) {
    die("Conexión fallida: " . $conexion->connect_error);
}

// Consulta a la tabla facturas para obtener los detalles necesarios
$sql = "SELECT 
            f.id_factura, f.fecha_emision, f.total_servicios, f.total_productos, f.total_iva, 
            f.total_a_pagar, f.metodo_pago, c.nombre AS cliente_nombre
        FROM 
            facturas f
        JOIN 
            clientes c ON f.id_cliente = c.id_cliente
        ORDER BY 
            f.fecha_emision DESC";

$resultado = $conexion->query($sql);

// Almacena los datos en un arreglo
$facturas = [];

if ($resultado && $resultado->num_rows > 0) {
    while ($row = $resultado->fetch_assoc()) {
        $facturas[] = $row;
    }
}

// Cierra la conexión
$conexion->close();

// Función para generar el PDF
if (isset($_GET['generar_pdf']) && $_GET['generar_pdf'] == 'true') {
    // Crear un nuevo documento TCPDF
    $pdf = new TCPDF();
    $pdf->AddPage();

    // Establecer el título y la fuente
    $pdf->SetFont('Helvetica', 'B', 16);
    $pdf->SetTextColor(0, 0, 0); // Color de texto negro
    $pdf->Cell(0, 10, 'Reporte de Facturas', 0, 1, 'C');

    // Agregar un espacio en blanco
    $pdf->Ln(10);

    // Encabezados de la tabla con un estilo más refinado
    $pdf->SetFont('Helvetica', 'B', 12);
    $pdf->SetFillColor(40, 167, 69); // Color de fondo verde
    $pdf->SetTextColor(255, 255, 255); // Color de texto blanco

    $pdf->Cell(30, 10, 'ID Factura', 1, 0, 'C', 1);
    $pdf->Cell(30, 10, 'Fecha Emision', 1, 0, 'C', 1);
    $pdf->Cell(40, 10, 'Monto Total', 1, 0, 'C', 1);
    $pdf->Cell(40, 10, 'Metodo de Pago', 1, 0, 'C', 1);
    $pdf->Cell(50, 10, 'Cliente', 1, 1, 'C', 1);

    // Restaurar el color de texto
    $pdf->SetTextColor(0, 0, 0);

    // Establecer el cuerpo de la tabla con los datos de las facturas
    $pdf->SetFont('Helvetica', '', 12);

    foreach ($facturas as $factura) {
        $pdf->Cell(30, 10, $factura['id_factura'], 1, 0, 'C');
        $pdf->Cell(30, 10, $factura['fecha_emision'], 1, 0, 'C');
        $pdf->Cell(40, 10, '₡' . number_format($factura['total_a_pagar'], 2), 1, 0, 'C');
        $pdf->Cell(40, 10, $factura['metodo_pago'], 1, 0, 'C');
        $pdf->Cell(50, 10, $factura['cliente_nombre'], 1, 1, 'C');
    }

    // Output del PDF
    $pdf->Output('reporte_facturas.pdf', 'D');
    exit;
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reporte de Facturas</title>
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
            transition: all 0.3s ease;
        }

        .container:hover {
            transform: translateY(-10px);
            box-shadow: 0px 15px 50px rgba(0, 0, 0, 0.2);
        }

        .table thead {
            background-color: #28a745;
            color: white;
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

        .btn-success, .btn-danger {
            border-radius: 10px;
            padding: 12px 25px;
            font-size: 16px;
            transition: all 0.3s ease;
        }

        .btn-success:hover {
            background-color: #1e7e34;
            transform: scale(1.05);
        }

        .btn-danger:hover {
            background-color: #c82333;
            transform: scale(1.05);
        }

        h2 {
            font-weight: bold;
            text-transform: uppercase;
            color: #ffffff;
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

        i {
            margin-right: 8px;
        }
    </style>
</head>
<body>

<div class="container">
    <h2 class="text-center"><i class="fas fa-file-invoice"></i> Reporte de Facturas</h2>
    <div class="table-responsive">
        <table class="table table-bordered table-striped mt-3">
            <thead>
                <tr>
                    <th>ID Factura</th>
                    <th><i class="fas fa-calendar-alt"></i> Fecha Emisión</th>
                    <th><i class="fas fa-dollar-sign"></i> Monto Total</th>
                    <th><i class="fas fa-credit-card"></i> Método de Pago</th>
                    <th><i class="fas fa-user"></i> Cliente</th>
                </tr>
            </thead>
            <tbody>
                <?php
                if (isset($facturas) && is_array($facturas) && count($facturas) > 0) {
                    foreach ($facturas as $factura) {
                        echo "<tr class='text-center'>
                                <td>{$factura['id_factura']}</td>
                                <td>{$factura['fecha_emision']}</td>
                                <td>₡" . number_format($factura['total_a_pagar'], 2) . "</td>
                                <td>{$factura['metodo_pago']}</td>
                                <td>{$factura['cliente_nombre']}</td>
                              </tr>";
                    }
                } else {
                    echo "<tr><td colspan='5' class='text-center'>No hay facturas disponibles</td></tr>";
                }
                ?>
            </tbody>
        </table>
    </div>

    <div class="text-center mt-4">
        <a href="vista_reportes.php" class="btn btn-success"><i class="fas fa-arrow-left"></i> Regresar</a>
        <a href="?generar_pdf=true" class="btn btn-danger"><i class="fas fa-file-pdf"></i> Descargar PDF</a>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
