<?php
class DashboardModel {
    private $conexion;

    public function __construct() {
        $this->conexion = new mysqli('localhost', 'root', '0895Gazuniga', 'dcafitness');
        if ($this->conexion->connect_error) {
            die("Error de conexión: " . $this->conexion->connect_error);
        }
    }

    public function obtenerDatosDashboard() {
        $sql = "SELECT COUNT(*) AS total_clientes FROM clientes";
        $resultado = $this->conexion->query($sql);
    
        if ($resultado && $resultado->num_rows > 0) {
            $row = $resultado->fetch_assoc();
            return (int)$row['total_clientes']; // Devuelve solo el número
        } else {
            return 0;
        }
    }
    

    public function obtenerEstadisticas() {
        // Consulta para obtener las estadísticas
        $sql = "SELECT * FROM estadisticas";
        $resultado = $this->conexion->query($sql);

        // Verifica si hay resultados
        if ($resultado->num_rows > 0) {
            return $resultado->fetch_all(MYSQLI_ASSOC);
        } else {
            return [];  // Si no hay resultados, retorna un array vacío
        }
    }
     // Obtener cantidad de rutinas realizadas hoy
     public function obtenerRutinasHoy() {
        // Consulta para contar rutinas realizadas hoy
        $sql = "SELECT COUNT(*) AS total_rutinas_hoy FROM rutinas WHERE DATE(fecha_realizacion) = CURDATE()";
        $resultado = $this->conexion->query($sql);

        if ($resultado && $resultado->num_rows > 0) {
            $row = $resultado->fetch_assoc();
            return (int)$row['total_rutinas_hoy']; // Devuelve el número de rutinas realizadas hoy
        } else {
            return 0; // Si no hay rutinas, devuelve 0
        }
    }

    // Cierra la conexión al finalizar
    public function __destruct() {
        $this->conexion->close();
    }
}
?>
