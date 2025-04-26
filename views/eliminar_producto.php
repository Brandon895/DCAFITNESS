<?php
include_once __DIR__ . '/../controllers/ProductController.php';

if (isset($_SERVER["REQUEST_METHOD"]) && $_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST['idProducto'])) {
    $idProducto = $_POST['idProducto'];

    // Crear instancia del controlador
    $productController = new ProductController();

    // Intentar eliminar el producto
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
