<?php
require_once 'db.php'; 


class ProgresoFisicoModel {
    // Función para obtener las medidas de un cliente basado en la cédula
    public static function obtenerMedidasPorCedula($cedula) {
        global $conn;  // Usar la conexión global
        
        // Consulta SQL para obtener las medidas del cliente por cédula
        $sql = "SELECT * FROM medidas WHERE cedula = ? ORDER BY fecha_medicion DESC";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("s", $cedula);  // "s" indica que es una cadena (string)
        
        if ($stmt->execute()) {
            $result = $stmt->get_result();
            // Verificar si hay resultados
            if ($result->num_rows > 0) {
                // Crear un array para almacenar las medidas
                $medidas = [];
                while ($row = $result->fetch_assoc()) {
                    $medidas[] = $row;
                }
                return $medidas;  // Devolver el array con las medidas
            } else {
                return null;  // Si no hay resultados, devolver null
            }
        } else {
            return null;  // Si hay un error en la consulta, devolver null
        }

        $stmt->close();
    }
}
?>
