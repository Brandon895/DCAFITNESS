<?php
require_once __DIR__ . '/../models/db.php';

if (isset($_GET['id_factura'])) {
    $id_factura = $_GET['id_factura'];

    // Eliminar la factura de la base de datos
    $sql = "DELETE FROM facturas WHERE id_factura = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id_factura);

    if ($stmt->execute()) {
        // Redirigir a la vista de facturas después de eliminar
        header("Location: VistaFacturacion.php");
        exit;
    } else {
        echo "Error al eliminar la factura.";
    }
} else {
    echo "ID de factura no proporcionado.";
}
?>
