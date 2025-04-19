<?php
class BitacoraModel {
    private $db;

    public function __construct() {
        $this->db = new mysqli("localhost", "root", "0895Gazuniga", "dcafitness");

        if ($this->db->connect_error) {
            die("Error en la conexión: " . $this->db->connect_error);
        }
    }

    // Método para registrar un movimiento
    public function registrarMovimiento($usuario, $accion) {
        $stmt = $this->db->prepare("INSERT INTO BITACORA_MOVIMIENTOS (usuario, accion) VALUES (?, ?)");
        $stmt->bind_param("ss", $usuario, $accion);
        $stmt->execute();
        $stmt->close();
    }

    // Método para obtener todos los movimientos
    public function obtenerMovimientos() {
        $sql = "SELECT * FROM BITACORA_MOVIMIENTOS ORDER BY fecha DESC";
        return $this->db->query($sql);
    }
}
?>
