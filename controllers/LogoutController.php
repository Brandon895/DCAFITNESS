<?php
require_once '../models/db.php';
require_once '../models/BitacoraAccesosModel.php';
session_start();

if (isset($_SESSION['id']) && isset($_SESSION['usuario'])) {
    // Registrar el cierre de sesión en la bitácora antes de destruir la sesión
    BitacoraAccesosModel::registrarAcceso($_SESSION['id'], $_SESSION['usuario'], "Cierre de sesión");
}

// Destruir la sesión después de registrarlo
session_destroy();
header("Location: ../index.php");
exit();
?>
