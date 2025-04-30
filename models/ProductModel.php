<?php
class ProductModel {
    private $conn;

   public function __construct() {
        // Aquí va la conexión directa como la tenías en tu código original, ajustada a los nuevos parámetros
        $this->conexion = new mysqli('sql3.freesqldatabase.com', 'sql3776084', 'vqri3ry8GD', 'sql3776084', 3306);
        
        // Verificamos la conexión
        if ($this->conexion->connect_error) {
            die("Error de conexión: " . $this->conexion->connect_error);
        }
    }

    // Crear un producto
    public function crearProducto($nom_producto, $tipo, $marca, $cantidad_disponible, $precio_venta, $fecha_ingreso, $descripcion) {
        $sql = "INSERT INTO Productos (nom_producto, tipo, marca, cantidad_disponible, precio_venta, fecha_ingreso, descripcion) 
                VALUES (?, ?, ?, ?, ?, ?, ?)";

        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("sssids", $nom_producto, $tipo, $marca, $cantidad_disponible, $precio_venta, $fecha_ingreso, $descripcion);
        return $stmt->execute();
    }

    // Obtener todos los productos
    public function obtenerProductos() {
        $sql = "SELECT * FROM Productos";
        $result = $this->conn->query($sql);

        $productos = [];
        while ($row = $result->fetch_assoc()) {
            $productos[] = $row;
        }
        return $productos;
    }

    // Obtener un producto por su ID
    public function obtenerProductoPorId($idProducto) {
        $sql = "SELECT * FROM Productos WHERE idProducto = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("i", $idProducto);
        $stmt->execute();
        return $stmt->get_result()->fetch_assoc();
    }

    // Actualizar un producto
    public function actualizarProducto($idProducto, $nom_producto, $tipo, $marca, $cantidad_disponible, $precio_venta, $fecha_ingreso, $descripcion) {
        $sql = "UPDATE Productos SET 
                nom_producto = ?, tipo = ?, marca = ?, cantidad_disponible = ?, precio_venta = ?, fecha_ingreso = ?, descripcion = ? 
                WHERE idProducto = ?";

        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("sssidsi", $nom_producto, $tipo, $marca, $cantidad_disponible, $precio_venta, $fecha_ingreso, $descripcion, $idProducto);
        return $stmt->execute();
    }

    // Eliminar un producto
    public function eliminarProducto($idProducto) {
        $sql = "DELETE FROM Productos WHERE idProducto = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("i", $idProducto);
        return $stmt->execute();
    }
}
?>
