<?php
require_once __DIR__ . '/../models/db.php';

if (isset($_GET['id_factura'])) {
    $id_factura = $_GET['id_factura'];

    $sql = "SELECT * FROM facturas WHERE id_factura = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id_factura);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows == 0) {
        die('Factura no encontrada.');
    }

    $factura = $result->fetch_assoc();
} else {
    die('ID de factura no proporcionado.');
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id_cliente = $_POST['id_cliente'];
    $fecha_emision = $_POST['fecha_emision'];
    $fecha_vencimiento = $_POST['fecha_vencimiento'];
    $total_servicios = $_POST['total_servicios'];
    $total_productos = $_POST['total_productos'];
    $total_iva = $_POST['total_iva'];
    $total_a_pagar = $_POST['total_a_pagar'];
    $metodo_pago = $_POST['metodo_pago'];

    $sql = "UPDATE facturas SET id_cliente = ?, fecha_emision = ?, fecha_vencimiento = ?, total_servicios = ?, total_productos = ?, total_iva = ?, total_a_pagar = ?, metodo_pago = ? WHERE id_factura = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("issddddsi", $id_cliente, $fecha_emision, $fecha_vencimiento, $total_servicios, $total_productos, $total_iva, $total_a_pagar, $metodo_pago, $id_factura);

    if ($stmt->execute()) {
        header("Location: VistaFacturacion.php");
        exit;
    } else {
        echo "Error al actualizar la factura.";
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Factura</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet">
    <style>
        body {
            background: linear-gradient(135deg,rgb(44, 241, 9),rgb(247, 251, 21));
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            min-height: 100vh;
        }

        .form-container {
            background-color: #ffffff;
            border-radius: 20px;
            padding: 40px;
            max-width: 700px;
            margin: auto;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.2);
            animation: fadeIn 1s ease-in-out;
        }

        h2 {
            font-weight: bold;
            color: #2f8f2f;
            text-align: center;
            margin-bottom: 30px;
        }

        .btn-primary {
            background-color: #28a745;
            border: none;
            font-size: 18px;
            padding: 10px 25px;
        }

        .btn-primary:hover {
            background-color: #218838;
        }

        .btn-danger {
            background-color:rgb(232, 13, 13);
            border: none;
            color: #fff;
            font-size: 18px;
            padding: 10px 25px;
        }

        .btn-danger:hover {
            background-color:rgb(243, 24, 24);
            color: #fff;
        }

        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(20px); }
            to { opacity: 1; transform: translateY(0); }
        }

        .button-group {
            display: flex;
            justify-content: center;
            gap: 20px;
            margin-top: 30px;
        }
    </style>
</head>
<body>
    <div class="container py-5">
        <div class="form-container">
            <h2><i class="fas fa-file-invoice-dollar"></i> Editar Factura</h2>
            <form action="editar_factura.php?id_factura=<?= $id_factura ?>" method="POST">
                <div class="mb-3">
                    <label for="id_cliente" class="form-label">ID Cliente</label>
                    <input type="number" class="form-control" id="id_cliente" name="id_cliente" value="<?= $factura['id_cliente']; ?>" required>
                </div>
                <div class="mb-3">
                    <label for="fecha_emision" class="form-label">Fecha de Emisión</label>
                    <input type="date" class="form-control" id="fecha_emision" name="fecha_emision" value="<?= $factura['fecha_emision']; ?>" required>
                </div>
                <div class="mb-3">
                    <label for="fecha_vencimiento" class="form-label">Fecha de Vencimiento</label>
                    <input type="date" class="form-control" id="fecha_vencimiento" name="fecha_vencimiento" value="<?= $factura['fecha_vencimiento']; ?>" required>
                </div>
                <div class="mb-3">
                    <label for="total_servicios" class="form-label">Total Servicios</label>
                    <input type="number" step="0.01" class="form-control" id="total_servicios" name="total_servicios" value="<?= $factura['total_servicios']; ?>" required>
                </div>
                <div class="mb-3">
                    <label for="total_productos" class="form-label">Total Productos</label>
                    <input type="number" step="0.01" class="form-control" id="total_productos" name="total_productos" value="<?= $factura['total_productos']; ?>" required>
                </div>
                <div class="mb-3">
                    <label for="total_iva" class="form-label">Total IVA</label>
                    <input type="number" step="0.01" class="form-control" id="total_iva" name="total_iva" value="<?= $factura['total_iva']; ?>" required>
                </div>
                <div class="mb-3">
                    <label for="total_a_pagar" class="form-label">Total a Pagar</label>
                    <input type="number" step="0.01" class="form-control" id="total_a_pagar" name="total_a_pagar" value="<?= $factura['total_a_pagar']; ?>" required>
                </div>
                <div class="mb-3">
                    <label for="metodo_pago" class="form-label">Método de Pago</label>
                    <select class="form-select" id="metodo_pago" name="metodo_pago" required>
                        <option value="efectivo" <?= $factura['metodo_pago'] == 'efectivo' ? 'selected' : ''; ?>>Efectivo</option>
                        <option value="tarjeta" <?= $factura['metodo_pago'] == 'tarjeta' ? 'selected' : ''; ?>>Tarjeta</option>
                        <option value="transferencia" <?= $factura['metodo_pago'] == 'transferencia' ? 'selected' : ''; ?>>Transferencia</option>
                    </select>
                </div>

                <div class="button-group">
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save"></i> Guardar
                    </button>
                    <a href="VistaFacturacion.php" class="btn btn-danger">
                        <i class="fas fa-times"></i> Cancelar
                    </a>
                </div>
            </form>
        </div>
    </div>
</body>
</html>
