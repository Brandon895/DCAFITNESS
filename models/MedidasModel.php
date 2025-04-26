<?php

class MedidasModel {
    private $conn;

    public function __construct() {
        mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
        
        $this->conn = new mysqli("localhost", "root", "0895Gazuniga", "dcafitness");

        // Verificar conexión
        if ($this->conn->connect_error) {
            throw new Exception("Conexión fallida: " . $this->conn->connect_error);
        }
    }

    // Método privado para calcular el IMC
    private function calcularIMC($peso, $altura) {
        if ($altura > 10) {
            $altura /= 100; // Convertir a metros si es necesario
        }
        $imc = $peso / pow($altura, 2);
        if ($imc < 10 || $imc > 100) {
            throw new Exception("IMC fuera de rango válido (10 - 100). IMC calculado: " . number_format($imc, 2));
        }
        return $imc;
    }

    // Crear una nueva medida
    public function crearMedida($cedula, $fecha_medicion, $peso, $altura, $porcentaje_grasa, $circunferencia_cintura, $circunferencia_biceps, $circunferencia_triceps, $circunferencia_muslo, $circunferencia_pantorrilla) {
        $imc = $this->calcularIMC($peso, $altura);

        $sql = "INSERT INTO Medidas (cedula, fecha_medicion, peso, altura, imc, porcentaje_grasa, circunferencia_cintura, circunferencia_biceps, circunferencia_triceps, circunferencia_muslo, circunferencia_pantorrilla) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
        
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("ssddddddddd", $cedula, $fecha_medicion, $peso, $altura, $imc, $porcentaje_grasa, $circunferencia_cintura, $circunferencia_biceps, $circunferencia_triceps, $circunferencia_muslo, $circunferencia_pantorrilla);
        $stmt->execute();
        return true;
    }

    // Obtener todas las medidas
    public function obtenerMedidas() {
        $sql = "SELECT * FROM Medidas";
        $result = $this->conn->query($sql);
        return $result->fetch_all(MYSQLI_ASSOC);
    }

    // Obtener medida por ID
    public function obtenerMedidaPorId($idMedida) {
        $sql = "SELECT * FROM Medidas WHERE id_medida = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("i", $idMedida);
        $stmt->execute();
        return $stmt->get_result()->fetch_assoc();
    }

    // Actualizar una medida
    public function actualizarMedida($idMedida, $cedula, $fecha_medicion, $peso, $altura, $porcentaje_grasa, $circunferencia_cintura, $circunferencia_biceps, $circunferencia_triceps, $circunferencia_muslo, $circunferencia_pantorrilla) {
        $imc = $this->calcularIMC($peso, $altura);
        
        $sql = "UPDATE Medidas SET cedula = ?, fecha_medicion = ?, peso = ?, altura = ?, imc = ?, porcentaje_grasa = ?, circunferencia_cintura = ?, circunferencia_biceps = ?, circunferencia_triceps = ?, circunferencia_muslo = ?, circunferencia_pantorrilla = ? WHERE id_medida = ?";
        
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("ssdddddddddi", $cedula, $fecha_medicion, $peso, $altura, $imc, $porcentaje_grasa, $circunferencia_cintura, $circunferencia_biceps, $circunferencia_triceps, $circunferencia_muslo, $circunferencia_pantorrilla, $idMedida);
        $stmt->execute();
        return true;
    }

    // Eliminar una medida
    public function eliminarMedida($idMedida) {
        $sql = "DELETE FROM Medidas WHERE id_medida = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("i", $idMedida);
        $stmt->execute();
        return true;
    }

    // Cerrar conexión
    public function __destruct() {
        mysqli_report(MYSQLI_REPORT_OFF); // Desactivar reportes antes de cerrar
        $this->conn->close();
    }
}

?>
