<?php
session_start();
require_once '../models/BitacoraAccesosModel.php'; // Asegúrate de que el modelo está correctamente importado

// Verificar que la sesión esté activa
if (isset($_SESSION['id']) && isset($_SESSION['usuario'])) {
    // Registrar el cierre de sesión en la bitácora
    $id_usuario = $_SESSION['id'];
    $nombreusuario = $_SESSION['usuario'];
    
    // Llamamos al modelo para registrar la acción
    BitacoraAccesosModel::registrarAcceso($id_usuario, $nombreusuario, 'Cierre de sesión');

    // Destruir la sesión
    session_unset();
    session_destroy();

    // Redirigir al usuario al login o inicio
    header('Location: loguin.php');
    exit;
} else {
    // Si no hay sesión activa, redirigir a inicio de sesión
    header('Location: loguin.php');
    exit;
}
?>

