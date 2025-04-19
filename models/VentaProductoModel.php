<?php

class VentaProductoModel {
    private $conn;

    public function __construct() {
        // Conexión a la base de datos
        $this->conn = new mysqli("localhost", "root", "0895Gazuniga", "dcafitness");

        if ($this->conn->connect_error) {
            die("Error de conexión: " . $this->conn->connect_error);
        }
    }

    // Obtener los productos disponibles
    public function obtenerProductos() {
        $query = "SELECT nom_producto, precio_venta FROM productos";
        $result = $this->conn->query($query);
    
        if ($result->num_rows > 0) {
            $productos = [];
            while ($row = $result->fetch_assoc()) {
                $productos[] = $row;
            }
            return $productos;
        } else {
            return [];
        }
    }
    
    // Registrar una venta
    public function registrarVenta($nom_producto, $cantidad, $precio_unitario) {
        $total = $cantidad * $precio_unitario;
        $fecha_venta = date("Y-m-d H:i:s");

        // Prepara la consulta para insertar la venta en la base de datos
        $stmt = $this->conn->prepare("INSERT INTO ventas_productos (nom_producto, cantidad, precio_venta, total, fecha_venta) VALUES (?, ?, ?, ?, ?)");
        $stmt->bind_param("sddds", $nom_producto, $cantidad, $precio_unitario, $total, $fecha_venta);

        if ($stmt->execute()) {
            return true;  // Venta registrada correctamente
        } else {
            return false; // Error al registrar la venta
        }
    }

    // Obtener todas las ventas realizadas
    public function obtenerVentas() {
        $query = "SELECT v.idVenta, v.nom_producto, v.cantidad, v.precio_venta, v.total, v.fecha_venta
                  FROM ventas_productos v";
        $result = $this->conn->query($query);
        
        if ($result->num_rows > 0) {
            $ventas = [];
            while ($row = $result->fetch_assoc()) {
                $ventas[] = $row;
            }
            return $ventas;
        } else {
            return [];
        }
    }
}
?>
