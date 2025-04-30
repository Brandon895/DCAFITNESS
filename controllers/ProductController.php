<?php
$dbPath = __DIR__ . '/../models/db.php';
$productModelPath = __DIR__ . '/../models/ProductModel.php';

if (!file_exists($dbPath)) {
    die("Error: No se encontró db.php en la ruta especificada.");
}
if (!file_exists($productModelPath)) {
    die("Error: No se encontró ProductModel.php en la ruta especificada.");
}

include_once $dbPath;
include_once $productModelPath;

class ProductController {

    public function obtenerProductos($buscar = '') {
        global $conn;

        if (!$conn) {
            die("Error: Conexión a la base de datos no establecida.");
        }

        if (!empty($buscar)) {
            return $this->buscarProducto($buscar);
        } else {
            $sql = "SELECT * FROM productos";
            $resultado = $conn->query($sql);

            $productos = [];
            if ($resultado && $resultado->num_rows > 0) {
                while ($row = $resultado->fetch_assoc()) {
                    $productos[] = $row;
                }
            }

            return $productos;
        }
    }

    public function obtenerProductoPorId($idProducto) {
        global $conn;

        if (!$conn) {
            die("Error: Conexión a la base de datos no establecida.");
        }

        $sql = "SELECT * FROM productos WHERE idProducto = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $idProducto);
        $stmt->execute();
        $resultado = $stmt->get_result();

        return $resultado->fetch_assoc();
    }

    public function crearProducto($nom_producto, $tipo, $marca, $cantidad_disponible, $precio_venta, $fecha_ingreso, $descripcion) {
        global $conn;

        if (!$conn) {
            die("Error: Conexión a la base de datos no establecida.");
        }

        $fecha = DateTime::createFromFormat('Y-m-d', $fecha_ingreso);
        if (!$fecha || $fecha->format('Y-m-d') !== $fecha_ingreso) {
            die("Error: La fecha de ingreso no tiene un formato válido (YYYY-MM-DD).");
        }
        $fecha_formateada = $fecha->format('Y-m-d');

        $sqlVerificar = "SELECT idProducto FROM productos WHERE nom_producto = ?";
        $stmtVerificar = $conn->prepare($sqlVerificar);
        $stmtVerificar->bind_param('s', $nom_producto);
        $stmtVerificar->execute();
        $resultado = $stmtVerificar->get_result();

        if ($resultado->num_rows > 0) {
            echo "Error: El producto '$nom_producto' ya existe.";
            return false;
        }

        try {
            $sql = "INSERT INTO productos (nom_producto, tipo, marca, cantidad_disponible, precio_venta, fecha_ingreso, descripcion) 
                    VALUES (?, ?, ?, ?, ?, ?, ?)";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param('sssidsd', $nom_producto, $tipo, $marca, $cantidad_disponible, $precio_venta, $fecha_formateada, $descripcion);

            return $stmt->execute();
        } catch (mysqli_sql_exception $e) {
            echo "Error al insertar el producto: " . $e->getMessage();
            return false;
        }
    }

    public function actualizarProducto($id, $nombre, $tipo, $marca, $cantidad, $precio, $descripcion) {
        global $conn;

        if (!$conn) {
            die("Error: Conexión a la base de datos no establecida.");
        }

        try {
            $sql = "UPDATE productos SET nom_producto = ?, tipo = ?, marca = ?, cantidad_disponible = ?, precio_venta = ?, descripcion = ? WHERE idProducto = ?";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param('sssidsi', $nombre, $tipo, $marca, $cantidad, $precio, $descripcion, $id);

            return $stmt->execute();
        } catch (mysqli_sql_exception $e) {
            echo "Error al actualizar el producto: " . $e->getMessage();
            return false;
        }
    }

    public function eliminarProducto($idProducto) {
        global $conn;

        if (!$conn) {
            die("Error: Conexión a la base de datos no establecida.");
        }

        try {
            $sql = "DELETE FROM productos WHERE idProducto = ?";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("i", $idProducto);

            return $stmt->execute();
        } catch (mysqli_sql_exception $e) {
            echo "Error al eliminar el producto: " . $e->getMessage();
            return false;
        }
    }

    public function buscarProducto($nombre) {
        global $conn;

        if (!$conn) {
            die("Error: Conexión a la base de datos no establecida.");
        }

        $searchTerm = "%" . $nombre . "%";

        $sql = "SELECT * FROM productos WHERE nom_producto LIKE ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("s", $searchTerm);
        $stmt->execute();
        $resultado = $stmt->get_result();

        $productos = [];
        if ($resultado && $resultado->num_rows > 0) {
            while ($row = $resultado->fetch_assoc()) {
                $productos[] = $row;
            }
        }

        return $productos;
    }
}
?>
