<?php
include($_SERVER['DOCUMENT_ROOT'] . '/mi_gimnasio/DCAFITNESS/Proyecto/controllers/MedidasController.php');

$medidasController = new MedidasController();

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['id_medida'])) {
    $id_medida = $_POST['id_medida'];
    
    // Llamar al método para eliminar la medida
    $resultado = $medidasController->eliminarMedida($id_medida);

    if ($resultado) {
        echo "<script>alert('Medida eliminada correctamente.'); window.location.href = 'VistaMedida.php';</script>";
    } else {
        echo "<script>alert('Error al eliminar la medida.'); window.history.back();</script>";
    }
} else {
    echo "<script>alert('Acceso no válido.'); window.location.href = 'VistaMedida.php';</script>";
}
?>
