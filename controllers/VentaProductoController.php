<?php
include('../models/db.php');  

class VentaProductoController {

    // Función para obtener todas las ventas de productos
    public function obtenerVentas() {
        global $conn;

        $sql = "SELECT idVenta, nom_producto, cantidad, precio_venta, total, fecha_venta FROM ventas_productos";
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            return $result->fetch_all(MYSQLI_ASSOC);
        } else {
            return [];
        }
    }

    // Función para registrar una venta
    public function registrarVenta($producto, $cantidad, $precio, $fecha_venta) {
        global $conn;

        try {
            $total = $cantidad * $precio;

            // Preparamos la consulta para insertar la venta
            $sql = "INSERT INTO ventas_productos (nom_producto, cantidad, precio_venta, total, fecha_venta) 
                    VALUES (?, ?, ?, ?, ?)";

            $stmt = $conn->prepare($sql);
            $stmt->bind_param('siiis', $producto, $cantidad, $precio, $total, $fecha_venta);

            return $stmt->execute();
        } catch (Exception $e) {
            echo "Error: " . $e->getMessage();
            return false;
        }
    }

    // Función para editar una venta
    public function editarVenta($idVenta, $producto, $cantidad, $precio, $fecha_venta) {
        global $conn;

        try {
            $total = $cantidad * $precio; 

            // Preparamos la consulta para actualizar la venta
            $sql = "UPDATE ventas_productos 
                    SET nom_producto = ?, cantidad = ?, precio_venta = ?, fecha_venta = ? 
                    WHERE idVenta = ?";

            $stmt = $conn->prepare($sql);
            $stmt->bind_param('siisi', $producto, $cantidad, $precio, $fecha_venta, $idVenta);

            // Ejecutar la actualización
            if ($stmt->execute()) {
                return true;
            } else {
                return false;
            }
        } catch (Exception $e) {
            echo "Error: " . $e->getMessage();
            return false;
        }
    }

    // Función para eliminar una venta
    public function eliminarVenta($idVenta) {
        global $conn;

        try {
            // Preparamos la consulta para eliminar la venta
            $sql = "DELETE FROM ventas_productos WHERE idVenta = ?";

            $stmt = $conn->prepare($sql);
            $stmt->bind_param('i', $idVenta);

            // Ejecutar la eliminación
            if ($stmt->execute()) {
                return true;
            } else {
                return false;
            }
        } catch (Exception $e) {
            echo "Error: " . $e->getMessage();
            return false;
        }
    }
}

// Instancia del controlador
$ventaController = new VentaProductoController();

// Obtener las ventas
$ventas = $ventaController->obtenerVentas();
?>
