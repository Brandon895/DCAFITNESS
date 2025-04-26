<?php
require_once __DIR__ . '/../models/ClienteModel.php';

$clienteModel = new ClienteModel();

// Validar que todos los datos fueron enviados por POST
if (!empty($_POST['id_cliente']) && !empty($_POST['monto']) && !empty($_POST['metodo_pago']) && !empty($_POST['descripcion'])) {
    $id_cliente = $_POST['id_cliente'];
    $monto = $_POST['monto'];
    $metodo_pago = $_POST['metodo_pago'];
    $descripcion = $_POST['descripcion'];

    // Ejecutar el método para registrar el pago
    $exito = $clienteModel->registrarPago($id_cliente, $monto, $metodo_pago, $descripcion);

    if ($exito) {
        echo "<p style='color:green;'>Pago registrado con éxito.</p>";
    } else {
        echo "<p style='color:red;'>Hubo un error al registrar el pago.</p>";
    }
} else {
    echo "<p style='color:red;'>Datos incompletos. Verifique que todos los campos estén llenos.</p>";
}
?>
