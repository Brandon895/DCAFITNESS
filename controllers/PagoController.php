<?php
require_once(__DIR__ . '/../models/db.php');
require_once(__DIR__ . '/../models/PagoModel.php');

$pagoModel = new PagoModel($conn);

$cliente = null;
$error_message = "";
$mensaje_pago = "";

// Función para obtener el cliente por cédula
function obtenerClientePorCedula($cedula, $conn) {
    $sql = "SELECT * FROM clientes WHERE cedula = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('s', $cedula);
    $stmt->execute();
    $result = $stmt->get_result();
    
    if ($result->num_rows > 0) {
        return $result->fetch_assoc();
    }
    return null;
}

// Procesar formulario
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['cedula'])) {
        $cedula = $_POST['cedula'];
        $cliente = obtenerClientePorCedula($cedula, $conn);

        if (!$cliente) {
            $error_message = "Cliente no encontrado.";
        } else {
            if (isset($_POST['monto']) && isset($_POST['metodo_pago']) && isset($_POST['descripcion'])) {
                $monto = $_POST['monto'];
                $metodo_pago = $_POST['metodo_pago'];
                $descripcion = $_POST['descripcion'];
                $fecha_pago = date('Y-m-d');

                $pagoModel->registrarPago($cliente['id_cliente'], $monto, $metodo_pago, $descripcion, $fecha_pago);

                $nuevo_vencimiento = date('Y-m-d', strtotime('+1 month'));
                $pagoModel->actualizarFechaVencimiento($cliente['id_cliente'], $nuevo_vencimiento);

                $mensaje_pago = "Pago realizado con éxito. Fecha de vencimiento actualizada.";

                // Refrescar cliente
                $cliente = obtenerClientePorCedula($cedula, $conn);
            }
        }
    }
}

// Cargar la vista
require_once(__DIR__ . '/../views/Vistarealizar_pago.php');
