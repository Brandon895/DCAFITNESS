<?php
require_once 'db.php'; // Incluimos la conexión

class RutinaModel {
    private $conn;

    public function __construct() {
        global $conn; // Usamos la conexión global definida en db.php
        $this->conn = $conn;
    }

    // Método para obtener todas las rutinas
    public function obtenerRutinas() {
        $query = "SELECT * FROM rutinas"; // Consulta para obtener todas las rutinas
        $result = $this->conn->query($query); // Ejecutar la consulta

        // Verificamos si la consulta devolvió resultados
        if ($result->num_rows > 0) {
            return $result->fetch_all(MYSQLI_ASSOC); // Devuelve todas las rutinas como un array asociativo
        } else {
            return []; // Si no hay resultados, retornamos un array vacío
        }
    }

    // Método para insertar una rutina
    public function insertarRutina($cedula, $nomrutina, $cantidadsesiones) {
        $stmt = $this->conn->prepare("INSERT INTO rutinas (cedula, nomrutina, cantidadsesiones) VALUES (?, ?, ?)");
        $stmt->bind_param("ssi", $cedula, $nomrutina, $cantidadsesiones); // Preparamos y vinculamos los parámetros
        return $stmt->execute(); // Ejecutamos la consulta
    }

    // Método para obtener una rutina por su ID
    public function obtenerRutinaPorId($id_rutina) {
        $stmt = $this->conn->prepare("SELECT * FROM rutinas WHERE id_rutina = ?");
        $stmt->bind_param("i", $id_rutina);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->fetch_assoc();
    }

    // Método para actualizar una rutina
    public function actualizarRutina($id_rutina, $cedula, $nomrutina, $cantidadsesiones) {
        $stmt = $this->conn->prepare("UPDATE rutinas SET cedula = ?, nomrutina = ?, cantidadsesiones = ? WHERE id_rutina = ?");
        $stmt->bind_param("ssii", $cedula, $nomrutina, $cantidadsesiones, $id_rutina);
        return $stmt->execute();
    }
    public function eliminarRutina($id_rutina) {
        global $conn;

        // Sentencia SQL para eliminar la rutina por su ID
        $sql = "DELETE FROM rutinas WHERE id_rutina = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $id_rutina);

        // Ejecutamos la consulta y verificamos si fue exitosa
        if ($stmt->execute()) {
            return true;
        } else {
            return false;
        }
    }
}
?>
