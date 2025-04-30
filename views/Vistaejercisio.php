<?php
// Habilitar errores
ini_set('display_errors', 1);
error_reporting(E_ALL);

require_once '../models/db.php';
require_once __DIR__ . '/../libs/tcpdf/tcpdf.php'; // Ruta a TCPDF

// Determinar la cédula desde POST (búsqueda) o GET (PDF)
$cedula = '';
if (isset($_POST['cedulaBuscar'])) {
    $cedula = trim($_POST['cedulaBuscar']);
} elseif (isset($_GET['cedula'])) {
    $cedula = trim($_GET['cedula']);
}

$diasOrdenados = ['Lunes','Martes','Miércoles','Jueves','Viernes','Sábado','Domingo'];

// Si se solicita descargar el PDF
if (isset($_GET['descargar_pdf']) && !empty($cedula)) {
    $stmt = $conn->prepare("SELECT * FROM ejercicio WHERE cedula = ?");
    $stmt->bind_param("s", $cedula);
    $stmt->execute();
    $res = $stmt->get_result();
    $ejercicios = [];
    while ($f = $res->fetch_assoc()) {
        $ejercicios[] = $f;
    }

    // Clase personalizada
    class MYPDF extends TCPDF {
        public function Header() {
            $this->SetY(10);
            $this->SetFont('helvetica', 'B', 12);
            $this->SetTextColor(0, 100, 0);
            $this->Cell(0, 10, 'DCAFitness - Rutina Personalizada', 0, true, 'C');
            $this->SetFont('helvetica', '', 10);
            $this->SetTextColor(0, 0, 0);
            $this->Cell(0, 10, 'Cédula: ' . $GLOBALS['cedula'], 0, true, 'C');
            $this->Ln(2);
        }

        public function Footer() {
            $this->SetY(-15);
            $this->SetFont('helvetica', 'I', 8);
            $this->SetTextColor(0, 100, 0);
            $this->Cell(0, 10, 'Generado automáticamente por DCAFitness', 0, 0, 'C');
        }
    }

    // Instanciar el PDF
    $pdf = new MYPDF('L', 'mm', 'A4', true, 'UTF-8', false);
    $pdf->SetMargins(10, 35, 10);
    $pdf->SetHeaderMargin(10);
    $pdf->SetFooterMargin(10);
    $pdf->SetAutoPageBreak(true, 15);
    $pdf->AddPage();

    // Estilo con colores y ajuste de tamaño
    $html = '
    <style>
        table { border-collapse: collapse; width: 100%; font-size: 10px; }
        th { background-color: #fffc33; color: #000; padding: 8px; border: 1px solid #ccc; }
        td { background-color: #e8f5e9; padding: 8px; border: 1px solid #ccc; text-align: center; }
    </style>
    <table>
        <thead>
            <tr>
                <th>Día</th>
                <th>Músculo</th>
                <th>Ejercicio</th>
                <th>Series</th>
                <th>Repeticiones</th>
                <th>Descanso (s)</th>
            </tr>
        </thead>
        <tbody>';
        
    foreach ($ejercicios as $ej) {
        $datos = json_decode($ej['ejercicios_data'], true);
        foreach ($diasOrdenados as $dia) {
            if (!isset($datos[$dia])) continue;
            $d = $datos[$dia];
            $html .= '<tr>' 
                . "<td>{$dia}</td>"
                . '<td>' . htmlspecialchars($d['musculo'] ?? '-') . '</td>'
                . '<td>' . htmlspecialchars($d['ejercicio'] ?? '-') . '</td>'
                . '<td>' . htmlspecialchars($d['series'] ?? '-') . '</td>'
                . '<td>' . htmlspecialchars($d['repeticiones'] ?? '-') . '</td>'
                . '<td>' . htmlspecialchars($d['descanso'] ?? '-') . '</td>'
                . '</tr>';
        }
    }

    $html .= '</tbody></table>';
    $pdf->writeHTML($html, true, false, true, false, '');
    $pdf->Output("Rutina_{$cedula}.pdf", 'D');
    exit;
}

// Vista en navegador
$ejercicios = [];
if (!empty($cedula) && isset($_POST['cedulaBuscar'])) {
    $stmt = $conn->prepare("SELECT * FROM ejercicio WHERE cedula = ?");
    $stmt->bind_param("s", $cedula);
    $stmt->execute();
    $res = $stmt->get_result();
    while ($f = $res->fetch_assoc()) {
        $ejercicios[] = $f;
    }
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Rutinas Registradas</title>
    <link href="https://fonts.googleapis.com/css2?family=Roboto&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <style>
        body { font-family:'Roboto', sans-serif; background:linear-gradient(135deg,#56ab2f,#fffc33); color:#fff; text-align:center; padding:40px; }
        form { background:rgba(255,255,255,0.1); padding:30px; border-radius:20px; margin-bottom:30px; width:400px; margin:auto; }
        input[type="text"] { width:100%; padding:12px; border:none; border-radius:10px; }
        input[type="submit"], .btn { padding:10px 20px; border:none; border-radius:8px; font-weight:bold; cursor:pointer; text-decoration:none; color:#fff; }
        input[type="submit"] { background:#fffc33; color:#000; }
        input[type="submit"]:hover { background:#fff176; color:#000; }
        .btn-verde { background:#4caf50; }
        .btn-azul  { background:#00bcd4; }
        .btn-rojo  { background:#d9534f; }
        table { width:100%; margin:auto; border-collapse:collapse; background:rgba(255,255,255,0.8); color:#000; }
        th,td { padding:12px; border:1px solid #ccc; }
        th { background:rgba(255,255,255,0.9); font-weight:bold; }
        h3 { margin-top:10px; display:flex; align-items:center; justify-content:center; }
        h3 i { margin-right:8px; }
    </style>
</head>
<body>
    <h2><i class="fas fa-search"></i> Rutinas Registradas</h2>

    <form method="POST">
        <label><i class="fas fa-id-card"></i> Cédula:</label><br>
        <input type="text" name="cedulaBuscar" value="<?= htmlspecialchars($cedula) ?>" required><br><br>
        <input type="submit" value="Buscar">
    </form>

    <?php if (!empty($cedula) && count($ejercicios) > 0): ?>
        <h3><i class="fas fa-list"></i> Rutina para la cédula: <?= htmlspecialchars($cedula) ?></h3>
        <table>
            <thead>
                <tr>
                    <th>Día</th><th>Músculo</th><th>Ejercicio</th>
                    <th>Series</th><th>Repeticiones</th><th>Descanso</th>
                </tr>
            </thead>
            <tbody>
            <?php foreach ($ejercicios as $ej): 
                $datos = json_decode($ej['ejercicios_data'], true);
                foreach ($diasOrdenados as $dia):
                    if (!isset($datos[$dia])) continue;
                    $d = $datos[$dia];
            ?>
                <tr>
                    <td><?= htmlspecialchars($dia) ?></td>
                    <td><?= htmlspecialchars($d['musculo'] ?? '-') ?></td>
                    <td><?= htmlspecialchars($d['ejercicio'] ?? '-') ?></td>
                    <td><?= htmlspecialchars($d['series'] ?? '-') ?></td>
                    <td><?= htmlspecialchars($d['repeticiones'] ?? '-') ?></td>
                    <td><?= htmlspecialchars($d['descanso'] ?? '-') ?></td>
                </tr>
            <?php endforeach; endforeach; ?>
            </tbody>
        </table>
    <?php elseif (!empty($cedula)): ?>
        <p>No se encontraron ejercicios para esta cédula.</p>
    <?php endif; ?>

    <!-- Botones siempre visibles -->
    <div style="margin-top:20px;">
        <a href="Crearejercisio.php?cedula=<?= urlencode($cedula) ?>" class="btn btn-verde"><i class="fas fa-plus-circle"></i> Crear Nuevo Ejercicio</a>
        <a href="vistarutinas.php" class="btn btn-azul"><i class="fas fa-arrow-left"></i> Volver a Vista Rutinas</a>
        <a href="?descargar_pdf=1&cedula=<?= urlencode($cedula) ?>" class="btn btn-rojo"><i class="fas fa-download"></i> Descargar PDF</a>
    </div>
</body>
</html>
