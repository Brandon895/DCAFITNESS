<?php
require 'ClienteModel.php';
$clienteModel = new ClienteModel();

if (isset($_POST['id_cliente'], $_POST['monto'], $_POST['metodo_pago'], $_POST['descripcion'])) {
    $id_cliente = $_POST['id_cliente'];
    $monto = $_POST['monto'];
    $metodo_pago = $_POST['metodo_pago'];
    $descripcion = $_POST['descripcion'];
    
    $exito = $clienteModel->registrarPago($id_cliente, $monto, $metodo_pago, $descripcion);
    
    if ($exito) {
        echo "<p>Pago registrado con éxito.</p>";
    } else {
        echo "<p style='color:red;'>Hubo un error al registrar el pago.</p>";
    }
} else {
    echo "<p style='color:red;'>Datos incompletos.</p>";
}
?>
