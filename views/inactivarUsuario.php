<?php
// views/inactivarUsuario.php
require_once('../controllers/UsuarioController.php');

if (!isset($_GET['id']) || empty($_GET['id'])) {
    die("Error: ID de usuario no proporcionado.");
}

$id = $_GET['id'];

$controller = new UsuarioController();
$controller->inactivarUsuario($id);

// Mensaje de éxito y redirección
session_start();
$_SESSION['mensaje'] = "Usuario inactivado correctamente.";
header('Location: vistaUsuarios.php');
exit();
?>
