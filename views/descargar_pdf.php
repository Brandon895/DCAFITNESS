<?php
require_once '../models/db.php';
require_once(__DIR__ . '/../libs/tcpdf/tcpdf.php');


$cedula = isset($_GET['cedula']) ? trim($_GET['cedula']) : '';

if (empty($cedula)) {
    die('Cédula no proporcionada');
}

$stmt = $conn->prepare("SELECT * FROM ejercicio WHERE cedula = ?");
$stmt->bind_param("s", $cedula);
$stmt->execute();
$result = $stmt->get_result();
$ejercicios = [];
while ($fila = $result->fetch_assoc()) {
    $ejercicios[] = $fila;
}

$diasOrdenados = ['Lunes', 'Martes', 'Miércoles', 'Jueves', 'Viernes', 'Sábado', 'Domingo'];

// Personalización de PDF
class MYPDF extends TCPDF {
    public function Header() {
        $imageFile = K_PATH_IMAGES . 'logo.png'; 
        if (file_exists($imageFile)) {
            $this->Image($imageFile, 15, 10, 25, '', 'PNG', '', 'T', false, 300);
        }
        $this->SetFont('helvetica', 'B', 16);
        $this->Cell(0, 15, 'DCAFitness - Rutina Personalizada', 0, false, 'C', 0, '', 0, false, 'M', 'M');
        $this->Ln(10);
    }

    public function Footer() {
        $this->SetY(-15);
        $this->SetFont('helvetica', 'I', 9);
        $this->Cell(0, 10, 'Generado automáticamente por el sistema DCAFitness', 0, false, 'C');
    }
}

$pdf = new MYPDF();
$pdf->SetCreator(PDF_CREATOR);
$pdf->SetAuthor('DCAFitness');
$pdf->SetTitle("Rutina - $cedula");
$pdf->SetMargins(15, 30, 15);
$pdf->SetHeaderMargin(10);
$pdf->SetFooterMargin(15);
$pdf->SetAutoPageBreak(TRUE, 25);
$pdf->AddPage();

$html = '<style>
    table {
        border-collapse: collapse;
        width: 100%;
        font-size: 11px;
    }
    th {
        background-color: #4CAF50;
        color: white;
        padding: 6px;
        text-align: center;
    }
    td {
        border: 1px solid #999;
        padding: 6px;
        text-align: center;
    }
</style>';

$html .= "<h3 style='text-align:left;'>Cédula: $cedula</h3>";
$html .= "<table>
<tr>
<th>Día</th>
<th>Músculo</th>
<th>Ejercicio</th>
<th>Series</th>
<th>Repeticiones</th>
<th>Descanso</th>
</tr>";

foreach ($ejercicios as $ejercicio) {
    $datos = json_decode($ejercicio['ejercicios_data'], true);
    if (!$datos) continue;
    foreach ($diasOrdenados as $dia) {
        if (isset($datos[$dia])) {
            $detalle = $datos[$dia];
            $html .= "<tr>
                <td>$dia</td>
                <td>" . htmlspecialchars($detalle['musculo'] ?? '-') . "</td>
                <td>" . htmlspecialchars($detalle['ejercicio'] ?? '-') . "</td>
                <td>" . htmlspecialchars($detalle['series'] ?? '-') . "</td>
                <td>" . htmlspecialchars($detalle['repeticiones'] ?? '-') . "</td>
                <td>" . htmlspecialchars($detalle['descanso'] ?? '-') . "</td>
            </tr>";
        }
    }
}

$html .= "</table>";
$pdf->writeHTML($html, true, false, true, false, '');
$pdf->Output("Rutina_$cedula.pdf", 'D');
