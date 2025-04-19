<?php
require_once '../models/BitacoraModel.php';

$bitacora = new BitacoraModel();

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["usuario"]) && isset($_POST["accion"])) {
    $usuario = $_POST["usuario"];
    $accion = $_POST["accion"];

    // Registrar la acción en la bitácora
    $bitacora->registrarMovimiento($usuario, $accion);
    echo "Movimiento registrado correctamente.";
}
?>
