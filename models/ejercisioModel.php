<?php
require_once 'db.php'; 

class EjercicioModel {

    private $conn;

    public function __construct() {
        global $conn;  
        $this->conn = $conn;
    }

    // Método para insertar ejercicios
    public function insertarEjercicio($cedula, $ejercicios_data) {
        
        $ejercicios_data_json = json_encode($ejercicios_data);

        
        $stmt = $this->conn->prepare("INSERT INTO ejercicio (cedula, ejercicios_data) VALUES (?, ?)");
        $stmt->bind_param("ss", $cedula, $ejercicios_data_json);

        if ($stmt->execute()) {
            return true;
        } else {
            return false;
        }
    }

    // Método para obtener los ejercicios por cédula
    public function obtenerEjerciciosPorCedula($cedula) {
        $stmt = $this->conn->prepare("SELECT * FROM ejercicio WHERE cedula = ?");
        $stmt->bind_param("s", $cedula);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->fetch_all(MYSQLI_ASSOC); // Devuelve todos los registros como array
    }
}
?>
