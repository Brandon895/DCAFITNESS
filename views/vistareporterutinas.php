<?php 
require_once '../controllers/RutinaController.php';
require_once '../libs/TCPDF/tcpdf.php';

$controller = new RutinaController();
$rutinas = $controller->listarRutinas(); 

if (isset($_GET['generar_pdf']) && $_GET['generar_pdf'] == 'true') {
    $pdf = new TCPDF();
    
    // Configuración del documento PDF
    $pdf->SetCreator(PDF_CREATOR);
    $pdf->SetAuthor('Zulu Gym');
    $pdf->SetTitle('Reporte de Rutinas');
    $pdf->SetMargins(15, 15, 15);
    $pdf->AddPage();
    
    $pdf->SetFont('helvetica', 'B', 16);
    
    $pdf->SetTextColor(0, 0, 0); 
    $pdf->Cell(0, 10, 'Reporte de Rutinas', 0, 1, 'C');
    
    $pdf->SetFont('helvetica', '', 12);
    $pdf->SetTextColor(0, 0, 0); 
    
    $pdf->Ln(5);
    $pdf->SetLineWidth(0.5);
    $pdf->Line(15, $pdf->GetY(), 195, $pdf->GetY());
    $pdf->Ln(5);
    
    $pdf->SetFillColor(40, 167, 69); 
    $pdf->SetTextColor(255, 255, 255);
    $pdf->Cell(30, 10, 'ID Rutina', 1, 0, 'C', 1);
    $pdf->Cell(90, 10, 'Nombre', 1, 0, 'C', 1);
    $pdf->Cell(60, 10, 'Cantidad de Sesiones', 1, 1, 'C', 1);
    
    $pdf->SetTextColor(0, 0, 0);
    
    foreach ($rutinas as $rutina) {
        $pdf->Cell(30, 10, $rutina['id_rutina'], 1, 0, 'C');
        $pdf->Cell(90, 10, $rutina['nomrutina'], 1, 0, 'C');
        $pdf->Cell(60, 10, $rutina['cantidadsesiones'], 1, 1, 'C');
    }
    
    $pdf->Ln(5);
    $pdf->SetLineWidth(0.5);
    $pdf->Line(15, $pdf->GetY(), 195, $pdf->GetY());
    
    $pdf->Output('reporte_rutinas.pdf', 'D');
    exit();
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reporte de Rutinas</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    <style>
        body {
            background: url('../assets/img/gym_background.jpg') no-repeat center center fixed;
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
            background-color: #28a745;
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
    <h2 class="text-center"><i class="fas fa-dumbbell"></i> Reporte de Rutinas</h2>
    <div class="table-responsive">
        <table class="table table-bordered table-striped mt-3">
            <thead>
                <tr>
                    <th><i class="fas fa-id-card"></i> ID Rutina</th>
                    <th><i class="fas fa-fitness"></i> Nombre</th>
                    <th><i class="fas fa-calendar-check"></i> Cantidad de Sesiones</th>
                </tr>
            </thead>
            <tbody>
                <?php if (!empty($rutinas)): ?>
                    <?php foreach ($rutinas as $rutina): ?>
                        <tr>
                            <td><?php echo $rutina['id_rutina']; ?></td>
                            <td><?php echo $rutina['nomrutina']; ?></td>
                            <td><?php echo $rutina['cantidadsesiones']; ?></td>
                        </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="3" class="text-center">No hay rutinas disponibles.</td>
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
