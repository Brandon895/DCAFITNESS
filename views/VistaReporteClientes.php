<?php
if (isset($_GET['generar_pdf']) && $_GET['generar_pdf'] == 'true') {
    //require_once('../libs/tcpdf/tcpdf.php');
require_once(__DIR__ . '/../libs/tcpdf/tcpdf.php');

    // Crear un nuevo documento PDF
    $pdf = new TCPDF();
    $pdf->SetAutoPageBreak(TRUE, 10);
    $pdf->AddPage();
    $pdf->SetFont('helvetica', '', 10);

    // Título del reporte
    $pdf->Cell(0, 10, 'Reporte de Clientes', 0, 1, 'C');
    $pdf->Ln(5);

    // Cabecera de la tabla
    $pdf->SetFillColor(40, 167, 69);
    $pdf->SetTextColor(255);
    $pdf->Cell(20, 7, 'ID', 1, 0, 'C', 1);
    $pdf->Cell(50, 7, 'Nombre', 1, 0, 'C', 1);
    $pdf->Cell(30, 7, 'Cédula', 1, 0, 'C', 1);
    $pdf->Cell(50, 7, 'Correo', 1, 0, 'C', 1);
    $pdf->Cell(30, 7, 'Teléfono', 1, 1, 'C', 1);

    // Incluir el controlador
    require_once('../controllers/ClienteController.php');
    $controller = new ClienteController();
    $clientes = $controller->obtenerClientes();

    // Agregar datos de clientes
    foreach ($clientes as $cliente) {
        $pdf->SetTextColor(0);
        $pdf->Cell(20, 6, $cliente['id_cliente'], 1, 0, 'C');
        $pdf->Cell(50, 6, $cliente['nombre'] . ' ' . $cliente['apellidos'], 1, 0, 'C');
        $pdf->Cell(30, 6, $cliente['cedula'], 1, 0, 'C');
        $pdf->Cell(50, 6, $cliente['correo_electronico'], 1, 0, 'C');
        $pdf->Cell(30, 6, $cliente['telefono'], 1, 1, 'C');
    }

    $pdf->Output('reporte_clientes.pdf', 'D');
    exit;
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reporte de Clientes</title>
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
    <h2 class="text-center"><i class="fas fa-users"></i> Reporte Total de Clientes</h2>
    <div class="table-responsive">
        <table class="table table-bordered table-striped mt-3">
            <thead>
                <tr>
                    <th>ID Cliente</th>
                    <th><i class="fas fa-user"></i> Nombre Completo</th>
                    <th><i class="fas fa-id-card"></i> Cédula</th>
                    <th><i class="fas fa-envelope"></i> Correo</th>
                    <th><i class="fas fa-phone"></i> Teléfono</th>
                    <th><i class="fas fa-calendar-alt"></i> Registro</th>
                    <th><i class="fas fa-medal"></i> Membresía</th>
                    <th><i class="fas fa-calendar-check"></i> Vencimiento</th>
                </tr>
            </thead>
            <tbody>
                <?php
                require_once('../controllers/ClienteController.php');
                $controller = new ClienteController();
                $clientes = $controller->obtenerClientes();

                foreach ($clientes as $cliente): ?>
                    <tr>
                        <td><?= $cliente['id_cliente']; ?></td>
                        <td><?= $cliente['nombre'] . ' ' . $cliente['apellidos']; ?></td>
                        <td><?= $cliente['cedula']; ?></td>
                        <td><?= $cliente['correo_electronico']; ?></td>
                        <td><?= $cliente['telefono']; ?></td>
                        <td><?= $cliente['fecha_registro']; ?></td>
                        <td><?= ucfirst($cliente['tipo_membresia']); ?> (<?= ucfirst($cliente['estado_membresia']); ?>)</td>
                        <td><?= $cliente['fecha_vencimiento']; ?></td>
                    </tr>
                <?php endforeach; ?>
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
