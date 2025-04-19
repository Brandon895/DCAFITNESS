<?php
// controllers/FacturacionController.php
require_once __DIR__ . '/../models/FacturacionModel.php';

class FacturacionController {
    // Función para crear una nueva factura
    public function crearFactura() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Recibiendo los datos del formulario
            $id_cliente = $_POST['id_cliente'];
            $fecha_emision = $_POST['fecha_emision'];
            $fecha_vencimiento = $_POST['fecha_vencimiento'];
            $total_servicios = $_POST['total_servicios'];
            $total_productos = $_POST['total_productos'];
            $total_iva = $_POST['total_iva'];
            $total_a_pagar = $_POST['total_a_pagar'];
            $metodo_pago = $_POST['metodo_pago'];

            $facturacionModel = new FacturacionModel();
            
            // Llamar a la función de crear factura en el modelo
            $resultado = $facturacionModel->crearFactura($id_cliente, $fecha_emision, $fecha_vencimiento, $total_servicios, $total_productos, $total_iva, $total_a_pagar, $metodo_pago);

            if ($resultado) {
                // Redirigir a la vista de facturación después de crear la factura
                header("Location: VistaFacturacion.php");
                exit;
            } else {
                echo "Error al crear la factura.";
            }
        }
    }

    // Función para obtener todas las facturas y pasarlas a la vista
    public function obtenerFacturas() {
        $facturacionModel = new FacturacionModel();
        $facturas = $facturacionModel->obtenerFacturas();
        
        // Pasar las facturas a la vista
        require_once __DIR__ . '/../views/VistaFacturacion.php';  // Asegúrate de incluir correctamente la vista
        require_once __DIR__ . '/../views/VistaReporteFacturas.php';  // Asegúrate de incluir correctamente la vista
    
    }
    
}
?>
