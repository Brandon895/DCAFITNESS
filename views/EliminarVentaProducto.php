<?php
// Incluir el archivo de conexión
include('../models/db.php');  // Asegúrate de que la ruta sea correcta
include('../controllers/VentaProductoController.php');
require_once '../helpers/BitacoraHelper.php'; // Incluir el helper para registrar en la bitácora

// Instancia del controlador
$ventaController = new VentaProductoController();

// Verificar si se ha pasado el parámetro idVenta por la URL
if (isset($_GET['idVenta'])) {
    $idVenta = $_GET['idVenta'];

    // Llamar al controlador para eliminar la venta
    if ($ventaController->eliminarVenta($idVenta)) {
        // Registrar el movimiento en la bitácora
        $usuario = "Usuario"; // Aquí deberías poner el nombre del usuario logueado
        $accion = "Eliminó la venta con ID: $idVenta"; // Acción a registrar
        BitacoraHelper::registrarEnBitacora("Se eliminó una venta de producto");

        // Redirigir a la vista de ventas con un mensaje de éxito
        header("Location: VistaVentaProducto.php?message=Venta eliminada con éxito");
        exit;
    } else {
        // En caso de error, mostrar mensaje
        echo "Error al eliminar la venta.";
    }
} else {
    // Si no se ha pasado el idVenta por la URL, redirigir a la vista de ventas
    header("Location: VistaVentasProducto.php");
    exit;
}
?>
