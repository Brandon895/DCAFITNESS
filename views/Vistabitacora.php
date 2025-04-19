<?php
require_once '../models/BitacoraModel.php';
$bitacora = new BitacoraModel();
$movimientos = $bitacora->obtenerMovimientos();
?>

<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <title>Bitácora de Movimientos</title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0">

  <!-- Bootstrap -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

  <!-- Google Fonts -->
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet">

  <!-- html2pdf -->
  <script src="https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.10.1/html2pdf.bundle.min.js"></script>

  <!-- Bootstrap Icons (para los iconos de los botones) -->
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
      border-bottom: 2px solid #40916c;
      padding-bottom: 10px;
      margin-bottom: 30px;
    }

    .table thead th {
      background-color: #1a7431;
      color: white !important;
    }

    .table tbody td {
      background-color: #fef102 !important;
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
  </style>
</head>
<body>

<div class="container" id="contenidoPDF">
  <h2>📋 Bitácora de Movimientos</h2>

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

  <table class="table table-striped table-hover">
    <thead>
      <tr>
        <th>ID</th>
        <th>Usuario</th>
        <th>Acción</th>
        <th>Fecha</th>
      </tr>
    </thead>
    <tbody>
      <?php while ($row = $movimientos->fetch_assoc()): ?>
        <tr>
          <td><?= $row['id_movimiento'] ?></td>
          <td><?= $row['usuario'] ?></td>
          <td><?= $row['accion'] ?></td>
          <td><?= $row['fecha'] ?></td>
        </tr>
      <?php endwhile; ?>
    </tbody>
  </table>
</div>

<script>
function descargarPDF() {
  const contenido = document.getElementById("contenidoPDF");
  contenido.classList.add("pdf-export");

  const opciones = {
    margin: 0.5,
    filename: 'bitacora_movimientos.pdf',
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
