<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
require_once '../models/BitacoraModel.php';

class BitacoraHelper {
    // Método para registrar un movimiento en la bitácora
    public static function registrarMovimiento($accion) {
        // Verificar si la sesión tiene un usuario activo
        if (!isset($_SESSION['usuario'])) {
            die('Usuario no autenticado');
        }

        $usuario = $_SESSION['usuario']; // Nombre del usuario desde la sesión
        $fecha = date('Y-m-d H:i:s'); // Fecha y hora actual

        // Conectar a la base de datos
        $conn = new mysqli('localhost', 'root', '0895Gazuniga', 'dcafitness');
        if ($conn->connect_error) {
            die("Conexión fallida: " . $conn->connect_error);
        }

        // SQL para insertar el registro de la bitácora
        $sql = "INSERT INTO bitacora_movimientos (usuario, accion, fecha) 
                VALUES (?, ?, ?)";
        
        // Preparar y ejecutar la consulta
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("sss", $usuario, $accion, $fecha);
        $stmt->execute();

        if ($stmt->affected_rows > 0) {
            echo "Movimiento registrado correctamente.<br>";
        } else {
            echo "Error al registrar el movimiento.<br>";
        }

        // Cerrar la conexión
        $stmt->close();
        $conn->close();
    }

    // Método estático para registrar un movimiento (sin necesidad de la clase)
    public static function registrarEnBitacora($accion) {
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }
        
        if (!isset($_SESSION['usuario'])) {
            die('Usuario no autenticado');
        }

        $usuario = $_SESSION['usuario'];
        $fecha = date('Y-m-d H:i:s');
        
        // Registrar en la bitácora
        self::registrarMovimiento($accion, $accion);
    }
}
?>
