<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
require_once __DIR__ . '/../models/BitacoraModel.php';

class BitacoraHelper {
    public static function registrarMovimiento($accion) {
        if (!isset($_SESSION['usuario'])) {
            return; // No usar die() ni echo
        }

        $usuario = $_SESSION['usuario'];
        $fecha = date('Y-m-d H:i:s');

        // Conexión a la base de datos
        $conn = new mysqli('127.0.0.1', 'root', '0895Gazuniga', 'dcafitness');
        if ($conn->connect_error) {
            return;
        }

        $sql = "INSERT INTO bitacora_movimientos (usuario, accion, fecha) 
                VALUES (?, ?, ?)";

        $stmt = $conn->prepare($sql);
        if ($stmt) {
            $stmt->bind_param("sss", $usuario, $accion, $fecha);
            $stmt->execute();
            $stmt->close();
        }

        $conn->close();
    }

    public static function registrarEnBitacora($accion) {
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }

        if (!isset($_SESSION['usuario'])) {
            return;
        }

        self::registrarMovimiento($accion);
    }
}
