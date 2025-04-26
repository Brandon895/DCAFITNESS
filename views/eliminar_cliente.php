<?php
include($_SERVER['DOCUMENT_ROOT'] . '/mi_gimnasio/DCAFITNESS/Proyecto/controllers/ClienteController.php');
require_once '../helpers/BitacoraHelper.php'; 

if (isset($_GET['id'])) {
    $id_cliente = $_GET['id'];

    $clienteController = new ClienteController();

    // Llamar al método de eliminar cliente
    $resultado = $clienteController->eliminarCliente($id_cliente);
    BitacoraHelper::registrarEnBitacora("Se eliminó un cliente");

    if ($resultado) {
        // Redirigir a la página principal con un mensaje de éxito
        header("Location: Clientes.php?mensaje=Cliente eliminado correctamente");
    } else {
        // Redirigir con un mensaje de error
        header("Location: Clientes.php?error=No se pudo eliminar el cliente");
    }
    exit();
} else {
    // Si no se pasa el id, redirigir con un mensaje de error
    header("Location: Clientes.php?error=No se especificó el cliente a eliminar");
    exit();
}
?>
