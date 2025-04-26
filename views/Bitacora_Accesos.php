<?php
require_once '../models/BitacoraAccesosModel.php';

$bitacora = BitacoraAccesosModel::obtenerBitacora();

if (!is_array($bitacora)) {
    $bitacora = []; 
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <title>Bitácora de Accesos</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
  <script src="https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.10.1/html2pdf.bundle.min.js"></script>

  <!-- Bootstrap Icons -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">

  <style>
    body {
      font-family: 'Poppins', sans-serif;
      background: linear-gradient(120deg, #d4f800, #52b788);
      padding: 30px;
    }

    .container {
      background: white;
      padding: 30px;
      border-radius: 15px;
      box-shadow: 0 0 20px rgba(0, 128, 0, 0.3);
    }

    h2 {
      font-weight: 600;
      color: #1b4332;
      text-align: center;
      border-bottom: 2px solidrgb(235, 250, 32);
      padding-bottom: 10px;
      margin-bottom: 30px;
    }

    .card-header {
      background-color: #ffc107;
      color: white;
      text-align: center;
      font-size: 18px;
    }

    .card-body {
      background-color: #e9f7e7;
    }

    table th {
      background-color: #a3d8a3;
      color: black !important;
    }

    table td {
      background-color: #e2f1e0;
      color: black !important;
      font-weight: 500;
    }

    /* Estilo de botones */
    .btn-regresar, .btn-danger {
      padding: 8px 15px;
      font-size: 14px;
      border-radius: 5px;
    }

    .btn-regresar {
      background-color: #0066cc;
      border: none;
      color: white;
    }

    .btn-regresar:hover {
      background-color: #004b8e;
    }

    .btn-danger {
      background-color: #d9534f;
      border: none;
      color: white;
    }

    .btn-danger:hover {
      background-color: #c9302c;
    }

    /* Posicionando los botones en las esquinas */
    .form-buttons {
      display: flex;
      justify-content: space-between;
      margin-bottom: 20px;
    }

    /* Ocultar botones en el PDF */
    .no-print {
      display: block;
    }

    .pdf-export .no-print {
      display: none !important;
    }

    .table-hover tbody tr:hover {
      background-color: #d9f1d3;
    }
  </style>
</head>
<body>

<div class="container" id="contenidoPDF">
  <h2>📋 Bitácora de Accesos</h2>

  <!-- Formulario con los botones -->
  <form class="form-buttons">
    <!-- Botón de regresar al menú principal -->
    <a href="dashboard.php" class="btn btn-primary no-print btn-regresar">
      <i class="bi bi-house-door"></i> Regresar al Menú Principal
    </a>

    <!-- Botón de generar PDF -->
    <button type="button" class="btn btn-danger no-print btn-danger" onclick="descargarPDF()">
      <i class="bi bi-file-earmark-pdf"></i> Generar PDF
    </button>
  </form>

  <div class="card">
    <div class="card-header">Bitácora de Accesos</div>
    <div class="card-body">
      <table class="table table-bordered table-hover">
        <thead>
          <tr>
            <th>ID</th>
            <th>Usuario</th>
            <th>Fecha y Hora</th>
            <th>Acción</th>
          </tr>
        </thead>
        <tbody>
          <?php foreach ($bitacora as $registro): ?>
            <tr>
              <td><?= htmlspecialchars($registro['id_bitacora']) ?></td>
              <td><?= htmlspecialchars($registro['nombreusuario']) ?></td>
              <td><?= htmlspecialchars($registro['fecha_hora']) ?></td>
              <td><?= htmlspecialchars($registro['accion']) ?></td>
            </tr>
          <?php endforeach; ?>
        </tbody>
      </table>
    </div>
  </div>
</div>

<script>
function descargarPDF() {
  const contenido = document.getElementById("contenidoPDF");
  contenido.classList.add("pdf-export");

  const opciones = {
    margin: 0.5,
    filename: 'bitacora_accesos.pdf',
    image: { type: 'jpeg', quality: 0.98 },
    html2canvas: { scale: 2, useCORS: true },
    jsPDF: { unit: 'in', format: 'letter', orientation: 'portrait' }
  };

  html2pdf().set(opciones).from(contenido).save().then(() => {
    contenido.classList.remove("pdf-export");
  });
}
</script>

</body>
</html>
