<?php
include 'models/db.php'; // Usa la conexión a tu base de datos

function registrarMovimiento($usuario, $accion) {
    global $conn;

    $query = "INSERT INTO bitacora_movimientos (usuario, accion) VALUES (?, ?)";
    
    if ($stmt = $conn->prepare($query)) {
        $stmt->bind_param("ss", $usuario, $accion);
        return $stmt->execute(); // true si se ejecuta correctamente
    } else {
        return false;
    }
}
?>
