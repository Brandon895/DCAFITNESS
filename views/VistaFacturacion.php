<?php
require_once __DIR__ . '/../models/db.php';
require_once __DIR__ . '/../libs/tcpdf/tcpdf.php'; 

// Obtener las facturas de la base de datos
$sql = "SELECT * FROM facturas";
$result = $conn->query($sql);

// Verificar si se ha solicitado ver una factura en PDF
if (isset($_GET['id_factura'])) {
    $id_factura = $_GET['id_factura'];

    // Obtener los datos de la factura específica
    $sql_factura = "SELECT * FROM facturas WHERE id_factura = ?";
    $stmt = $conn->prepare($sql_factura);
    $stmt->bind_param("i", $id_factura);
    $stmt->execute();
    $result_factura = $stmt->get_result();

    if ($result_factura->num_rows == 0) {
        die('Factura no encontrada.');
    }

    $factura = $result_factura->fetch_assoc();

    // Crear el objeto TCPDF
    $pdf = new TCPDF('P', 'mm', 'A4');
    $pdf->SetAutoPageBreak(TRUE, 15);
    $pdf->AddPage();

    // Configuración de fuentes
    $pdf->SetFont('helvetica', 'B', 22);
    
    // Título centrado y más elegante
    $pdf->SetXY(10, 20);
    $pdf->Cell(0, 10, 'Factura', 0, 1, 'C');

    // Subtítulo centrado
    $pdf->SetFont('helvetica', 'I', 14);
    $pdf->Cell(0, 10, 'DCAFITNESS CENTER', 0, 1, 'C');
    
    // Espacio entre título y contenido
    $pdf->Ln(15);

    // Información de la factura (Cliente y fecha)
    $pdf->SetFont('helvetica', '', 12);
    $pdf->Cell(100, 10, 'Cliente: ' . $factura['id_cliente'], 0, 1);
    $pdf->Cell(100, 10, 'Fecha de Emisión: ' . $factura['fecha_emision'], 0, 1);
    $pdf->Cell(100, 10, 'Fecha de Vencimiento: ' . $factura['fecha_vencimiento'], 0, 1);
    
    // Espacio entre la información y los conceptos
    $pdf->Ln(10);

    // Encabezado de la tabla
    $pdf->SetFont('helvetica', 'B', 12);
    $pdf->Cell(100, 10, 'Concepto', 0, 0, 'L');
    $pdf->Cell(40, 10, 'Monto', 0, 1, 'C');

    // Datos de los conceptos
    $pdf->SetFont('helvetica', '', 12);
    $pdf->Cell(100, 10, 'Servicios', 0, 0, 'L');
    $pdf->Cell(40, 10, number_format($factura['total_servicios'], 2), 0, 1, 'C');
    $pdf->Cell(100, 10, 'Productos', 0, 0, 'L');
    $pdf->Cell(40, 10, number_format($factura['total_productos'], 2), 0, 1, 'C');
    $pdf->Cell(100, 10, 'IVA', 0, 0, 'L');
    $pdf->Cell(40, 10, number_format($factura['total_iva'], 2), 0, 1, 'C');
    $pdf->Cell(100, 10, 'Total a Pagar', 0, 0, 'L');
    $pdf->Cell(40, 10, number_format($factura['total_a_pagar'], 2), 0, 1, 'C');

    
    $pdf->Ln(10);

    $pdf->SetFont('helvetica', 'B', 12);
    $pdf->Cell(40, 10, 'Metodo de Pago:', 0, 0);
    $pdf->SetFont('helvetica', '', 12);
    $pdf->Cell(40, 10, ucfirst($factura['metodo_pago']), 0, 1);

    // Pie de página con información adicional de la empresa
    $pdf->SetXY(10, 270);
    $pdf->SetFont('helvetica', 'I', 10);
    $pdf->Cell(0, 10, 'Gracias por su compra en DCAFITNESS. Visite nuestro sitio web para más servicios.', 0, 1, 'C');

    // Salida del archivo PDF
    $pdf->Output('Factura_'.$factura['id_factura'].'.pdf', 'D'); 
    exit(); 
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Facturación - DCAFITNESS</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet"> 
    <style>
        body {
            background: linear-gradient(135deg, #00b140, #ffcc00); 
            background-size: 400% 400%;
            animation: gradientShift 10s ease infinite;
        }

        @keyframes gradientShift {
            0% { background-position: 100% 50%; }
            50% { background-position: 0% 50%; }
            100% { background-position: 100% 50%; }
        }

        .container {
            background: rgba(255, 255, 255, 0.9); 
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }

        .btn-success {
            background-color: #28a745; 
            border-color: #218838;
        }

        .btn-primary {
            background-color: #007bff;
        }

        .btn-warning {
            background-color: #ffcc00;
        }

        .btn-danger {
            background-color: #dc3545;
        }

        .btn-secondary {
            background-color: #007bff; 
            color: white;
        }

        .table {
            background-color: rgba(255, 255, 255, 0.8);
        }

        /* Diseño del botón "Crear Factura" */
        .btn-success {
            font-size: 1.2rem;
            padding: 10px 20px;
            border-radius: 10px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
            transition: background-color 0.3s ease;
        }

        .btn-success:hover {
            background-color: #218838;
        }

        .table th, .table td {
            text-align: center;
            vertical-align: middle;
        }

        /* Añade un toque más moderno a las celdas */
        .table-dark th {
            background-color: #343a40;
            color: #fff;
        }

        .table-bordered td, .table-bordered th {
            border: 1px solid #ddd;
        }
    </style>
</head>
<body>
    <div class="container mt-5">
        <!-- Título centrado con icono -->
        <h2 class="text-center mb-4">
            <i class="fas fa-file-invoice"></i> Facturas de Clientes
        </h2>

        <!-- Botón para crear nueva factura -->
        <a href="CrearFacturas.php" class="btn btn-success mb-3">
            <i class="fas fa-file-invoice"></i> Crear Factura
        </a>

        <?php if ($result && $result->num_rows > 0): ?>
            <table class="table table-bordered">
                <thead class="table-dark text-center">
                    <tr>
                        <th><i class="fas fa-hashtag"></i> ID Factura</th>
                        <th><i class="fas fa-user"></i> ID Cliente</th>
                        <th><i class="fas fa-calendar-day"></i> Fecha de Emisión</th>
                        <th><i class="fas fa-calendar-check"></i> Fecha de Vencimiento</th>
                        <th><i class="fas fa-money-bill-wave"></i> Total Servicios</th>
                        <th><i class="fas fa-cogs"></i> Total Productos</th>
                        <th><i class="fas fa-calculator"></i> Total IVA</th>
                        <th><i class="fas fa-dollar-sign"></i> Total a Pagar</th>
                        <th><i class="fas fa-credit-card"></i> Método de Pago</th>
                        <th><i class="fas fa-cogs"></i> Acciones</th> 
                    </tr>
                </thead>
                <tbody>
                    <?php while ($factura = $result->fetch_assoc()): ?>
                        <tr class="text-center">
                            <td><?= $factura['id_factura']; ?></td>
                            <td><?= $factura['id_cliente']; ?></td>
                            <td><?= $factura['fecha_emision']; ?></td>
                            <td><?= $factura['fecha_vencimiento']; ?></td>
                            <td><?= number_format($factura['total_servicios'], 2); ?></td>
                            <td><?= number_format($factura['total_productos'], 2); ?></td>
                            <td><?= number_format($factura['total_iva'], 2); ?></td>
                            <td><?= number_format($factura['total_a_pagar'], 2); ?></td>
                            <td><?= $factura['metodo_pago']; ?></td>
                            <td>
                                <!-- Botones en fila y con el mismo tamaño -->
                                <div class="d-flex justify-content-between">
                                    <!-- Botón para generar PDF -->
                                    <a href="?id_factura=<?= $factura['id_factura']; ?>" class="btn btn-primary flex-fill mx-1">
                                        <i class="fas fa-file-pdf"></i> Ver PDF
                                    </a>
                                    <!-- Botón para editar -->
                                    <a href="editar_factura.php?id_factura=<?= $factura['id_factura']; ?>" class="btn btn-warning flex-fill mx-1">
                                        <i class="fas fa-edit"></i> Editar
                                    </a>
                                    <!-- Botón para eliminar -->
                                    <a href="eliminar_factura.php?id_factura=<?= $factura['id_factura']; ?>" class="btn btn-danger flex-fill mx-1" onclick="return confirm('¿Estás seguro de eliminar esta factura?')">
                                        <i class="fas fa-trash"></i> Eliminar
                                    </a>
                                </div>
                            </td>
                        </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        <?php else: ?>
            <p>No se encontraron facturas.</p>
        <?php endif; ?>

        <!-- Botón para regresar al menú principal -->
        <div class="mt-4">
            <a href="dashboard.php" class="btn btn-secondary">
                <i class="fas fa-arrow-left"></i> Regresar al Menú Principal
            </a>
        </div>
    </div>
</body>
</html>
