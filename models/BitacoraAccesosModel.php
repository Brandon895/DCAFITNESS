<?php
class BitacoraAccesosModel {

    public static function obtenerBitacora() {
        require __DIR__ . '/db.php';  
        $sql = "SELECT * FROM bitacora ORDER BY fecha_hora DESC";
        $result = $conn->query($sql);
        return ($result && $result->num_rows > 0)
             ? $result->fetch_all(MYSQLI_ASSOC)
             : [];
    }

    public static function registrarAcceso($id_usuario, $nombreusuario, $accion) {
        require __DIR__ . '/db.php'; 

        $sql = "INSERT INTO bitacora (id, nombreusuario, fecha_hora, accion)
                VALUES (?, ?, NOW(), ?)";
        $stmt = $conn->prepare($sql);

        if (!$stmt) {
            error_log("Error en prepare: " . $conn->error); 
            return false;
        }
        $stmt->bind_param("iss", $id_usuario, $nombreusuario, $accion);

        // Ejecuta la consulta
        if (!$stmt->execute()) {
            error_log("Error en execute: " . $stmt->error); // Muestra el error si falla la ejecución
            return false;
        }

        $stmt->close();
        return true;  // Registra correctamente
    }
}

