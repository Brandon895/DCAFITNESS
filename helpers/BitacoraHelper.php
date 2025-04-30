<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
require_once __DIR__ . '/../models/BitacoraModel.php';

class BitacoraHelper {
    public static function registrarMovimiento($accion) {
        if (!isset($_SESSION['usuario'])) {
            die('Usuario no autenticado');
        }

        $usuario = $_SESSION['usuario'];
        $fecha = date('Y-m-d H:i:s');

        // Conexión con IP en vez de 'localhost'
        $conn = new mysqli('127.0.0.1', 'root', '0895Gazuniga', 'dcafitness');
        if ($conn->connect_error) {
            die("Conexión fallida: " . $conn->connect_error);
        }

        $sql = "INSERT INTO bitacora_movimientos (usuario, accion, fecha) 
                VALUES (?, ?, ?)";
        
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("sss", $usuario, $accion, $fecha);
        $stmt->execute();

        if ($stmt->affected_rows > 0) {
            echo "Movimiento registrado correctamente.<br>";
        } else {
            echo "Error al registrar el movimiento.<br>";
        }

        $stmt->close();
        $conn->close();
    }

    public static function registrarEnBitacora($accion) {
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }

        if (!isset($_SESSION['usuario'])) {
            die('Usuario no autenticado');
        }

        self::registrarMovimiento($accion);
    }
}
?>
