<?php
// Incluir el controlador
include($_SERVER['DOCUMENT_ROOT'] . '/mi_gimnasio/DCAFITNESS/Proyecto/controllers/ProductController.php');

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['idProducto'])) {
    $idProducto = $_POST['idProducto'];

    $productController = new ProductController();
    $resultado = $productController->eliminarProducto($idProducto);

    if ($resultado) {
        echo "<script>alert('Producto eliminado correctamente.'); window.location.href='VistaProductos.php';</script>";
    } else {
        echo "<script>alert('Error al eliminar el producto.'); window.history.back();</script>";
    }
} else {
    echo "<script>alert('Acción no permitida.'); window.history.back();</script>";
}
?>
