<?php
require_once __DIR__ . '/db.php'; // Ajusta la ruta según la ubicación de db.php dentro de models

class DashboardModel {
    private $conexion;

    public function __construct() {
        global $conn; // Usa la conexión definida en db.php
        $this->conexion = $conn;

        if ($this->conexion->connect_error) {
            die("Error de conexión: " . $this->conexion->connect_error);
        }
    }

    public function obtenerDatosDashboard() {
        $sql = "SELECT COUNT(*) AS total_clientes FROM clientes";
        $resultado = $this->conexion->query($sql);

        if ($resultado && $resultado->num_rows > 0) {
            $row = $resultado->fetch_assoc();
            return (int)$row['total_clientes'];
        } else {
            return 0;
        }
    }

    public function obtenerEstadisticas() {
        $sql = "SELECT * FROM estadisticas";
        $resultado = $this->conexion->query($sql);

        if ($resultado->num_rows > 0) {
            return $resultado->fetch_all(MYSQLI_ASSOC);
        } else {
            return [];
        }
    }

    public function obtenerRutinasHoy() {
        $sql = "SELECT COUNT(*) AS total_rutinas_hoy FROM rutinas WHERE DATE(fecha_realizacion) = CURDATE()";
        $resultado = $this->conexion->query($sql);

        if ($resultado && $resultado->num_rows > 0) {
            $row = $resultado->fetch_assoc();
            return (int)$row['total_rutinas_hoy'];
        } else {
            return 0;
        }
    }

    public function __destruct() {
        if ($this->conexion) {
            $this->conexion->close();
        }
    }
}
?>
