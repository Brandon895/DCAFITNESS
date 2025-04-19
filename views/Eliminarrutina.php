<?php
require_once '../controllers/RutinaController.php';

$controller = new RutinaController();

// Verificar si se ha pasado el ID de la rutina
if (isset($_GET['id'])) {
    $id_rutina = $_GET['id'];

    // Eliminar la rutina de la base de datos
    if ($controller->eliminarRutina($id_rutina)) {
        // Redirigir a la vista principal de rutinas después de eliminar
        header("Location: VistaRutinas.php");
        exit;
    } else {
        echo "Error al eliminar la rutina.";
    }
} else {
    echo "ID de rutina no proporcionado.";
}
?>
